<?php
// index.php – Main dashboard (protected)
require 'auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js" defer></script>
    <title>Airline Management System</title>
</head>
<body>
    <header>
        <h1>&#9992; Airline Management System</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#">Airport</a>
                <ul class="dropdown">
                    <li><a href="airport/add_airport.php">Add Airport</a></li>
                    <li><a href="airport/edit_airport.php">Edit Airport</a></li>
                    <li><a href="airport/list_airport.php">List Airports</a></li>
                </ul>
            </li>
            <li><a href="#">Crew</a>
                <ul class="dropdown">
                    <li><a href="crew/add_crew.php">Add Crew</a></li>
                    <li><a href="crew/edit_crew.php">Edit Crew</a></li>
                    <li><a href="crew/list_crew.php">List Crew</a></li>
                </ul>
            </li>
            <li><a href="#">Crew Assignment</a>
                <ul class="dropdown">
                    <li><a href="crew_assignment/crew_assignment.php">Assign Crew</a></li>
                    <li><a href="crew_assignment/list_assighnments.php">List Assignments</a></li>
                </ul>
            </li>
            <li><a href="#">Flight</a>
                <ul class="dropdown">
                    <li><a href="flight/add_flight.php">Add Flight</a></li>
                    <li><a href="flight/edit_flight.php">Edit Flight</a></li>
                    <li><a href="flight/list_flight.php">List Flights</a></li>
                </ul>
            </li>
            <li><a href="#">Passenger</a>
                <ul class="dropdown">
                    <li><a href="passenger/create_passenger.php">Add Passenger</a></li>
                    <li><a href="passenger/edit_passenger.php">Edit Passenger</a></li>
                    <li><a href="passenger/list_passenger.php">List Passengers</a></li>
                    <li><a href="passenger/delete_passenger.php">Delete Passenger</a></li>
                </ul>
            </li>
            <li><a href="#">Payment</a>
                <ul class="dropdown">
                    <li><a href="payment/create_payment.php">Add Payment</a></li>
                    <li><a href="payment/list_payments.php">Payment List</a></li>
                    <li><a href="payment/edit_payment.php">Edit Payment</a></li>
                </ul>
            </li>
            <li><a href="#">Booking</a>
                <ul class="dropdown">
                    <li><a href="booking/create_booking.php">Create Booking</a></li>
                    <li><a href="booking/edit_booking.php">Edit Booking</a></li>
                    <li><a href="booking/list_booking.php">List Bookings</a></li>
                </ul>
            </li>
            <li><a href="#">Planes</a>
                <ul class="dropdown">
                    <li><a href="planes/add_plane.php">Add Plane</a></li>
                    <li><a href="planes/edit_plane.php">Edit Plane</a></li>
                    <li><a href="planes/delete_plane.php">Delete Plane</a></li>
                </ul>
            </li>
            <li><a href="#">Tickets</a>
                <ul class="dropdown">
                    <li><a href="ticket/new_ticket.php">New Ticket</a></li>
                    <li><a href="ticket/edit_ticket.php">Edit Ticket</a></li>
                    <li><a href="ticket/list_ticket.php">List Tickets</a></li>
                </ul>
            </li>
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <li><a href="#">Admin</a>
                <ul class="dropdown">
                    <li><a href="auth/manage_users.php">Manage Users</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Logged-in user info + logout -->
            <li style="margin-left:auto;">
                <a href="#">&#128100; <?= htmlspecialchars($_SESSION['username']) ?> (<?= $_SESSION['role'] ?>)</a>
                <ul class="dropdown">
                    <li><a href="auth/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div style="padding:40px;text-align:center;">
        <h2 style="color:#fff;text-shadow:1px 1px 4px #000;">
            Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!
        </h2>
        <p style="color:#fff;text-shadow:1px 1px 3px #000;font-size:16px;">
            Use the navigation menu above to manage flights, passengers, bookings and more.
        </p>
    </div>

    <footer>
        <p>&copy; 2024 Airline Management System</p>
    </footer>
</body>
</html>
