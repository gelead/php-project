<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home_Page</title>
    <link rel="stylesheet" href="./css/home.css">
</head>
<body>
    <div class="side-panel">
        <h2>Admin</h2>
        <div class="link-list">
            <a href="./add_package.php">Add Package</a>
            <a href="./manage_package.php">Manage Package</a>
            <a href="">Manage Users</a>
            <a href="">Manage Bookings</a>
            <a href="">View Contact us</a>
            <a href="./php/logout.php">Logout</a>
        </div>
    </div>

    <div class="title">
        <h1 class="title">Welocome to the Admin Page</h1>
    </div>
    
    
</body>
</html>