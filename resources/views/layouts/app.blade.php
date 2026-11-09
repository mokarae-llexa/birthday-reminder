    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Birthday Reminder</title>

        <link rel="icon" type="image/png" href="{{ asset('images/icon-hat.ico') }}">

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary: #E88F9B;
                --primary-dark: #B95569;

                --secondary: #5D688A;
                --secondary-dark: #3F4766;

                --accent: #FFDBB6;
                --accent-dark: #E8A765;

                --background: #FFF2EF;
                --text: #333333;
                --white: #FFFFFF;
                --border: #F0C9C9;

                --primary-soft: #FCE4E6;
                --secondary-soft: #E9ECF4;
            }

body {
    margin: 0;
    font-family: "Poppins", sans-serif;
    color: var(--text);
    background-color: var(--background);
    background-image:
        linear-gradient(rgba(255, 242, 239, 0.75), rgba(255, 242, 239, 0.75)),
        url("{{ asset('assets/bg-pattern.jpeg') }}");
    background-repeat: no-repeat, repeat;
    background-size: cover, 350px auto;
    background-attachment: fixed;
}

            .dashboard-container {
                display: flex;
                min-height: 100vh;
                position: relative;
            }

            .sidebar {
                width: 260px;
                transition: transform 0.3s ease, margin-left 0.3s ease;
                flex-shrink: 0;
                z-index: 1000;
            }

            .sidebar.closed {
                transform: translateX(-100%);
                margin-left: -260px;
            }

            .main-content {
                flex: 1;
                padding: 30px;
                overflow-y: auto;
                width: 100%;
                transition: all 0.3s ease;
            }

            #sidebarBackdrop {
                display: none;
                background-color: rgba(0, 0, 0, 0.5);
            }

            #sidebarBackdrop.show {
                display: block !important;
            }

            .topbar {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 16px;
            }

            #sidebarToggle {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                background: var(--white);
                border: 1.5px solid var(--border);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: var(--primary-dark);
                cursor: pointer;
                box-shadow: none;
                flex-shrink: 0;
            }

            #sidebarToggle:hover {
                background: var(--primary-soft);
                border-color: var(--primary);
            }

            .sticker {
                color: var(--text);
                paint-order: stroke fill;
                -webkit-text-stroke: 0.28em #fff;
                text-shadow: 0 0 10px rgba(255, 255, 255, .9);
            }

            .sticker-soft {
                color: var(--primary-dark);
                font-weight: 500;
            }


            .btn-chip {
                background: var(--secondary-soft);
                border: 1.5px solid var(--secondary);
                color: var(--secondary-dark);
                font-weight: 600;
            }

            .btn-chip:hover {
                background: var(--secondary);
                border-color: var(--secondary-dark);
                color: var(--white);
            }

            .card-flat {
                background: var(--white);
                border: 1.5px solid var(--border) !important;
            }

            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(16px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes pop {
                from {
                    opacity: 0;
                    transform: scale(.92);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .anim-up {
                animation: fadeUp .5s ease backwards;
            }

            .anim-pop {
                animation: pop .4s cubic-bezier(.16, 1, .3, 1) backwards;
            }

            .d1 {
                animation-delay: .08s;
            }

            .d2 {
                animation-delay: .16s;
            }

            .d3 {
                animation-delay: .24s;
            }

            .d4 {
                animation-delay: .32s;
            }

            .card-flat,
            .btn {
                transition: transform .2s ease, border-color .2s ease, background-color .2s ease, color .2s ease;
            }

            .card-flat:hover {
                border-color: var(--primary) !important;
            }

            .btn:active {
                transform: scale(.96);
            }

            @media (prefers-reduced-motion: reduce) {

                *,
                *::before,
                *::after {
                    animation-duration: .01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: .01ms !important;
                }
            }
        </style>
    </head>

    <body>
        <div class="dashboard-container">
            <div id="sidebarBackdrop" class="position-fixed top-0 start-0 w-100 h-100" style="z-index: 1040;"></div>

            @include('layouts.sidebar')

            <main class="main-content">
                <div class="topbar">
                    <button id="sidebarToggle" aria-label="Toggle sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                @yield('content')
            </main>
        </div>

        <x-toast-notification />

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.querySelector('.sidebar');
                const toggleBtn = document.getElementById('sidebarToggle');
                const backdrop = document.getElementById('sidebarBackdrop');

                if (!sidebar || !toggleBtn) return;

                function isOpen() {
                    return !sidebar.classList.contains('closed');
                }

                if (window.innerWidth <= 768) {
                    sidebar.classList.add('closed');
                }

                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('closed');
                    backdrop?.classList.toggle('show', isOpen() && window.innerWidth <= 768);
                });

                backdrop?.addEventListener('click', () => {
                    sidebar.classList.add('closed');
                    backdrop.classList.remove('show');
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
        <style>
            .reveal {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity .6s ease, transform .6s ease;
            }

            .reveal.show {
                opacity: 1;
                transform: none;
            }
        </style>
        <script>
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('show');
                        io.unobserve(e.target);
                    }
                });
            }, {
                threshold: .15
            });
            document.querySelectorAll('.reveal').forEach(el => io.observe(el));
        </script>
        @stack('scripts')
    </body>

    </html>
