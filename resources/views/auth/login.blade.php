@extends('auth.layout')

@section('title', 'Login - iWander')
@section('hero_title', 'Welcome back')
@section('hero_text', 'Sign in to continue to your admin, agent, or user dashboard.')

@section('content')
    <div class="auth-header">
        <h2>Login</h2>
        <p>Use your email and password to continue.</p>
    </div>

    @if ($errors->any())
        <div class="auth-alert auth-alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="auth-form">
        @csrf

        <label class="auth-field">
            <span>Email</span>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
        </label>

        <label class="auth-field">
            <span>Password</span>
            <input type="password" name="password" required autocomplete="current-password">
        </label>

        <label class="auth-checkbox">
            <input type="checkbox" name="remember" value="1">
            <span>Remember me</span>
        </label>

        <button type="submit" class="auth-button">Login</button>
    </form>

    <p class="auth-footer-text">
        Don't have an account? <a href="{{ route('register') }}">Register</a>
    </p>
@endsection
