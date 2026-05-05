<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'DBConn.php';

if (!isset($conn)) {
    die("Database connection failed. Check DBConn.php");
}

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // 🚨 VALIDATION
    if ($name == "" || $email == "" || $password == "" || $confirm == "") {
        $message = "All fields are required.";
        $type = "error";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        $type = "error";
    }
    elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
        $type = "error";
    }
    elseif ($password !== $confirm) {
        $message = "Passwords do not match.";
        $type = "error";
    }
    else {

        // 🔍 CHECK EMAIL EXISTS
        $check = $conn->prepare("SELECT user_id FROM tblUser WHERE email=?");

        if (!$check) {
            die("SQL Error: " . $conn->error);
        }

        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already registered.";
            $type = "error";
        }
        else {

            // 🔒 HASH PASSWORD (MATCHES YOUR LOGIN)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                INSERT INTO tblUser (name, email, password, verified)
                VALUES (?, ?, ?, 0)
            ");

            if (!$stmt) {
                die("SQL Error: " . $conn->error);
            }

            $stmt->bind_param("sss", $name, $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "Registered successfully! Await admin approval.";
                $type = "success";
            }
            else {
                $message = "Registration failed. Try again.";
                $type = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register | Hype Wear SA</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

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
    background:linear-gradient(-45deg,#111,#333,#000,#444);
    background-size:400% 400%;
    animation:bg 10s ease infinite;
}

@keyframes bg{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.box{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(12px);
    padding:40px;
    border-radius:15px;
    width:350px;
    color:white;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
}

h2{ margin-bottom:20px; }

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
    background:white;
    color:black;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{ background:#ddd; }

.msg{ margin-top:10px; font-size:14px; }

.success{ color:#4CAF50; }
.error{ color:#ff4d4d; }

.link{ margin-top:10px; font-size:14px; }

.link a{
    color:white;
    font-weight:bold;
    text-decoration:none;
}
</style>

</head>

<body>

<div class="box">

<h2>Create Account</h2>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password (min 6 chars)" required>

<input type="password" name="confirm_password" placeholder="Confirm Password" required>

<button type="submit">Register</button>

</form>

<p class="msg <?php echo $type; ?>">
    <?php echo $message; ?>
</p>

<div class="link">
    Already have an account?
    <a href="login.php">Login</a>
</div>

</div>

</body>
</html>