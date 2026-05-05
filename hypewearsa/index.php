<?php
include 'DBConn.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Hype Wear SA</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f4f4f4;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    background:#111;
    color:white;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin:0 10px;
}

/* HERO */
.hero{
    background:#111;
    color:white;
    text-align:center;
    padding:60px 20px;
}

/* PRODUCTS */
.container{
    width:90%;
    margin:auto;
    padding:30px 0;
}

.products{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

.card{
    background:white;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    padding:15px;
}

.price{
    font-weight:bold;
    font-size:18px;
    margin:10px 0;
}

button{
    width:100%;
    padding:10px;
    background:#ff9800;
    border:none;
    color:white;
    font-weight:bold;
    border-radius:8px;
}

</style>

</head>

<body>

<div class="navbar">
    <div><b>Hype Wear SA</b></div>
    <div>
        <a href="index.php">Home</a>
        <a href="products/view_product.php">Shop</a>
        <a href="cart.php">Cart</a>
        <a href="login.php">Login</a>
    </div>
</div>

<div class="hero">
    <h1>Welcome to Hype Wear SA</h1>
    <p>Trendy Streetwear • Best Prices • Fast Delivery</p>
</div>

<div class="container">

<div class="products">

<?php
$result = $conn->query("SELECT * FROM tblProducts WHERE approved=1");

while($row = $result->fetch_assoc()){
?>

<div class="card">
    <h3><?php echo $row['name']; ?></h3>
    <p><?php echo $row['description']; ?></p>
    <div class="price">R<?php echo $row['price']; ?></div>

    <form action="buy.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
        <input type="number" name="user_id" placeholder="User ID" required>
        <input type="number" name="quantity" value="1" min="1" required>
        <button>Buy Now</button>
    </form>
</div>

<?php } ?>

</div>
</div>

</body>
</html>