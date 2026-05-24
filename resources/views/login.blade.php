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
                <svg class="left-logo" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M3 12L21 3L13 21L10 13L3 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 13L21 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                
                <h1 class="left-title">iWander</h1>
                
                <p class="left-tagline">Explore The World With Luxury</p>
                
                <div class="left-footer">
                    <p class="left-footer-title">adventure & wanderlust</p>
                    <p class="left-footer-text">Contact: +1 (555) 123-4567</p>
                    <p class="left-footer-text">www.iwander.com</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="right-panel">
            <div class="form-container">
                <!-- Mobile Logo -->
                <div class="mobile-logo">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M3 12L21 3L13 21L10 13L3 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 13L21 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="mobile-logo-text">iWander</span>
                </div>

                <!-- Form Header -->
                <div class="form-header">
                    <h2 class="form-title">Login Here!</h2>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                    <div id="errorMessage" class="error-message">
                        {{ $errors->first() }}
                    </div>
                @else
                    <div id="errorMessage" class="error-message" style="display: none;"></div>
                @endif

                <!-- Login Form -->
                <form class="form" id="loginForm" method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <!-- Email Field -->
                    @error('email')
                        <div class="field-error field-error-top" aria-live="polite">{{ $message }}</div>
                    @enderror
                    <div class="input-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <div class="input-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="email address"
                            value="{{ old('email') }}"
                            required
                        />
                    </div>

                    <!-- Password Field -->
                    @error('password')
                        <div class="field-error field-error-top" aria-live="polite">{{ $message }}</div>
                    @enderror
                    <div class="input-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <div class="input-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="password"
                            required
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

                    <!-- Remember Password -->
                    <div class="checkbox-group">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            value="1"
                        />
                        <label for="remember" class="checkbox-label">
                            Remember Password
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn-submit">
                        <span>LOGIN</span>
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                    <!-- Cancel Button -->
                    <a href="{{ route('landing') }}" class="btn-cancel">
                        <span>CANCEL</span>
                    </a>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <span class="divider-text">or</span>
                </div>

                <!-- Sign Up Link -->
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
