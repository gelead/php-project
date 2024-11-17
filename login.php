<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://kit.fontawesome.com/fc0e7b7945.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/login.css">
    <style>body{background-image:url('images/signup_back.jpg');}</style>
</head>
<body>
    <?php
        session_start();
        
        include './php/connection.php';

        $err = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!empty($_POST['email']) && !empty($_POST['passwd'])) {
                $email = test_input($_POST['email']);
                $passwd = test_input($_POST['passwd']);
    
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
    
                if (mysqli_num_rows($result) === 1) {
                    $row = mysqli_fetch_assoc($result);
    
                    if (password_verify($passwd, $row['password'])) {
                        $_SESSION['username'] = $row['fullname'];
                        header("Location: home.php");
                        exit();
                    } else {
                        $err = "Incorrect password!";
                    }
                } else {
                    $err = "Email not found!";
                }
                mysqli_close($conn);
            } else {
                $err = "Please fill in all fields!";
            }
        }


        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>


    <div class="container">
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Email <input type="text" name="email"></label>
        <label>Password
            <div class="pass-input">
                <input type="password" name="passwd">
                <div class="show"><i class="fa-solid fa-eye"></i></div>
            </div>
        </label>
        <p class="err"><?php echo $err ?></p>
        <button type="submit">login</button>
    </form>
    <p class="signup">Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
    <script src="./js//pwdshow.js"></script>
</body>
</html>