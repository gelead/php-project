<?php
session_start();
require '../../php/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $uploadDir = 'uploads';
        $fileName = basename($image['name']);
        $destination = $uploadDir . '/' . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($image['tmp_name'], $destination)) {
            $imagePath = $destination;
        } else {
            $_SESSION['msg'] = 'Failed to upload the image';
            exit();
        }
    } else {
        $sql = "SELECT image_path FROM packages WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $package = $result->fetch_assoc();
            $imagePath = $package['image_path'];
        } else {
            $_SESSION['msg'] = 'Failed to retrieve the image';
            exit();
        }
        $stmt->close();
    }

    $sql = "UPDATE packages SET name = ?, location = ?, price = ?, description = ?, image_path = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdssi', $name, $location, $price, $description, $imagePath, $id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = 'Package updated successfully';
    } else {
        $_SESSION['msg'] = 'Error updating package: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header('Location: ../manage_package.php');
    exit();
}

?>