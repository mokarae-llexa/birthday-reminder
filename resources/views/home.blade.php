@extends('layouts.app')

@section('content')
    @php
        $inisial = fn($nama) => strtoupper(
            collect(explode(' ', trim($nama)))
                ->map(fn($k) => mb_substr($k, 0, 1))
                ->take(2)
                ->implode(''),
        );
        $namaDepan = fn($nama) => explode(' ', trim($nama))[0];
        $warna = fn($nama) => ['pink', 'lavender', 'yellow', 'mint', 'blue'][crc32($nama) % 5];

        $tanggalHariIni = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y');

        $kartu = [
            ['judul' => 'Today', 'kelas' => 'pink', 'ikon' => '🎂', 'daftar' => $hariIni],
            ['judul' => 'This week', 'kelas' => 'lavender', 'ikon' => '🗓️', 'daftar' => $mingguIni],
            ['judul' => 'This Month', 'kelas' => 'yellow', 'ikon' => '📅', 'daftar' => $bulanIni],
        ];
    @endphp

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <style>
        .beranda {
            --ink: #2B1F22;
            --muted: #A0707A;
            --accent: #E8637D;
            --line: #F3DDD8;
            --pink-bg: #FFEBEC;
            --pink-fg: #E8637D;
            --pink-av: #FFD3D9;
            --lav-bg: #EEEBFF;
            --lav-fg: #7C5CE0;
            --lav-av: #DCD5FF;
            --yel-bg: #FFF7D6;
            --yel-fg: #E39B0B;
            --yel-av: #FFE9A3;
            --mint-av: #B9F3E4;
            --blue-av: #C9E6FF;

        }

        .beranda a {
            text-decoration: none;
        }

        .beranda *,
        .beranda *::before,
        .beranda *::after {
            box-sizing: border-box;
        }

        .beranda h1,
        .beranda h2,
        .beranda p {
            margin: 0;
        }

        .beranda a:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 3px;
            border-radius: 6px;
        }

        .beranda-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 24px 32px 16px;
            padding-left: 72px;
        }

        .beranda-title {
            font-family: 'Roboto', Georgia, serif;
            font-size: 26px;
            font-weight: 700;
            line-height: 1.1;
        }

        .beranda-date {
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
        }

        .btn-tambah {
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            justify-content: flex-end;
            font-size: 14px;
            padding: 11px 20px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(232, 99, 125, .28);
            white-space: nowrap;
            margin-left: auto;
        }

        .btn-tambah:hover {
            background: #ffb2c2;
            color: #fff;
        }

        .beranda-body {
            max-width: 1100px;
            margin: 0 auto;
            padding: 8px 32px 48px;
            display: grid;
            gap: 24px;
        }

        .ringkasan {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .kartu {
            border-radius: 16px;
            padding: 22px 26px;
            border: 1px solid rgba(0, 0, 0, .04);
            display: grid;
            gap: 10px;
        }

        .kartu.pink {
            background: var(--pink-bg);
            --fg: var(--pink-fg);
        }

        .kartu.lavender {
            background: var(--lav-bg);
            --fg: var(--lav-fg);
        }

        .kartu.yellow {
            background: var(--yel-bg);
            --fg: var(--yel-fg);
        }

        .kartu-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .kartu-judul {
            font-size: 16px;
            font-weight: 700;
            color: var(--fg);
        }

        .kartu-ikon {
            font-size: 16px;
            line-height: 1;
        }

        .kartu-tengah {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .kartu-angka {
            font-size: 12px;
            color: var(--fg);
            white-space: nowrap;
        }

        .kartu-angka strong {
            font-family: 'Roboto', Georgia, serif;
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
            margin-right: 2px;
        }

        .tumpuk {
            display: flex;
            align-items: center;
        }

        .tumpuk .av {
            border: 2px solid #fff;
            margin-left: -8px;
        }

        .tumpuk .av:first-child {
            margin-left: 0;
        }

        .kartu-nama {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.3;
        }

        .av {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .av.lg {
            width: 44px;
            height: 44px;
            font-size: 14px;
        }

        .av.pink {
            background: var(--pink-av);
            color: var(--pink-fg);
        }

        img.av {
            object-fit: cover;
        }

        .av.lavender {
            background: var(--lav-av);
            color: var(--lav-fg);
        }

        .av.yellow {
            background: var(--yel-av);
            color: #B97A00;
        }

        .av.mint {
            background: var(--mint-av);
            color: #0E8A70;
        }

        .av.blue {
            background: var(--blue-av);
            color: #2F7FC1;
        }

        .panel {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 24px 32px 20px;
        }

        .panel-head {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 12px;
        }

        .panel-judul {
            font-family: 'Roboto', Georgia, serif;
            font-size: 18px;
            font-weight: 700;
        }

        .panel-link {
            font-size: 12px;
            color: var(--accent);
            font-weight: 600;
        }

        .daftar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 56px;
        }

        .baris {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 0;
            border-bottom: 1px solid #F8ECE8;
        }

        .baris-kiri {
            display: flex;
            align-items: center;
            gap: 16px;
            min-width: 0;
        }

        .baris-nama {
            font-size: 15px;
            font-weight: 600;
        }

        .baris-sub {
            font-size: 12px;
            color: var(--muted);
        }

        .baris-kanan {
            display: flex;
            align-items: center;
            gap: 12px;
            text-align: right;
        }

        .baris-tgl {
            font-size: 14px;
            font-weight: 600;
        }

        .baris:last-child {
            border-bottom: none;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent);
            flex-shrink: 0;
        }

        .kosong {
            font-size: 13px;
            color: var(--muted);
            padding: 16px 0 20px;
        }

        .kosong a {
            color: var(--accent);
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .daftar {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .ringkasan {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 560px) {
            .beranda-head {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px 16px 12px;
            }

            .beranda-body {
                max-width: 1300px;    
                padding: 8px 16px 32px;
                gap: 32px;
            }
        }
    </style>

    <div class="beranda">
        <header class="beranda-head">
            <a href="{{ route('friends.create') }}" class="btn-tambah">+ Add Friend</a>
        </header>

        <div class="beranda-body">

            <section class="ringkasan" aria-label="Ringkasan ulang tahun">
                @foreach ($kartu as $k)
                    @php
                        $total = count($k['daftar']);
                        $sisa = max($total - 2, 0);
                        $depan = collect($k['daftar'])->take(2)->map(fn($t) => $namaDepan($t->name))->implode(', ');
                    @endphp
                    <article class="kartu {{ $k['kelas'] }}">
                        <div class="kartu-top">
                            <span class="kartu-judul">{{ $k['judul'] }}</span>
                            <span class="kartu-ikon" aria-hidden="true">{{ $k['ikon'] }}</span>
                        </div>

                        <div class="kartu-tengah">
                            <p class="kartu-angka"><strong>{{ $total }}</strong> people</p>
                            <div class="tumpuk">
                                @foreach (collect($k['daftar'])->take(3) as $t)
                                    <img class="av"
                                        src="{{ $t->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($t->name) . '&background=FFE1DD&color=C55F4E&size=64&bold=true' }}"
                                        alt="{{ $t->name }}" title="{{ $t->name }}">
                                @endforeach
                            </div>
                        </div>

                        <p class="kartu-nama">
                            @if ($total === 0)
                                there isn't any yet
                            @else
                                {{ $depan }}@if ($sisa > 0)
                                    +{{ $sisa }} more
                                @endif
                            @endif
                        </p>
                    </article>
                @endforeach
            </section>

            <section class="panel">
                <div class="panel-head">
                    <h2 class="panel-judul">The Next Birthday</h2>
                    <a href="{{ route('calendar') }}" class="panel-link">See all</a>
                </div>

                @if ($berikutnya->isEmpty())
                    <p class="kosong">
                        There are no upcoming birthdays.
                        <a href="{{ route('friends.create') }}">Add Friend</a>
                    </p>
                @else
                    <div class="daftar">
                        @foreach ($berikutnya as $b)
                            <div class="baris">
                                <div class="baris-kiri">
                                    <img class="av lg"
                                        src="{{ $b->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($b->name) . '&background=FFE1DD&color=C55F4E&size=96&bold=true' }}"
                                        alt="{{ $b->name }}">
                                    <p class="baris-nama">{{ $b->name }}</p>
                                </div>
                                <div class="baris-kanan">
                                    <div>
                                        <p class="baris-tgl">
                                            {{ $b->ulang_tahun_berikutnya->locale('id')->isoFormat('D MMM') }}</p>
                                        <p class="baris-sub">
                                            {{ $b->sisa_hari === 1 ? 'Tomorrow' : $b->sisa_hari . ' days left' }}</p>
                                    </div>
                                    <span class="dot" aria-hidden="true"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

        </div>
    </div>
@endsection
