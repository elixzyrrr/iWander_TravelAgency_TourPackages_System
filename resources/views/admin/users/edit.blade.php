@extends('admin.layout')

@section('title', 'Edit User')
@section('page_title', 'Edit User')
@section('page_subtitle', 'Update the selected account and its access status')

@section('content')
    <div class="admin-card">
        <form class="admin-form-stack" method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label class="admin-label" for="name">Name</label>
                    <input class="admin-input" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="email">Email</label>
                    <input class="admin-input" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="role">Role</label>
                    <select class="admin-select" id="role" name="role" required>
                        @foreach (['admin', 'agent'] as $role)
                            <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="status">Status</label>
                    <select class="admin-select" id="status" name="status" required>
                        @foreach (['active', 'inactive', 'locked'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $user->status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <div class="admin-help">Choose locked to disable the account. The change is saved when you press Update User.</div>
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="commission_rate">Commission Rate</label>
                    <input class="admin-input" id="commission_rate" name="commission_rate" type="number" min="0" max="100" step="0.01" value="{{ old('commission_rate', $user->commission_rate) }}">
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="credit_limit">Credit Limit</label>
                    <input class="admin-input" id="credit_limit" name="credit_limit" type="number" min="0" step="0.01" value="{{ old('credit_limit', $user->credit_limit) }}">
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="password">Password</label>
                    <input class="admin-input" id="password" name="password" type="password" placeholder="Leave blank to keep current password">
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="password_confirmation">Confirm Password</label>
                    <input class="admin-input" id="password_confirmation" name="password_confirmation" type="password">
                </div>
            </div>
            <div class="admin-actions">
                <button class="admin-btn primary" type="submit">Update User</button>
                <a class="admin-btn secondary" href="{{ route('admin.users.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
