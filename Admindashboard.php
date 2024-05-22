<!DOCTYPE html>
<html>
<link rel="stylesheet" href="Styles/admindashboard.css">

<head>
  <title>Add Products</title>
 
</head>
<body>

<?php
require 'navbar.php';
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$user = $_SESSION['user'];
if ($user['role'] != 'admin' && $user['role'] != 'staff') {
  header('Location: index.php');
  exit();
}

?>
  <div class="container">
    <h1>Add Product</h1>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter product Name" required>
      </div>
      <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" placeholder="Enter product Price" required>
      </div>
      <div class="form-group">
        <label for="price">Quantity:</label>
        <input type="text" id="price" name="quantity" placeholder="Enter product Quantity" required>
      </div>
      <div class="form-group">
        <label for="price">Category:</label>
        <input type="text" id="price" name="category" placeholder="Enter product Category" required>
      </div>
      <div class="form-group">
        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" required>
      </div>
      <button type="submit" name="addproduct">Add Product</button>
    </form>
  </div>
</body>
</html>


<?php
require_once 'components/database.php';

if (isset($_POST['addproduct'])) {
  if (!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
    echo "No file was uploaded.";
    exit;
  }

  $pdo = Database::getInstance()->getPdo();
  $target_dir = "images/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);

  $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);

  if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    exit;
  }

  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
  $sql = "INSERT INTO products (name, price, quantity, image,category) VALUES (:name, :price, :quantity, :image,:category)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':name', $_POST['name']);
  $stmt->bindParam(':price', $_POST['price']);
  $stmt->bindParam(':quantity', $_POST['quantity']);
  $stmt->bindParam(':category', $_POST['category']);
  $stmt->bindParam(':image', $target_file);
  $stmt->execute();
  header('Location: index.php');
}
?>

<h1>Products List</h1>
<?php
try {
  $pdo = Database::getInstance()->getPdo();
  $sql = "SELECT * FROM products";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $products = $stmt->fetchAll();
  echo '<table class="table">';
  echo '<tr>';
  echo '<th>product_id</th>';
  echo '<th>Image</th>';
  echo '<th>Name</th>';
  echo '<th>Price</th>';
  echo '<th>Quantity</th>';
  echo '<th>Category</th>';
  echo '<th>Update</th>';
  echo '<th>Delete</th>';
  echo '</tr>';
  foreach ($products as $product) {
    echo '<tr>';
    echo '<td>' . $product['product_id'] . '</td>';
    echo '<td><img src="' . $product['image'] . '" alt="' . $product['name'] . '"style= width:100px; hight: 220px; ></td>';
    echo '<td><input type="text" name="products[' . $product['product_id'] . '][name]" value="' . $product['name'] . '"></td>';
    echo '<td><input type="text" name="products[' . $product['product_id'] . '][price]" value="' . $product['price'] . '"></td>';
    echo '<td><input type="text" name="products[' . $product['product_id'] . '][quantity]" value="' . $product['quantity'] . '"></td>';
    echo '<td><input type="text" name="products[' . $product['product_id'] . '][category]" value="' . $product['category'] . '"></td>';
    echo '<td><button class="btn-style" type="submit" name="updateProduct" onclick="updateProduct(' . $product['product_id'] . ', 
    document.getElementsByName(\'products[' . $product['product_id'] . '][name]\')[0].value, 
    document.getElementsByName(\'products[' . $product['product_id'] . '][price]\')[0].value, 
    document.getElementsByName(\'products[' . $product['product_id'] . '][quantity]\')[0].value,
    document.getElementsByName(\'products[' . $product['product_id'] . '][category]\')[0].value)">Update Product</button></td>';
    echo '<td><button class="btn-style" type="submit" name="deleteProduct" onclick="deleteProduct('.$product['product_id'].')">Delete</button></td>';
    echo '</tr>';
  }
  echo '</table>';
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

?>


<h1>On Going Orders</h1>
<?php
require_once ('components/product.php');
try {
  $pdo = Database::getInstance()->getPdo();
  $sqlorder = "SELECT * FROM orders";
  $stmt = $pdo->prepare($sqlorder);
  $stmt->execute();
  $orders = $stmt->fetchAll();
  echo '<table class="table">';
  echo '<tr>';
  echo '<th>orderid</th>';
  echo '<th>Images</th>';
  echo '<th>Names</th>';
  echo '<th>Total Price</th>';
  echo '<th>Total Quantity</th>';
  echo '<th>User</th>';
  echo '<th>Status</th>';
  echo '<th>Update</th>';
  echo '<th>Remove</th>';
  echo '</tr>';

  foreach ($orders as $order) {
    $sqlplaced_product = "SELECT * FROM placed_products where order_id = :order_id";
    $stmtplaced_product = $pdo->prepare($sqlplaced_product);
    $stmtplaced_product->bindParam(':order_id', $order['order_id']);
    $stmtplaced_product->execute();
    $placed_products = $stmtplaced_product->fetchAll();

    $sqluser = "SELECT * FROM users where user_id = :user_id";
    $stmtuser = $pdo->prepare($sqluser);
    $stmtuser->bindParam(':user_id', $order['user_id']);
    $stmtuser->execute();
    $user = $stmtuser->fetch();

    $images = '';
    $names = '';

    $totalprice = 0;
    $totalquantity = 0;
    foreach ($placed_products as $placed_product) {
      $product = Product::getProductById($placed_product['product_id']);
      $images .= '<img src="' . $product->image . '" alt="' . $product->name . '"style= width:100px; hight: 220px;>';
      $names .= $product->name . ', ';

      $totalprice += $product->price * $placed_product['quantity'];
      $totalquantity += $placed_product['quantity'];
    }

    echo '<tr>';
    echo '<td>' . $order['order_id'] . '</td>';
    echo '<td>' . $images . '</td>';
    echo '<td>' . rtrim($names, ', ') . '</td>';
    echo '<td>' . $totalprice . '</td>';
    echo '<td>' . $totalquantity . '</td>';
    echo '<td>' . $user['fullname'] . '</td>';
    echo '<td>';
    echo '<select id="status" name="status">';
    echo '<option value="Pending"' . ($order['status'] == 'Pending' ? ' selected' : '') . '>Pending</option>';
    echo '<option value="Acknowledged"' . ($order['status'] == 'Acknowledged' ? ' selected' : '') . '>Acknowledged</option>';
    echo '<option value="Completed"' . ($order['status'] == 'Completed' ? ' selected' : '') . '>Completed</option>';
    echo '</select>';
    echo '<td><button class= "btn-style" type="submit" name="updateorder" onclick="updateOrder('.$order['order_id']. ',document.getElementById(\'status\').value)">Update status</button></td>';
    echo '<td><button class= "btn-style" type="submit" name="deleteorder" onclick="deleteOrder('.$order['order_id'].')">Delete order</button></td>';
    echo '</tr>';
  }
  echo '</table>';
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>

<h1>User List</h1>
<?php
try {
  $pdo = Database::getInstance()->getPdo();
  $sql = "SELECT * FROM users";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $users = $stmt->fetchAll();
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  $current_user_id = $_SESSION['user']['user_id'];
  $current_user_role = $_SESSION['user']['role'];

  echo '<table class="table">';
  echo '<tr>';
  echo '<th>Full Name</th>';
  echo '<th>Email</th>';
  echo '<th>Role</th>';
  echo '<th>Update</th>';
  echo '<th>Delete</th>';
  echo '</tr>';
  foreach ($users as $user) {
    echo '<tr>';
    echo '<td>' . $user['fullname'] . '</td>';
    echo '<td>' . $user['email'] . '</td>';
    echo '<td>';

    echo $user['role'];
    echo '   ';
    echo '<select name="role" id="role'.$user['user_id'].'" ' . ($user['role'] == 'admin' ? 'disabled' : '') . '>';
    if ($user['role'] != 'admin') {
        echo '<option value="user"' . ($user['role'] == 'user' ? ' selected' : '') . '>User</option>';
        if($current_user_role != 'staff') {

          echo '<option value="staff"' . ($user['role'] == 'staff' ? ' selected' : '') . '>Staff</option>';
        }
    } else {

      echo '<option value="admin"' . ($user['role'] == 'admin' ? ' selected' : '') . '>Admin</option>';
    }
    echo '</select>';

    echo '</td>';
    echo '<td><button class="btn-style" name="updateUserRole" onclick="updateUserRole('.$user['user_id'].', document.getElementById(\'role'.$user['user_id'].'\').value)">Update User</button></td>';

    echo '<td><button class="btn-style" name="deleteUser" onclick="deleteUser('.$user['user_id'].')" '.($user['role'] == 'admin' ? 'disabled' : '').'>Delete User</button></td>';
    echo '</tr>';
  }
  echo '</table>';
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>


<script src="admindashboard.js"></script>