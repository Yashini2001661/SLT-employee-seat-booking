<?php
session_start();
include 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['login_user'])) {
    header("Location: user-login.php");
    exit;
}

$emp_id = $_SESSION['login_user'];

// SQL query to get the booking details for the logged-in user
$query = "SELECT id, reservation_date, seat_no 
          FROM booking_details 
          WHERE emp_id = '$emp_id'
          ORDER BY reservation_date";
$result = mysqli_query($connection, $query);

// Handle cancellation request
if (isset($_GET['cancel_id'])) {
    $cancel_id = intval($_GET['cancel_id']);
    
    // Fetch the corresponding reservation details using the ID
    $fetch_query = "SELECT emp_id, reservation_date FROM booking_details WHERE id = $cancel_id AND emp_id = '$emp_id'";
    $fetch_result = mysqli_query($connection, $fetch_query);
    
    if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
        $row = mysqli_fetch_assoc($fetch_result);
        $reservation_date = $row['reservation_date'];
        
        // Delete from all tables
        $delete_booking_details = "DELETE FROM booking_details WHERE emp_id = '$emp_id' AND reservation_date = '$reservation_date'";
        $delete_reservations = "DELETE FROM reservations WHERE emp_id = '$emp_id' AND reservation_date = '$reservation_date'";
        $delete_seats = "DELETE FROM seats WHERE emp_id = '$emp_id' AND reservation_date = '$reservation_date'";

        if (mysqli_query($connection, $delete_booking_details) && 
            mysqli_query($connection, $delete_reservations) && 
            mysqli_query($connection, $delete_seats)) {
            echo "<script>alert('Booking cancelled successfully.'); window.location='cancel-date.php';</script>";
        } else {
            echo "<script>alert('Error cancelling booking.'); window.location='cancel-date.php';</script>";
        }
    } else {
        echo "<script>alert('Booking record not found.'); window.location='cancel-date.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Cancellation - Employee Seat Reservation System</title>
    <link rel="stylesheet" href="date.css?v=1.0" />
    <link rel="stylesheet" href="admin.css?v=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script>
        function confirmCancellation(cancelId) {
            if (confirm("Are you sure you want to cancel this booking?")) {
                window.location.href = "cancel-date.php?cancel_id=" + cancelId;
            }
        }
    </script>
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
            <a href="new-date.php" class="panel-btn">New Date</a>
            <a href="#" class="panel-btn">Cancel Date</a>

            <h1>My Bookings</h1>
            <table class="reservation-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Seat No</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['reservation_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['seat_no']); ?></td>
                        <td>
                            <button onclick="confirmCancellation(<?php echo $row['id']; ?>)">Cancel</button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
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
