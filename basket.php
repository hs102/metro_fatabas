<?php

require 'navbar.php';


?>

<html>
<head>
    <title>Basket</title>
    <link rel="stylesheet" href="styles/basket.css">
</head>

</br>
</br>
</br>
<body>
    <?php 
     if(session_status() == PHP_SESSION_NONE){
         session_start();
        }
        $user = $_SESSION['user'];
        echo '<div class="cart-product">';
        echo '<button class="btn-style" onclick="clearBasket('.$user['user_id'].')">clear basket</button>';
        echo '<a class="btn-style" href="basket_history.php">View Basket History</a>';
        echo '</div>';
        ?>
    <?php
    require_once 'components/product.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION['Basket']) && isset($_SESSION['user'])) {
        
        
        $total_price = 0;
        $user = $_SESSION['user'];
        
        if(!isset($_SESSION['Basket'][$user['user_id']])) {
            $_SESSION['Basket'][$user['user_id']] = [];
        }
        

        // echo '<pre>';
        // echo print_r($_SESSION['Basket'][$user['user_id']]);
        // echo '</pre>';
        foreach ($_SESSION['Basket'][$user['user_id']] as $productId => $productdata) {
            $product = Product::getProductById($productId);
            
            if ($product) {
                echo '<div class = "cart-product">';
                echo '<div class= "product-info-con">';
                echo '<img src="' . $product->image . '" alt="product image">';
                echo '<div class="product-info">';
                echo '<p> Product Name: ' . $product->name . '</p>';
                echo '<p>Product Price: ' . $product->price . ' BD'. '</p>';
                echo '<p>Product Quantity:' . $productdata['quantity'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="product-actions">';
                echo '<button class="btn-style" onclick="addtoBasket(' . $product->id . ',  '.$user['user_id'].' )">Add Product to Basket</button>';
                echo '<button class="btn-style"onclick="removeFromBasket(' . $product->id . ',  '.$user['user_id'].')">Remove from Basket</button>';
                echo '</div>';
                echo '</div>';
                $total_price += $product->price * $productdata['quantity'] ;
                
            } else {
                echo 'Product not found';
            }
        }
        
        echo '<div class="cart-product">';
        echo '<p class="product-info">Total Price: ' . $total_price . '</p>';
        echo '<button class="btn-style" onclick="placeorder()"> Proceed to checkout</button>';
        echo '</div>';
        
    } else {
        echo 'Your cart is empty';
    }
    ?>



<script src="basket.js"></script>
</body>
</html>