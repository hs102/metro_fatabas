<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href = "Styles/auth.css" rel = "stylesheet" type = "text/css">
    <script src="validate.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/MetroLogo.jpg" type="image/x-icon">
</head>
<body>
<div class="container">
    <main>
        <img src="images/MetroWide.jpg" alt="Logo" style="float: left;">
        <h1>Register</h1>
        <form  method="post">
        <label for="name">Name:</label><input name="name" type="text" id="name" placeholder="Enter Your Name" required>
        <label for="email">Email:</label><input name="email" type="text" id="email" placeholder="Enter Your Email" oninput="validateForm(true)" required>
        <label for="password">Password:</label><input name="password" type="password" id="password" placeholder="Enter Your Password" oninput="validateForm()" required>
            <ul id="passwordRules">
                <li id="length">At least 8 characters</li>
                <li id="upper">At least one uppercase letter</li>
                <li id="lower">At least one lowercase letter</li>
                <li id="number">At least one number</li>
                <li id="special">At least one special character</li>
            </ul>
            <input id="submit" type="submit" name="signup" disabled>
            <a href="loginFE.php">have an account? Login</a>
        </form>
    </main>

    <?php
    require_once ('components/database.php');
    
    if (isset($_POST['signup'])) {
        try {
            if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name'])) {
                $pdo = Database::getInstance()->getPdo();
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch();

                if ($user) {
                    return;
                }
    
                $stmt = $pdo->prepare("INSERT INTO users (fullname,role,email, password) VALUES (:fullname,'user',:email, :password)");
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":fullname", $name);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(":password", $hashedPassword);
                $stmt->execute();
    
                header("Location: loginFE.php");
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo "An error occurred while processing your request." . $e->getMessage();
        }
    }
    ?>
    </div>
    </body>
    </html>