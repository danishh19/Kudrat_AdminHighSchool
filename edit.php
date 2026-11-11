<?php

session_start();
include 'db.php';

// Prevent access without login
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// Make sure ID exists
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];


// Get current student data
$stmt = $conn->prepare(
    "SELECT id, name, password, email, phone_number
     FROM users
     WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();


// If student does not exist
if (!$row) {
    header("Location: index.php");
    exit();
}


// Update student
if (isset($_POST['update'])) {

    $name = trim($_POST['name']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);


    $stmt = $conn->prepare(
        "UPDATE users
         SET name = ?, password = ?, email = ?, phone_number = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "ssssi",
        $name,
        $password,
        $email,
        $phone_number,
        $id
    );

    $stmt->execute();

    header("Location: index.php");
    exit();
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
        Kudrat High School | Edit Student
    </title>

    <link rel="stylesheet" href="styles.css">

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
     EDIT FORM
========================= -->

<main class="form-page-container">


    <div class="form-page-header">

        <div>

            <a
                href="index.php"
                class="back-link"
            >
                ← Back to Student List
            </a>


            <h1>
                Edit Student
            </h1>

            <p>
                Update student information below.
            </p>

        </div>

    </div>



    <div class="form-card">


        <div class="form-card-header">

            <h2>
                Student Information
            </h2>

            <p>
                Student ID:
                #<?php echo htmlspecialchars($row['id']); ?>
            </p>

        </div>



        <form method="post" class="student-form">


            <!-- NAME -->

            <div class="form-group">

                <label for="name">
                    Full Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?php echo htmlspecialchars($row['name']); ?>"
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
                    value="<?php echo htmlspecialchars($row['email']); ?>"
                    required
                >

            </div>



            <!-- PHONE -->

            <div class="form-group">

                <label for="phone_number">
                    Phone Number
                </label>

                <input
                    type="text"
                    id="phone_number"
                    name="phone_number"
                    value="<?php echo htmlspecialchars($row['phone_number']); ?>"
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
                    value="<?php echo htmlspecialchars($row['password']); ?>"
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
                    name="update"
                    class="update-btn"
                >
                    Update Student
                </button>

            </div>


        </form>

    </div>

</main>


</body>

</html>