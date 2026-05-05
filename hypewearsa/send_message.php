<?php
session_start();
include 'DBConn.php';

// 🔒 REQUIRE LOGIN
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$sender_id = $_SESSION['user_id'];
$messageText = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $receiver_id = $_POST['receiver_id'];
    $message = trim($_POST['message']);

    if (!empty($receiver_id) && !empty($message)) {

        $stmt = $conn->prepare("
            INSERT INTO tblMessages (sender_id, receiver_id, message)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param("iis", $sender_id, $receiver_id, $message);

        if($stmt->execute()){
            $messageText = "Message sent successfully!";
            $type = "success";
        } else {
            $messageText = "Error sending message.";
            $type = "error";
        }

    } else {
        $messageText = "All fields are required.";
        $type = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Send Message | Hype Wear SA</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:white;
    padding:30px;
    width:350px;
    border-radius:10px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

select, textarea{
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:6px;
    border:1px solid #ccc;
}

button{
    width:100%;
    padding:12px;
    background:#111;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

button:hover{
    background:#333;
}

.msg{
    text-align:center;
    margin-top:10px;
}

.success{
    color:green;
}

.error{
    color:red;
}
</style>

</head>

<body>

<div class="box">

<h2>Send Message</h2>

<form method="POST">

<select name="receiver_id" required>
<option value="">Select Receiver</option>

<?php
// LOAD USERS (EXCEPT YOURSELF)
$result = $conn->query("SELECT user_id, name FROM tblUser WHERE user_id != $sender_id AND verified=1");

while($row = $result->fetch_assoc()){
    echo "<option value='{$row['user_id']}'>{$row['name']}</option>";
}
?>

</select>

<textarea name="message" placeholder="Type your message..." required></textarea>

<button type="submit">Send Message</button>

</form>

<p class="msg <?php echo $type; ?>">
    <?php echo $messageText; ?>
</p>

</div>

</body>
</html>