// Load data
const bookingDraft = JSON.parse(localStorage.getItem('selectedBookingItem') || localStorage.getItem('selectedFlight') || '{}');
const passengers = JSON.parse(localStorage.getItem('passengers') || '[]');
const bookingType = document.body?.dataset.bookingType || bookingDraft.bookingType || 'flights';
const nextStepUrl = document.body?.dataset.nextStepUrl || '/bookings/steps/payment';
const backStepUrl = document.body?.dataset.backStepUrl || '/bookings/steps/booking';

const seatConfig = {
    firstClass: { rows: 3, price: 15000, cols: ['A', 'C', '', 'D', 'F'] },
    business: { rows: 7, price: 8000, cols: ['A', 'B', 'C', '', 'D', 'E', 'F'] },
    economy: { rows: 20, price: 0, cols: ['A', 'B', 'C', '', 'D', 'E', 'F'] }
};

let selectedSeats = [];
let occupiedSeats = [];

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    if ((!bookingDraft.id && !bookingDraft.itemId) || !passengers.length) {
        window.location.href = backStepUrl;
        return;
    }

    generateOccupiedSeats();
    updateSummary();
    renderSeats();
    attachEventListeners();
});

// Generate random occupied seats
function generateOccupiedSeats() {
    const occupiedCount = Math.floor(Math.random() * 30) + 20;
    while (occupiedSeats.length < occupiedCount) {
        const row = Math.floor(Math.random() * 30) + 1;
        const col = ['A', 'B', 'C', 'D', 'E', 'F'][Math.floor(Math.random() * 6)];
        const seat = `${row}${col}`;
        if (!occupiedSeats.includes(seat)) occupiedSeats.push(seat);
    }
}

// Update passenger & price summary
function updateSummary() {
    document.getElementById('passengerCountText').textContent = passengers.length;
    const summaryTitle = bookingDraft.title || (bookingType === 'tours' ? 'Tour Package' : bookingType === 'stays' ? 'Hotel Stay' : 'Flight');
    const summaryOrigin = bookingDraft.origin || bookingDraft.departLocation?.split('(')[0].trim() || 'Selected departure';
    const summaryDestination = bookingDraft.destination || bookingDraft.arriveLocation?.split('(')[0].trim() || 'Selected destination';
    document.getElementById('summaryFlight').textContent = `${summaryTitle} - ${summaryOrigin} → ${summaryDestination}`;

    const passengerListHTML = passengers.map((p, i) =>
        `<div class="summary-value" style="margin-top: 4px;">${i + 1}. ${p.firstName} ${p.lastName}</div>`
    ).join('');
    document.getElementById('passengerList').innerHTML = passengerListHTML;

    updatePriceSummary();
}

// Render all seats
function renderSeats() {
    renderClassSeats('firstClass', 'firstClassSeats', 1);
    renderClassSeats('business', 'businessClassSeats', 4);
    renderClassSeats('economy', 'economyClassSeats', 11);
}

function renderClassSeats(className, containerId, startRow) {
    const config = seatConfig[className];
    const container = document.getElementById(containerId);
    let html = '';

    for (let row = 0; row < config.rows; row++) {
        const rowNum = startRow + row;
        html += '<div class="seat-grid">';
        html += `<div class="seat-row-label">${rowNum}</div>`;

        config.cols.forEach(col => {
            if (col === '') {
                html += '<div class="seat aisle"></div>';
            } else {
                const seatId = `${rowNum}${col}`;
                const isOccupied = occupiedSeats.includes(seatId);
                const isSelected = selectedSeats.some(s => s.seat === seatId);
                const isPremium = className === 'economy' && (col === 'A' || col === 'F') && rowNum >= 11 && rowNum <= 15;

                let seatClass = 'seat ';
                if (isSelected) seatClass += 'selected';
                else if (isOccupied) seatClass += 'occupied';
                else if (isPremium) seatClass += 'premium';
                else seatClass += 'available';

                const priceAdd = isPremium ? 2000 : config.price;

                // Use data attributes instead of inline onclick
                html += `<div class="${seatClass}" data-seat="${seatId}" data-class="${className}" data-price="${priceAdd}">${seatId}</div>`;
            }
        });

        html += '</div>';
    }

    container.innerHTML = html;
}

// Attach event listeners to seats and continue button
function attachEventListeners() {
    document.querySelectorAll('.seat.available, .seat.premium').forEach(seatEl => {
        seatEl.addEventListener('click', () => {
            const seatId = seatEl.dataset.seat;
            const className = seatEl.dataset.class;
            const priceAdd = Number(seatEl.dataset.price);
            toggleSeat(seatId, className, priceAdd);
        });
    });

    const continueBtn = document.getElementById('continueBtn');
    if (continueBtn) {
        continueBtn.addEventListener('click', proceedToPayment);
    }
}

// Toggle seat selection
function toggleSeat(seatId, className, priceAdd) {
    if (occupiedSeats.includes(seatId)) {
        showAlert('This seat is already occupied', 'error');
        return;
    }

    const index = selectedSeats.findIndex(s => s.seat === seatId);
    if (index >= 0) selectedSeats.splice(index, 1);
    else if (selectedSeats.length < passengers.length) {
        const passengerIndex = selectedSeats.length;
        selectedSeats.push({
            seat: seatId,
            passengerId: passengers[passengerIndex].id,
            passengerName: `${passengers[passengerIndex].firstName} ${passengers[passengerIndex].lastName}`,
            class: className,
            priceAdd: priceAdd
        });
    } else {
        showAlert(`You can only select ${passengers.length} seat(s)`, 'warning');
    }

    renderSeats();
    updateSelectedSeatsPanel();
    updatePriceSummary();
}

// Update selected seats panel
function updateSelectedSeatsPanel() {
    const container = document.getElementById('selectedSeatsList');

    if (selectedSeats.length === 0) {
        container.innerHTML = '<div class="no-selection">No seats selected yet</div>';
        document.getElementById('continueBtn').disabled = true;
    } else {
        container.innerHTML = selectedSeats.map(s => `
            <div class="selected-seat-tag">
                ${s.seat} - ${s.passengerName}
                <button class="remove-seat-btn" data-seat="${s.seat}">×</button>
            </div>
        `).join('');

        document.getElementById('continueBtn').disabled = selectedSeats.length !== passengers.length;

        // Add remove listeners
        document.querySelectorAll('.remove-seat-btn').forEach(btn => {
            btn.addEventListener('click', () => removeSeat(btn.dataset.seat));
        });
    }
}

// Remove seat
function removeSeat(seatId) {
    const index = selectedSeats.findIndex(s => s.seat === seatId);
    if (index >= 0) {
        selectedSeats.splice(index, 1);
        renderSeats();
        updateSelectedSeatsPanel();
        updatePriceSummary();
    }
}

// Update price summary
function updatePriceSummary() {
    const baseFare = bookingDraft.price || 38000;
    const paxCount = passengers.length;
    const subtotal = baseFare * paxCount;
    const seatUpgradeTotal = selectedSeats.reduce((sum, s) => sum + s.priceAdd, 0);
    const taxes = Math.round((subtotal + seatUpgradeTotal) * 0.1);
    const total = subtotal + seatUpgradeTotal + taxes;

    document.getElementById('paxCount').textContent = paxCount;
    document.getElementById('baseFare').textContent = `₱${baseFare.toLocaleString()}`;
    document.getElementById('subtotal').textContent = `₱${subtotal.toLocaleString()}`;
    document.getElementById('taxes').textContent = `₱${taxes.toLocaleString()}`;
    document.getElementById('totalAmount').textContent = `₱${total.toLocaleString()}`;

    const upgradeRow = document.getElementById('seatUpgradeRow');
    if (seatUpgradeTotal > 0) {
        upgradeRow.style.display = 'flex';
        document.getElementById('seatUpgrade').textContent = `₱${seatUpgradeTotal.toLocaleString()}`;
    } else {
        upgradeRow.style.display = 'none';
    }
}

// Show alert
function showAlert(message, type = 'warning') {
    const alert = document.getElementById('alertBox');
    alert.textContent = message;
    alert.className = 'alert show';
    alert.style.background = type === 'error' ? '#fee2e2' : '#fef3c7';
    alert.style.borderColor = type === 'error' ? '#fca5a5' : '#fcd34d';
    alert.style.color = type === 'error' ? '#991b1b' : '#92400e';

    setTimeout(() => alert.classList.remove('show'), 5000);
}

// Proceed to payment
function proceedToPayment() {
    if (selectedSeats.length !== passengers.length) {
        showAlert(`Please select ${passengers.length} seat(s)`, 'warning');
        return;
    }

    localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
    window.location.href = nextStepUrl;
}