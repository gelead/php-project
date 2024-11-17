<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGUP</title>
    <script src="https://kit.fontawesome.com/fc0e7b7945.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/sigup.css">
    <style>body{background-image:url('./images/signup_back.jpg');}</style>
</head>
<body>

<?php
        require './php/connection.php';

        $fname = $lname = $email = $newPass = $confPass = $address = '';
        $fnameErr = $lnameErr = $emailErr = $newPassErr = $addressErr = $confPassErr = $trmsErr = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //First name
            list($fname, $fnameErr) = name_validation($_POST['fname']);
            //Last name
            list($lname, $lnameErr) = name_validation($_POST['lname']);
            //Email
            if (empty($_POST['email'])) {
                $emailErr = "Email is required";
            } else {
                $email = test_input($_POST['email']);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                }
            }
            //Address
            if (empty($_POST['address'])) {
                $addressErr = "Address is required";
            } else {
                $address = test_input($_POST['address']);
            }
            //Password
            if (empty($_POST['createpass'])) {
                $newPassErr = "Password is required";
            } else {
                $newPass = test_input($_POST['createpass']);
                $pattern = "/^(?=.*[a-z])(?=.*[A-Z]).{9,}$/";
                if (!preg_match($pattern, $newPass)) {
                    $newPassErr = "Password must be at least 9 characters long and contain at least one lowercase and one uppercase letter.";
                }
            }
            //Confirm password
            if (empty($_POST['confirmpass'])) {
                $confPassErr = "Password is required";
            } else {
                $confPass = test_input($_POST['confirmpass']);
                $pattern = "/^(?=.*[a-z])(?=.*[A-Z]).{9,}$/";
                if (!preg_match($pattern, $confPass)) {
                    $confPassErr = "Password must be at least 9 characters long and contain at least one lowercase and one uppercase letter.";
                }
                else if ($confPass != $newPass) {
                    $confPassErr = "Passwords do not match";
                }
                $confPass = password_hash($confPass, PASSWORD_DEFAULT);
            }
            //Terms&Conditions
            if (empty($_POST['terms-conditions'])) {
                $trmsErr = "You must agree to the terms and conditions";
            }

            //Insert data into the database
            $fullName = $fname . " " . $lname;
            if ($fnameErr == "" && $lnameErr == "" && $emailErr == "" && $newPassErr == "" && $addressErr == "" && $confPassErr == "" && $trmsErr == "") {
                $sql = "INSERT INTO users (fullname, email, password, address) VALUES ('$fullName', '$email', '$confPass', '$address')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: ../login.php");
                    exit();
                }
            }
        }

        function error_export() {
            global $fnameErr, $lnameErr, $emailErr, $newPassErr, $confPassErr, $addressErr, $trmsErr;
            return [$fnameErr, $lnameErr, $emailErr, $newPassErr, $confPassErr, $addressErr, $trmsErr];
        }
        function name_validation($data) {
            if (empty($data)) {
                return ["", "First Name is required"];
            } else if (!preg_match("/^[a-zA-Z]+$/", $data)) {
                return ["", "Only letters allowed"];
            }
            return [test_input($data), ""];
        }
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>




    <div class="form-container">
        <div>
            <h1>Co.</h1>
            <p>Already have an account? <a href="login.php">Sign in</a></p>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            <h2>Create An Account</h2>
            <div class="input-container">
                <div class="input-box">
                    <input type="text" name="fname" placeholder="First Name">
                    <div class="error-msg"> <?php echo $fnameErr; ?> </div>
                </div>
                <div class="input-box">
                    <input type="text" name="lname" placeholder="Last Name">
                    <div class="error-msg"> <?php echo $lnameErr; ?> </div>
                </div>
                <div class="input-box">
                    <input type="text" name="email" placeholder="Email">
                    <div class="error-msg"> <?php echo $emailErr; ?> </div>
                </div>
                <div class="input-box">
                    <input type="text" name="address" placeholder="Address">
                    <div class="error-msg"> <?php echo $addressErr; ?> </div>
                </div>
                <div class="input-box">
                    <div class="pass-input">
                        <input type="password" id="newPass" name="createpass" placeholder="Create Password">
                        <div class="show"><i class="fa-solid fa-eye"></i></div>
                    </div>
                    <div class="error-msg"> <?php echo $newPassErr; ?> </div>
                </div>
                <div class="input-box">
                    <div class="pass-input">
                        <input type="password" name="confirmpass" placeholder="Confirm Password">
                        <div class="show"><i class="fa-solid fa-eye"></i></div>
                    </div>
                    <div class="error-msg"> <?php echo $confPassErr; ?> </div>
                </div>
            </div>
            <p class="input-box echeck">
                <label> <input id="checkbox" type="checkbox" name="terms-conditions">
                        I agree to the <a href="#">Terms & Conditions</a>
                </label>
                <p class="error-msg"> <?php echo $trmsErr; ?> </p>
            </p>
            <button type="submit">Create Account</button>
        </form>
    </div>
    <script src="./js/pwdshow.js"></script>
</body>
</html>