
<?php

require_once(__DIR__ . '/../components/database.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    try {

        $user_id = $_POST['user_id'];
        
        $pdo = Database::getInstance()->getPdo();
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
      
        echo "User deleted successfully.";
    } catch (PDOException $e) {
        error_log($e->getMessage());
        echo "An error occurred while processing your request.";
    }
  }


?>