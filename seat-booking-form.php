<?php
session_start();
include 'db.php';

// Ensure seat_no is passed from reservation.php
if (!isset($_POST['seat_no'])) {
    echo "<script>alert('No seat selected.'); window.location.href='reservation.php';</script>";
    exit();
}

$emp_id = $_SESSION['login_user'];
$reservation_date = $_SESSION['reservation_date'];
$seat_no = $_POST['seat_no'];

// Fetch user details (e.g., from session or another database query)
$employee_name = ''; // You might want to fetch this from the session or another query
$phone_number = '';  // Same as above
$email = '';         // Same as above

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Booking Form</title>
    <link rel="stylesheet" href="seat-booking-form.css?v=1.0" />
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

    <main class="booking-section">
        <div class="booking-container">
            <h1>Complete Your Reservation</h1>
            <form action="seat-booking-form.php" method="POST">
                <div class="form-group">
                    <label for="selected-date">Selected Date</label>
                    <input type="date" id="selected-date" name="reservation_date" value="<?php echo $reservation_date; ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="employee_name">Name:</label>
                    <input type="text" id="employee_name" name="employee_name" value="<?php echo $employee_name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone-number">Phone Number:</label>
                    <input type="text" id="phone-number" name="phone_number" value="<?php echo $phone_number; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="form-group">
                    <label for="selected-seat">Selected Seat</label>
                    <input type="text" id="seat_no" name="seat_no" value="<?php echo $seat_no; ?>" readonly />
                </div>
                <button type="submit" class="btn">Confirm Booking</button>
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

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $emp_id = $_SESSION['login_user'];
    $reservation_date = $_SESSION['reservation_date'];
    $seat_no = $_POST['seat_no'];
    $name = filter_input(INPUT_POST, 'employee_name', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Insert into booking_details table using prepared statements
    $stmt = $connection->prepare("INSERT INTO booking_details (emp_id, reservation_date, seat_no, employee_name, phone_number, email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $emp_id, $reservation_date, $seat_no, $name, $phone, $email);
    $stmt->execute();

    // Insert into reservations and seats table
    $stmt = $connection->prepare("INSERT INTO reservations (emp_id, reservation_date, seat_no) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $emp_id, $reservation_date, $seat_no);
    $stmt->execute();

    $stmt = $connection->prepare("INSERT INTO seats (seat_no, reservation_date, emp_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $seat_no, $reservation_date, $emp_id);
    $stmt->execute();

    // Send confirmation email
    $to = $email;
    $subject = "Seat Reservation Confirmation";
    $message = "Dear $name,\n\nYour seat reservation for seat number $seat_no on $reservation_date has been confirmed.\n\nThank you,\nSLT Employee Seat Reservation System";
    $headers = "From: noreply@company.com";
    mail($to, $subject, $message, $headers);

    echo "<script>alert('Seat booked successfully!'); window.location.href='home.php';</script>";
    exit();
}
?>
