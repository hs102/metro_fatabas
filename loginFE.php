<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="Styles/auth.css">
    <link rel="icon" href="Images/MetroLogo.jpg" type="image/x-icon">
    <script src="validate.js"></script>

</head>

<body>

    <?php
        require_once('components/database.php');
        $error = '';
        if(isset($_POST['login'])) {
            if(isset($_POST['email']) && isset($_POST['password'])) {
                $pdo = Database::getInstance()->getPdo();
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch();
                if($user) {
                    if(password_verify($password, $user['password'])) {
                        if(session_status() == PHP_SESSION_NONE){
                            session_start();
                        }
                        $_SESSION['user'] = $user;
                        header("Location: index.php");
                    } elseif($password == $user['password']) {
                        if(session_status() == PHP_SESSION_NONE){
                            session_start();
                        }
                        $_SESSION['user'] = $user;
                        header("Location: index.php");
                    } else {
                        $error = "Invalid email or password";
                    }
                    
                } else {
                    $error = "Invalid email or password";
                }
            } else {
                $error = "Please enter email and password";
            }
        }
    ?>
    <div class="container">
        <main>
            <img src="images/MetroWide.jpg" alt="Logo" style="float: left;">
            <h1>Login</h1>
            <form method="post">

                <label for="email">Email:</label>
                <input type="text" name="email" id="email"
                    value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                <label for="password">Password:<?php if (isset($error))
                    echo '<small> ' . $error . '</small>' ?></label>
                    <input type="password" name="password" id="password" required oninput="validateEmail(false)">
                    <input id="submit" type="submit" name="login" value="login">
                    <a href="signup.php">Create account</a>
                </form>
            </main>
            
    </div>







</body>

</html>