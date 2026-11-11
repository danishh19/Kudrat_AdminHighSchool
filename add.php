<?php

session_start();
include 'db.php';

// Prevent user from opening page without login
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$error = "";

// Save new student
if (isset($_POST['save'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone_number = trim($_POST['phone_number']);

    // Use prepared statement
    $stmt = $conn->prepare(
        "INSERT INTO users (name, password, email, phone_number)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssss",
        $name,
        $password,
        $email,
        $phone_number
    );

    if ($stmt->execute()) {

        header("Location: index.php");
        exit();

    } else {

        $error = "Unable to add student.";
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

    <title>
        Kudrat High School | Add Student
    </title>

    <link
        rel="stylesheet"
        href="styles.css"
    >

</head>


<body class="dashboard-body">


<!-- =========================
     NAVBAR
========================= -->

<header class="topbar">

    <div class="brand">

        <img
            src="images/Kolej-Ungku-Deramat.png"
            alt="Kudrat High School Logo"
            class="nav-logo"
        >

        <div class="brand-text">

            <h2>
                KUDRAT HIGH SCHOOL
            </h2>

            <p>
                School Management System
            </p>

        </div>

    </div>


    <div class="user-section">

        <span class="user-name">

            Welcome,
            <?php
            echo htmlspecialchars($_SESSION["name"]);
            ?>

        </span>


        <a
            href="logout.php"
            class="logout-btn"
        >
            Logout
        </a>

    </div>

</header>



<!-- =========================
     ADD STUDENT FORM
========================= -->

<main class="form-page-container">


    <div class="form-page-header">

        <a
            href="index.php"
            class="back-link"
        >
            ← Back to Student List
        </a>


        <h1>
            Add New Student
        </h1>

        <p>
            Enter the student's information below.
        </p>

    </div>



    <!-- =========================
         FORM CARD
    ========================== -->

    <div class="form-card">


        <div class="form-card-header">

            <h2>
                Student Information
            </h2>

            <p>
                Complete all required information.
            </p>

        </div>



        <form
            method="post"
            class="student-form"
        >


            <?php if (!empty($error)) { ?>

                <div class="error-message">
                    <?php
                    echo htmlspecialchars($error);
                    ?>
                </div>

            <?php } ?>



            <!-- FULL NAME -->

            <div class="form-group">

                <label for="name">
                    Full Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter student's full name"
                    required
                >

            </div>



            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="example@gmail.com"
                    required
                >

            </div>



            <!-- PHONE NUMBER -->

            <div class="form-group">

                <label for="phone_number">
                    Phone Number
                </label>

                <input
                    type="text"
                    id="phone_number"
                    name="phone_number"
                    placeholder="Example: 0123456789"
                    required
                >

            </div>



            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Create a password"
                    required
                >

            </div>



            <!-- BUTTONS -->

            <div class="form-actions">


                <a
                    href="index.php"
                    class="cancel-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    name="save"
                    class="update-btn"
                >
                    Add Student
                </button>


            </div>

        </form>

    </div>

</main>


</body>

</html>