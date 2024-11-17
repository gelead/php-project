<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage_Packages</title>
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/manage_package.css">
</head>
<body>
<?php
include '../php/connection.php';

$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

$sql = "SELECT id, image_path, name, location, description, price FROM packages WHERE name LIKE ? OR location LIKE ?";
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
    echo "No records found!";
}

if (isset($_SESSION['message'])) {
    echo '<script>setTimeout(() => alert(' . json_encode($_SESSION['message']) . '), 1000);</script>';
    unset($_SESSION['message']);
}
?>
<?php
if (isset($_SESSION['msg'])) {
    echo '<script>setTimeout(() => alert(' . json_encode($_SESSION['msg']) . '), 1000);</script>';
    unset($_SESSION['msg']);
}
?>

<div class="side-panel">
    <h2>Admin</h2>
    <div class="link-list">
        <a href="./add_package.php">Add Package</a>
        <a href="">Manage Package</a>
        <a href="">Manage Users</a>
        <a href="">Manage Bookings</a>
        <a href="">View Contact us</a>
        <a href="./php/logout.php">Logout</a>
    </div>
</div>

<div class="main">
    <h1 class="title">Manage Packages</h1>
    <form method="post" action="">
        <input type="text" name="search" placeholder="Search packages..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
    </form>
    <div class="container">
        <div class="head body">Image</div>
        <div class="head body">Name</div>
        <div class="head body">Location</div>
        <div class="head body">Details</div>
        <div class="head body">Price</div>
        <div class="head body">Update</div>
        <div class="head body">Remove</div>
        <?php
            if (!empty($datas)) {
                foreach ($datas as $data) {
                    echo '<div class="body"><img class="img" src="./php/' . htmlspecialchars($data['image_path']) . '"></div>';
                    echo '<div class="body">' . htmlspecialchars($data['name']) . '</div>';
                    echo '<div class="body">' . htmlspecialchars($data['location']) . '</div>';
                    echo '<div class="body">' . htmlspecialchars($data['description']) . '</div>';
                    echo '<div class="body">' . htmlspecialchars($data['price']) . '</div>';
                    echo '<div class="btns body"><a class="btn update" href="./update_package.php?id=' . htmlspecialchars($data['id']) . '">Update</a></div>';
                    echo '<div class="btns body"><a class="btn remove" href="./php/deletePackage.php?id=' . htmlspecialchars($data['id']) . '">Remove</a></div>';
                }
            }
        ?>
    </div>
</div>
</body>
</html>
