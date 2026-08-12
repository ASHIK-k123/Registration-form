<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Spatial background -->
    <div class="space">

        <div class="orb orb-one"></div>
        <div class="orb orb-two"></div>
        <div class="orb orb-three"></div>

        <div class="grid"></div>

        <div class="floating-card card-one">
            <span>01</span>
        </div>

        <div class="floating-card card-two">
            <span>+</span>
        </div>

        <div class="floating-card card-three">
            <span>✦</span>
        </div>

    </div>


    <main class="page">

        <!-- LEFT SIDE -->
        <section class="intro">

            <div class="eyebrow">
                <span class="status-dot"></span>
                SYSTEM / REGISTRATION
            </div>

            <h1>
                Create
                <span>your</span>
                account<span class="dot">.</span>
            </h1>

            <p>
                Enter your details and become part of the system.
                Simple. Secure. Yours.
            </p>

            <div class="coordinates">
                <span>USER ACCESS</span>
                <span>2026 / 08</span>
            </div>

        </section>


        <!-- REGISTRATION CARD -->
        <section class="register-area">

            <div class="register-card">

                <div class="card-top">
                    <div>
                        <span class="small-label">NEW USER</span>
                        <h2>Register</h2>
                    </div>

                    <div class="card-number">
                        01
                    </div>
                </div>


                <form action="register.php" method="POST" id="registerForm">

                    <!-- NAME -->
                    <div class="field">

                        <label for="name">
                            FULL NAME
                        </label>

                        <div class="input-wrapper">

                            <span class="field-number">
                                01
                            </span>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Your name"
                                required
                                autocomplete="name"
                            >

                        </div>

                    </div>


                    <!-- EMAIL -->
                    <div class="field">

                        <label for="email">
                            EMAIL ADDRESS
                        </label>

                        <div class="input-wrapper">

                            <span class="field-number">
                                02
                            </span>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="you@example.com"
                                required
                                autocomplete="email"
                            >

                        </div>

                    </div>


                    <!-- PASSWORD -->
                    <div class="field">

                        <label for="password">
                            PASSWORD
                        </label>

                        <div class="input-wrapper">

                            <span class="field-number">
                                03
                            </span>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Create a password"
                                required
                                autocomplete="new-password"
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                id="togglePassword"
                            >
                                SHOW
                            </button>

                        </div>

                    </div>


                    <!-- PHONE -->
                    <div class="field">

                        <label for="phone">
                            PHONE NUMBER
                        </label>

                        <div class="input-wrapper">

                            <span class="field-number">
                                04
                            </span>

                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                placeholder="+91 00000 00000"
                                required
                                autocomplete="tel"
                            >

                        </div>

                    </div>


                    <!-- BUTTON -->
                    <button type="submit" class="register-button">

                        <span class="button-text">
                            CREATE ACCOUNT
                        </span>

                        <span class="button-arrow">
                            →
                        </span>

                    </button>

                </form>


                <div class="card-footer">

                    <span>ALREADY REGISTERED?</span>

                    <a href="users.php">
                        VIEW USERS →
                    </a>

                </div>

            </div>

        </section>

    </main>


    <footer class="site-footer">

        <span>REGISTRATION SYSTEM</span>

        <span>SECURE ACCESS</span>

    </footer>


    <script>

        /*
        ========================================
        MOUSE PARALLAX
        ========================================
        */

        const cards = document.querySelectorAll(".floating-card");
        const orbs = document.querySelectorAll(".orb");

        document.addEventListener("mousemove", (event) => {

            const x = (event.clientX / window.innerWidth) - 0.5;
            const y = (event.clientY / window.innerHeight) - 0.5;


            cards.forEach((card, index) => {

                const strength = (index + 1) * 15;

                card.style.transform =
                    `translate(${x * strength}px, ${y * strength}px)
                     rotateX(${y * -10}deg)
                     rotateY(${x * 10}deg)`;

            });


            orbs.forEach((orb, index) => {

                const strength = (index + 1) * 8;

                orb.style.transform =
                    `translate(${x * strength}px, ${y * strength}px)`;

            });

        });


        /*
        ========================================
        PASSWORD TOGGLE
        ========================================
        */

        const password =
            document.getElementById("password");

        const toggle =
            document.getElementById("togglePassword");


        toggle.addEventListener("click", () => {

            if (password.type === "password") {

                password.type = "text";
                toggle.textContent = "HIDE";

            } else {

                password.type = "password";
                toggle.textContent = "SHOW";

            }

        });


        /*
        ========================================
        INPUT MOVEMENT
        ========================================
        */

        const inputs =
            document.querySelectorAll("input");


        inputs.forEach(input => {

            input.addEventListener("focus", () => {

                input.closest(".input-wrapper")
                    .classList.add("active");

            });


            input.addEventListener("blur", () => {

                input.closest(".input-wrapper")
                    .classList.remove("active");

            });

        });


        /*
        ========================================
        BUTTON MAGNETIC EFFECT
        ========================================
        */

        const button =
            document.querySelector(".register-button");


        button.addEventListener("mousemove", (event) => {

            const rect =
                button.getBoundingClientRect();

            const x =
                event.clientX - rect.left - rect.width / 2;

            const y =
                event.clientY - rect.top - rect.height / 2;


            button.style.transform =
                `translate(${x * 0.08}px, ${y * 0.08}px)`;

        });


        button.addEventListener("mouseleave", () => {

            button.style.transform =
                "translate(0, 0)";

        });

    </script>

</body>
</html>