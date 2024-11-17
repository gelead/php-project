<?php 
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
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

    <h1>WELCOME TO THE PAGE, <?php echo $username ?></h1>

    <a class="logout" href="./php/logout.php">LOGOUT</a>
    
</body>
</html>