<?php
include 'DBConn.php';

// DROP TABLE
$conn->query("DROP TABLE IF EXISTS tblUser");

// CREATE TABLE
$conn->query("
CREATE TABLE tblUser (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    role INT,
    verified BOOLEAN DEFAULT 0
) ENGINE=InnoDB
");

// OPEN FILE
$file = fopen("userData.txt", "r");

// SKIP HEADER
fgets($file);

while (($line = fgets($file)) !== false) {

    $data = explode(",", trim($line));

    if (count($data) == 4) {

        $name = $data[0];
        $email = $data[1];
        $password = $data[2];
        $role = $data[3];
        $verified = 0;

        $stmt = $conn->prepare("
            INSERT INTO tblUser (name, email, password, role, verified)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("sssii", $name, $email, $password, $role, $verified);
        $stmt->execute();
    }
}

fclose($file);

echo "Table created and data loaded successfully!";
?>
