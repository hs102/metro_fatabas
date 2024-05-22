
<?php
require_once(__DIR__ . '/../components/product.php');


    if(isset($_POST['id']) && isset($_POST['userid'])){
        $id = $_POST['id'];
        $userid = $_POST['userid'];
        Product::addToBasket($userid,$id);

        
        echo "Product added to cart.";
    } else {
        echo "Product not found.";
    }
?>