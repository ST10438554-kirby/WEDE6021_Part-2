<?php
session_start();
include 'DBConn.php';

// 🔒 MUST BE LOGGED IN
if(!isset($_SESSION['user_id'])){
    die("<h3>Please login first.</h3><a href='login.php'>Login</a>");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    // 🔒 GET PRODUCT SAFELY
    $stmt = $conn->prepare("SELECT price FROM tblproducts WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        die("Product not found.");
    }

    $row = $result->fetch_assoc();

    $quantity = 1;
    $total = $row['price'] * $quantity;

    // 🔒 INSERT ORDER SAFELY
    $insert = $conn->prepare("
        INSERT INTO tblOrders (user_id, product_id, quantity, total_amount)
        VALUES (?, ?, ?, ?)
    ");

    $insert->bind_param("iiid", $user_id, $product_id, $quantity, $total);

    if($insert->execute()){
        echo "
        <div style='text-align:center; margin-top:50px; font-family:Arial;'>
            <h2 style='color:green;'>Purchase successful!</h2>
            <a href='products/view_product.php'>Back to Products</a>
        </div>";
    } else {
        echo "Error: " . $insert->error;
    }
}
?>