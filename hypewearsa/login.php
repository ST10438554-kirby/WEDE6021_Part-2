<?php
session_start();
include 'DBConn.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password']; // ❌ NO md5

    $stmt = $conn->prepare("SELECT * FROM tblUser WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        // 🚫 NOT VERIFIED
        if ($user['verified'] == 0) {
            $message = "Account pending admin approval.";
        }

        // ✅ SECURE PASSWORD CHECK
        elseif (password_verify($password, $user['password'])) {

            // ✅ SESSION
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // 🔁 REDIRECT
            header("Location: products/view_product.php");
            exit();
        }

        else {
            $message = "Incorrect password.";
        }

    } else {
        $message = "User not found. Please register.";
    }
}
?>