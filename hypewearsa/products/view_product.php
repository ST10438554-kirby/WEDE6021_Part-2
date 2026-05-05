<?php
session_start();
include __DIR__ . '/../DBConn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hype Wear SA</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f4f4;
}

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    background:#111;
    color:white;
}

.nav-links a{
    color:white;
    text-decoration:none;
    margin:0 10px;
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
}

.card img{
    width:100%;
    height:260px;
    object-fit:cover;
}

.card-body{
    padding:15px;
}

.price{
    font-weight:bold;
    margin:10px 0;
}

.btn-group{
    display:flex;
    gap:10px;
}

.btn{
    flex:1;
    padding:10px;
    border:none;
    cursor:pointer;
    font-weight:bold;
    border-radius:8px;
}

.cart{background:#ff9800;color:white;}
.buy{background:#111;color:white;}
</style>

</head>

<body>

<div class="navbar">
    <div><b>Hype Wear SA</b></div>

    <div class="nav-links">
        <a href="/hypewearsa/index.php">Home</a>
        <a href="/hypewearsa/products/view_product.php">Shop</a>
        <a href="/hypewearsa/cart/cart.php">Cart</a>
        <a href="/hypewearsa/users/login.php">Login</a>
    </div>
</div>

<div class="container">

<div class="products">

<?php
$result = $conn->query("SELECT * FROM tblproducts WHERE approved=1");

while($row = $result->fetch_assoc()){

    $image = !empty($row['image'])
        ? "/hypewearsa/images/" . $row['image']
        : "https://via.placeholder.com/300x260";
?>

<div class="card">

    <img src="<?php echo $image; ?>" alt="Product">

    <div class="card-body">

        <h3><?php echo $row['name']; ?></h3>
        <p><?php echo $row['description']; ?></p>

        <div class="price">R<?php echo $row['price']; ?></div>

        <div class="btn-group">

            <form action="/hypewearsa/cart/add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                <button class="btn cart" type="submit">Add to Cart</button>
            </form>

            <form action="/hypewearsa/cart/buy.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                <button class="btn buy" type="submit">Buy Now</button>
            </form>

        </div>

    </div>
</div>

<?php } ?>

</div>
</div>

</body>
</html>