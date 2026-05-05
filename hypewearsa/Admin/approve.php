<?php
session_start();
include __DIR__ . '/../DBConn.php';

// 🔒 Check connection
if (!isset($conn)) {
    die("Database connection failed.");
}

// 🔒 Check ID
if (!isset($_GET['id'])) {
    die("Invalid user ID (missing ID).");
}

$user_id = (int)$_GET['id'];

if ($user_id <= 0) {
    die("Invalid user ID (invalid number).");
}

// 🔍 Check user exists
$stmt = $conn->prepare("SELECT user_id FROM tblUser WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found.");
}

// ✅ Approve user
$update = $conn->prepare("UPDATE tblUser SET verified = 1 WHERE user_id = ?");
$update->bind_param("i", $user_id);

if ($update->execute()) {
    header("Location: /hypewearsa/Admin/adminLogin.php?success=1");
    exit();
} else {
    die("Failed to approve user.");
}
?>