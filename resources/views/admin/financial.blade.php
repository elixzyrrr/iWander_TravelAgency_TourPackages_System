@extends('admin.layout')

@section('title', 'Financial')
@section('page_title', 'Financial')
@section('page_subtitle', 'Review commission exposure and user credit limits')

@section('content')
    <div class="admin-grid stats">
        <div class="admin-card admin-stat">
            <div class="admin-stat-value">₱{{ number_format($summary['projectedCommission'], 2) }}</div>
            <div class="admin-stat-label">Projected Commission</div>
        </div>
        <div class="admin-card admin-stat">
            <div class="admin-stat-value">₱{{ number_format($summary['totalCreditLimit'], 2) }}</div>
            <div class="admin-stat-label">Total Credit Limit</div>
        </div>
        <div class="admin-card admin-stat">
            <div class="admin-stat-value">₱{{ number_format($summary['lockedExposure'], 2) }}</div>
            <div class="admin-stat-label">Locked Exposure</div>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-card-title">Commission Overview</h2>

            </div>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Commission</th>
                        <th>Credit Limit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td><span class="admin-chip role">{{ $user->role }}</span></td>
                            <td><span class="admin-chip {{ $user->status }}">{{ $user->status }}</span></td>
                            <td>{{ number_format((float) $user->commission_rate, 2) }}%</td>
                            <td>₱{{ number_format((float) $user->credit_limit, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="admin-muted">No financial records found.</td>
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
