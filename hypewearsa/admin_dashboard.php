<?php
session_start();
include 'DBConn.php';

// OPTIONAL: protect admin
if(!isset($_SESSION['admin_id'])){
    header("Location: adminLogin.php");
    exit();
}

// ===== STATS QUERIES =====

// Total Products
$products = $conn->query("SELECT COUNT(*) as total FROM tblproducts");
$totalProducts = $products->fetch_assoc()['total'];

// Pending Products
$pending = $conn->query("SELECT COUNT(*) as total FROM tblproducts WHERE approved=0");
$pendingProducts = $pending->fetch_assoc()['total'];

// Total Users
$users = $conn->query("SELECT COUNT(*) as total FROM tbluser");
$totalUsers = $users->fetch_assoc()['total'];

// Total Orders
$orders = $conn->query("SELECT COUNT(*) as total FROM tblorders");
$totalOrders = $orders->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard | Hype Wear SA</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#f4f6f9;
    display:flex;
}

/* ===== SIDEBAR ===== */
.sidebar{
    width:250px;
    height:100vh;
    background:#111;
    color:white;
    padding:20px;
    position:fixed;
}

.sidebar h2{
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    margin:8px 0;
    border-radius:8px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#ff9800;
    color:black;
}

/* ===== MAIN ===== */
.main{
    margin-left:250px;
    width:100%;
    padding:20px;
}

/* ===== HEADER ===== */
.header{
    background:white;
    padding:15px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

/* ===== CARDS ===== */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    text-align:center;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    font-size:16px;
    color:#333;
}

.card p{
    font-size:28px;
    font-weight:bold;
    color:#ff9800;
    margin-top:10px;
}

/* ===== TABLE ===== */
.table-box{
    margin-top:30px;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:12px;
    border-bottom:1px solid #eee;
}

th{
    background:#111;
    color:white;
}

.status-pending{
    color:red;
    font-weight:bold;
}

.status-approved{
    color:green;
    font-weight:bold;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Hype Admin</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="products/admin_products.php">Products</a>
    <a href="products/approve_products.php">Approve Products</a>
    <a href="view_users.php">Users</a>
    <a href="orders.php">Orders</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <div class="header">
        <h2>Admin Dashboard Overview</h2>
        <p>Manage your Hype Wear SA store</p>
    </div>

    <!-- STATS CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Total Products</h3>
            <p><?php echo $totalProducts; ?></p>
        </div>

        <div class="card">
            <h3>Pending Approvals</h3>
            <p><?php echo $pendingProducts; ?></p>
        </div>

        <div class="card">
            <h3>Total Users</h3>
            <p><?php echo $totalUsers; ?></p>
        </div>

        <div class="card">
            <h3>Total Orders</h3>
            <p><?php echo $totalOrders; ?></p>
        </div>

    </div>

    <!-- RECENT ORDERS PREVIEW -->
    <div class="table-box">

        <h3>Latest Orders</h3>

        <table>

            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
            </tr>

            <?php
            $result = $conn->query("SELECT * FROM tblorders ORDER BY order_id DESC LIMIT 5");

            while($row = $result->fetch_assoc()){
            ?>

            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>