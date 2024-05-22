
<nav>
<link rel="stylesheet" type="text/css" href="Styles/navbar.css">
<a href="index.php" class="logo-link" ><img src="images/metroside.jpg" alt="Logo" style="float: left;"></a>

    <div class="buttons">

    <?php 

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    echo '<a href="index.php">Home</a>';
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
        echo '<a href="basket.php">Basket</a>';
        if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'staff') {
            echo '<a href="Admindashboard.php">Admin Dashboard</a>';
        }
        if (isset($_SESSION['user']['fullname'])) {
            echo '<p class="username">Welcome, ' . $_SESSION['user']['fullname'] . '</p>';
        }
        echo '<button onclick= "Logout()">Logout</a>';
    } else {
        echo '<a href="loginFE.php">Login</a>';
        echo '<a href="signup.php">Sign Up</a>';
    }

    ?>

    <script>
        function Logout() {
            fetch('controllers/logout.php')
            .then(response => response.text())
            .then(data => {
                console.log(data);
                location.reload();
            })
        }
    </script>
    
    </div>
</nav>