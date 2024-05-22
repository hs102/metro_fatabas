<?php
require_once (__DIR__."./../components/database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {

  try {

    $pdo = Database::getInstance()->getPdo();
  
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

  
    $sql = "UPDATE products SET name = :name, price = :price, quantity = :quantity, category = :category WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':product_id', $product_id);

    $stmt->execute();
  
    echo $product_id . " updated successfully." .$name . $price . $quantity;


  } catch(PDOException $e) {
    error_log($e->getMessage());
    echo "An error occurred while processing your request.";

  }
}
?>