<?php
include 'DBConn.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin | View Users</title>

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
    width:90%;
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
    padding:15px;
    text-align:left;
    border-bottom:1px solid #eee;
}

th{
    background:#111;
    color:white;
}

.actions a{
    margin-right:10px;
    text-decoration:none;
    padding:6px 10px;
    border-radius:6px;
    font-size:14px;
}

.edit{
    background:#2196f3;
    color:white;
}

.delete{
    background:#e74c3c;
    color:white;
}

.status{
    font-weight:bold;
}

.verified{
    color:green;
}

.pending{
    color:orange;
}

</style>

</head>

<body>

<header>
    User Management
</header>

<div class="container">

<table>

<tr>
    <th>User ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM tblUser");

if($result && $result->num_rows > 0){

    while ($row = $result->fetch_assoc()) {

        $statusText = ($row['verified'] == 1) 
            ? "<span class='status verified'>Verified</span>" 
            : "<span class='status pending'>Pending</span>";
?>

<tr>
    <td><?php echo $row['user_id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $statusText; ?></td>

    <td class="actions">
        <a class="edit" href="edit_user.php?id=<?php echo $row['user_id']; ?>">Edit</a>
        <a class="delete" href="delete_user.php?id=<?php echo $row['user_id']; ?>">Delete</a>
    </td>
</tr>

<?php
    }

} else {
    echo "<tr><td colspan='5'>No users found</td></tr>";
}
?>

</table>

</div>

</body>
</html>