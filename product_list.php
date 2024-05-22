<!DOCTYPE html>
<html>
<link rel="stylesheet" href="Styles/product_list.css">

<head>
  <title>Add Products</title>
 
</head>
<body>

<?php
require 'navbar.php';
?>
  <div class="container">
    <h1>Add Product</h1>
    <form>
      <div class="form-group">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter product name" required>
      </div>
      <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" placeholder="Enter product price" required>
      </div>
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" placeholder="Enter product description" required></textarea>
      </div>
      <button type="submit">Add Product</button>
    </form>
  </div>
</body>
</html>