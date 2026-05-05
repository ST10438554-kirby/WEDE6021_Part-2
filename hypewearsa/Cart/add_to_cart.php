<?php
session_start();

/* ✅ correct DB path */
include __DIR__ . '/../DBConn.php';

// 🚨 CHECK POST DATA
if (!isset($_POST['product_id'])) {
    die("Invalid request.");
}

$product_id = (int)$_POST['product_id'];

// 🚨 CHECK PRODUCT EXISTS
$stmt = $conn->prepare("SELECT product_id FROM tblproducts WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Product not found.");
}

/* 🔴 LOGIN CHECK (FIXED FLOW) */
if (!isset($_SESSION['user_id'])) {

    // 💡 remember what user wanted to add
    $_SESSION['pending_cart'] = $product_id;

    header("Location: /hypewearsa/users/login.php");
    exit();
}

/* 🛒 INIT CART */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* 🛒 ADD PRODUCT */
$_SESSION['cart'][] = $product_id;

/* 🔁 REDIRECT BACK TO SHOP */
header("Location: /hypewearsa/products/view_product.php");
exit();
?>