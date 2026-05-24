@extends('admin.layout')

@section('title', 'Authentication')
@section('page_title', 'Authentication')
@section('page_subtitle', 'Track locked users and generate password reset tokens')

@section('content')
    <div class="admin-grid two-col">
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Locked Accounts</h2>

                </div>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Locked At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lockedUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ optional($user->locked_at)->format('M d, Y h:i A') ?? 'N/A' }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.users.unlock', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="admin-btn success" type="submit">Unlock</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="admin-muted">No locked accounts.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:12px;">
                {{ $lockedUsers->links() }}
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Password Reset</h2>

                </div>
            </div>

            <form class="admin-form-stack" method="POST" action="{{ route('admin.authentication.reset') }}">
                @csrf
                <div class="admin-field">
                    <label class="admin-label" for="email">User Email</label>
                    <input class="admin-input" id="email" name="email" type="email" required>
                </div>
                <button class="admin-btn primary" type="submit">Generate Reset Token</button>
            </form>

            <div class="admin-card soft" style="margin-top: 18px;">
                <div class="admin-card-header">
                    <div>
                        <h3 class="admin-card-title">Token Count</h3>

                    </div>
                </div>
                <div class="admin-stat-value" style="font-size: 1.75rem;">{{ $resetTokenCount }}</div>
            </div>
        </div>
    </div>
@endsection
