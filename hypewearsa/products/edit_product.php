<?php
include '../DBConn.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM tblproducts WHERE product_id=$id");
$product = $result->fetch_assoc();

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $conn->query("UPDATE tblproducts 
        SET name='$name', price='$price', description='$description' 
        WHERE product_id=$id");

    header("Location: admin_products.php");
    exit();
}
?>

<h2>Edit Product</h2>

<form method="POST">

<input type="text" name="name" value="<?php echo $product['name']; ?>"><br><br>

<input type="text" name="price" value="<?php echo $product['price']; ?>"><br><br>

<textarea name="description"><?php echo $product['description']; ?></textarea><br><br>

<button name="update">Update</button>

</form>