<?php
session_start();

/* ✅ FIX: safe DB path (prevents "not found" errors) */
include __DIR__ . '/DBConn.php';

/* 🔒 REQUIRE LOGIN */
if (!isset($_SESSION['user_id'])) {
    header("Location: /hypewearsa/users/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* 🚨 SAFETY CHECK */
if (!isset($conn)) {
    die("Database connection failed.");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders | Hype Wear SA</title>

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
    font-size:24px;
}

.container{
    width:85%;
    margin:auto;
    padding:30px 0;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    border-radius:10px;
    overflow:hidden;
}

th, td{
    padding:14px;
    border-bottom:1px solid #eee;
    text-align:left;
}

th{
    background:#111;
    color:white;
}

tr:hover{
    background:#f1f1f1;
}

.empty{
    text-align:center;
    padding:30px;
    color:gray;
}

.btn{
    padding:10px 15px;
    background:#ff9800;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
    text-decoration:none;
    display:inline-block;
    margin-top:15px;
}
</style>

</head>

<body>

<header>My Order History</header>

<div class="container">

<table>

<tr>
    <th>Order ID</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Date</th>
</tr>

<?php

$sql = "
SELECT o.order_id, o.quantity, o.order_date, p.name 
FROM tblorders o
JOIN tblproducts p ON o.product_id = p.product_id
WHERE o.user_id = ?
ORDER BY o.order_id DESC
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "
        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['order_date']}</td>
        </tr>
        ";
    }

} else {
    echo "<tr><td colspan='4' class='empty'>No orders yet</td></tr>";
}

?>

</table>

<br>

<a href="/hypewearsa/index.php" class="btn">Continue Shopping</a>

</div>

</body>
</html>