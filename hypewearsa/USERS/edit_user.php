<?php
include 'DBConn.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $verified = $_POST['verified'];

    $stmt = $conn->prepare("
        UPDATE tblUser SET name=?, email=?, verified=? WHERE user_id=?
    ");

    $stmt->bind_param("ssii", $name, $email, $verified, $id);
    $stmt->execute();

    header("Location: view_users.php");
}

$result = $conn->query("SELECT * FROM tblUser WHERE user_id=$id");
$user = $result->fetch_assoc();
?>

<form method="POST">
    <input type="text" name="name" value="<?= $user['name'] ?>" required>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>
    <input type="number" name="verified" value="<?= $user['verified'] ?>" required>
    <button>Update</button>
</form>