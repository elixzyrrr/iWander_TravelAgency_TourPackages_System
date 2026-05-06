@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'A live overview of the admin modules and their data')

@section('content')
    <div class="admin-grid stats">
        <div class="admin-card admin-stat">
            <div class="admin-stat-chip">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div class="admin-stat-value">{{ $stats['totalUsers'] }}</div>
            <div class="admin-stat-label">Total Users</div>
            <div class="admin-stat-foot">{{ $stats['activeUsers'] }} active, {{ $stats['lockedUsers'] }} locked</div>
        </div>

        <div class="admin-card admin-stat">
            <div class="admin-stat-chip">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="admin-stat-value">{{ number_format($stats['avgCommission'], 2) }}%</div>
            <div class="admin-stat-label">Average Commission</div>
            <div class="admin-stat-foot">Based on all user records</div>
        </div>

        <div class="admin-card admin-stat">
            <div class="admin-stat-chip">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="admin-stat-value">{{ number_format($stats['resetTokens']) }}</div>
            <div class="admin-stat-label">Password Reset Tokens</div>
            <div class="admin-stat-foot">Authentication activity</div>
        </div>

        <div class="admin-card admin-stat">
            <div class="admin-stat-chip">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2v4c0 1.105 1.343 2 3 2s3-.895 3-2v-4c0-1.105-1.343-2-3-2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16v10H4z"/></svg>
            </div>
            <div class="admin-stat-value">₱{{ number_format($stats['totalCreditLimit'], 2) }}</div>
            <div class="admin-stat-label">Total Credit Limit</div>
            <div class="admin-stat-foot warning">Financial controls available in the financial module</div>
        </div>
    </div>

    <div class="admin-grid two-col">
        <div class="admin-section">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Module Map</h2>
                        <p class="admin-card-copy">Each module is now routed separately and backed by the database.</p>
                    </div>
                </div>
                <div class="admin-metric-list">
                    <div class="admin-metric">
                        <span>Users</span>
                        <a class="admin-panel-link" href="{{ route('admin.users.index') }}">Manage records</a>
                    </div>
                    <div class="admin-metric">
                        <span>Authentication</span>
                        <a class="admin-panel-link" href="{{ route('admin.authentication') }}">Monitor resets</a>
                    </div>
                    <div class="admin-metric">
                        <span>System Config</span>
                        <a class="admin-panel-link" href="{{ route('admin.system') }}">Edit settings</a>
                    </div>
                    <div class="admin-metric">
                        <span>Financial</span>
                        <a class="admin-panel-link" href="{{ route('admin.financial') }}">Review commission</a>
                    </div>
                    <div class="admin-metric">
                        <span>Analytics</span>
                        <a class="admin-panel-link" href="{{ route('admin.analytics') }}">View insights</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-section">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">System Snapshot</h2>
                        <p class="admin-card-copy">Loaded from admin settings and user tables.</p>
                    </div>
                </div>
                <div class="admin-metric-list">
                    <div class="admin-metric"><span>Agency</span><strong>{{ $settings['agency_name'] }}</strong></div>
                    <div class="admin-metric"><span>Contact Email</span><strong>{{ $settings['contact_email'] }}</strong></div>
                    <div class="admin-metric"><span>Currency</span><strong>{{ $settings['currency'] }}</strong></div>
                    <div class="admin-metric"><span>Reset Tokens</span><strong>{{ $stats['resetTokens'] }}</strong></div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Recent Users</h2>
                        <p class="admin-card-copy">Latest accounts pulled from the users table.</p>
                    </div>
                </div>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td><span class="admin-chip role">{{ $user->role }}</span></td>
                                    <td><span class="admin-chip {{ $user->status }}">{{ $user->status }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="admin-muted">No users available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
