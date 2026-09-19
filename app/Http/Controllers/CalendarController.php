<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $tampil = Carbon::today()->startOfMonth();
        $param = $request->query('bulan');

        if ($param && preg_match('/^\d{4}-\d{2}$/', $param)) {
            try {
                $tampil = Carbon::createFromFormat('!Y-m', $param)->startOfMonth();
            } catch (\Throwable $e) {
            }
        }
        $bulanIni = collect();

        $friends = Friend::query()
            ->whereNotNull('birth_date')
            ->get();

        foreach ($friends as $f) {
            $lahir = Carbon::parse($f->birth_date);

            if ($lahir->month !== $tampil->month) {
                continue;
            }


            $hari = min($lahir->day, $tampil->daysInMonth);

            $f->hari_ulang_tahun = $hari;
            $f->tanggal_ulang_tahun = $tampil->copy()->day($hari);
            $f->umur = $tampil->year - $lahir->year;

            $bulanIni->push($f);
        }

        $bulanIni = $bulanIni->sortBy('hari_ulang_tahun')->values();
        $perHari = $bulanIni->groupBy('hari_ulang_tahun');

    
        $dipilih = (int) $request->query('tanggal');
        if (! $perHari->has($dipilih)) {
            $dipilih = null;
        }

        return view('calendar', [
            'tampil'  => $tampil,
            'perHari' => $perHari,
            'dipilih' => $dipilih,
            'daftar'  => $dipilih ? $perHari[$dipilih] : $bulanIni,
            'totalFriendsCount' => $friends->count(),
        ]);
    }
}