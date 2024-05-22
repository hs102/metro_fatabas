<?php

require_once (__DIR__ . '/../components/database.php');
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

try {
    if(isset($_SESSION['Basket']) && isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $pdo = Database::getInstance()->getPdo();
        $sql = "INSERT INTO orders (user_id,status) VALUES (:user_id,'Pending')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user['user_id']);
        $stmt->execute();
        $orderId = $pdo->lastInsertId();

        foreach ($_SESSION['Basket'][$user['user_id']] as $productId => $productdata) {
            $sql = "INSERT INTO placed_products (order_id, product_id,quantity,price) VALUES (:order_id, :product_id, :quantity, :price)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->bindParam(':quantity', $productdata['quantity']);
            $stmt->bindParam(':price', $productdata['price']);
            $stmt->execute();

            $sql = "UPDATE products SET quantity = quantity - :quantity WHERE product_id = :productId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':quantity', $productdata['quantity']);
            $stmt->bindParam(':productId', $productId);
            $stmt->execute();
        }

        echo 'Order placed successfully';

        unset($_SESSION['Basket'][$user['user_id']]);
    } else {
        echo 'Your cart is empty';
    
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



?>