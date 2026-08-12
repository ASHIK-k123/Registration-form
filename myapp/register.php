<?php

$host = "localhost";
$username = "root";
$password = "ak@12345";
$database = "registration_db";


/*
========================================
DATABASE CONNECTION
========================================
*/

$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);


if ($conn->connect_error) {

    die("Database connection failed: " . $conn->connect_error);

}


/*
========================================
GET FORM DATA
========================================
*/

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$userPassword = $_POST["password"] ?? "";
$phone = trim($_POST["phone"] ?? "");


/*
========================================
VALIDATION
========================================
*/

if (
    empty($name) ||
    empty($email) ||
    empty($userPassword) ||
    empty($phone)
) {

    die("Please fill in all fields.");

}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    die("Please enter a valid email address.");

}


/*
========================================
CHECK EXISTING EMAIL
========================================
*/

$check = $conn->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$check->bind_param("s", $email);

$check->execute();

$check->store_result();


if ($check->num_rows > 0) {

    $check->close();
    $conn->close();

    die("
        <h2>Email already registered.</h2>
        <a href='index.php'>Go back</a>
    ");

}

$check->close();


/*
========================================
HASH PASSWORD
========================================
*/

$hashedPassword =
    password_hash(
        $userPassword,
        PASSWORD_DEFAULT
    );


/*
========================================
INSERT USER
========================================
*/

$sql = "
    INSERT INTO users
    (name, email, password, phone)
    VALUES (?, ?, ?, ?)
";


$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssss",
    $name,
    $email,
    $hashedPassword,
    $phone
);


/*
========================================
RESULT
========================================
*/

if ($stmt->execute()) {

    ?>

    <!DOCTYPE html>

    <html>

    <head>

        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <title>Registration Complete</title>

        <link
            rel="stylesheet"
            href="style.css"
        >

    </head>

    <body>

        <div class="success-page">

            <div class="success-card">

                <div class="success-icon">
                    ✓
                </div>

                <span class="small-label">
                    SYSTEM MESSAGE
                </span>

                <h1>
                    Account created<span>.</span>
                </h1>

                <p>
                    Your registration has been successfully
                    stored in the system.
                </p>

                <div class="success-buttons">

                    <a href="index.php">
                        REGISTER ANOTHER
                    </a>

                    <a href="users.php">
                        VIEW USERS →
                    </a>

                </div>

            </div>

        </div>

    </body>

    </html>

    <?php

} else {

    echo "Error: " . $stmt->error;

}


$stmt->close();
$conn->close();

?>