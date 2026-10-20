<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' : ''; ?>Elegance Salon</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS (Modular) -->
    <link rel="stylesheet" href="assets/css/variables.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/home-enhance.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="assets/css/services.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-elegant sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/logo.png" class="logo" alt="Logo">
       <span>ELEGANCE SALON</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link <?php echo ($activePage ?? '') === 'home' ? 'active' : ''; ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activePage ?? '') === 'about' ? 'active' : ''; ?>" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activePage ?? '') === 'services' ? 'active' : ''; ?>" href="services.php">Services</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activePage ?? '') === 'book' ? 'active' : ''; ?>" href="book.php">Book</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activePage ?? '') === 'contact' ? 'active' : ''; ?>" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activePage ?? '') === 'feedback' ? 'active' : ''; ?>" href="feedback.php">Feedback</a></li>
            </ul>
<div class="d-flex align-items-center gap-2">
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if (in_array($_SESSION['user_role'] ?? '', ['admin','receptionist','stylist'], true)): ?>
            <a href="admin/dashboard.php" class="btn btn-nav">Dashboard</a>
        <?php else: ?>
            <a href="customer/index.php" class="btn btn-nav">My Account</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-nav-outline">Logout</a>
    <?php else: ?>
        <a href="login.php" class="btn btn-nav-outline">Log In</a>
        <a href="book.php" class="btn btn-nav">Book Appointment</a>
    <?php endif; ?>
</div>
        </div>
    </div>
</nav>
