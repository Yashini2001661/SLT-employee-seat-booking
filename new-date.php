<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['login_user'])) {
    header("Location: user-login.php");
    exit();
}

$emp_id = $_SESSION['login_user'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $reservation_date = filter_input(INPUT_POST, 'reservation_date', FILTER_SANITIZE_STRING);
    if (!$reservation_date || !strtotime($reservation_date)) {
        echo "<script>alert('Invalid date selected. Please choose a valid date.'); window.location.href='new-date.php';</script>";
        exit();
    }

    // Check if the employee has already booked a seat for the selected date
    $query = "SELECT * FROM reservations WHERE emp_id = ? AND reservation_date = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $emp_id, $reservation_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Employee has already booked a seat for this date
        echo "<script>alert('Cannot make more than one booking for the same date. You have already booked a seat for this date.'); window.location.href='new-date.php';</script>";
        $stmt->close();
        $connection->close();
        exit();
    } else {
        // No previous booking found, proceed with setting the session and redirecting
        $_SESSION['reservation_date'] = $reservation_date;

        // Redirect to the reservation page after setting the session
        header("Location: reservation.php");
        exit();
    }

    $stmt->close();
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Selection - Employee Seat Reservation System</title>
    <link rel="stylesheet" href="date.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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

    <main class="date-selection-section">
        <div class="date-selection-container">
        <a href="#" class="panel-btn">New Date</a>
        <a href="cancel-date.php" class="panel-btn">Cancel Date</a>

            <h1>Select a Date</h1>
            <form action="new-date.php" method="POST">
                <div class="form-group">
                    <label for="reservation_date">Choose a Date:</label>
                    <input type="date" id="reservation_date" name="reservation_date" required>
                </div>
                <button type="submit" class="hero-btn">Continue</button>
            </form>
        </div>
    </main>

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
</body>
</html>
