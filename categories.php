<div class="naseem" style="margin: 0 auto; text-align: center;">

<form action="search.php" method="GET">
    <input type="text" name="search" id="search" placeholder="Search products..." >
</form>

</div>
<?php

require_once('components/database.php');
require_once('components/product.php');
    try {
      $pdo = Database::getInstance()->getPdo();
      $stmt = $pdo->prepare("SELECT * FROM products");
      $stmt->execute();
      $products = $stmt->fetchAll();
      
      echo '<ul type="none" style="display: flex; list-style-type: none; padding: 0;">';
echo '<li class="catagory-con" data-category="all" style="margin-left: 20px; "> <a href="#" style="display:inline-block;padding:6px 12px;font-size:20px;font-weight:normal;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;cursor:pointer;background-image:none;border:1px solid transparent;border-radius:25px;color:#333;background-color:#fff;border-color:#ccc;">All</a></li>';
$categories = [];
foreach ($products as $productdata) {
    $category = $productdata['category'];
    if (!in_array($category, $categories)) {
        echo '<li class="catagory-con" data-category="' . $category . '" style="margin-left: 10px;"> <a href="#" style="display:inline-block;padding:6px 12px;font-size:20px;font-weight:normal;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;cursor:pointer;background-image:none;border:1px solid transparent;border-radius:25px;color:#333;background-color:#fff;border-color:#ccc;">' . $category . '</a></li>';
        $categories[] = $category;
    }
}
echo '</ul>';
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

?>



<div class="container">
    <?php 


    try {

        $pdo = Database::getInstance()->getPdo();
        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
    
        foreach ($products as $productdata) {
            $product = new Product(
                $productdata['product_id'], 
                $productdata['name'], 
                $productdata['quantity'], 
                $productdata['price'], 
                $productdata['image'],
                $productdata['category']
            );
            $product->display();
            
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }




    ?>



<script src="categories.js"></script>
<script src="basket.js"></script>
<!-- 





        document.addEventListener('DOMContentLoaded', function() {
        let searchInput = document.querySelector('#search');
        searchInput.addEventListener('input', function() {
            let query = this.value.toLowerCase();

            let products = document.querySelectorAll('.productview, .product-card');

            products.forEach(function(product) {
                let productName = product.textContent.toLowerCase();
                if (productName.includes(query)) {
                    product.style.display = 'flex';
                } else {
                    product.style.display = 'none';
                }
            });
        });

        // Rest of your code...
    }); -->
</div>