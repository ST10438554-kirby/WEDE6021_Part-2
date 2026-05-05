<?php
session_start();
include __DIR__ . '/../DBConn.php';

if (!isset($conn)) {
    die("Database connection failed.");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Approve Users | Hype Wear SA</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#111;
    padding:15px 30px;
    color:white;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin:0 12px;
    font-weight:bold;
}

.navbar a:hover{
    color:#ff9800;
}

/* HEADER */
header{
    background:#222;
    color:white;
    padding:20px;
    text-align:center;
    font-size:24px;
}

.container{
    width:90%;
    margin:auto;
    padding:30px 0;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    border-radius:10px;
    overflow:hidden;
}

th, td{
    padding:15px;
    text-align:left;
    border-bottom:1px solid #eee;
}

th{
    background:#111;
    color:white;
}

.approve-btn{
    background:#28a745;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
    font-weight:bold;
    display:inline-block;
}

.approve-btn:hover{
    background:#1e7e34;
}

.no-users{
    text-align:center;
    padding:20px;
    color:#777;
}
</style>

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div><b>Hype Wear SA Admin</b></div>

    <div>
        <a href="/hypewearsa/index.php">Home</a>
        <a href="/hypewearsa/Admin/admin_dashboard.php">Dashboard</a>
        <a href="/hypewearsa/Admin/adminLogin.php">Pending Users</a>
        <a href="/hypewearsa/Admin/admin_products.php">Products</a>
        <a href="/hypewearsa/users/view_users.php">Users</a>
    </div>
</div>

<header>Pending User Approvals</header>

<div class="container">

<table>

<tr>
    <th>User ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM tblUser WHERE verified=0");

if($result && $result->num_rows > 0){

    while ($row = $result->fetch_assoc()) {

        // 🔥 SAFETY FIX (prevents empty or broken IDs)
        $user_id = (int)$row['user_id'];
        $name = htmlspecialchars($row['name']);
        $email = htmlspecialchars($row['email']);
?>

<tr>
    <td><?php echo $user_id; ?></td>
    <td><?php echo $name; ?></td>
    <td><?php echo $email; ?></td>

    <td>
        <a class="approve-btn"
           href="/hypewearsa/Admin/approve.php?id=<?php echo $user_id; ?>">
            Approve
        </a>
    </td>
</tr>

<?php
    }

} else {
    echo "<tr><td colspan='4' class='no-users'>No pending users</td></tr>";
}
?>

</table>

</div>

</body>
</html>