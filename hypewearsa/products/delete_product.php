<?php
include '../DBConn.php';

$id = $_GET['id'];

$conn->query("DELETE FROM tblproducts WHERE product_id=$id");

header("Location: admin_products.php");
exit();
?>