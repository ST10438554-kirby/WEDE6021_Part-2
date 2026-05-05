<?php
include 'DBConn.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Approve Users | Hype Wear SA</title>

<style>

/* ===== PAGE ===== */
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
}

/* ===== HEADER ===== */
header{
    background:#111;
    color:white;
    padding:20px;
    text-align:center;
    font-size:24px;
}

/* ===== CONTAINER ===== */
.container{
    width:90%;
    margin:auto;
    padding:30px 0;
}

/* ===== TABLE ===== */
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

/* ===== BUTTON ===== */
.approve-btn{
    background:#28a745;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
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

<header>
    Pending User Approvals
</header>

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

if($result->num_rows > 0){

    while ($row = $result->fetch_assoc()) {
?>

<tr>
    <td><?php echo $row['user_id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td>
        <a class="approve-btn" href="approve.php?id=<?php echo $row['user_id']; ?>">
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