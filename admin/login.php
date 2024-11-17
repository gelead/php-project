<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin_Login</title>
    <script src="https://kit.fontawesome.com/fc0e7b7945.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/admin.css">
    <style>body{background-image:url('../images/admin_wallpaper.jpg');}</style>
</head>
<body>
     <?php
        session_start();
        
        include '../php/connection.php';

        
        $err = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!empty($_POST['username']) && !empty($_POST['passwd'])) {
                $username = test_input($_POST['username']);
                $passwd = test_input($_POST['passwd']);
    
                $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();

                    if ($passwd == $row['password']) {
                        $_SESSION['username'] = $username;
                        header("Location: ./home.php");
                        exit();
                    } else {
                        $err = "Incorrect Password!";
                    }
                } else {
                    $err = "Username not found!";
                }
                $stmt->close();
            } else {
                $err = "Please fill in all fields!";
            }
            $conn->close();
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>


    <div class="container">
    <h2>Admin Page</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Username <input type="text" name="username"></label>
        <label>Password
            <div class="pass-input">
                <input type="password" name="passwd">
                <div class="show"><i class="fa-solid fa-eye"></i></div>
            </div>
        </label>
        <p class="err"><?php echo $err ?></p>
        <button type="submit">login</button>
    </form>
    </div>
    <script src="../js/pwdshow.js"></script>
</body>
</html>
