<?php
session_start();
include 'DBConn.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Cart | Hype Wear SA</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

header{
    background:#111;
    color:white;
    padding:20px;
    text-align:center;
}

.container{
    width:80%;
    margin:auto;
    padding:20px;
}

.cart-item{
    background:white;
    padding:15px;
    margin-bottom:10px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.total{
    font-size:20px;
    font-weight:bold;
    margin-top:20px;
}

.empty{
    text-align:center;
    padding:40px;
    color:gray;
}

.btn{
    padding:8px 12px;
    background:#ff9800;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}
</style>

</head>

<body>

<header>
    Your Shopping Cart
</header>

<div class="container">

<?php

$total = 0;

// CHECK CART
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    echo "<div class='empty'>Your cart is empty</div>";
    exit();
}

// LOOP CART ITEMS
foreach($_SESSION['cart'] as $product_id){

    $result = $conn->query("SELECT * FROM tblproducts WHERE product_id=$product_id");

    if($row = $result->fetch_assoc()){

        echo "
        <div class='cart-item'>
            <div>
                <h3>{$row['name']}</h3>
                <p>R{$row['price']}</p>
            </div>
        </div>
        ";

        $total += $row['price'];
    }
}

echo "<div class='total'>Total: R".$total."</div>";

?>

<br>
<a href="index.php"><button class="btn">Continue Shopping</button></a>

</div>

</body>
</html>