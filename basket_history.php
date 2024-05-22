<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MetroMart - Order history</title>
</head>
<body>
    
    <?php include('navbar.php') ?>
    <?php 
    include_once('components/database.php');
    require_once 'components/product.php'; 

    // $userId = $_SESSION['userId'];
    echo "<hr>";
    $pdo = Database::getInstance()->getPdo();
    $sql = "SELECT * FROM Orders where user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user']['user_id']);
    $stmt->execute();
    $orders = $stmt->fetchAll();
    echo ' <div class="container">';
        foreach ($orders as $order) {
            echo "Order ID: " . $order['order_id'] . "<br>";
            echo "Status: " . $order['status'] . "<br>";
        
            $sql = "SELECT * FROM placed_products WHERE order_id = :order_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':order_id', $order['order_id']);
            $stmt->execute();
            $products = $stmt->fetchAll();
            foreach ($products as $placed_product) {

                $product = Product::getProductById($placed_product['product_id']);
                if ($product) {
                    echo '<table >';
                    echo '<div class = "cart-product">';
                    echo '<img src="' . $product->image . '" alt="product image" style= width:100px; height=210px;>';
                    
                    echo '<div class="product-info">';
                    echo '<p> Product Name: ' . $product->name . '</p> <br>';
                    echo '<p>Product Price: ' . $placed_product['price'] . ' BD' .'</p> <br>'; 
                    echo '<p>Ordered Quantity:' . $placed_product['quantity'] . '</p> <br>';
                    echo  '</div>';
                    echo '</div>';
                    
                    echo '</table>';

                } else {
                    echo 'Product not found';
                }
            }
        
            echo "<hr>";
        }
        echo ' </div>';
    ?>

</body>
</html>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
      
    }

    .container {
        
        background-color: #C1DBB3;
        width: 35%;
        justify-content: center;
        align-items: center;
        margin: 30px auto;
      padding-top: 30px;
        border-radius: 40px;
        text-align: center;
    font-size: large;

    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .order {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .order-info {
        margin-bottom: 10px;
    }

    .product {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .product img {
        width: 100px;
        height: 100px;
        margin-right: 10px;
    }

    .product-info {
        flex-grow: 1;
        padding:20px ;
    }

    .product-info p {
        margin: 0;
    }
    .cart-product{
        margin-bottom: 5px;
        padding: 20px;
    }
</style>