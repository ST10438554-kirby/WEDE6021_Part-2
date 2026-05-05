<?php
include '../DBConn.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Products | Hype Wear SA</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

/* ===== NAVBAR ===== */
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
    margin:0 10px;
    padding:8px 12px;
    border-radius:6px;
}

.navbar a:hover{
    background:#ff9800;
    color:black;
}

/* HEADER */
header{
    background:#222;
    color:white;
    padding:20px;
    text-align:center;
}

/* CONTAINER */
.container{
    width:90%;
    margin:auto;
    padding:20px;
}

/* SEARCH */
.search-box{
    margin-bottom:20px;
}

input[type="text"]{
    padding:10px;
    width:300px;
    border-radius:8px;
    border:1px solid #ccc;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}

th, td{
    padding:12px;
    border-bottom:1px solid #eee;
}

th{
    background:#111;
    color:white;
}

/* IMAGE */
img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:6px;
}

/* BUTTONS */
.btn{
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    color:white;
    font-size:12px;
}

.edit{background:#2196f3;}
.delete{background:#f44336;}
.approve{background:#28a745;}

.btn:hover{
    opacity:0.8;
}
</style>

</head>

<body>

<!-- ===== NAVBAR ADDED ===== -->
<div class="navbar">
    <div><b>Hype Wear SA Admin</b></div>

    <div>
        <a href="../index.php">Home</a>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_products.php">Products</a>
        <a href="adminLogin.php">Users</a>
        <a href="../users/logout.php">Logout</a>
    </div>
</div>

<header>Admin Product Management</header>

<div class="container">

<!-- SEARCH -->
<div class="search-box">
<form method="GET">
    <input type="text" name="search" placeholder="Search product name...">
</form>
</div>

<table>

<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Price</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php

$search = isset($_GET['search']) ? $_GET['search'] : "";

$sql = "SELECT * FROM tblproducts WHERE name LIKE '%$search%' ORDER BY product_id DESC";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

$image = !empty($row['image']) ? "../images/".$row['image'] : "https://via.placeholder.com/60";

?>

<tr>

    <td><img src="<?php echo $image; ?>"></td>

    <td><?php echo $row['name']; ?></td>

    <td>R<?php echo $row['price']; ?></td>

    <td>
        <?php echo ($row['approved'] == 1) ? "Approved" : "Pending"; ?>
    </td>

    <td>

        <a class="btn edit" href="edit_product.php?id=<?php echo $row['product_id']; ?>">Edit</a>

        <a class="btn delete" href="delete_product.php?id=<?php echo $row['product_id']; ?>">Delete</a>

        <?php if($row['approved'] == 0){ ?>
        <a class="btn approve" href="approve_product.php?id=<?php echo $row['product_id']; ?>">Approve</a>
        <?php } ?>

    </td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>