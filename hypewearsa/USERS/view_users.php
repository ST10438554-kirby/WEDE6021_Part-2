<?php
include 'DBConn.php';

$result = $conn->query("SELECT * FROM tblUser");

echo "<h2>Users</h2>";

while ($row = $result->fetch_assoc()) {
    echo "
    <p>
        {$row['name']} | {$row['email']} | Verified: {$row['verified']}

        <a href='edit_user.php?id={$row['user_id']}'>Edit</a> |
        <a href='delete_user.php?id={$row['user_id']}'>Delete</a>
    </p>
    <hr>
    ";
}
?>