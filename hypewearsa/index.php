<?php
include 'DBConn.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Hype Wear SA</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#f4f4f4;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 40px;
    background:#111;
    color:white;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin:0 12px;
    font-weight:500;
}

.navbar a:hover{
    color:#ff9800;
}

/* HERO */
.hero{
    background:linear-gradient(135deg,#111,#333);
    color:white;
    text-align:center;
    padding:80px 20px;
}

.hero h1{
    font-size:40px;
    margin-bottom:10px;
}

.hero p{
    color:#ccc;
}

/* CONTAINER */
.container{
    width:90%;
    margin:auto;
    padding:40px 0;
}

/* PRODUCT GRID */
.products{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

/* PRODUCT CARD */
.card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
    padding:18px;
}

.card:hover{
    transform:translateY(-8px);
}

/* TITLE */
.card h3{
    margin-bottom:5px;
    color:#111;
}

/* DESCRIPTION */
.card p{
    color:#666;
    font-size:14px;
}

/* PRICE */
.price{
    font-size:18px;
    font-weight:bold;
    margin:10px 0;
    color:#ff9800;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    background:#ff9800;
    border:none;
    color:white;
    font-weight:bold;
    border-radius:10px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#e68900;
}

/* BADGE */
.badge{
    display:inline-block;
    background:#111;
    color:white;
    font-size:12px;
    padding:4px 8px;
    border-radius:5px;
    margin-bottom:8px;
}

footer{
    text-align:center;
    padding:20px;
    margin-top:40px;
    background:#111;
    color:white;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div><b>Hype Wear SA</b></div>

    <div>
        <a href="index.php">Home</a>
        <a href="products/view_product.php">Shop</a>
        <a href="cart/cart.php">Cart</a>
        <a href="users/login.php">Login</a>
        <a href="admin/adminLogin.php">Admin</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Streetwear That Defines You</h1>
    <p>Premium Fashion • Affordable Prices • Fast Delivery</p>
</div>

<!-- PRODUCTS -->
<div class="container">

<div class="products">

<?php
$result = $conn->query("SELECT * FROM tblProducts WHERE approved=1");

if($result && $result->num_rows > 0){

    while($row = $result->fetch_assoc()){
?>

<div class="card">

    <div class="badge">🔥 Featured</div>

    <h3><?php echo $row['name']; ?></h3>
    <p><?php echo $row['description']; ?></p>

    <div class="price">R<?php echo $row['price']; ?></div>

    <form action="cart/buy.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
        <input type="number" name="quantity" value="1" min="1" required>
        <button>Buy Now</button>
    </form>

</div>

<?php
    }

} else {
    echo "<h3 style='text-align:center;'>No products available right now.</h3>";
}
?>

</div>
</div>

<footer>
© 2026 Hype Wear SA | All Rights Reserved
</footer>

</body>
</html>