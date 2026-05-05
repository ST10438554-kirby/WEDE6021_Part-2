<?php
session_start();
include '../DBConn.php';
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
    padding:10px 15px;
    background:#ff9800;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
    margin-top:10px;
}
</style>

</head>

<body>

<header>Your Shopping Cart</header>

<div class="container">

<?php

$total = 0;

if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    echo "<div class='empty'>Your cart is empty</div>";
} else {

    foreach($_SESSION['cart'] as $product_id){

        $stmt = $conn->prepare("SELECT name, price FROM tblproducts WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

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

    echo '
    <form action="/hypewearsa/cart/checkout_cart.php" method="POST">
        <button class="btn">Checkout All Items</button>
    </form>
    ';
}

?>

<br>
<a href="../index.php"><button class="btn">Continue Shopping</button></a>

</div>

</body>
</html>