<?php
include 'DBConn.php';

/* =========================
   DROP TABLES
========================= */
$conn->query("DROP TABLE IF EXISTS tblOrders");
$conn->query("DROP TABLE IF EXISTS tblProducts");
$conn->query("DROP TABLE IF EXISTS tblUser");
$conn->query("DROP TABLE IF EXISTS tblAdmin");

/* =========================
   CREATE TABLES
========================= */

$conn->query("
CREATE TABLE tblUser (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('buyer','seller'),
    verified BOOLEAN
)
");

$conn->query("
CREATE TABLE tblAdmin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    password VARCHAR(255)
)
");

$conn->query("
CREATE TABLE tblProducts (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    seller_id INT,
    approved BOOLEAN,
    FOREIGN KEY (seller_id) REFERENCES tblUser(user_id)
)
");

$conn->query("
CREATE TABLE tblOrders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
");

/* =========================
   LOAD USERS
========================= */
$file = fopen("userData.txt", "r");

while (($line = fgets($file)) !== false) {
    $data = explode(",", trim($line));

    $stmt = $conn->prepare("
        INSERT INTO tblUser (name, email, password, role, verified)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssssi", $data[0], $data[1], $data[2], $data[3], $data[4]);
    $stmt->execute();
}
fclose($file);

/* =========================
   LOAD ADMINS
========================= */
$file = fopen("adminData.txt", "r");

while (($line = fgets($file)) !== false) {
    $data = explode(",", trim($line));

    $stmt = $conn->prepare("
        INSERT INTO tblAdmin (username, password)
        VALUES (?, ?)
    ");

    $stmt->bind_param("ss", $data[0], $data[1]);
    $stmt->execute();
}
fclose($file);

/* =========================
   LOAD PRODUCTS
========================= */
$file = fopen("productData.txt", "r");

while (($line = fgets($file)) !== false) {
    $data = explode(",", trim($line));

    $stmt = $conn->prepare("
        INSERT INTO tblProducts (name, description, price, seller_id, approved)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssdii", $data[0], $data[1], $data[2], $data[3], $data[4]);
    $stmt->execute();
}
fclose($file);

/* =========================
   LOAD ORDERS
========================= */
$file = fopen("orderData.txt", "r");

while (($line = fgets($file)) !== false) {
    $data = explode(",", trim($line));

    $stmt = $conn->prepare("
        INSERT INTO tblOrders (user_id, product_id, quantity)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("iii", $data[0], $data[1], $data[2]);
    $stmt->execute();
}
fclose($file);

echo "<h2>Pastimes database loaded from files successfully!</h2>";
?>