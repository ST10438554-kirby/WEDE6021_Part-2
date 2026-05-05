<?php
session_start();
include 'DBConn.php';

// 🔒 OPTIONAL: protect admin action (recommended)
if(!isset($_SESSION['user_id'])){
    die("Access denied.");
}

if(isset($_GET['id']) && !empty($_GET['id'])){

    $id = intval($_GET['id']); // extra safety

    // 🔒 SAFE UPDATE
    $stmt = $conn->prepare("UPDATE tblUser SET verified = 1 WHERE user_id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){

        // ✅ redirect with success message
        header("Location: view_users.php?status=approved");
        exit();

    } else {
        echo "<h3 style='color:red;'>Error approving user.</h3>";
    }

} else {
    echo "<h3>Invalid user ID.</h3>";
}
?>