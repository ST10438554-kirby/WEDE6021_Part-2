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

/* ===== BODY ===== */
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f4f4;
}

/* ===== MODERN NAVBAR ===== */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    background:rgba(17,17,17,0.95);
    backdrop-filter: blur(10px);
    position:sticky;
    top:0;
    z-index:1000;
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
}

.logo{
    color:white;
    font-size:22px;
    font-weight:bold;
}

.nav-links a{
    color:white;
    text-decoration:none;
    margin:0 12px;
    padding:8px 12px;
    border-radius:8px;
    transition:0.3s;
}

.nav-links a:hover{
    background:#ff9800;
    color:black;
}

/* ===== CONTAINER ===== */
.container{
    width:90%;
    margin:auto;
    padding:30px 0;
}

/* ===== PRODUCT GRID ===== */
.products{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

/* ===== PRODUCT CARD ===== */
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
    font-size:20px;
}

.card-body p{
    color:#666;
    font-size:14px;
}

.price{
    font-size:20px;
    font-weight:bold;
    margin:10px 0;
}

/* ===== BUTTONS ===== */
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
    transition:0.3s;
}

.cart{
    background:#ff9800;
    color:white;
}

.cart:hover{
    background:#e68900;
}

.buy{
    background:#111;
    color:white;
}

.buy:hover{
    background:#333;
}

/* ===== FOOTER ===== */
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

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">Hype Wear SA</div>

    <div class="nav-links">
        <a href="../index.php">Home</a>
        <a href="view_product.php">Shop</a>
        <a href="../cart.php">Cart</a>
        <a href="../login.php">Login</a>
    </div>
</div>

<!-- PRODUCTS -->
<div class="container">

<div class="products">

<?php
$result = $conn->query("SELECT * FROM tblproducts WHERE approved=1");

if($result && $result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        // IMAGE FIX
        $image = (!empty($row['image'])) 
        ? "../images/".$row['image'] 
        : "https://via.placeholder.com/300x260?text=Hype+Wear";
?>

<div class="card">

    <img src="<?php echo $image; ?>" alt="Product">

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

<?php
    }

} else {
    echo "<h3>No products available right now.</h3>";
}
?>

</div>
</div>

<footer>
© 2026 Hype Wear SA
</footer>

</body>
</html>