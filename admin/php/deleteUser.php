<?php
session_start();

require '../../php/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'DELETE FROM users WHERE id = ?';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'User deleted successfully.';
    } else {
        $_SESSION['message'] = 'Error deleting user: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

header('Location: ../manage_user.php');
exit();
?>