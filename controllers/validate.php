

<?php 

require_once (__DIR__."./../components/database.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["email"])) {
        try {

            $pdo = Database::getInstance()->getPdo();
            $email = $_POST["email"];
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user) {
                echo "true";
            } else {
                echo "false";
            }
        } catch(PDOException $e) {
            error_log($e->getMessage());
            echo "An error occurred while processing your request.";
        }
    }
}
?>