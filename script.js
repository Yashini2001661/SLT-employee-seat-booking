// Initialize seat data
const totalSeats = 100;
let availableSeats = 80; // Initial count of available seats
let bookedSeats = [1, 2, 5, 20]; // Example of booked seats

const seatGrid = document.querySelector(".seat-grid");

// Generate seats dynamically
for (let i = 1; i <= totalSeats; i++) {
  const seat = document.createElement("div");
  seat.classList.add("seat");

  // Mark booked seats
  if (bookedSeats.includes(i)) {
    seat.classList.add("booked");
  }

  // Add seat number as an attribute
  seat.setAttribute("data-seat-number", i.toString().padStart(3, "0"));

  // Add click event for selectable seats
  seat.addEventListener("click", function () {
    if (!seat.classList.contains("booked")) {
      document
        .querySelectorAll(".seat")
        .forEach((s) => s.classList.remove("selected"));
      seat.classList.add("selected");
      document.getElementById("selected-seat").value =
        seat.getAttribute("data-seat-number");
    }
  });

  seatGrid.appendChild(seat);
}

// Show booking form
function showBookingForm() {
  const selectedSeat = document.querySelector(".seat.selected");
  if (selectedSeat) {
    document.getElementById("seat-selection").classList.add("hidden");
    document.getElementById("seat-booking-form").classList.remove("hidden");
  } else {
    alert("Please select a seat before proceeding.");
  }
}

// Confirm booking
function confirmBooking() {
  const employeeName = document.getElementById("employee-name").value;
  const employeeID = document.getElementById("employee-id").value;
  const phoneNumber = document.getElementById("phone-number").value;
  const selectedSeat = document.getElementById("selected-seat").value;

  if (employeeName && employeeID && phoneNumber && selectedSeat) {
    // Update counts
    availableSeats--;
    bookedSeats.push(parseInt(selectedSeat, 10));

    // Update the displayed seat count
    document.getElementById("available-seats").textContent = availableSeats;
    document.getElementById("booked-seats").textContent = bookedSeats.length;

    // Mark the selected seat as booked
    const seat = Array.from(document.querySelectorAll(".seat")).find(
      (s) => s.getAttribute("data-seat-number") === selectedSeat
    );
    if (seat) {
      seat.classList.add("booked");
      seat.classList.remove("selected");
    }

    // Hide booking form and show success message
    document.getElementById("seat-booking-form").classList.add("hidden");
    document.getElementById("success-message").classList.remove("hidden");
  } else {
    alert("Please fill in all fields.");
  }
}
function validateForm() {
  const employeeName = document.getElementById("employee-name").value;
  const employeeId = document.getElementById("employee-id").value;
  const phoneNumber = document.getElementById("phone-number").value;

  // Basic example of additional validation
  if (!employeeName || !employeeId || !phoneNumber) {
    alert("Please fill in all required fields.");
    return false;
  }

  // Example of validating phone number length
  if (phoneNumber.length !== 10) {
    alert("Phone number should be exactly 10 digits.");
    return false;
  }

  return true; // Allow form submission
}
