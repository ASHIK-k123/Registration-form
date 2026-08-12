<?php

$host = "localhost";
$username = "root";
$password = "ak@12345";
$database = "registration_db";


$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);


if ($conn->connect_error) {

    die("Database connection failed.");

}


/*
========================================
GET FORM DATA
========================================
*/

$id = intval($_POST["id"] ?? 0);

$name = trim($_POST["name"] ?? "");

$email = trim($_POST["email"] ?? "");

$phone = trim($_POST["phone"] ?? "");


if (
    $id <= 0 ||
    empty($name) ||
    empty($email) ||
    empty($phone)
) {

    die("Invalid data.");

}


/*
========================================
UPDATE USER
========================================
*/

$stmt = $conn->prepare(
    "UPDATE users
     SET name = ?, email = ?, phone = ?
     WHERE id = ?"
);


$stmt->bind_param(
    "sssi",
    $name,
    $email,
    $phone,
    $id
);


if ($stmt->execute()) {

    header(
        "Location: users.php"
    );

    exit;

} else {

    echo "Error updating user: " .
         $stmt->error;

}


$stmt->close();

$conn->close();

?>