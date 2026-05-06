<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/login.css')
</head>
<body>
    <div class="container">
        <!-- Left Side - Designed Section -->
        <div class="left-panel">
            <img 
                src="https://images.unsplash.com/photo-1768438194652-651b5a6d9580?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBiZWFjaCUyMHBhcmFkaXNlJTIwbWFsZGl2ZXMlMjBhZXJpYWx8ZW58MXx8fHwxNzc0MjM3NjY3fDA&ixlib=rb-4.1.0&q=80&w=1080"
                alt="Luxury travel destination" 
                class="left-bg"
            />
            
            <div class="left-overlay"></div>
            
            <div class="left-content">
                <svg class="left-logo" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                
                <h1 class="left-title">iWander</h1>
                
                <p class="left-tagline">Explore The World With Luxury</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="right-panel">
            <div class="form-container">
                <!-- Mobile Logo -->
                <div class="mobile-logo">
                    <svg class="logo-img" viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30.5 0L61 47H0L30.5 0Z" fill="white" opacity="0.9"/>
                    <path d="M30.5 10L50 40H11L30.5 10Z" fill="#237f87"/>
                    </svg>
                    <span class="mobile-logo-text">iWander</span>
                </div>

                <div class="form-header">
                    <h2 class="form-title">Login Here!</h2>
                </div>

                <form class="form" id="loginForm" method="POST" action="{{ route('login.store') }}">
                    @csrf

                    @if ($errors->any())
                        <div style="margin-bottom: 8px; color: #dc2626; font-size: 14px;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="input-group">
                        <div class="input-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            placeholder="email"
                            required
                            autocomplete="email"
                        />
                    </div>

                    <div class="input-group">
                        <div class="input-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="password"
                            required
                            autocomplete="current-password"
                        />
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <svg id="eyeIconClosed" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                            <svg id="eyeIconOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <div class="checkbox-group">
                        <input
                            name="remember"
                            id="remember"
                            type="checkbox"
                            value="1"
                        />
                        <label for="remember" class="checkbox-label">
                            Remember Password
                        </label>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>LOGIN</span>
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </form>

                <div class="signup-link">
                    <p class="signup-link-text">
                        Don't have an account? <a href="{{ route('signup') }}">Sign Up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/login.js')
</body>
</html>