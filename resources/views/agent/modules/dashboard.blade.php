@extends('agent.layout')

@section('title', 'Dashboard')
@section('page_title', $page['title'])
@section('page_subtitle', $page['subtitle'])

@section('content')
    @unless ($storageReady ?? true)
        <div class="admin-alert error">
            The agent tables are not ready yet. Run <strong>php artisan migrate</strong> to create <code>agent_records</code> and <code>agent_settings</code>.
        </div>
    @endunless

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon" style="background: #3b82f6;">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
            </div>
            <div class="stat-title">Total Bookings</div>
            <div class="stat-value">{{ $summary['totalBookings'] }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon" style="background: #10b981;">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="stat-title">Active Customers</div>
            <div class="stat-value">{{ $summary['totalCustomers'] }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon" style="background: #f59e0b;">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
            </div>
            <div class="stat-title">Pending Requests</div>
            <div class="stat-value">{{ $summary['pendingRequests'] }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon" style="background: #237f87;">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="stat-title">Revenue</div>
            <div class="stat-value">₱{{ number_format($summary['revenue'], 2) }}</div>
        </div>
    </div>

    <div class="grid-2" style="margin-top: 18px;">
        <div class="table-container">
            <div class="table-header">
                <div class="panel-header">
                    <div>
                        <h3 class="panel-title">Recent Flights</h3>
                    </div>
                    <a class="btn btn-view" href="{{ route('agent.module', ['module' => 'flights']) }}">View All</a>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Destination</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentFlights as $record)
                            <tr>
                                <td>{{ $record->title }}</td>
                                <td>{{ $record->destination ?? 'N/A' }}</td>
                                <td><span class="status-badge status-{{ $record->status }}">{{ ucfirst(str_replace('_', ' ', $record->status)) }}</span></td>
                                <td>₱{{ number_format((float) ($record->amount ?? 0), 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4">No flight records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div class="panel-header">
                    <div>
                        <h3 class="panel-title">Recent Hotels & Packages</h3>
                    </div>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Module</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (collect($recentHotels)->concat($recentPackages)->take(6) as $record)
                            <tr>
                                <td>{{ $record->title }}</td>
                                <td>{{ ucfirst($record->module) }}</td>
                                <td><span class="status-badge status-{{ $record->status }}">{{ ucfirst(str_replace('_', ' ', $record->status)) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3">No hotel or package records yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="table-container">
            <div class="table-header">
                <div class="panel-header">
                    <div>
                        <h3 class="panel-title">Recent Bookings</h3>

                    </div>
                    <a class="btn btn-view" href="{{ route('agent.module', ['module' => 'bookings']) }}">View All</a>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Customer</th>
                            <th>Destination</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentBookings as $record)
                            <tr>
                                <td>{{ $record->reference_code ?? 'N/A' }}</td>
                                <td>{{ $record->user?->name ?? 'Unknown customer' }}</td>
                                <td>{{ $record->destination ?? $record->origin ?? 'N/A' }}</td>
                                <td><span class="status-badge status-{{ $record->status }}">{{ ucfirst(str_replace('_', ' ', $record->status)) }}</span></td>
                                <td>₱{{ number_format((float) ($record->amount ?? 0), 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No bookings yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pending-requests">
            <h3 class="pending-requests-title">Pending Requests</h3>
            @forelse ($pendingRequests as $requestItem)
                <div class="request-item">
                    <div class="request-customer">{{ $requestItem->contact_name ?? $requestItem->title }}</div>
                    <span class="request-type">{{ ucfirst($requestItem->module) }}</span>
                    <div class="request-text">{{ $requestItem->description ?? 'No details provided.' }}</div>
                    <div class="request-time">{{ $requestItem->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <p>No pending requests.</p>
            @endforelse
        </div>
    </div>
@endsection
