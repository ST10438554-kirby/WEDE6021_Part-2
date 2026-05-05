<?php
session_start();
include __DIR__ . '/../DBConn.php';

/* 🚨 MUST BE LOGGED IN */
if (!isset($_SESSION['user_id'])) {
    header("Location: /hypewearsa/users/login.php");
    exit();
}

/* 🚨 CHECK CART */
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty.");
}

$user_id = $_SESSION['user_id'];

foreach ($_SESSION['cart'] as $product_id) {

    // GET PRODUCT
    $stmt = $conn->prepare("SELECT price FROM tblproducts WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $price = $row['price'];
        $qty = 1;
        $total = $price * $qty;

        // INSERT ORDER
        $insert = $conn->prepare("
            INSERT INTO tblorders (user_id, product_id, quantity, total_price)
            VALUES (?, ?, ?, ?)
        ");

        $insert->bind_param("iiid", $user_id, $product_id, $qty, $total);
        $insert->execute();
    }
}

/* 🧹 CLEAR CART */
unset($_SESSION['cart']);

/* 🔁 REDIRECT SUCCESS */
header("Location: /hypewearsa/orders.php");
exit();
?>