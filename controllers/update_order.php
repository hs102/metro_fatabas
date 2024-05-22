
<?php 
require_once (__DIR__."./../components/database.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["order_id"])) {
        try {
            $pdo = Database::getInstance()->getPdo();
            $order_id = $_POST["order_id"];
            $status = $_POST["status"];
            echo $order_id . $status;
            $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            echo "Order updated successfully.";
        } catch(PDOException $e) {
            error_log($e->getMessage());
            echo "An error occurred while processing your request.";
        }
    }
}


?>