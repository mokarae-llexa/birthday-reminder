<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Reminder</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #5D688A;
            --secondary: #F7A5A5;
            --accent: #FFDBB6;
            --background: #FFF2EF;
            --text: #333333;
            --white: #FFFFFF;
        }

        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            color: var(--text);
            background-image: url("{{ asset('assets/bg-pattern.png') }}");
            background-repeat: repeat;
            background-size: 350px auto;
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

        #sidebarToggle {
            position: fixed;
            top: 20px;
            left: 272px;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #FFFFFF;
            border: 1.5px solid #FFD6D2;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #C55F4E;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            z-index: 1100;
            transition: left 0.3s ease;
        }

        #sidebarToggle:hover {
            background: #FFF0EE;
        }

        .sidebar.closed~#sidebarToggle {
            left: 20px;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <div id="sidebarBackdrop" class="position-fixed top-0 start-0 w-100 h-100" style="z-index: 1040;"></div>
        <button id="sidebarToggle" class="sidebar-edge-toggle" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>

        @include('layouts.sidebar')

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (!sidebar || !toggleBtn) return; 
            function isOpen() {
                return !sidebar.classList.contains('closed');
            }

            function updateToggleBtnPosition() {
                if (isOpen()) {
                    toggleBtn.style.left = '272px';
                } else {
                    toggleBtn.style.left = '20px';
                }
            }
            
            if (window.innerWidth <= 768) {
                sidebar.classList.add('closed');
            }
            updateToggleBtnPosition();

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('closed');
                backdrop?.classList.toggle('show', isOpen() && window.innerWidth <= 768);
                updateToggleBtnPosition(); 
            });

            backdrop?.addEventListener('click', () => {
                sidebar.classList.add('closed');
                backdrop.classList.remove('show');
                updateToggleBtnPosition();
            });
        });
    </script>
</body>

</html>
