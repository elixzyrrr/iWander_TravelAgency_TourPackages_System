@extends('agent.layout')

@section('title', $page['title'])
@section('page_title', $page['title'])
@section('page_subtitle', $page['subtitle'])

@section('content')
    <div class="panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">{{ $page['title'] }}</h2>

            </div>
        </div>

        @if ($page['module'])
            <form method="POST" action="{{ $editingRecord ? route('agent.records.update', $editingRecord) : route('agent.module.store', ['module' => $moduleKey]) }}">
                @csrf
                @if ($editingRecord)
                    @method('PUT')
                @endif

                <div class="grid-2">
                    <div>
                        <div class="form-group">
                            <label class="form-label">Reference Code</label>
                            <input class="form-input" type="text" name="reference_code" value="{{ old('reference_code', $editingRecord?->reference_code) }}" placeholder="Optional reference number">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input class="form-input" type="text" name="title" value="{{ old('title', $editingRecord?->title) }}" placeholder="Record title" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Name</label>
                            <input class="form-input" type="text" name="contact_name" value="{{ old('contact_name', $editingRecord?->contact_name) }}" placeholder="Optional contact name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Email</label>
                            <input class="form-input" type="email" name="contact_email" value="{{ old('contact_email', $editingRecord?->contact_email) }}" placeholder="Optional contact email">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Phone</label>
                            <input class="form-input" type="text" name="contact_phone" value="{{ old('contact_phone', $editingRecord?->contact_phone) }}" placeholder="Optional contact phone">
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label class="form-label">Destination / Location</label>
                            <input class="form-input" type="text" name="destination" value="{{ old('destination', $editingRecord?->destination) }}" placeholder="Destination or location">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <input class="form-input" type="text" name="travel_type" value="{{ old('travel_type', $editingRecord?->travel_type) }}" placeholder="Package, flight, room, etc.">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Start Date</label>
                            <input class="form-input" type="date" name="travel_start" value="{{ old('travel_start', optional($editingRecord?->travel_start)->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">End Date</label>
                            <input class="form-input" type="date" name="travel_end" value="{{ old('travel_end', optional($editingRecord?->travel_end)->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Amount</label>
                            <input class="form-input" type="number" step="0.01" name="amount" value="{{ old('amount', $editingRecord?->amount) }}" placeholder="0.00">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        @foreach ($page['statusOptions'] ?: ['active', 'pending', 'confirmed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $editingRecord?->status ?? 'pending') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-textarea" name="description" placeholder="Additional notes">{{ old('description', $editingRecord?->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Details</label>
                    <textarea class="form-textarea" name="details" placeholder='{"notes":"Optional structured data"}'>{{ old('details', $editingRecord?->details ? json_encode($editingRecord->details, JSON_PRETTY_PRINT) : '') }}</textarea>
                </div>

                <div class="action-buttons">
                    <button class="btn-primary" type="submit">{{ $editingRecord ? 'Update Record' : 'Create Record' }}</button>
                    @if ($editingRecord)
                        <a class="btn btn-view" href="{{ route('agent.module', ['module' => $moduleKey]) }}">Cancel Edit</a>
                    @endif
                </div>
            </form>
        @endif
    </div>

    <div class="table-container" style="margin-top: 24px;">
        <div class="table-header">
            <div class="panel-header">
                <div>
                    <h3 class="panel-title">{{ $page['title'] }} Records</h3>

                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Title</th>
                        <th>Contact</th>
                        <th>Destination</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr>
                            <td>{{ $record->reference_code ?? 'N/A' }}</td>
                            <td>
                                <div style="font-weight: 600;">{{ $record->title }}</div>
                                <div style="font-size: 12px; color: #6b7280;">{{ $record->module }}</div>
                            </td>
                            <td>
                                <div>{{ $record->contact_name ?? 'N/A' }}</div>
                                <div style="font-size: 12px; color: #6b7280;">{{ $record->contact_email ?? '' }}</div>
                            </td>
                            <td>{{ $record->destination ?? 'N/A' }}</td>
                            <td><span class="status-badge status-{{ $record->status }}">{{ ucfirst(str_replace('_', ' ', $record->status)) }}</span></td>
                            <td>₱{{ number_format((float) ($record->amount ?? 0), 2) }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a class="btn btn-edit" href="{{ route('agent.module', ['module' => $moduleKey, 'edit' => $record->id]) }}">Edit</a>
                                    <form method="POST" action="{{ route('agent.records.destroy', $record) }}" onsubmit="return confirm('Delete this record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No records found for this module.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($moduleKey === 'reports')
        <div class="stats-grid" style="margin-top: 24px;">
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
    @endif

    @if ($moduleKey === 'settings')
        <div class="panel" style="margin-top: 24px;">
            <div class="panel-header">
                <div>
                    <h3 class="panel-title">Agent Settings</h3>

                </div>
            </div>

            <form method="POST" action="{{ route('agent.settings.update') }}">
                @csrf
                <div class="grid-2">
                    <div>
                        <div class="form-group">
                            <label class="form-label">Agency Name</label>
                            <input class="form-input" type="text" name="agency_name" value="{{ $settings['agency_name'] }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Email</label>
                            <input class="form-input" type="email" name="contact_email" value="{{ $settings['contact_email'] }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input class="form-input" type="text" name="phone_number" value="{{ $settings['phone_number'] }}">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="currency">
                                @foreach (['PHP', 'USD', 'EUR'] as $currency)
                                    <option value="{{ $currency }}" @selected($settings['currency'] === $currency)>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea class="form-textarea" name="address">{{ $settings['address'] }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group"><label><input type="checkbox" name="email_booking" value="1" @checked($settings['email_booking'] === '1')> Booking email alerts</label></div>
                    <div class="form-group"><label><input type="checkbox" name="email_payment" value="1" @checked($settings['email_payment'] === '1')> Payment email alerts</label></div>
                    <div class="form-group"><label><input type="checkbox" name="email_reminder" value="1" @checked($settings['email_reminder'] === '1')> Reminder email alerts</label></div>
                    <div class="form-group"><label><input type="checkbox" name="email_newsletter" value="1" @checked($settings['email_newsletter'] === '1')> Newsletter email alerts</label></div>
                </div>

                <button class="btn-primary" type="submit">Save Settings</button>
            </form>
        </div>
    @endif
@endsection
