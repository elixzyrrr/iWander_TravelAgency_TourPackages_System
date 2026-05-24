@extends('admin.layout')

@section('title', 'Analytics')
@section('page_title', 'Analytics')
@section('page_subtitle', 'Summaries grouped from the current database records')

@section('content')
    <div class="admin-grid stats">
        <div class="admin-card admin-stat">
            <div class="admin-stat-value">{{ $summary['totalUsers'] }}</div>
            <div class="admin-stat-label">Total Users</div>
        </div>
        <div class="admin-card admin-stat">
            <div class="admin-stat-value">{{ $summary['activeUsers'] }}</div>
            <div class="admin-stat-label">Active Users</div>
        </div>
        <div class="admin-card admin-stat">
            <div class="admin-stat-value">{{ $summary['lockedUsers'] }}</div>
            <div class="admin-stat-label">Locked Users</div>
        </div>
        <div class="admin-card admin-stat">
            <div class="admin-stat-value">{{ number_format($summary['averageCommission'], 2) }}%</div>
            <div class="admin-stat-label">Average Commission</div>
        </div>
    </div>

    <div class="admin-grid two-col">
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Role Breakdown</h2>

                </div>
            </div>
            <div class="admin-metric-list">
                @forelse ($roleBreakdown as $item)
                    <div class="admin-metric"><span>{{ ucfirst($item->role) }}</span><strong>{{ $item->total }}</strong></div>
                @empty
                    <div class="admin-muted">No role data available.</div>
                @endforelse
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Status Breakdown</h2>

                </div>
            </div>
            <div class="admin-metric-list">
                @forelse ($statusBreakdown as $item)
                    <div class="admin-metric"><span>{{ ucfirst($item->status) }}</span><strong>{{ $item->total }}</strong></div>
                @empty
                    <div class="admin-muted">No status data available.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="admin-card" style="margin-top: 20px;">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Top Credit Limits</h2>

            </div>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Credit Limit</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td><span class="admin-chip role">{{ $user->role }}</span></td>
                            <td>₱{{ number_format((float) $user->credit_limit, 2) }}</td>
                            <td><span class="admin-chip {{ $user->status }}">{{ $user->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="admin-muted">No analytics data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($topUsers->hasPages())
            @php
                $query = request()->except('page');
                $currentPage = $topUsers->currentPage();
                $lastPage = $topUsers->lastPage();
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
                    <button type="submit" name="page" value="{{ max(1, $currentPage - 1) }}" @disabled($topUsers->onFirstPage())>
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
                    <button type="submit" name="page" value="{{ min($lastPage, $currentPage + 1) }}" @disabled(! $topUsers->hasMorePages())>
                        Next
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
