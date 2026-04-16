<?php
if (session_status() == PHP_SESSION_NONE) {
    if (session_status() == PHP_SESSION_NONE) { session_start(); }
}
$root = '/airlineManagmentSystem2/';
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
<a class="navbar-brand" href="<?= $root ?>index.php">✈ AMS</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav me-auto">

<?php if(isset($_SESSION['role']) && $_SESSION['role']=='admin'): ?>
<li class="nav-item"><a class="nav-link" href="<?= $root ?>admin/dashboard.php">Dashboard</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $root ?>airport/add_airport.php">Airport</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $root ?>flight/add_flight.php">Flight</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $root ?>crew/assign_crew.php">Crew</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $root ?>plane/add_plane.php">Planes</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $root ?>auth/manage_users.php">Users</a></li>
<?php endif; ?>

<li class="nav-item"><a class="nav-link" href="<?= $root ?>passenger/create_passenger.php">Passenger</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $root ?>booking/book_ticket.php">Booking</a></li>

</ul>

<span class="navbar-text text-white me-3">
<?= $_SESSION['user'] ?? '' ?>
</span>

<a class="btn btn-outline-light" href="<?= $root ?>auth/logout.php">Logout</a>
</div>
</div>
</nav>
