<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Birthday Reminder</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --primary: #5D688A; --secondary: #F7A5A5; --accent: #FFDBB6; --background: #FFF2EF; --text: #333333; --white: #FFFFFF; }
        body { margin: 0; font-family: "Poppins", sans-serif; background-color: var(--background); color: var(--text); }
        .login-content { min-height: 100vh; width: 100%; }
        .auth-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px; background: var(--background); }
        .auth-card { width: 100%; max-width: 1050px; min-height: 600px; display: flex; overflow: hidden; background: var(--white); border-radius: 28px; box-shadow: 0 15px 40px rgba(93, 104, 138, 0.15); }
        .auth-left { width: 45%; padding: 55px; background: var(--primary); color: white; display: flex; flex-direction: column; justify-content: center; }
        .auth-logo { font-size: 48px; margin-bottom: 20px; }
        .auth-left h1 { font-size: 42px; font-weight: 700; line-height: 1.1; margin-bottom: 15px; }
        .auth-left p { font-size: 16px; line-height: 1.7; opacity: 0.9; }
        .auth-illustration { font-size: 110px; text-align: center; margin-top: 35px; }
        .auth-right { width: 55%; padding: 55px 70px; display: flex; flex-direction: column; justify-content: center; }
        .auth-right h2 { color: var(--primary); font-size: 30px; font-weight: 700; margin-bottom: 8px; }
        .auth-subtitle { color: #777; margin-bottom: 30px; }
        .auth-label { font-weight: 600; color: var(--primary); margin-bottom: 8px; }
        .auth-input { border: 1px solid #e5dede; border-radius: 12px; padding: 13px 15px; background: #fffafa; }
        .auth-input:focus { border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(247, 165, 165, 0.2); }
        .auth-button { width: 100%; border: none; border-radius: 12px; padding: 13px; background: var(--secondary); color: white; font-weight: 600; transition: 0.2s; }
        .auth-button:hover { background: var(--primary); color: white; }
        .auth-link { color: var(--primary); text-decoration: none; font-weight: 500; }
        .auth-link:hover { color: var(--secondary); }

        @media (max-width: 768px) {
            .auth-card { flex-direction: column; }
            .auth-left, .auth-right { width: 100%; padding: 35px; }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>