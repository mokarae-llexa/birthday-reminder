@extends('layouts.app')

@section('content')
    @php
        $hariIniTgl = \Carbon\Carbon::today();
        $awalGrid = $tampil->copy()->startOfWeek();
        $akhirGrid = $tampil->copy()->endOfMonth()->endOfWeek();
        $namaHari = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $bulanIniAktif = $tampil->format('Y-m') === $hariIniTgl->format('Y-m');
        $namaBulan = $tampil->copy()->format('F');
        $namaBulanTahun = $tampil->copy()->format('F Y');

        $urlBulan = fn($tgl) => route('calendar', ['bulan' => $tgl->format('Y-m')]);
    @endphp

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

<style>
    .kal *,
    .kal *::before,
    .kal *::after { box-sizing: border-box; }

    .kal h1, .kal h2, .kal p { margin: 0; }
    .kal a { text-decoration: none; color: inherit; }
    .kal a:focus-visible,
    .kal button:focus-visible { outline: 2px solid var(--slate); outline-offset: 2px; }

    .kal {
        --ink: #3F4766;
        --muted: #5D688A;
        --slate: #5D688A;
        --pink: #F7A5A5;
        --pink-deep: #E27D7D;
        --peach: #FFDBB6;
        --cream: #FFF2EF;

        color: var(--ink);
        min-height: 100vh;
        flex: 1;
        min-width: 0;
        width: 100%;
        padding: 48px 40px 56px;
    }

    .kal-inner { max-width: 1200px; margin: 0 auto; padding-left: 40px; }
    .kal-title { font-family: 'Roboto', Georgia, serif; font-size: 36px; font-weight: 700; line-height: 1.15; }
    .kal-sub { font-size: 13px; color: var(--muted); margin-top: 6px; }

    .kal-layout {
        margin-top: 32px;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 420px;
        gap: 32px;
        align-items: start;
    }

    .sec-head {
        background: #fff;
        border: 2px solid var(--pink);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        border-radius: 14px;
        margin-bottom: 14px;
    }
    .sec-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }
    .sec-reset { font-size: 12px; font-weight: 600; color: var(--slate); }
    .sec-reset:hover { color: var(--pink-deep); }

    .bday-list { display: grid; gap: 12px; }

    .bday-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        background: #fff;
        border: 2px solid var(--pink);
        border-radius: 14px;
        padding: 18px 20px;
        transition: background-color .2s ease;
    }
    .bday-item:hover { background: var(--cream); }
    .bday-item.lewat { background: #fff; border-color: #EADFE0; }

    .bday-left { display: flex; align-items: center; gap: 14px; min-width: 0; }

    .bday-avatar {
        width: 56px; height: 56px;
        border-radius: 50%;
        object-fit: cover;
        background: var(--cream);
        border: 2px solid var(--pink);
        flex-shrink: 0;
    }

    .bday-nama { font-size: 17px; font-weight: 600; color: var(--ink); }
    .bday-info { font-size: 12px; color: var(--muted); margin-top: 2px; }

    .bday-label {
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        padding: 6px 12px;
        border-radius: 999px;
        background: var(--peach);
        color: var(--ink);
    }
    .bday-item.hari-ini .bday-label { background: var(--slate); color: #fff; }

    .kosong {
        font-size: 13px;
        color: var(--muted);
        background: #fff;
        border: 2px dashed var(--pink);
        border-radius: 12px;
        padding: 28px 20px;
        text-align: center;
    }

    .mini-cal {
        background: #fff;
        border: 2px solid var(--pink);
        border-radius: 18px;
        padding: 26px 20px 22px;
        position: sticky;
        top: 24px;
    }

    .cal-nav { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .cal-bulan { font-family: 'Roboto', Georgia, serif; font-size: 15px; font-weight: 700; color: var(--ink); }

    .cal-panah {
        width: 30px; height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--slate);
        font-size: 16px;
        transition: background .15s;
    }
    .cal-panah:hover { background: var(--peach); color: var(--ink); }

    .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); row-gap: 2px; text-align: center; }
    .cal-head { font-size: 14px; font-weight: 600; color: var(--muted); padding-bottom: 6px; }
    .cal-sel { display: flex; justify-content: center; }

    .tgl {
        position: relative;
        width: 44px; height: 44px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
        transition: background .15s;
    }
    .tgl.luar { color: #C9CCDA; }
    a.tgl:hover { background: var(--peach); }

    .tgl.ada::after {
        content: '';
        position: absolute;
        bottom: 3px; left: 50%;
        width: 5px; height: 5px;
        margin-left: -2.5px;
        border-radius: 50%;
        background: var(--pink-deep);
    }

    .tgl.hari-ini { background: var(--slate); color: #fff; font-weight: 700; }
    .tgl.hari-ini.ada::after { background: #fff; }~
    .tgl.dipilih { background: var(--pink); color: var(--ink); font-weight: 700; }
    .tgl.dipilih.hari-ini { background: var(--slate); color: #fff; }

    .cal-aksi { margin-top: 18px; display: grid; gap: 10px; }

    .btn-tambah {
        display: block;
        text-align: center;
        background: var(--pink);
        color: var(--ink) !important;
        font-weight: 700;
        font-size: 14px;
        padding: 11px 20px;
        border-radius: 999px;
        border: 2px solid var(--pink-deep);
        transition: background .15s;
    }
    .btn-tambah:hover { background: var(--pink-deep); }

    .btn-hari-ini { text-align: center; font-size: 12px; font-weight: 600; color: var(--slate); }
    .btn-hari-ini:hover { color: var(--pink-deep); }

    .sticker {
        color: #2B1F22;
        paint-order: stroke fill;
        -webkit-text-stroke: 0.28em #fff;
        text-shadow: 0 0 10px rgba(255, 255, 255, .9);
    }
    .kal .kal-sub { color: var(--slate); font-weight: 500; }

    @media (max-width: 900px) {
        .kal { padding: 32px 20px 40px; }
        .kal-inner { padding-left: 0; padding-top: 36px; }
        .kal-layout { grid-template-columns: 1fr; gap: 24px; }
        .mini-cal { order: -1; position: static; }
    }
</style>

    <div class="kal">
        <div class="kal-inner">

            <header>
                <h2 class="fw-bold mb-1 sticker">Calendar Of Friends</h2>
                <p class="kal-sub sticker">Your friends' birthdays, by month.</p>
            </header>

            <div class="kal-layout">

                <section aria-label="Daftar ulang tahun">
                    <div class="sec-head">
                        <div>
                            <h6 class="fw-bold mb-0" style="color: #1F1F1F;">
                                {{ $dipilih ? 'Birthday on ' . $dipilih . ' ' . $namaBulan : 'Birthday this month' }}
                            </h6>
                            <p class="sec-sub">{{ $namaBulanTahun }}</p>
                        </div>
                        @if ($dipilih)
                            <a href="{{ $urlBulan($tampil) }}" class="sec-reset">See all</a>
                        @endif
                    </div>

                    @if ($daftar->isEmpty())
                        <p class="kosong">There are no birthdays this month..</p>
                    @else
                        <div class="bday-list">
                            @foreach ($daftar as $f)
                                @php
                                    $selisih = (int) $hariIniTgl->diffInDays($f->tanggal_ulang_tahun, false);
                                    if ($selisih === 0) {
                                        $label = 'Today 🎂';
                                        $kelas = 'hari-ini';
                                    } elseif ($selisih === 1) {
                                        $label = 'Tomorrow';
                                        $kelas = '';
                                    } elseif ($selisih > 1) {
                                        $label = $selisih . ' days left';
                                        $kelas = '';
                                    } else {
                                        $label = 'Passed';
                                        $kelas = 'lewat';
                                    }
                                    $foto =
                                        $f->avatar_url ?:
                                        'https://ui-avatars.com/api/?name=' .
                                            urlencode($f->name) .
                                            '&background=FFE1DD&color=C55F4E&size=96&bold=true';
                                @endphp
                                <article class="bday-item {{ $kelas }}">
                                    <div class="bday-left">
                                        <img class="bday-avatar" src="{{ $foto }}" alt="{{ $f->name }}">
                                        <div>
                                            <h3 class="bday-nama" style="margin:0;">{{ $f->name }}</h3>
                                            <p class="bday-info">
                                                {{ $f->tanggal_ulang_tahun->format('F j') }}
                                                · turns {{ $f->umur }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="bday-label">{{ $label }}</span>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>

                <aside class="mini-cal" aria-label="Kalender">
                    <div class="cal-nav">
                        <a href="{{ $urlBulan($tampil->copy()->subMonth()) }}" class="cal-panah"
                            aria-label="Bulan sebelumnya">&lsaquo;</a>
                        <span class="cal-bulan">{{ $namaBulanTahun }}</span>
                        <a href="{{ $urlBulan($tampil->copy()->addMonth()) }}" class="cal-panah"
                            aria-label="Bulan berikutnya">&rsaquo;</a>
                    </div>

                    <div class="cal-grid">
                        @foreach ($namaHari as $h)
                            <div class="cal-head">{{ $h }}</div>
                        @endforeach

                        @foreach (\Carbon\CarbonPeriod::create($awalGrid, $akhirGrid) as $hari)
                            @php
                                $luar = $hari->month !== $tampil->month;
                                $ada = !$luar && $perHari->has($hari->day);
                                $isToday = $hari->isSameDay($hariIniTgl);
                                $dipilihIni = !$luar && $dipilih === $hari->day;
                                $kelasTgl = trim(
                                    'tgl' .
                                        ($luar ? ' luar' : '') .
                                        ($ada ? ' ada' : '') .
                                        ($isToday ? ' hari-ini' : '') .
                                        ($dipilihIni ? ' dipilih' : ''),
                                );
                            @endphp
                            <div class="cal-sel">
                                @if ($ada)
                                    <a class="{{ $kelasTgl }}"
                                        href="{{ route('calendar', ['bulan' => $tampil->format('Y-m'), 'tanggal' => $hari->day]) }}"
                                        title="{{ $perHari[$hari->day]->pluck('name')->implode(', ') }}">{{ $hari->day }}</a>
                                @else
                                    <span class="{{ $kelasTgl }}">{{ $hari->day }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="cal-aksi">
                        <a href="{{ route('friends.create') }}" class="btn-tambah">+ Add Friends</a>
                        @unless ($bulanIniAktif)
                            <a href="{{ route('calendar') }}" class="btn-hari-ini">Back to this month</a>
                        @endunless
                    </div>
                </aside>

            </div>
        </div>
    </div>
@endsection
