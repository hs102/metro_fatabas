
<?php
require_once(__DIR__ . '/../components/product.php');

if(isset($_POST['userid'])){
    $userid = $_POST['userid'];
    Product::clearBasket($userid);
}


?>