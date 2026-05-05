<?php
include 'DBConn.php';

$id = $_GET['id'];

$conn->query("DELETE FROM tblUser WHERE user_id=$id");

header("Location: view_users.php");
?>