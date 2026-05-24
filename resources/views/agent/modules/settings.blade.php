@extends('agent.layout')

@section('title', $page['title'])
@section('page_title', $page['title'])
@section('page_subtitle', $page['subtitle'])

@section('content')
    <div class="panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">Agent Settings</h2>

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
@endsection
