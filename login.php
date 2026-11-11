<?php

session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare(
        "SELECT id, name, email, password
         FROM users
         WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if ($password === $user["password"]) {

            session_regenerate_id(true);

            $_SESSION["id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["email"] = $user["email"];

            header("Location: index.php");
            exit();

        } else {
            $error = "Invalid email or password.";
        }

    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
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

    <title>Kudrat High School | Login</title>

    <link
        rel="stylesheet"
        href="styles.css"
    >
</head>

<body class="login-body">

    <div class="login-container">

        <img
            src="images/Kolej-Ungku-Deramat.png"
            alt="Kudrat High School Logo"
            class="school-logo"
        >

        <h1 class="school-name">
            KUDRAT
        </h1>

        <p class="school-subtitle">
            High School Management System
        </p>


        <?php
        if (!empty($error)) {
        ?>

            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php
        }
        ?>


        <form
            method="POST"
            action=""
            class="login-form"
        >

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >

            </div>


            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

            </div>


            <button
                type="submit"
                class="login-btn"
            >
                Login
            </button>

        </form>


        <div class="login-footer">

            © 2026 Kudrat High School

        </div>

    </div>

</body>

</html>