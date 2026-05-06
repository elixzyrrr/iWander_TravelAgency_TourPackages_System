@extends('agent.layout')

@section('title', 'Agent Dashboard')
@section('page_title', 'Agent Dashboard')
@section('page_subtitle', 'This view has been broken into route-based agent modules')

@section('content')
    <div class="panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">Agent dashboard</h2>
                <div class="panel-subtitle">Use the sidebar navigation to open bookings, customers, flights, hotels, packages, reports, and settings.</div>
            </div>
            <a class="btn btn-view" href="{{ route('agent.dashboard') }}">Open Dashboard</a>
        </div>
    </div>
@endsection
