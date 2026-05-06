@php
    $moduleKey = $moduleKey ?? ($page['module'] ?? '');
    $canCrud = ($page['canCrud'] ?? false) && ($storageReady ?? true);
    $modalId = 'agent-module-modal-'.$moduleKey;
    $showCoverUpload = in_array($moduleKey, ['flights', 'hotels', 'packages'], true);
    $isPackageModule = $moduleKey === 'packages';
    $isFlightModule = $moduleKey === 'flights';
    $isHotelModule = $moduleKey === 'hotels';
@endphp

<div class="admin-alert error" style="margin-bottom: 24px; display: {{ ($storageReady ?? true) ? 'none' : 'block' }};">
    The agent tables are not ready yet. Run <strong>php artisan migrate</strong> to enable this module.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h2 class="panel-title">{{ $page['title'] }}</h2>
            <div class="panel-subtitle">
                {{ $canCrud ? 'Use quick actions to add or update records in a modal.' : 'Browse records stored in the database.' }}
            </div>
        </div>

        @if ($canCrud)
            <button class="btn-primary" type="button" onclick="openModal('{{ $modalId }}')">
                {{ $isPackageModule ? 'Create Package' : ($isFlightModule ? 'Add Flight' : ($isHotelModule ? 'Add Hotel' : 'Create Record')) }}
            </button>
        @endif
    </div>

    @if ($canCrud)
        <div class="modal-overlay" id="{{ $modalId }}">
            <div class="modal">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title">{{ $editingRecord ? 'Edit '.$page['title'] : $page['title'] }}</h3>
                        <div class="panel-subtitle">{{ $editingRecord ? 'Update the saved record details.' : 'Fill out the form to save a new record.' }}</div>
                    </div>
                    <button class="modal-close" type="button" onclick="closeModal('{{ $modalId }}')">Close</button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ $editingRecord ? route('agent.records.update', $editingRecord) : route('agent.module.store', ['module' => $moduleKey]) }}" enctype="multipart/form-data">
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
                            </div>

                            <div>
                                <div class="form-group">
                                    <label class="form-label">End Date</label>
                                    <input class="form-input" type="date" name="travel_end" value="{{ old('travel_end', optional($editingRecord?->travel_end)->format('Y-m-d')) }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Amount</label>
                                    <input class="form-input" type="number" step="0.01" name="amount" value="{{ old('amount', $editingRecord?->amount) }}" placeholder="0.00">
                                </div>

                                @if ($showCoverUpload)
                                    <div class="form-group">
                                        <label class="form-label">Cover Photo</label>
                                        <input class="form-input" type="file" name="cover_image" accept="image/*">
                                    </div>
                                @endif

                                @if ($isPackageModule)
                                    <div class="form-group">
                                        <label class="form-label">Flight</label>
                                        <select class="form-select" name="flight_record_id" required>
                                            <option value="">Select a flight</option>
                                            @foreach (($supportingFlights ?? collect()) as $flight)
                                                <option value="{{ $flight->id }}" @selected((string) old('flight_record_id', $editingRecord?->flight_record_id) === (string) $flight->id)>{{ $flight->title }}{{ $flight->reference_code ? ' ('.$flight->reference_code.')' : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Hotel</label>
                                        <select class="form-select" name="hotel_record_id" required>
                                            <option value="">Select a hotel</option>
                                            @foreach (($supportingHotels ?? collect()) as $hotel)
                                                <option value="{{ $hotel->id }}" @selected((string) old('hotel_record_id', $editingRecord?->hotel_record_id) === (string) $hotel->id)>{{ $hotel->title }}{{ $hotel->reference_code ? ' ('.$hotel->reference_code.')' : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status" required>
                                        @foreach ($page['statusOptions'] ?: ['active', 'pending', 'confirmed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" @selected(old('status', $editingRecord?->status ?? 'pending') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Contact Name</label>
                                    <input class="form-input" type="text" name="contact_name" value="{{ old('contact_name', $editingRecord?->contact_name) }}" placeholder="Optional contact name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Contact Email</label>
                                    <input class="form-input" type="email" name="contact_email" value="{{ old('contact_email', $editingRecord?->contact_email) }}" placeholder="Optional contact email">
                                </div>
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Contact Phone</label>
                                <input class="form-input" type="text" name="contact_phone" value="{{ old('contact_phone', $editingRecord?->contact_phone) }}" placeholder="Optional contact phone">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Details JSON / Notes</label>
                                <textarea class="form-textarea" name="details" placeholder='{"notes":"Optional structured data"}'>{{ old('details', $editingRecord?->details ? json_encode($editingRecord->details, JSON_PRETTY_PRINT) : '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-textarea" name="description" placeholder="Additional notes">{{ old('description', $editingRecord?->description) }}</textarea>
                        </div>

                        <div class="modal-footer">
                            <button class="btn-secondary" type="button" onclick="closeModal('{{ $modalId }}')">Cancel</button>
                            <button class="btn-primary" type="submit">{{ $editingRecord ? 'Update Record' : 'Save Record' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="table-container" style="margin-top: 24px;">
    <div class="table-header">
        <div class="panel-header">
            <div>
                <h3 class="panel-title">{{ $page['title'] }} List</h3>
                <div class="panel-subtitle">Showing the saved records.</div>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    @if ($showCoverUpload)
                        <th>Cover</th>
                    @endif
                    <th>Title</th>
                    @if ($isPackageModule)
                        <th>Flight</th>
                        <th>Hotel</th>
                    @elseif ($isFlightModule)
                        <th>Route</th>
                        <th>Schedule</th>
                    @elseif ($isHotelModule)
                        <th>Location</th>
                        <th>Schedule</th>
                    @else
                        <th>Contact</th>
                        <th>Destination</th>
                    @endif
                    <th>Status</th>
                    <th>Amount</th>
                    @if ($canCrud)
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        @if ($showCoverUpload)
                            <td>
                                @if ($record->cover_image)
                                    <img src="{{ asset('storage/'.$record->cover_image) }}" alt="{{ $record->title }}" style="width: 64px; height: 64px; object-fit: cover; border-radius: 10px; border: 1px solid #e5e7eb;">
                                @else
                                    <div style="width: 64px; height: 64px; border-radius: 10px; border: 1px dashed #d1d5db; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 12px;">No photo</div>
                                @endif
                            </td>
                        @endif

                        <td>
                            <div style="font-weight: 600;">{{ $record->title }}</div>
                            <div style="font-size: 12px; color: #6b7280;">{{ $record->reference_code ?? 'No reference' }}</div>
                        </td>

                        @if ($isPackageModule)
                            @php
                                $linkedFlight = ($flightLookup ?? collect())->get($record->flight_record_id);
                                $linkedHotel = ($hotelLookup ?? collect())->get($record->hotel_record_id);
                            @endphp
                            <td>
                                <div style="font-weight: 600;">{{ $linkedFlight?->title ?? 'No flight linked' }}</div>
                                <div style="font-size: 12px; color: #6b7280;">{{ $linkedFlight?->reference_code ?? '' }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $linkedHotel?->title ?? 'No hotel linked' }}</div>
                                <div style="font-size: 12px; color: #6b7280;">{{ $linkedHotel?->reference_code ?? '' }}</div>
                            </td>
                        @elseif ($isFlightModule)
                            <td>{{ $record->destination ?? 'N/A' }}</td>
                            <td>
                                {{ optional($record->travel_start)->format('M d, Y') ?? 'N/A' }}
                                @if ($record->travel_end)
                                    <span style="color:#6b7280;">to {{ $record->travel_end->format('M d, Y') }}</span>
                                @endif
                            </td>
                        @elseif ($isHotelModule)
                            <td>{{ $record->destination ?? 'N/A' }}</td>
                            <td>
                                {{ optional($record->travel_start)->format('M d, Y') ?? 'N/A' }}
                                @if ($record->travel_end)
                                    <span style="color:#6b7280;">to {{ $record->travel_end->format('M d, Y') }}</span>
                                @endif
                            </td>
                        @else
                            <td>
                                <div>{{ $record->contact_name ?? 'N/A' }}</div>
                                <div style="font-size: 12px; color: #6b7280;">{{ $record->contact_email ?? $record->contact_phone ?? '' }}</div>
                            </td>
                            <td>{{ $record->destination ?? 'N/A' }}</td>
                        @endif

                        <td><span class="status-badge status-{{ $record->status }}">{{ ucfirst(str_replace('_', ' ', $record->status)) }}</span></td>
                        <td>₱{{ number_format((float) ($record->amount ?? 0), 2) }}</td>

                        @if ($canCrud)
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
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $showCoverUpload ? 7 : 6 }}">No records found for this module.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (method_exists($records, 'links'))
        <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb;">
            {{ $records->links() }}
        </div>
    @endif
</div>

@if ($canCrud && (($editingRecord ?? null) || $errors->any()))
    <script>
        window.addEventListener('load', function () {
            openModal(@json($modalId));
        });
    </script>
@endif

@if ($moduleKey === 'settings')
    <div class="panel" style="margin-top: 24px;">
        <div class="panel-header">
            <div>
                <h3 class="panel-title">Agent Settings</h3>
                <div class="panel-subtitle">Update the agent-specific settings.</div>
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
