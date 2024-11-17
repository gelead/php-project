<?php
    session_start();
    $uploadDir = 'uploads';

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            die('Failed to create uploads directory...');
        }
    }

    require '../../php/connection.php';

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = test_input($_POST["name"]);
        $location = test_input($_POST["location"]);
        $price = test_input($_POST["price"]);
        $description = test_input($_POST["description"]);
        $imagePath = $_FILES["image"];

        if (!empty($name) && !empty($location) && !empty($price) && !empty($description) && $imagePath['error']== UPLOAD_ERR_OK) {
            $filePath = $imagePath['tmp_name'];
            $fileName = $imagePath['name'];
            $destination = 'uploads/' . $fileName;

            if (move_uploaded_file($filePath, $destination)) {
                $stmt = $conn->prepare("INSERT INTO packages (name, location, price, description, image_path) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdss", $name, $location, $price, $description, $destination);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Pacakge added successfully.";
                } else {
                    $_SESSION['message'] = $stmt->error;
                }
                $stmt->close();
            } else {
                $_SESSION['message'] = "Failed to move the uploaded file.";
            }
        } else {
                $_SESSION['message'] = "Please fill all fields and ensure the file is uploaded.";
        }
    } else {
        $_SESSION['message'] = "Error on the data you entered.";
    }
    header('Location: ../add_package.php');
    $conn->close();
?>
