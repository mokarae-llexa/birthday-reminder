<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $awalMinggu = $today->copy()->startOfWeek(); 
        $akhirMinggu = $today->copy()->endOfWeek();    
        $friends = Friend::query()
            ->whereNotNull('birth_date')
            ->get()
            ->map(function ($f) use ($today) {
                $lahir = Carbon::parse($f->birth_date);

                $tahunIni = Carbon::create($today->year, $lahir->month, $lahir->day)->startOfDay();
                $berikutnya = $tahunIni->lt($today) ? $tahunIni->copy()->addYear() : $tahunIni;

                $f->ulang_tahun_ini = $tahunIni;
                $f->ulang_tahun_berikutnya = $berikutnya;
                $f->sisa_hari = (int) $today->diffInDays($berikutnya);
                $f->umur_berikutnya = $berikutnya->year - $lahir->year;

                return $f;
            });

        return view('home', [
            'hariIni'    => $friends->where('sisa_hari', 0)->values(),
            'mingguIni'  => $friends->filter(fn ($f) => $f->ulang_tahun_ini->between($awalMinggu, $akhirMinggu))->values(),
            'bulanIni'   => $friends->filter(fn ($f) => $f->ulang_tahun_ini->month === $today->month)->values(),
            'berikutnya' => $friends->filter(fn ($f) => $f->sisa_hari > 0)->sortBy('sisa_hari')->take(6)->values(),
            'totalFriendsCount' => $friends->count(),
        ]);
    }
}