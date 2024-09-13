
You said:
<?php
session_start();
include 'db.php';

// SQL query to get the booking details
$query = "SELECT id, reservation_date, emp_id, seat_no, employee_name, phone_number, email 
          FROM booking_details 
          ORDER BY reservation_date, emp_id";
$result = mysqli_query($connection, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css?v=1.0" />
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

<main class="admin-panel">
    <h1 class="centered-heading">Admin Panel - Reserved Seats</h1>
    <table class="reservation-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Seat No</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Attendance</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['reservation_date']); ?></td>
                <td><?php echo htmlspecialchars($row['emp_id']); ?></td>
                <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                <td><?php echo htmlspecialchars($row['seat_no']); ?></td>
                <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
    mysqli_close($connection);
    ?>
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

<script src="script.js"></script>
</body>
</html>