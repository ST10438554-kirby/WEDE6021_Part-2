<?php
session_start();
include 'DBConn.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_POST['product_id'])){
    die("Invalid request.");
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_POST['product_id'];

// get product
$stmt = $conn->prepare("SELECT price FROM tblproducts WHERE product_id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Product not found");
}

$product = $result->fetch_assoc();

$quantity = 1;
$total = $product['price'] * $quantity;

// insert order
$order = $conn->prepare("
    INSERT INTO tblOrders (user_id, product_id, quantity, total_amount, order_date)
    VALUES (?, ?, ?, ?, NOW())
");

$order->bind_param("iiid", $user_id, $product_id, $quantity, $total);

if($order->execute()){
    echo "<h2 style='color:green;'>Order placed successfully!</h2>";
    echo "<a href='products/view_product.php'>Back to Shop</a>";
} else {
    echo "Error placing order.";
}
?>