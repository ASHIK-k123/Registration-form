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
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT id, name, email, phone
    FROM users
    ORDER BY id DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Users</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

    <style>

        .user-row {
            grid-template-columns:
                70px
                1.2fr
                1.5fr
                1fr
                150px;
        }

        .user-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .edit-button,
        .delete-button {

            display: inline-block;

            padding: 9px 13px;

            text-decoration: none;

            font-size: 8px;

            letter-spacing: 1.5px;

            transition: all 0.3s ease;

        }

        .edit-button {

            color: var(--accent);

            border:
                1px solid
                rgba(215, 255, 79, 0.3);

        }

        .edit-button:hover {

            background: var(--accent);

            color: #111;

            transform: translateY(-2px);

        }

        .delete-button {

            color: #ff6868;

            border:
                1px solid
                rgba(255, 80, 80, 0.3);

        }

        .delete-button:hover {

            background: #ff5f5f;

            color: #111;

            border-color: #ff5f5f;

            transform: translateY(-2px);

        }

        .action-header {
            text-align: right;
        }

        @media (max-width: 650px) {

            .user-row {

                display: flex;

                flex-direction: column;

                align-items: flex-start;

            }

            .user-actions {

                width: 100%;

                justify-content: flex-start;

            }

        }

    </style>

</head>


<body>


    <!-- SPATIAL BACKGROUND -->

    <div class="space">

        <div class="orb orb-one"></div>

        <div class="orb orb-two"></div>

        <div class="orb orb-three"></div>

        <div class="grid"></div>

    </div>


    <main class="users-page">


        <!-- HEADER -->

        <div class="users-header">

            <div>

                <div class="eyebrow">

                    <span class="status-dot"></span>

                    DATABASE / USERS

                </div>


                <h1>

                    Registered

                    <span>users</span>

                    <span class="dot">.</span>

                </h1>

            </div>


            <a
                href="index.php"
                class="new-user-button"
            >

                + NEW USER

            </a>

        </div>


        <!-- USERS -->

        <div class="users-card">


            <!-- TABLE HEADER -->

            <div class="table-header">

                <span>ID</span>

                <span>USER</span>

                <span>EMAIL</span>

                <span>PHONE</span>

                <span class="action-header">
                    ACTION
                </span>

            </div>


            <?php

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    ?>

                    <div class="user-row">


                        <!-- ID -->

                        <span class="user-id">

                            #

                            <?php

                            echo htmlspecialchars(
                                $row["id"]
                            );

                            ?>

                        </span>


                        <!-- NAME -->

                        <span class="user-name">

                            <?php

                            echo htmlspecialchars(
                                $row["name"]
                            );

                            ?>

                        </span>


                        <!-- EMAIL -->

                        <span>

                            <?php

                            echo htmlspecialchars(
                                $row["email"]
                            );

                            ?>

                        </span>


                        <!-- PHONE -->

                        <span>

                            <?php

                            echo htmlspecialchars(
                                $row["phone"]
                            );

                            ?>

                        </span>


                        <!-- ACTIONS -->

                        <span class="user-actions">


                            <!-- EDIT -->

                            <a
                                href="edit.php?id=<?php echo $row['id']; ?>"
                                class="edit-button"
                            >

                                EDIT

                            </a>


                            <!-- DELETE -->

                            <a
                                href="delete.php?id=<?php echo $row['id']; ?>"
                                class="delete-button"
                                onclick="return confirmDelete('<?php echo htmlspecialchars($row['name']); ?>')"
                            >

                                DELETE

                            </a>


                        </span>


                    </div>

                    <?php

                }

            } else {

                ?>


                <!-- EMPTY -->

                <div class="empty-state">

                    <div class="empty-icon">
                        ∅
                    </div>


                    <h2>

                        No users yet<span>.</span>

                    </h2>


                    <p>

                        Create your first account.

                    </p>


                    <a href="index.php">

                        CREATE USER →

                    </a>

                </div>


                <?php

            }

            ?>


        </div>


        <!-- FOOTER -->

        <div class="users-footer">

            <span>

                TOTAL RECORDS:

                <?php

                echo $result->num_rows;

                ?>

            </span>


            <span>

                REGISTRATION DATABASE

            </span>

        </div>


    </main>


    <script>


        /*
        ========================================
        DELETE CONFIRMATION
        ========================================
        */

        function confirmDelete(name) {

            return confirm(
                "Are you sure you want to delete " +
                name +
                "?"
            );

        }


        /*
        ========================================
        ROW PARALLAX
        ========================================
        */

        const rows =
            document.querySelectorAll(".user-row");


        rows.forEach(row => {

            row.addEventListener(
                "mousemove",
                event => {

                    const rect =
                        row.getBoundingClientRect();


                    const x =
                        event.clientX -
                        rect.left;


                    const percent =
                        (x / rect.width) - 0.5;


                    row.style.transform =
                        `perspective(800px)
                         rotateY(${percent * 2}deg)
                         translateX(${percent * 4}px)`;

                }
            );


            row.addEventListener(
                "mouseleave",
                () => {

                    row.style.transform =
                        "perspective(800px)
                         rotateY(0deg)
                         translateX(0)";

                }
            );

        });


    </script>


</body>

</html>


<?php

$conn->close();

?>