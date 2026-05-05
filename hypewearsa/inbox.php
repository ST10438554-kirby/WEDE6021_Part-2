<?php
session_start();
include 'DBConn.php';

// 🔒 REQUIRE LOGIN
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Inbox | Hype Wear SA</title>

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
    font-size:22px;
}

.container{
    width:80%;
    margin:auto;
    padding:30px 0;
}

.message{
    background:white;
    padding:15px;
    border-radius:10px;
    margin-bottom:15px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.from{
    font-weight:bold;
    color:#333;
}

.text{
    margin:10px 0;
    color:#555;
}

.date{
    font-size:12px;
    color:gray;
}

.empty{
    text-align:center;
    color:gray;
    margin-top:30px;
}
</style>

</head>

<body>

<header>Inbox</header>

<div class="container">

<?php

$stmt = $conn->prepare("
    SELECT m.message, m.sent_at, u.name AS sender_name
    FROM tblMessages m
    JOIN tblUser u ON m.sender_id = u.user_id
    WHERE m.receiver_id = ?
    ORDER BY m.sent_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0){

    while ($row = $result->fetch_assoc()){
?>

<div class="message">
    <div class="from">From: <?php echo $row['sender_name']; ?></div>
    <div class="text"><?php echo $row['message']; ?></div>
    <div class="date"><?php echo $row['sent_at']; ?></div>
</div>

<?php
    }

} else {
    echo "<div class='empty'>No messages yet.</div>";
}
?>

</div>

</body>
</html>