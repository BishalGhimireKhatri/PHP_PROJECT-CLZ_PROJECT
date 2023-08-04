<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php include("database/database.php"); ?>
<?php include("validation/valid.php") ?>

<div class="Outer-form-text">
<h1>Library  Management System</h1>
<span id="outer-form-span">
Welcome to the  Library!

Explore a world of knowledge and imagination in our cozy library. We're here to make your reading experience delightful and convenient. With our simple and efficient library management system, you can easily browse, borrow, and return books with just a few clicks.






.
</span>
</div>

    <div class="Main_form">
        <div class="signup">
            <form method="post" action="register.php" name="signup">
                <div class="signup-image">
                    <img src="icons/add-user.png" id="addUser" style="width: 60px;">
                </div>

                <div class = "username-section">
                <input type="text" name="username" class="userInput" id="usernameInput" placeholder="Enter your Username" autocomplete="off">
                <p style="color: red; margin-right:40px" id="usernameError"><?php if (isset($errors['username'])) echo $errors['username']; ?></p>
                </div><br>

                <div class = "password-section">
                <input type="text" name="email" class="userInput" id="emailInput" placeholder="Enter your Email" autocomplete="off">
                <p style="color: red; margin-right:50px" id="emailError"><?php if (isset($errors['email'])) echo $errors['email']; ?></p>
                </div><br>

                <div class="password-section">
                    <input type="password" id="userPassword" class="userInput" id="passwordInput" name="password" placeholder="Enter your Password" autocomplete="off">
                    <p style="color: red; margin-right:5px" id="passwordError"><?php if (isset($errors['password'])) echo $errors['password']; ?></p>
                    <img src="icons/eye-close.png" id="eyeicon"><br>
                </div>
        </div>
        <br>
        <input type="submit" class="button" name="signupSubmit" value="Signup">
        </form>
    </div>
    <script src="javascript/password.js"></script>

    <!-- php code -->
    <?php
include_once("database/database.php");

/* User Registration */
function userRegistration($email, $password, $username)
{
    global $conn;
    try {
        $st = $conn->prepare("SELECT * FROM user_information WHERE email=:email");
        $st->bindParam("email", $email);
        $st->execute();
        $st->setFetchMode(PDO::FETCH_ASSOC); // fetch the output in form of associative array
        $count = $st->rowCount();
        if ($count < 1) {
            $stmt = $conn->prepare("INSERT INTO user_information(email,password,username) VALUES (:email,:hash_password,:username)");
            $stmt->bindParam("email", $email, PDO::PARAM_STR);
            $hash_password = hash('sha256', $password); //Password encryption
            $stmt->bindParam("hash_password", $hash_password, PDO::PARAM_STR);
            $stmt->bindParam("username", $username, PDO::PARAM_STR);
            $stmt->execute();
            $uid = $conn->lastInsertId(); // Last inserted row id
            $_SESSION['uid'] = $uid;
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

/* Signup Form */
if (!empty($_POST['signupSubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // email and password rules
    $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
    $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

    if ($email_check && $password_check && strlen(trim($username)) > 0) {
        $uid = userRegistration($email, $password, $username);
        if ($uid) {
            header("Location: index.php"); // redirected to index.php
        } else {
            $errorMsgReg = "Username or Email already exists.";
        }
    }
} ?>
</body>

</html>