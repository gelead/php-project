<?php
    session_start();
    require '../php/connection.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = 'SELECT * FROM packages WHERE id = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $package = $result->fetch_assoc();
        } else {
            $_SESSION['message'] = 'Package not found';
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'No package ID provided.';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update_Packages</title>
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/add_package.css">
</head>
<body>
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
        <h1 class="title">Update Package</h1>
        <form action="./php/updatePackage.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="id" value="<?php echo $package['id']; ?>">
            <label>Package name <input type="text" name="name" value="<?php echo $package['name'] ?>"></label>
            <label>Package Location <input type="text" name="location" value="<?php echo $package['location'] ?>"></label>
            <label>Package Price <input type="number" name="price" value="<?php echo $package['price'] ?>"></label>
            <label>Package Description <input type="text" name="description" value="<?php echo $package['description'] ?>"></label>
            <label>Select Package Image <input type="file" name="image"></label>
            <div class="submit-reset-btn">
                <input class="btn add" type="submit" value="Update">
            </div>
        </form>
    </div>
</body>
</html>
