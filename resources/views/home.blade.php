@extends('layouts.app')

@section('content')
    @php
        $inisial = fn($nama) => strtoupper(
            collect(explode(' ', trim($nama)))->map(fn($k) => mb_substr($k, 0, 1))->take(2)->implode(''),
        );
        $namaDepan = fn($nama) => explode(' ', trim($nama))[0];
        $warna = fn($nama) => ['pink', 'lavender', 'yellow', 'mint', 'blue'][crc32($nama) % 5];

        $tanggalHariIni = \Carbon\Carbon::now()->locale('en')->isoFormat('dddd, MMMM D, Y');

        $kartu = [
            ['judul' => 'Today', 'kelas' => 'pink', 'ikon' => 'cake', 'daftar' => $hariIni],
            ['judul' => 'This week', 'kelas' => 'lavender', 'ikon' => 'week', 'daftar' => $mingguIni],
            ['judul' => 'This Month', 'kelas' => 'yellow', 'ikon' => 'month', 'daftar' => $bulanIni],
        ];
    @endphp

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <style>
        .beranda {
            --ink: var(--text, #333333);
            --muted: var(--secondary, #5D688A);
            --accent: var(--primary, #E88F9B);
            --line: var(--border, #F0C9C9);
            --pink-bg: var(--primary-soft, #FCE4E6);
            --pink-fg: var(--primary-dark, #B95569);
            --pink-av: var(--primary, #E88F9B);
            --lav-bg: var(--secondary-soft, #E9ECF4);
            --lav-fg: var(--secondary, #5D688A);
            --lav-av: var(--secondary, #5D688A);
            --yel-bg: var(--accent, #FFDBB6);
            --yel-fg: var(--primary-dark, #B95569);
            --yel-av: var(--accent-dark, #E8A765);
            --mint-av: var(--primary-soft, #FCE4E6);
            --blue-av: var(--secondary-soft, #E9ECF4);
            color: var(--ink);
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
            background: var(--primary, #E88F9B);
            color: var(--white, #fff);
            font-weight: 600;
            justify-content: flex-end;
            font-size: 14px;
            padding: 11px 20px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(232, 143, 155, .28);
            white-space: nowrap;
            margin-left: auto;
        }

        .btn-tambah:hover {
            background: var(--primary-dark, #B95569);
            color: var(--white, #fff);
        }

        .beranda-body {
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 32px 40px 56px;
            display: grid;
            gap: 32px;
        }

        .ringkasan {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .kartu {
            border-radius: 16px;
            padding: 22px 26px;
            border: 2px solid var(--fg);
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
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .7);
            color: var(--fg);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .kartu-ikon svg {
            width: 18px;
            height: 18px;
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
            color: var(--primary-dark, #B95569);
        }

        .av.mint {
            background: var(--mint-av);
            color: var(--primary-dark, #B95569);
        }

        .av.blue {
            background: var(--blue-av);
            color: var(--secondary-dark, #3F4766);
        }

        .panel {
            background: var(--white, #fff);
            border: 2px solid var(--border, #F0C9C9);
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
            color: var(--ink);
        }

        .panel-link {
            font-size: 12px;
            color: var(--primary-dark, #B95569);
            font-weight: 600;
        }

        .panel-link:hover {
            color: var(--secondary, #5D688A);
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
            border-bottom: 1px solid var(--background, #FFF2EF);
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
            background: var(--primary, #E88F9B);
            flex-shrink: 0;
        }

        .kosong {
            font-size: 13px;
            color: var(--muted);
            padding: 16px 0 20px;
        }

        .kosong a {
            color: var(--primary-dark, #B95569);
            font-weight: 600;
        }

        .avatar-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            padding: 8px 0 4px;
        }

        .avatar-item {
            display: inline-flex;
            transition: transform .15s ease;
        }

        .avatar-item:hover {
            transform: translateY(-3px);
        }

        .av.x1 {
            width: 64px;
            height: 64px;
            font-size: 18px;
            border: 3px solid var(--primary, #E88F9B);
        }

        .avatar-lebih {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            background: var(--primary-soft, #FCE4E6);
            color: var(--primary-dark, #B95569);
            font-weight: 700;
            font-size: 16px;
            border: 3px solid var(--primary, #E88F9B);
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


            .kolom-utama {
                display: grid;
                grid-template-columns: minmax(0, 1fr);
                gap: 32px;
                min-width: 0;
            }

            .rencana {
                position: sticky;
                top: 24px;
                height: fit-content;
                min-height: 0;
                max-height: none;
                display: flex;
                flex-direction: column;
                padding: 20px 20px 12px;
            }

            .rencana-head {
                display: flex;
                justify-content: space-between;
                align-items: baseline;
                margin-bottom: 12px;
            }

            .rencana-badge {
                background: var(--pink-bg);
                color: var(--pink-fg);
                font-size: 11px;
                font-weight: 700;
                padding: 2px 10px;
                border-radius: 999px;
            }

            .rencana-err {
                font-size: 12px;
                color: var(--primary-dark, #B95569);
                margin-bottom: 8px;
            }

            .rencana-form {
                display: grid;
                gap: 8px;
                padding-bottom: 14px;
                border-bottom: 1px solid var(--background, #FFF2EF);
            }

            .rencana-form select,
            .rencana-form input {
                width: 100%;
                border: 1.5px solid var(--line);
                border-radius: 10px;
                padding: 8px 12px;
                font-size: 13px;
                background: var(--white, #fff);
                color: var(--ink);
            }

            .rencana-form .baris2 {
                display: grid;
                grid-template-columns: 1fr auto;
                gap: 8px;
            }

            .rencana-form button {
                background: var(--primary, #E88F9B);
                color: var(--white, #fff);
                border: 0;
                border-radius: 10px;
                padding: 8px 16px;
                font-weight: 600;
                font-size: 13px;
                cursor: pointer;
            }

            .rencana-form button:hover {
                background: var(--primary-dark, #B95569);
            }

            .rencana-list {
                flex: 1;
                min-height: 0;
                overflow-y: auto;
                padding-top: 12px;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .plan {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                background: var(--background, #FFF2EF);
                border: 1.5px solid var(--line);
                border-radius: 14px;
                padding: 10px 12px;
            }

            .plan.done {
                opacity: .55;
            }

            .plan.done .plan-judul {
                text-decoration: line-through;
            }

            .plan-cek {
                width: 22px;
                height: 22px;
                border-radius: 50%;
                border: 2px solid var(--primary, #E88F9B);
                background: var(--white, #fff);
                color: var(--white, #fff);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                cursor: pointer;
                flex-shrink: 0;
            }

            .plan-cek svg {
                opacity: 0;
            }

            .plan.done .plan-cek {
                background: var(--primary, #E88F9B);
            }

            .plan.done .plan-cek svg {
                opacity: 1;
            }

            .plan-isi {
                flex: 1;
                min-width: 0;
            }

            .plan-judul {
                font-size: 13.5px;
                font-weight: 600;
                word-break: break-word;
            }

            .plan-sub {
                font-size: 11.5px;
                color: var(--muted);
            }

            .plan-sub .telat {
                color: var(--primary-dark, #B95569);
                font-weight: 600;
            }

            .plan-hapus {
                border: 0;
                background: transparent;
                color: var(--muted);
                cursor: pointer;
                padding: 0 2px;
                font-size: 18px;
                line-height: 1;
            }
        }

        .beranda-body {
            grid-template-columns: minmax(0, 1fr) 340px;
            align-items: start;
        }

        .kolom-utama {
            display: grid;
            gap: 32px;
            min-width: 0;
        }

        .rencana {
            position: sticky;
            top: 24px;
            height: fit-content;
            min-height: 0;
            display: flex;
            flex-direction: column;
            padding: 20px 20px 12px;
        }

        .rencana-head {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 12px;
        }

        .rencana-badge {
            background: var(--pink-bg);
            color: var(--pink-fg);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 999px;
        }

        .rencana-err {
            font-size: 12px;
            color: var(--primary-dark, #B95569);
            margin-bottom: 8px;
        }

        .rencana-form {
            display: grid;
            gap: 8px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--background, #FFF2EF);
        }

        .rencana-form select,
        .rencana-form input {
            width: 100%;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 13px;
            background: var(--white, #fff);
            color: var(--ink);
        }

        .rencana-form .baris2 {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 8px;
        }

        .rencana-form button {
            background: var(--primary, #E88F9B);
            color: var(--white, #fff);
            border: 0;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
        }

        .rencana-form button:hover {
            background: var(--primary-dark, #B95569);
        }

        .rencana-list {
            flex: none;
            min-height: 0;
            overflow-y: visible;
            padding-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .plan {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: var(--background, #FFF2EF);
            border: 1.5px solid var(--line);
            border-radius: 14px;
            padding: 10px 12px;
        }

        .plan.done {
            opacity: .55;
        }

        .plan.done .plan-judul {
            text-decoration: line-through;
        }

        .plan-cek {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid var(--primary, #E88F9B);
            background: var(--white, #fff);
            color: var(--white, #fff);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
            flex-shrink: 0;
        }

        .plan-cek svg {
            opacity: 0;
        }

        .plan.done .plan-cek {
            background: var(--primary, #E88F9B);
        }

        .plan.done .plan-cek svg {
            opacity: 1;
        }

        .plan-isi {
            flex: 1;
            min-width: 0;
        }

        .plan-judul {
            font-size: 13.5px;
            font-weight: 600;
            word-break: break-word;
        }

        .plan-sub {
            font-size: 11.5px;
            color: var(--muted);
        }

        .plan-sub .telat {
            color: var(--primary-dark, #B95569);
            font-weight: 600;
        }

        .plan-hapus {
            border: 0;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            padding: 0 2px;
            font-size: 18px;
            line-height: 1;
        }
        @media (max-width: 560px) {
    .beranda-body {
        grid-template-columns: 1fr;
    }

    .rencana {
        position: static;
        height: auto;
        max-height: 560px;
    }

    .rencana-list {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
    }
}
    </style>

    <div class="beranda">
        <div class="beranda-body">
            <div class="kolom-utama">
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
                                <span class="kartu-ikon" aria-hidden="true">
                                    @switch($k['ikon'])
                                        @case('cake')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 2.5c.8.7 1 1.4.5 2a1 1 0 0 1-1.7-.1c-.2-.6 0-1.2 1.2-1.9Z"
                                                    fill="currentColor" stroke-width="1" />
                                                <path d="M12 7v3" />
                                                <rect x="4" y="10" width="16" height="9" rx="2" />
                                                <path d="M4 14c1.3 1.3 2.7 1.3 4 0s2.7-1.3 4 0 2.7 1.3 4 0 2.7-1.3 4 0" />
                                                <path d="M3 21.5h18" />
                                            </svg>
                                        @break

                                        @case('week')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="5" width="18" height="16" rx="2" />
                                                <path d="M16 3v4M8 3v4M3 10h18" />
                                                <path d="M7 15h10" />
                                            </svg>
                                        @break

                                        @default
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="5" width="18" height="16" rx="2" />
                                                <path d="M16 3v4M8 3v4M3 10h18" />
                                                <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"
                                                    stroke-width="2.4" />
                                            </svg>
                                    @endswitch
                                </span>
                            </div>

                            <div class="kartu-tengah">
                                <p class="kartu-angka"><strong>{{ $total }}</strong> people</p>
                                <div class="tumpuk">
                                    @foreach (collect($k['daftar'])->take(3) as $t)
                                        <img class="av"
                                            src="{{ $t->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($t->name) . '&background=FCE4E6&color=B95569&size=128&bold=true' }}"
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
                                            src="{{ $b->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($b->name) . '&background=FCE4E6&color=B95569&size=96&bold=true' }}"
                                            alt="{{ $b->name }}">
                                        <p class="baris-nama">{{ $b->name }}</p>
                                    </div>
                                    <div class="baris-kanan">
                                        <div>
                                            <p class="baris-tgl">
                                                {{ $b->ulang_tahun_berikutnya->format('j M') }}</p>
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
                <section class="panel">
                    <div class="panel-head">
                        <h2 class="panel-judul">Friends Who Have Joined</h2>
                        <a href="{{ route('friends.index') }}" class="panel-link">See all</a>
                    </div>

                    @if ($semuaTeman->isEmpty())
                        <p class="kosong">
                            No Friend's yet.
                            <a href="{{ route('friends.create') }}">Add Friend</a>
                        </p>
                    @else
                        @php $maks = 14; @endphp
                        <div class="avatar-grid">
                            @foreach ($semuaTeman->take($maks) as $t)
                                <a href="{{ route('friends.edit', $t->id) }}" class="avatar-item"
                                    title="{{ $t->name }}">
                                    <img class="av x1"
                                        src="{{ $t->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($t->name) . '&background=FCE4E6&color=B95569&size=128&bold=true' }}"
                                        alt="{{ $t->name }}">
                                </a>
                            @endforeach

                            @if ($semuaTeman->count() > $maks)
                                <a href="{{ route('friends.index') }}" class="avatar-item avatar-lebih">
                                    +{{ $semuaTeman->count() - $maks }}
                                </a>
                            @endif
                        </div>
                    @endif
                </section>
            </div>
            <aside class="panel rencana" aria-label="Preparations">
                <div class="rencana-head">
                    <h2 class="panel-judul">Preparations</h2>
                    <span class="rencana-badge">{{ $rencana->where('is_done', false)->count() }} left</span>
                </div>

                @if ($errors->any())
                    <p class="rencana-err">{{ $errors->first() }}</p>
                @endif

                @if ($semuaTeman->isEmpty())
                    <p class="kosong">Add a friend first to start planning.
                        <a href="{{ route('friends.create') }}">Add Friend</a>
                    </p>
                @else
                    <form class="rencana-form" action="{{ route('plans.store') }}" method="POST">
                        @csrf
                        <select name="friend_id" required>
                            <option value="" disabled selected>Choose a friend</option>
                            @foreach ($semuaTeman as $t)
                                <option value="{{ $t->id }}" @selected(old('friend_id') == $t->id)>{{ $t->display_name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="title" value="{{ old('title') }}" maxlength="150"
                            placeholder="e.g. Buy a gift" required>
                        <div class="baris2">
                            <input type="date" name="due_date" value="{{ old('due_date') }}">
                            <button type="submit">Add</button>
                        </div>
                    </form>
                @endif

                <div class="rencana-list">
                    @forelse ($rencana as $p)
                        @php
                            $sisaHari = $p->due_date
                                ? (int) now()
                                    ->startOfDay()
                                    ->diffInDays($p->due_date->copy()->startOfDay(), false)
                                : null;
                        @endphp
                        <div class="plan {{ $p->is_done ? 'done' : '' }}">
                            <form action="{{ route('plans.toggle', $p) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="plan-cek" aria-label="Toggle done">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12.5l4.5 4.5L19 7.5" />
                                    </svg>
                                </button>
                            </form>
                            <div class="plan-isi">
                                <p class="plan-judul">{{ $p->title }}</p>
                                <p class="plan-sub">
                                    for {{ $namaDepan($p->friend->display_name ?? '') }} &middot;
                                    @if (is_null($sisaHari))
                                        No due date
                                    @elseif ($p->is_done)
                                        Done
                                    @elseif ($sisaHari < 0)
                                        <span class="telat">{{ abs($sisaHari) }} days overdue</span>
                                    @elseif ($sisaHari === 0)
                                        Today
                                    @elseif ($sisaHari === 1)
                                        Tomorrow
                                    @else
                                        {{ $sisaHari }} days left
                                    @endif
                                </p>
                            </div>
                            <form action="{{ route('plans.destroy', $p) }}" method="POST"
                                onsubmit="return confirm('Delete this preparation?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="plan-hapus" aria-label="Delete">&times;</button>
                            </form>
                        </div>
                    @empty
                        <p class="kosong">No preparations yet.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    @endsection
