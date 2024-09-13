<?php
session_start();
include 'db.php';

if (!isset($_SESSION['reservation_date'])) {
    header("Location: new-date.php");
    exit();
}

$reservation_date = $_SESSION['reservation_date'];

// Secure SQL query using prepared statements
$total_seats = 5;
$query = "SELECT seat_no FROM seats WHERE reservation_date = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $reservation_date);
$stmt->execute();
$result = $stmt->get_result();
$booked_seats = $result->num_rows;
$available_seats = $total_seats - $booked_seats;

if ($available_seats <= 0) {
    echo "<script>alert('No seats available for the selected date'); window.location.href='new-date.php';</script>";
    exit();
}

// Fetch booked seats
$booked_seat_nos = [];
while ($row = $result->fetch_assoc()) {
    $booked_seat_nos[] = $row['seat_no'];
}

$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seat Reservation</title>
    <link rel="stylesheet" href="reservation.css?v=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="navbar-logo">
            <img src="images/logo.png" alt="SLT Logo" />
        </div>
        <ul class="navbar-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="#footer">About</a></li>
            <li><a href="#footer">Contact</a></li>
            <li class="user-logout">
              <a href="logout.php">
                  <i class="fa-solid fa-arrow-right-from-bracket logout-icon"></i>
                  Logout
              </a>
            </li>
        </ul>
    </nav>
</header>

    <!-- Reservation Page -->
    <div id="reservation-page" class="container">
        <h1>Employee Seat Reservation</h1>

        <!-- Cards Displaying Total, Available, and Booked Seats -->
        <div class="card-container">
            <div class="card">
                <h3 id="total-seats"><?php echo $total_seats; ?></h3>
                <p>Total Seats</p>
            </div>
            <div class="card">
                <h3 id="available-seats"><?php echo $available_seats; ?></h3>
                <p>Available Seats</p>
            </div>
            <div class="card">
                <h3 id="booked-seats"><?php echo $booked_seats; ?></h3>
                <p>Booked Seats</p>
            </div>
        </div>

        <!-- Seat Grid -->
        <div id="seat-selection">
            <h2>Select Your Seat</h2>
            <div class="seat-grid">
                <?php
                for ($i = 1; $i <= $total_seats; $i++) {
                    $is_booked = in_array($i, $booked_seat_nos) ? 'booked' : 'available';
                    echo "<div class='seat $is_booked' data-seat='$i'>$i</div>";
                }
                ?>
            </div>
            <button class="btn" id="proceed-btn">Proceed to Booking</button>
        </div>
    </div>

    <footer id="footer" class="footer">
      <div class="footer-container">
        <div class="contact-details">
          <h3>Contact us</h3>
          <p>support@slt.lk | +94 11 2 123456</p>
        </div>

        <div class="social-media">
          <div class="contact-details">
            <h3>Follow us</h3>
          <a
            href="https://www.facebook.com/slt"
            target="_blank"
            aria-label="Facebook"
          >
            <img src="images/facebook-icon.png" alt="Facebook" />
          </a>
          <a
            href="https://www.twitter.com/slt"
            target="_blank"
            aria-label="Twitter"
          >
            <img src="images/twitter-icon.png" alt="Twitter" />
          </a>
          <a
            href="https://www.instagram.com/slt"
            target="_blank"
            aria-label="Instagram"
          >
            <img src="images/instagram-icon.png" alt="Instagram" />
          </a>
          <a
            href="https://www.youtube.com/slt"
            target="_blank"
            aria-label="YouTube"
          >
            <img src="images/youtube-icon.png" alt="YouTube" />
          </a>
        </div>
      </div>

      <div class="footer-content">
        <p>
          &copy; 2024 SLT Employee Seat Reservation System. All rights reserved.
        </p>
      </div>
    </footer>
    
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        let selectedSeat = null;

        // Highlight selected seat and capture seat number
        document.querySelectorAll('.seat.available').forEach(seat => {
            seat.addEventListener('click', () => {
                document.querySelectorAll('.seat').forEach(s => s.classList.remove('selected'));
                seat.classList.add('selected');
                selectedSeat = seat.getAttribute('data-seat');
            });
        });

        // Proceed to booking form with the selected seat
        document.getElementById('proceed-btn').addEventListener('click', () => {
            if (selectedSeat) {
                // Create a form dynamically to submit the selected seat number
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'seat-booking-form.php';

                const seatInput = document.createElement('input');
                seatInput.type = 'hidden';
                seatInput.name = 'seat_no';
                seatInput.value = selectedSeat;
                form.appendChild(seatInput);

                document.body.appendChild(form);
                form.submit();
            } else {
                alert('Please select a seat.');
            }
        });
    });
</script>
</body>
</html>
