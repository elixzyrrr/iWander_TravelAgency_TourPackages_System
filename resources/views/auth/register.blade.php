@extends('auth.layout')

@section('title', 'Register - iWander')
@section('hero_title', 'Create your account')
@section('hero_text', 'Join iWander and get the right dashboard for your role.')

@section('content')
    <div class="auth-header">
        <h2>Register</h2>
        <p>Create a user account to get started.</p>
    </div>

    @if ($errors->any())
        <div class="auth-alert auth-alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="auth-form">
        @csrf

        <label class="auth-field">
            <span>Full name</span>
            <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
        </label>

        <label class="auth-field">
            <span>Email</span>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
        </label>

        <label class="auth-field">
            <span>Password</span>
            <input type="password" name="password" required autocomplete="new-password">
        </label>

        <label class="auth-field">
            <span>Confirm password</span>
            <input type="password" name="password_confirmation" required autocomplete="new-password">
        </label>

        <button type="submit" class="auth-button">Create account</button>
    </form>

    <p class="auth-footer-text">
        Already have an account? <a href="{{ route('login') }}">Login</a>
    </p>
@endsection
