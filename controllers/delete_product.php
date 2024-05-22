


<?php

require_once(__DIR__ . '/../components/database.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    $pdo = Database::getInstance()->getPdo();
    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
  
    echo "Product deleted successfully.";
  }



?>