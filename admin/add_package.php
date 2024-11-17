<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add_Packages</title>
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/add_package.css">
</head>
<body>
<?php
if (isset($_SESSION['message'])) {
    echo '<script>setTimeout(() => alert(' . json_encode($_SESSION['message']) . '), 1000);</script>';
    unset($_SESSION['message']);
}
?>
    <div class="side-panel">
        <h2>Admin</h2>
        <div class="link-list">
            <a href="">Add Package</a>
            <a href="./manage_package.php">Manage Package</a>
            <a href="">Manage Users</a>
            <a href="">Manage Bookings</a>
            <a href="">View Contact us</a>
            <a href="./php/logout.php">Logout</a>
        </div>
    </div>

    <div class="main">
        <h1 class="title">Add Package</h1>
        <form action="./php/insert.php" method="post" enctype="multipart/form-data">
            <label>Enter Package name <input type="text" name="name"></label>
            <label>Enter Package Location <input type="text" name="location"></label>
            <label>Enter Package Price <input type="number" name="price"></label>
            <label>Enter Package Description <input type="text" name="description"></label>
            <label>Select Package Image <input type="file" name="image"></label>
            <div class="submit-reset-btn">
                <input class="btn add" type="submit" value="Add Package">
                <input class="btn reset" type="reset" value="Reset">
            </div>
        </form>
    </div>
</body>
</html>
