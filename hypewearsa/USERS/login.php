<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/* ✅ SAFE DB CONNECTION */
include __DIR__ . '/../DBConn.php';

$message = "";

/* 🔴 CHECK CONNECTION */
if (!isset($conn)) {
    die("Database connection failed. Check DBConn.php path.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    /* 🔴 PREPARE QUERY */
    $stmt = $conn->prepare("SELECT * FROM tblUser WHERE email=?");

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {

        $user = $result->fetch_assoc();

        /* ❌ NOT VERIFIED */
        if ($user['verified'] == 0) {
            $message = "Account pending admin approval.";
        }

        /* ✅ PASSWORD CHECK */
        elseif (password_verify($password, $user['password'])) {

            // SESSION
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            /* 🔥 SMART REDIRECT (IMPORTANT FIX FOR YOUR CART SYSTEM) */
            if (isset($_SESSION['pending_cart'])) {

                $product_id = $_SESSION['pending_cart'];
                unset($_SESSION['pending_cart']);

                header("Location: /hypewearsa/cart/add_to_cart.php?product_id=" . $product_id);
                exit();

            } else {

                header("Location: /hypewearsa/products/view_product.php");
                exit();
            }

        } else {
            $message = "Incorrect password.";
        }

    } else {
        $message = "User not found. Please register.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login | Hype Wear SA</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(-45deg,#0f0f0f,#1a1a1a,#000,#2a2a2a);
    background-size:400% 400%;
    animation:gradientBG 10s ease infinite;
}

@keyframes gradientBG{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.box{
    width:350px;
    padding:35px;
    border-radius:15px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,0.2);
    color:white;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
}

.logo{
    font-size:24px;
    font-weight:700;
    margin-bottom:5px;
    color:#ff9800;
}

.subtitle{
    font-size:13px;
    margin-bottom:20px;
    color:#ccc;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:none;
    border-radius:8px;
    outline:none;
}

button{
    width:100%;
    padding:12px;
    background:#ff9800;
    border:none;
    color:white;
    font-weight:bold;
    border-radius:8px;
    cursor:pointer;
}

button:hover{
    background:#e68900;
    transform:scale(1.02);
}

.error{
    color:#ff4d4d;
    font-size:14px;
    margin-top:10px;
}
</style>

</head>

<body>

<div class="box">

    <div class="logo">Hype Wear SA</div>
    <div class="subtitle">Welcome back 👕 Streetwear Login</div>

    <form method="POST">

        <input type="email" name="email" placeholder="Email address" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

    </form>

    <p class="error"><?php echo $message; ?></p>

</div>

</body>
</html>