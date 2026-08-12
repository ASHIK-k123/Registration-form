<?php

session_start();

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
GET USER ID
========================================
*/

$id = $_GET["id"] ?? $_POST["id"] ?? "";

if (!is_numeric($id) || (int)$id <= 0) {
    die("
        <h2>Invalid user ID.</h2>
        <a href='users.php'>Go back</a>
    ");
}

$id = (int)$id;


/*
========================================
GET USER DETAILS
========================================
*/

$stmt = $conn->prepare(
    "SELECT id, name, email FROM users WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    $stmt->close();
    $conn->close();

    die("
        <h2>User not found.</h2>
        <a href='users.php'>Go back</a>
    ");
}

$user = $result->fetch_assoc();

$stmt->close();


/*
========================================
STEP 2 - DELETE VERIFICATION
========================================
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $verification = trim($_POST["verification"] ?? "");

    /*
    ========================================
    VERIFY DELETE CODE
    ========================================
    */

    if ($verification !== "DELETE") {

        $error = "Incorrect verification code.";

    } else {

        /*
        ========================================
        DELETE USER
        ========================================
        */

        $delete = $conn->prepare(
            "DELETE FROM users WHERE id = ?"
        );

        $delete->bind_param("i", $id);

        if ($delete->execute()) {

            $delete->close();
            $conn->close();

            header("Location: users.php");
            exit;

        } else {

            $error = "Failed to delete user.";

        }

        $delete->close();
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Delete User</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

    <style>

        .delete-page {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 20px;

        }

        .delete-card {

            width: 100%;

            max-width: 480px;

            padding: 40px;

            text-align: center;

            background: rgba(20, 20, 20, 0.9);

            border: 1px solid
                rgba(255, 80, 80, 0.35);

            box-shadow:
                0 20px 60px
                rgba(0, 0, 0, 0.5);

        }

        .warning-icon {

            width: 70px;

            height: 70px;

            margin: 0 auto 25px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            font-size: 30px;

            color: #ff6868;

            border: 1px solid
                rgba(255, 80, 80, 0.5);

        }

        .delete-card h1 {

            margin-bottom: 10px;

        }

        .delete-card h1 span {

            color: #ff6868;

        }

        .delete-card p {

            color: #aaa;

            line-height: 1.6;

        }

        .user-info {

            margin: 25px 0;

            padding: 18px;

            text-align: left;

            border: 1px solid
                rgba(255, 255, 255, 0.1);

        }

        .user-info strong {

            color: white;

        }

        .verification-label {

            display: block;

            margin-bottom: 10px;

            font-size: 12px;

            letter-spacing: 2px;

            color: #aaa;

        }

        .verification-input {

            width: 100%;

            box-sizing: border-box;

            padding: 14px;

            background: #111;

            color: white;

            border: 1px solid
                rgba(255, 255, 255, 0.2);

            outline: none;

            text-align: center;

            letter-spacing: 4px;

            font-weight: bold;

        }

        .verification-input:focus {

            border-color: #ff6868;

        }

        .delete-confirm {

            width: 100%;

            margin-top: 15px;

            padding: 14px;

            border: none;

            background: #ff5f5f;

            color: #111;

            font-weight: bold;

            letter-spacing: 2px;

            cursor: pointer;

        }

        .delete-confirm:hover {

            background: #ff3838;

        }

        .cancel-button {

            display: block;

            margin-top: 15px;

            padding: 14px;

            text-decoration: none;

            color: #aaa;

            border: 1px solid
                rgba(255, 255, 255, 0.15);

        }

        .error-message {

            margin-bottom: 15px;

            padding: 12px;

            color: #ff6868;

            border: 1px solid
                rgba(255, 80, 80, 0.3);

        }

    </style>

</head>

<body>

    <div class="space">

        <div class="orb orb-one"></div>
        <div class="orb orb-two"></div>
        <div class="orb orb-three"></div>
        <div class="grid"></div>

    </div>


    <main class="delete-page">

        <div class="delete-card">

            <div class="warning-icon">
                !
            </div>


            <h1>
                Delete <span>user.</span>
            </h1>


            <p>
                This action is permanent and cannot be undone.
            </p>


            <div class="user-info">

                <p>
                    <strong>Name:</strong>
                    <?php
                    echo htmlspecialchars($user["name"]);
                    ?>
                </p>

                <p>
                    <strong>Email:</strong>
                    <?php
                    echo htmlspecialchars($user["email"]);
                    ?>
                </p>

            </div>


            <?php if (isset($error)) { ?>

                <div class="error-message">

                    <?php
                    echo htmlspecialchars($error);
                    ?>

                </div>

            <?php } ?>


            <form method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $id; ?>"
                >


                <label class="verification-label">

                    TYPE DELETE TO CONFIRM

                </label>


                <input
                    type="text"
                    name="verification"
                    class="verification-input"
                    placeholder="DELETE"
                    autocomplete="off"
                    required
                >


                <button
                    type="submit"
                    class="delete-confirm"
                >

                    CONFIRM DELETE

                </button>

            </form>


            <a
                href="users.php"
                class="cancel-button"
            >

                CANCEL

            </a>

        </div>

    </main>

</body>

</html>

<?php

$conn->close();

?>