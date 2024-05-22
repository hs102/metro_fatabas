

<?php


require_once('components/product.php');

require_once('navbar.php');

if(isset($_GET['product_id'])){
    $product = product::getProductById($_GET['product_id']);

    echo '<div class="product-view">';
    echo '<img src="' . $product->image . '" alt="product image">';
    echo '<div class="product-info">';
    echo '<h3>' . $product->name . '</h3>';
    echo '<p>Price: ' . $product->price . ' BD' . '</p>';
    echo '<p>Quantity: ' . $product->quantity . '</p>';
    echo '</div>';
    echo '<button class="cartbtn" onclick="addtoBasket('. $product->id. ', '. $_SESSION['user']['user_id'] . ')">Add to Basket</button>';
    if(!$product){
        header('Location: index.php');
    }
}



?>


<script src="basket.js"></script>
<style>
    .product-view {
        background-color: #C1DBB3;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        margin-top: 50px;
        width: 50%;
margin: 30px auto; 
border-radius: 50px;   }

    .product-view img {
        margin-top: 40px;
        border-radius: 15%;
        padding-top: 10px;
        width: 230px;
        height: 200px;
        margin-bottom: 20px;
    }

    .product-info {
        text-align: center;
        font-family: 'Roboto', sans-serif;
    }

    .product-info h3 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .product-info p {
        font-size: 18px;
        margin-bottom: 5px;
    }


    .cartbtn {
        background-color: green;
            padding: 10px 20px;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 55px;
            margin-bottom: 20px;

    }

    .cartbtn:hover {
        background-color: #00b894;    }


</style>