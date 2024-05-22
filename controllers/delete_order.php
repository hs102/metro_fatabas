
<?php
require_once(__DIR__ . '/../components/database.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {

    try {
        $pdo = Database::getInstance()->getPdo();
        $order_id = $_POST['order_id'];
        $sql = "DELETE FROM orders WHERE order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        echo "Order deleted successfully.";
    } catch (PDOException $e) {
        error_log($e->getMessage());
        echo "An error occurred while processing your request.";
    }
}


?>