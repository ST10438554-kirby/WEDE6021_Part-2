<?php
include 'DBConn.php';

// Check if ID exists
if(isset($_GET['id']) && !empty($_GET['id'])){

    $id = $_GET['id'];

    // Secure update (prepared statement)
    $stmt = $conn->prepare("UPDATE tblProducts SET approved = 1 WHERE product_id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        // success redirect
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Error approving product.";
    }

} else {
    echo "Invalid product ID.";
}
?>