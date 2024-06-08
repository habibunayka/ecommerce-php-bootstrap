<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLEVS</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
        <a class="navbar-brand" href="#">
            E-COMMERCE
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="order_history.php">History</a></li>
                    <?php if ($_SESSION['role'] === 'admin') : ?>
                        <li class="nav-item"><a class="nav-link" href="admin_index.php">Admin Panel</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><button type="button" class="btn btn-secondary">Log out</button></a></li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><button type="button" class="btn btn-primary">Login</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"><button type="button" class="btn btn-success">Register</button></a>
                    <?php endif; ?>
            </ul>
        </div>
    </nav>