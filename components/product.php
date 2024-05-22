

<?php
require_once('database.php');
class Product{

    public $id;
    public $name;
    public $quantity;
    public $price;
    public $image;
    public $category;

    public function __construct($id,$name,$quantity, $price, $image, $category){
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->id = $id;
        $this->quantity = $quantity;
        $this->category = $category;
    }

    public function display(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if($this->quantity > 0) {

            echo '<div class="product-card" name="'.$this->name.'" data-category="'.$this->category.'" style=height:350px;>
                <img src='. $this->image. ' alt='. $this->name. ' style="width:100px;height:100px; margin:0 auto;"> <br>
                <h3>'. $this->name. '</h3>
                <p>Price: '. $this->price. ' BD' . '</p>';
                if(isset($_SESSION['user'])) {
                    // echo '<pre>';
                    // echo print_r($_SESSION['user']);
                    // echo '</pre>';

                    echo '<a href="productview.php?product_id='. $this->id .'">View Product</a> <br>';
                    echo '<button onclick="addtoBasket('. $this->id .', '. $_SESSION['user']['user_id'] . ')">Add to Basket</button>';
                }
            echo "</div>";
        }
    }

    public static function getProductbyId($id) {
        try {
            $pdo = Database::getInstance()->getPdo();
            $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $id);
            $stmt->execute();
            $productdata = $stmt->fetch();
            if($productdata){
                return new self(
                $productdata['product_id'], 
                $productdata['name'], 
                $productdata['quantity'], 
                $productdata['price'], 
                $productdata['image'],
                $productdata['category']
            );
            }
            return null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public static function addToBasket($userid, $id) {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        $product = self::getProductbyId($id);
        if($product){
            if(isset($_SESSION['Basket'][$userid][$id])){
                if($_SESSION['Basket'][$userid][$id]['quantity'] < $product->quantity){
                    $_SESSION['Basket'][$userid][$id]['quantity']++;
                } else {
                    echo "Cannot add more of this product to the basket. Maximum quantity reached.";
                    return;
                }
            }else{
                $_SESSION['Basket'][$userid][$id] = array(
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                    'image' => $product->image
                );
            }
    
            echo "<pre>";
            echo print_r($_SESSION['Basket']);
            echo "</pre>";
        }else{
            echo "Product not found.";
        }
    }

    public static function removeFromBasket($userid, $id) {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['Basket'][$userid][$id])){
            if($_SESSION['Basket'][$userid][$id]['quantity'] > 1){
                $_SESSION['Basket'][$userid][$id]['quantity']--;
            }else{
                unset($_SESSION['Basket'][$userid][$id]);
            }
            echo "Product removed from Basket.";
        }else{
            echo "Product not found in Basket.";
        }
    }

    public static function getBasket($userid){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['Basket'][$userid])){
            return $_SESSION['Basket'][$userid];
        }else{
            return null;
        }
    }

    public static function clearBasket($userid){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['Basket'][$userid])){
            unset($_SESSION['Basket'][$userid]);
            echo "Basket cleared.";
        }else{
            echo "Basket is already empty.";
        }
    }

}




?>