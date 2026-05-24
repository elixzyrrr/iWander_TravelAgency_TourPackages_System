@extends('admin.layout')

@section('title', 'System Configuration')
@section('page_title', 'System Configuration')
@section('page_subtitle', 'Store agency settings in the admin_settings table')

@section('content')
    <div class="admin-card">
        <form class="admin-form-stack" method="POST" action="{{ route('admin.system.update') }}">
            @csrf
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label class="admin-label" for="agency_name">Agency Name</label>
                    <input class="admin-input" id="agency_name" name="agency_name" value="{{ old('agency_name', $settings['agency_name']) }}" required>
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="contact_email">Contact Email</label>
                    <input class="admin-input" id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', $settings['contact_email']) }}" required>
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="phone_number">Phone Number</label>
                    <input class="admin-input" id="phone_number" name="phone_number" value="{{ old('phone_number', $settings['phone_number']) }}" required>
                </div>
                <div class="admin-field">
                    <label class="admin-label" for="currency">Currency</label>
                    <select class="admin-select" id="currency" name="currency" required>
                        @foreach (['PHP' => 'Philippine Peso', 'USD' => 'US Dollar', 'EUR' => 'Euro'] as $code => $label)
                            <option value="{{ $code }}" @selected(old('currency', $settings['currency']) === $code)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="admin-field">
                <label class="admin-label" for="address">Address</label>
                <textarea class="admin-textarea" id="address" name="address" rows="3" required>{{ old('address', $settings['address']) }}</textarea>
            </div>

            <div class="admin-card soft" style="margin-bottom: 0;">
                <div class="admin-card-header">
                    <div>
                        <h3 class="admin-card-title">Email Notifications</h3>

                    </div>
                </div>
                <div class="admin-form-grid">
                    @foreach ([
                        'email_booking' => 'Send confirmation emails for new bookings',
                        'email_payment' => 'Send payment confirmation emails',
                        'email_reminder' => 'Send reminder emails before departure',
                        'email_newsletter' => 'Send monthly newsletter to customers',
                    ] as $key => $label)
                        <label class="admin-chip" style="justify-content: flex-start; gap: 10px;">
                            <input type="checkbox" name="{{ $key }}" value="1" @checked(old($key, $settings[$key] ?? '0') === '1')>
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="admin-actions" style="margin-top: 18px;">
                <button class="admin-btn primary" type="submit">Save Settings</button>
                <a class="admin-btn secondary" href="{{ route('admin.dashboard') }}">Back to dashboard</a>
            </div>
        </form>
    </div>
@endsection
