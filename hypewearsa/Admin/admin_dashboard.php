<?php
session_start();
include '../DBConn.php';

if (!isset($conn)) {
    die("Database connection failed.");
}

/* =========================
   DASHBOARD STATS
========================= */

// Total users
$users = $conn->query("SELECT COUNT(*) AS total FROM tblUser")->fetch_assoc()['total'];

// Pending users
$pending = $conn->query("SELECT COUNT(*) AS total FROM tblUser WHERE verified=0")->fetch_assoc()['total'];

// Products
$products = $conn->query("SELECT COUNT(*) AS total FROM tblProducts")->fetch_assoc()['total'];

// Orders
$orders = $conn->query("SELECT COUNT(*) AS total FROM tblOrders")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard | Hype Wear SA</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f4f6f9;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#111;
    color:white;
    padding:15px 30px;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin:0 10px;
    font-weight:bold;
}

.navbar a:hover{
    color:#ff9800;
}

/* HEADER */
.header{
    padding:25px;
    text-align:center;
}

/* STATS GRID */
.grid{
    width:90%;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(220px,1fr));
    gap:20px;
}

/* CARDS */
.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    text-align:center;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h2{
    margin:10px 0;
    font-size:32px;
    color:#111;
}

.card p{
    color:#666;
}

/* COLORS */
.blue{border-left:5px solid #2196f3;}
.green{border-left:5px solid #4caf50;}
.orange{border-left:5px solid #ff9800;}
.red{border-left:5px solid #f44336;}

/* ACTIONS */
.actions{
    width:90%;
    margin:30px auto;
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.btn{
    padding:12px 15px;
    background:#111;
    color:white;
    border:none;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
}

.btn:hover{
    background:#ff9800;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div><b>Hype Wear Admin</b></div>

    <div>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_products.php">Products</a>
        <a href="adminLogin.php">Users</a>
        <a href="approve.php">Approvals</a>
        <a href="../index.php">View Site</a>
    </div>
</div>

<!-- HEADER -->
<div class="header">
    <h1>Admin Dashboard</h1>
    <p>Welcome to Hype Wear SA Control Panel</p>
</div>

<!-- STATS -->
<div class="grid">

    <div class="card blue">
        <p>Total Users</p>
        <h2><?= $users ?></h2>
    </div>

    <div class="card orange">
        <p>Pending Approvals</p>
        <h2><?= $pending ?></h2>
    </div>

    <div class="card green">
        <p>Total Products</p>
        <h2><?= $products ?></h2>
    </div>

    <div class="card red">
        <p>Total Orders</p>
        <h2><?= $orders ?></h2>
    </div>

</div>

<!-- QUICK ACTIONS -->
<div class="actions">

    <a class="btn" href="approve.php">Approve Users</a>
    <a class="btn" href="admin_products.php">Manage Products</a>
    <a class="btn" href="add_product.php">Add Product</a>
    <a class="btn" href="../index.php">View Website</a>

</div>

</body>
</html>