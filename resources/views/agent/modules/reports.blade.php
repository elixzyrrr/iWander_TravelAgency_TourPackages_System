@extends('agent.layout')

@section('title', $page['title'])
@section('page_title', $page['title'])
@section('page_subtitle', $page['subtitle'])

@section('content')
    <div class="stats-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <div class="stat-title">Bookings</div>
            <div class="stat-value">{{ $summary['totalBookings'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Customers</div>
            <div class="stat-value">{{ $summary['totalCustomers'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Revenue</div>
            <div class="stat-value">₱{{ number_format($summary['revenue'], 2) }}</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">Reports</h2>

            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Metric</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total bookings</td>
                        <td>{{ $summary['totalBookings'] }}</td>
                    </tr>
                    <tr>
                        <td>Total customers</td>
                        <td>{{ $summary['totalCustomers'] }}</td>
                    </tr>
                    <tr>
                        <td>Total revenue</td>
                        <td>₱{{ number_format($summary['revenue'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
