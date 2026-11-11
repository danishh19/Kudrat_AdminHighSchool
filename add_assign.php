<?php

session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$error = "";

if (isset($_POST['save'])) {

    $subject_name = trim($_POST['subject_name']);
    $teacher = trim($_POST['teacher']);
    $day = trim($_POST['day']);
    $time = trim($_POST['time']);

    $stmt = $conn->prepare(
        "INSERT INTO assign (subject_name, teacher, day, time)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssss",
        $subject_name,
        $teacher,
        $day,
        $time
    );

    if ($stmt->execute()) {

        header("Location: assign.php");
        exit();

    } else {

        $error = "Unable to add assignment.";
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
        Kudrat High School | Add Assignment
    </title>

    <link rel="stylesheet" href="styles.css">

</head>

<body class="dashboard-body">


<header class="topbar">

    <div class="brand">

        <img
            src="images/Kolej-Ungku-Deramat.png"
            alt="Kudrat High School Logo"
            class="nav-logo"
        >

        <div class="brand-text">

            <h2>KUDRAT HIGH SCHOOL</h2>

            <p>School Management System</p>

        </div>

    </div>


    <div class="user-section">

        <span class="user-name">

            Welcome,
            <?php echo htmlspecialchars($_SESSION["name"]); ?>

        </span>

        <a href="logout.php" class="logout-btn">
            Logout
        </a>

    </div>

</header>



<main class="form-page-container">


    <div class="form-page-header">

        <a
            href="assign.php"
            class="back-link"
        >
            ← Back to Subject Assignment
        </a>

        <h1>Add Assignment</h1>

        <p>
            Enter the subject assignment details below.
        </p>

    </div>



    <div class="form-card">


        <div class="form-card-header">

            <h2>Assignment Information</h2>

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

                    <?php echo htmlspecialchars($error); ?>

                </div>

            <?php } ?>


            <div class="form-group">

                <label for="subject_name">
                    Subject Name
                </label>

                <input
                    type="text"
                    id="subject_name"
                    name="subject_name"
                    placeholder="Example: Bahasa Melayu"
                    required
                >

            </div>


            <div class="form-group">

                <label for="teacher">
                    Teacher
                </label>

                <input
                    type="text"
                    id="teacher"
                    name="teacher"
                    placeholder="Example: Rahman"
                    required
                >

            </div>


            <div class="form-group">

                <label for="day">
                    Day
                </label>

                <select
                    id="day"
                    name="day"
                    class="form-select"
                    required
                >

                    <option value="">
                        Select Day
                    </option>

                    <option value="Monday">
                        Monday
                    </option>

                    <option value="Tuesday">
                        Tuesday
                    </option>

                    <option value="Wednesday">
                        Wednesday
                    </option>

                    <option value="Thursday">
                        Thursday
                    </option>

                    <option value="Friday">
                        Friday
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="time">
                    Time
                </label>

                <input
                    type="text"
                    id="time"
                    name="time"
                    placeholder="Example: 9.00 AM"
                    required
                >

            </div>



            <div class="form-actions">

                <a
                    href="assign.php"
                    class="cancel-btn"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    name="save"
                    class="update-btn"
                >
                    Add Assignment
                </button>

            </div>

        </form>

    </div>

</main>

</body>
</html>