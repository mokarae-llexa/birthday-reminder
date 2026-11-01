<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Reminder</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500;600;700&family=Fraunces:opsz,wght@9..144,700;9..144,800;9..144,900&display=swap"
        rel="stylesheet">

    @vite('resources/js/app.js')
</head>

<body>
    <div class="landing-page page-shell">
        <header class="site-header">
            <nav class="nav-wrap" aria-label="Navigasi utama">
                <div class="nav-group nav-left">
                    <a href="{{ url('/') }}" aria-current="page">Home</a>
                    <a href="{{ url('/calendar') }}">Birthdays</a>
                </div>

                <a class="logo" href="{{ url('/') }}" aria-label="Birthday Reminder home">
                    <span>Birthday</span> Reminder
                </a>

                <div class="nav-group nav-right">
                    <a href="{{ url('/notifications') }}">Reminders</a>
                    <a href="{{ route('login') }}">Login</a>
                    <span class="tiny-cake" aria-hidden="true">
                        <svg viewBox="0 0 42 42">
                            <path d="M10 21h22v14H10z" fill="#FFF2EF" stroke="currentColor" stroke-width="2" />
                            <path d="M10 24c4 4 6-3 10 0s7-3 12 0v-4H10v4Z" fill="#F7A5A5" />
                            <path d="M15 20v-7m6 7v-9m6 9v-7" stroke="currentColor" stroke-width="2" />
                            <path d="m13.5 11.5 1.5-3 1.5 3.5m3-2L21 6l1.5 3.5m3 2L27 8l1.5 3.5" fill="#FFDBB6"
                                stroke="#FFDBB6" />
                        </svg>
                    </span>
                </div>
            </nav>
        </header>

        <main class="hero">
            <section class="hero-card" aria-labelledby="hero-heading">
                <div class="stickers" aria-hidden="true">
                    <svg class="sticker sticker-cake" viewBox="0 0 135 130">
                        <path d="m22 50 24-11 60 14 12 59-87 4Z" fill="#FFF2EF" stroke="#5D688A" stroke-width="3.5" />
                        <path d="m29 68 82 2 3 39-80 3Z" fill="#F7A5A5" stroke="#5D688A" stroke-width="3.5" />
                        <path d="M30 67c11 0 10 13 21 13s9-13 20-13 10 13 21 13 9-10 19-10l-2-14-80-1Z"
                            fill="#F7A5A5" />
                        <path d="m29 68 82 2m-77 42 80-3" stroke="#5D688A" stroke-width="3.5" />
                        <path d="m45 54-1-24m24 25 1-30m23 33 3-24" stroke="#5D688A" stroke-width="4" />
                        <path
                            d="M39 27c1-7 7-12 7-12s6 7 5 13a6 6 0 1 1-12-1Zm24-5c1-7 7-12 7-12s6 7 5 13a6 6 0 1 1-12-1Zm26 9c1-7 7-12 7-12s6 7 5 13a6 6 0 1 1-12-1Z"
                            fill="#FFDBB6" stroke="#5D688A" stroke-width="2.5" />
                        <path d="m49 94 7 4m19-9-2 8m20-4 5-5" stroke="#FFF2EF" stroke-linecap="round"
                            stroke-width="4" />
                    </svg>

                    <svg class="sticker sticker-gift" viewBox="0 0 110 105">
                        <path d="m14 43 76 5-6 48-67-4Z" fill="#F7A5A5" stroke="#5D688A" stroke-width="3.5" />
                        <path d="m11 36 85 5-2 19-84-6Z" fill="#F7A5A5" stroke="#5D688A" stroke-width="3.5" />
                        <path d="m48 39 16 1-4 54-17-1Z" fill="#FFDBB6" stroke="#5D688A" stroke-width="3" />
                        <path d="M54 37C35 29 32 13 45 14c10 1 10 13 10 23Zm4 1c20-5 25-20 12-21-10-1-12 11-12 21Z"
                            fill="#FFF2EF" stroke="#5D688A" stroke-linejoin="round" stroke-width="3.5" />
                    </svg>

                    <svg class="sticker sticker-hat" viewBox="0 0 115 115">
                        <path d="m23 90 38-73 32 79Z" fill="#F7A5A5" stroke="#5D688A" stroke-linejoin="round"
                            stroke-width="3.5" />
                        <path d="m35 68 42-21 8 20-58 27Z" fill="#FFDBB6" />
                        <path d="M61 18c-7-10 8-17 11-6 1-10 15-6 10 3" stroke="#5D688A" stroke-linecap="round"
                            stroke-width="3" />
                        <path d="M13 96c18-8 65-7 88 2" fill="#F7A5A5" stroke="#5D688A" stroke-linecap="round"
                            stroke-width="7" />
                        <circle cx="55" cy="41" r="4" fill="#FFF2EF" />
                        <circle cx="70" cy="78" r="4" fill="#FFF2EF" />
                    </svg>

                    <svg class="sticker sticker-balloon" viewBox="0 0 110 145">
                        <path d="M84 45c0 25-17 43-34 42-18-1-33-20-31-45C21 17 36 6 55 8c19 1 31 13 29 37Z"
                            fill="#F7A5A5" stroke="#5D688A" stroke-width="3.5" />
                        <path d="m49 87 8 1-5 9Z" fill="#F7A5A5" stroke="#5D688A" stroke-linejoin="round"
                            stroke-width="2.5" />
                        <path d="M53 97c11 12-10 16 0 27 5 6 2 12-2 17" stroke="#5D688A" stroke-linecap="round"
                            stroke-width="2.5" />
                        <path d="M68 21c8 6 9 14 8 23" stroke="#FFF2EF" stroke-linecap="round" stroke-width="4" />
                    </svg>

                    <svg class="sticker sticker-calendar" viewBox="0 0 104 100">
                        <path d="m10 22 82-3 3 70-80 2Z" fill="#FFF2EF" stroke="#5D688A" stroke-width="3.5" />
                        <path d="m11 24 82-3 1 19-81 3Z" fill="#F7A5A5" stroke="#5D688A" stroke-width="3" />
                        <path d="m31 12 1 17m39-18 1 17" stroke="#5D688A" stroke-linecap="round" stroke-width="5" />
                        <path d="M47 55c5-11 22-7 20 5-1 8-10 14-17 20-6-5-15-11-16-18-2-11 11-14 16-6" fill="#F7A5A5"
                            stroke="#5D688A" stroke-linejoin="round" stroke-width="2.5" />
                    </svg>

                    <svg class="sticker sticker-candle" viewBox="0 0 75 120">
                        <path d="m22 40 35 1-5 66-32-3Z" fill="#FFDBB6" stroke="#5D688A" stroke-width="3.5" />
                        <path d="m24 58 31-9m-33 29 32-9m-33 29 32-9" stroke="#F7A5A5" stroke-width="7" />
                        <path d="M26 24C27 12 39 5 39 5s11 10 9 21a11 11 0 1 1-22-2Z" fill="#F7A5A5" stroke="#5D688A"
                            stroke-width="3" />
                        <path d="M34 25c0-5 5-9 5-9s4 5 3 10a4 4 0 1 1-8-1Z" fill="#FFDBB6" />
                    </svg>

                    <div class="mini-shape star star-one">★</div>
                    <div class="mini-shape star star-two">✦</div>
                    <div class="mini-shape heart heart-one">♥</div>
                    <div class="mini-shape heart heart-two">♥</div>
                    <div class="confetti confetti-one"></div>
                    <div class="confetti confetti-two"></div>
                    <div class="confetti confetti-three"></div>
                    <div class="confetti confetti-four"></div>
                </div>

                <div class="hero-copy">
                    <div class="eyebrow">
                        <span>Make every birthday special</span>
                    </div>

                    <h1 id="hero-heading">
                        Never Miss a<br>
                        <em>Birthday</em> Again!
                    </h1>

                    <p>
                        Remember every special moment and make your friends feel loved.
                        Keep track of birthdays, all in one place.
                    </p>

                    <div class="hero-actions">
                        <a class="primary-button" href="{{ route('register') }}">
                            Get started <span aria-hidden="true">→</span>
                        </a>
                        <a class="login-link" href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </section>
        </main>
