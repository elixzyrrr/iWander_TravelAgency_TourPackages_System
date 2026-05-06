@extends('admin.layout')

@section('title', 'User Management')
@section('page_title', 'Users')
@section('page_subtitle', 'Create, update, and delete admin-facing users')

@section('content')
    <div class="admin-grid two-col">
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Create User</h2>
                    <p class="admin-card-copy">This form writes directly into the users table.</p>
                </div>
            </div>

            <form class="admin-form-stack" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="admin-form-grid">
                    <div class="admin-field">
                        <label class="admin-label" for="name">Name</label>
                        <input class="admin-input" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="admin-field">
                        <label class="admin-label" for="email">Email</label>
                        <input class="admin-input" id="email" name="email" type="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="admin-field">
                        <label class="admin-label" for="role">Role</label>
                        <select class="admin-select" id="role" name="role" required>
                            <option value="">Choose a role</option>
                            @foreach (['admin', 'agent'] as $role)
                                <option value="{{ $role }}" @selected(old('role') === $role)>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="admin-field">
                        <label class="admin-label" for="status">Status</label>
                        <select class="admin-select" id="status" name="status" required>
                            @foreach (['active', 'inactive', 'locked'] as $status)
                                <option value="{{ $status }}" @selected(old('status', 'active') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="admin-field">
                        <label class="admin-label" for="commission_rate">Commission Rate</label>
                        <input class="admin-input" id="commission_rate" name="commission_rate" type="number" min="0" max="100" step="0.01" value="{{ old('commission_rate', 0) }}">
                    </div>
                    <div class="admin-field">
                        <label class="admin-label" for="credit_limit">Credit Limit</label>
                        <input class="admin-input" id="credit_limit" name="credit_limit" type="number" min="0" step="0.01" value="{{ old('credit_limit', 0) }}">
                    </div>
                    <div class="admin-field">
                        <label class="admin-label" for="password">Password</label>
                        <input class="admin-input" id="password" name="password" type="password" required>
                    </div>
                    <div class="admin-field">
                        <label class="admin-label" for="password_confirmation">Confirm Password</label>
                        <input class="admin-input" id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>
                </div>
                <div class="admin-actions">
                    <button class="admin-btn primary" type="submit">Save User</button>
                    <a class="admin-btn secondary" href="{{ route('admin.dashboard') }}">Back to dashboard</a>
                </div>
            </form>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">User Counts</h2>
                    <p class="admin-card-copy">A quick read on the database state.</p>
                </div>
            </div>
                <div class="admin-metric-list">
                    <div class="admin-metric"><span>Total Users</span><strong>{{ $metrics['totalUsers'] ?? 0 }}</strong></div>
                    <div class="admin-metric"><span>Active</span><strong>{{ $metrics['activeUsers'] ?? 0 }}</strong></div>
                    <div class="admin-metric"><span>Inactive</span><strong>{{ $metrics['inactiveUsers'] ?? 0 }}</strong></div>
                    <div class="admin-metric"><span>Locked</span><strong>{{ $metrics['lockedUsers'] ?? 0 }}</strong></div>
                </div>
        </div>
    </div>

    <div class="admin-card" style="margin-top: 20px;">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">All Users</h2>
                    <p class="admin-card-copy">Edit or delete users from the database. Account status is managed in Edit User.</p>
            </div>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Commission</th>
                        <th>Credit Limit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="admin-chip role">{{ $user->role }}</span></td>
                            <td><span class="admin-chip {{ $user->status }}">{{ $user->status }}</span></td>
                            <td>{{ number_format((float) $user->commission_rate, 2) }}%</td>
                            <td>₱{{ number_format((float) $user->credit_limit, 2) }}</td>
                            <td>
                                <div class="admin-row-actions">
                                    <a class="admin-btn secondary admin-row-btn" href="{{ route('admin.users.edit', $user) }}">Edit User</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-btn danger admin-row-btn" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="admin-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
            @if ($users->hasPages())
                @php
                    $query = request()->except('page');
                    $currentPage = $users->currentPage();
                    $lastPage = $users->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);
                @endphp

                <div class="pagination">
                    <form method="GET" action="{{ url()->current() }}">
                        @foreach ($query as $key => $value)
                            @if (is_array($value))
                                @foreach ($value as $arrayValue)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <button type="submit" name="page" value="{{ max(1, $currentPage - 1) }}" @disabled($users->onFirstPage())>
                            Previous
                        </button>
                    </form>

                    @if ($startPage > 1)
                        <button type="button" disabled>...</button>
                    @endif

                    @for ($page = $startPage; $page <= $endPage; $page++)
                        <form method="GET" action="{{ url()->current() }}">
                            @foreach ($query as $key => $value)
                                @if (is_array($value))
                                    @foreach ($value as $arrayValue)
                                        <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <button type="submit" name="page" value="{{ $page }}" class="{{ $page === $currentPage ? 'active' : '' }}" @disabled($page === $currentPage)>
                                {{ $page }}
                            </button>
                        </form>
                    @endfor

                    @if ($endPage < $lastPage)
                        <button type="button" disabled>...</button>
                    @endif

                    <form method="GET" action="{{ url()->current() }}">
                        @foreach ($query as $key => $value)
                            @if (is_array($value))
                                @foreach ($value as $arrayValue)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <button type="submit" name="page" value="{{ min($lastPage, $currentPage + 1) }}" @disabled(! $users->hasMorePages())>
                            Next
                        </button>
                    </form>
                </div>
            @endif
    </div>
@endsection
