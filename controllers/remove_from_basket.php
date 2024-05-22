
<?php
require_once(__DIR__ . '/../components/product.php');

if(isset($_POST['id'], $_POST['userid'])){
    $id = $_POST['id'];
    
    $userid = $_POST['userid'];
    Product::removeFromBasket($userid,$id);
}

?>