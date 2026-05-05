<?php
session_start();
include '../DBConn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hype Wear SA</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f4f4;
}

header{
    background:#111;
    color:#fff;
    text-align:center;
    padding:20px;
    font-size:32px;
    font-weight:bold;
}

nav{
    background:#222;
    text-align:center;
    padding:12px;
}

nav a{
    color:white;
    text-decoration:none;
    margin:0 15px;
    font-size:16px;
}

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
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card img{
    width:100%;
    height:260px;
    object-fit:cover;
}

.card-body{
    padding:18px;
}

.card-body h3{
    margin:0;
    font-size:22px;
}

.card-body p{
    color:#666;
}

.price{
    font-size:22px;
    font-weight:bold;
    margin:12px 0;
}

.btn-group{
    display:flex;
    gap:10px;
}

.btn{
    flex:1;
    padding:10px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.cart{
    background:#ff9800;
    color:white;
}

.buy{
    background:#111;
    color:white;
}

footer{
    margin-top:40px;
    background:#111;
    color:white;
    text-align:center;
    padding:20px;
}
</style>
</head>

<body>

<header>Hype Wear SA</header>

<nav>
<a href="../index.php">Home</a>
<a href="view_product.php">Products</a>
<a href="../cart.php">Cart</a>
<a href="../login.php">Login</a>
</nav>

<div class="container">
<div class="products">

<?php
$result = $conn->query("SELECT * FROM tblproducts WHERE approved=1");

while($row = $result->fetch_assoc()){
?>

<div class="card">

<img src="https://via.placeholder.com/300x260?text=Hype+Wear" alt="Product">

<div class="card-body">

<h3><?php echo $row['name']; ?></h3>

<p><?php echo $row['description']; ?></p>

<div class="price">R<?php echo $row['price']; ?></div>

<div class="btn-group">

<form action="../add_to_cart.php" method="POST">
<input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
<button class="btn cart">Add to Cart</button>
</form>

<form action="../buy.php" method="POST">
<input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
<button class="btn buy">Buy Now</button>
</form>

</div>

</div>
</div>

<?php } ?>

</div>
</div>

<footer>
© 2026 Hype Wear SA
</footer>

</body>
</html>