
<?php
require_once(__DIR__ . '/../components/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    try {

        $user_id = $_POST['user_id'];
        $role = $_POST['role'];
        
        echo $user_id . $role;
        $pdo = Database::getInstance()->getPdo();
        $sql = "UPDATE users SET role = :role WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
      
        echo "User role updated successfully.";
    } catch (PDOException $e) {
        error_log($e->getMessage());
        echo "An error occurred while processing your request.";
    }

  }


?>