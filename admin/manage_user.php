<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage_Users</title>
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/manage_user.css">
</head>
<body>
<?php
include '../php/connection.php';

$search = '';
if(isset($_POST['search'])) {
    $search = $_POST['search'];
}

$sql = "SELECT id, fullname, email, address FROM users WHERE fullname LIKE ? OR email LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = '%' . $search . '%';
$stmt->bind_param('ss', $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
$datas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datas[] = $row;
    }
} else {
    echo "0 results";
}

if (isset($_SESSION['message'])) {
    echo '<script>setTimeout(() => alert(' . json_encode($_SESSION['message']) . '), 1000);</script>';
    unset($_SESSION['message']);
}
?>
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

    <div class="main">
        <h1 class="title">Manage Users</h1>
        <form action="" method="post">
            <input type="text" name="search" placeholder="Search users..." value="">
            <input type="submit" value="Search">
        </form>
        <div class="container">
            <div class="head body">Full Name</div>
            <div class="head body">Email</div>
            <div class="head body">Address</div>
            <div class="head body">Remove</div>
            <?php
                if (!empty($datas)) {
                    foreach ($datas as $data) {
                        echo '<div class="body">' . htmlspecialchars($data['fullname']) . '</div>';
                        echo '<div class="body">' . htmlspecialchars($data['email']) . '</div>';
                        echo '<div class="body">' . htmlspecialchars($data['address']) . '</div>';
                        echo '<div class="body"><a class="btn remove" href="./php/deleteUser.php?id=' . htmlspecialchars($data['id']) . '">Remove</a></div>';
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
