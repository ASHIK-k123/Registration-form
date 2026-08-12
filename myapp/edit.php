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
GET USER ID
========================================
*/

$id = intval($_GET["id"] ?? 0);


if ($id <= 0) {

    die("Invalid user ID.");

}


/*
========================================
GET USER
========================================
*/

$stmt = $conn->prepare(
    "SELECT name, email, phone
     FROM users
     WHERE id = ?"
);

$stmt->bind_param(
    "i",
    $id
);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows === 0) {

    die("User not found.");

}


$user = $result->fetch_assoc();

$stmt->close();

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit User</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

    <style>

        .edit-page {

            position: relative;

            z-index: 2;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 30px;

        }


        .edit-card {

            width: min(520px, 100%);

            padding: 45px;

            background:
                rgba(255,255,255,.05);

            border:
                1px solid
                var(--border);

            backdrop-filter: blur(25px);

            box-shadow:
                0 40px 100px
                rgba(0,0,0,.5);

        }


        .edit-card h1 {

            font-size: 45px;

            letter-spacing: -3px;

            margin-bottom: 35px;

        }


        .edit-card h1 span {

            color: var(--accent);

        }


        .edit-field {

            margin-bottom: 25px;

        }


        .edit-field label {

            display: block;

            color: var(--muted);

            font-size: 9px;

            letter-spacing: 2px;

            margin-bottom: 8px;

        }


        .edit-field input {

            width: 100%;

            padding: 15px;

            border: none;

            border-bottom:
                1px solid
                rgba(255,255,255,.2);

            outline: none;

            background:
                rgba(255,255,255,.03);

            color: white;

        }


        .update-button {

            width: 100%;

            padding: 18px;

            border: none;

            background: var(--accent);

            color: #111;

            font-weight: bold;

            cursor: pointer;

            letter-spacing: 2px;

        }


        .back-link {

            display: block;

            margin-top: 20px;

            color: var(--muted);

            text-align: center;

            text-decoration: none;

            font-size: 10px;

            letter-spacing: 1px;

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


    <main class="edit-page">


        <div class="edit-card">


            <div class="eyebrow">

                <span class="status-dot"></span>

                DATABASE / EDIT USER

            </div>


            <h1>

                Edit

                <span>user.</span>

            </h1>


            <form
                action="update.php"
                method="POST"
            >


                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $id; ?>"
                >


                <div class="edit-field">

                    <label>
                        FULL NAME
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="<?php echo htmlspecialchars($user['name']); ?>"
                        required
                    >

                </div>


                <div class="edit-field">

                    <label>
                        EMAIL
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="<?php echo htmlspecialchars($user['email']); ?>"
                        required
                    >

                </div>


                <div class="edit-field">

                    <label>
                        PHONE
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        value="<?php echo htmlspecialchars($user['phone']); ?>"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="update-button"
                >

                    UPDATE USER →

                </button>


            </form>


            <a
                href="users.php"
                class="back-link"
            >

                ← BACK TO USERS

            </a>


        </div>


    </main>


</body>

</html>


<?php

$conn->close();

?>