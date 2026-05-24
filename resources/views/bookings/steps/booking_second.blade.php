<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection - iWander</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Gwendolyn:wght@700&display=swap" rel="stylesheet">
    @vite('resources/css/booking_second.css')
</head>
<body data-booking-type="{{ $bookingType ?? 'flights' }}" data-next-step-url="{{ route('booking.steps.third', ['type' => $bookingType ?? 'flights']) }}" data-back-step-url="{{ route('booking.steps', ['type' => $bookingType ?? 'flights']) }}">
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="logo-section">
            <svg viewBox="0 0 61 47" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: #237f87;">
                <path d="M6 24L55 6L33 41L28 27L6 24Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M28 27L55 6" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="logo-text">iWander</span>
        </div>
        <a href="{{ route('booking.steps', ['type' => $bookingType ?? 'flights']) }}" class="back-btn">← Back</a>
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-container">
            <div class="steps">
                <div class="step completed">
                    <div class="step-circle">✓</div>
                    <div class="step-label">Passenger Details</div>
                </div>
                <div class="step active">
                    <div class="step-circle">2</div>
                    <div class="step-label">Seat Selection</div>
                </div>
                <div class="step">
                    <div class="step-circle">3</div>
                    <div class="step-label">Payment</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left: Seat Map -->
        <div>
            <div class="seat-map-card">
                <h1 class="card-title">Select Your Seats</h1>
                <p class="card-subtitle">Choose seats for <span id="passengerCountText">1</span> passenger(s)</p>

                <div class="alert" id="alertBox"></div>

                <!-- Legend -->
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-seat available">1A</div>
                        <span class="legend-label">Available</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-seat selected">2B</div>
                        <span class="legend-label">Your Selection</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-seat occupied">3C</div>
                        <span class="legend-label">Occupied</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-seat premium">4D</div>
                        <span class="legend-label">Premium (+₱2,000)</span>
                    </div>
                </div>

                <!-- Airplane -->
                <div class="airplane">
                    <div class="airplane-nose">✈️</div>

                    <!-- First Class -->
                    <div class="class-section">
                        <div class="class-header">
                            <span class="class-name">First Class</span>
                            <span class="class-price">+₱15,000 per seat</span>
                        </div>
                        <div id="firstClassSeats"></div>
                    </div>

                    <!-- Business Class -->
                    <div class="class-section">
                        <div class="class-header">
                            <span class="class-name">Business Class</span>
                            <span class="class-price">+₱8,000 per seat</span>
                        </div>
                        <div id="businessClassSeats"></div>
                    </div>

                    <!-- Economy Class -->
                    <div class="class-section">
                        <div class="class-header">
                            <span class="class-name">Economy Class</span>
                            <span class="class-price">Included</span>
                        </div>
                        <div id="economyClassSeats"></div>
                    </div>
                </div>

                <!-- Selected Seats Panel -->
                <div class="selected-panel">
                    <div class="selected-title">Selected Seats</div>
                    <div class="selected-list" id="selectedSeatsList">
                        <div class="no-selection">No seats selected yet</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn btn-secondary" onclick="window.location.href='{{ route('booking.steps', ['type' => $bookingType ?? 'flights']) }}'">Back</button>
                    <button class="btn btn-primary" id="continueBtn" disabled> Continue to Payment </button>
                </div>
            </div>
        </div>

        <!-- Right: Summary -->
        <div>
            <div class="summary-card">
                <h2 class="summary-title">Booking Summary</h2>

                <div class="summary-section">
                    <div class="summary-label">Flight</div>
                    <div class="summary-value" id="summaryFlight">Air France - JFK → CDG</div>
                </div>

                <div class="summary-section">
                    <div class="summary-label">Passengers</div>
                    <div id="passengerList"></div>
                </div>

                <div class="summary-section">
                    <div class="summary-label">Price Breakdown</div>
                    <div class="price-breakdown">
                        <div class="price-row">
                            <span>Base Fare (<span id="paxCount">1</span> × <span id="baseFare">₱38,000</span>)</span>
                            <strong id="subtotal">₱38,000</strong>
                        </div>
                        <div class="price-row" id="seatUpgradeRow" style="display: none;">
                            <span>Seat Upgrades</span>
                            <strong id="seatUpgrade">₱0</strong>
                        </div>
                        <div class="price-row">
                            <span>Taxes & Fees</span>
                            <strong id="taxes">₱3,800</strong>
                        </div>
                        <div class="price-row total-row">
                            <span>Total Amount</span>
                            <strong id="totalAmount">₱41,800</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/booking_second.js')
</body>
</html>