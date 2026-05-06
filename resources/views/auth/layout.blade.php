<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'iWander')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/auth.css')
</head>
<body>
    <main class="auth-shell">
        <section class="auth-hero">
            <div class="auth-hero-overlay"></div>
            <div class="auth-hero-content">
                <div class="auth-brand">
                    <span class="auth-brand-mark">iW</span>
                    <span class="auth-brand-name">iWander</span>
                </div>
                <h1>@yield('hero_title', 'Explore the world with clarity and control')</h1>
                <p>@yield('hero_text', 'Access your travel workspace, manage bookings, and continue exactly where you left off.')</p>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                @yield('content')
            </div>
        </section>
    </main>
</body>
</html>
