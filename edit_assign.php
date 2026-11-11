<?php

session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: assign.php");
    exit();
}

$id = (int) $_GET['id'];


// Get assignment
$stmt = $conn->prepare(
    "SELECT *
     FROM assign
     WHERE assign_id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();


if (!$row) {

    header("Location: assign.php");
    exit();
}


// Update assignment
if (isset($_POST['update'])) {

    $subject_name = trim($_POST['subject_name']);
    $teacher = trim($_POST['teacher']);
    $day = trim($_POST['day']);
    $time = trim($_POST['time']);

    $stmt = $conn->prepare(
        "UPDATE assign
         SET subject_name = ?,
             teacher = ?,
             day = ?,
             time = ?
         WHERE assign_id = ?"
    );

    $stmt->bind_param(
        "ssssi",
        $subject_name,
        $teacher,
        $day,
        $time,
        $id
    );

    $stmt->execute();

    header("Location: assign.php");
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
        Kudrat High School | Edit Assignment
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

        <h1>Edit Assignment</h1>

        <p>
            Update the subject assignment details.
        </p>

    </div>



    <div class="form-card">


        <div class="form-card-header">

            <h2>Assignment Information</h2>

            <p>
                Assignment ID:
                #<?php echo htmlspecialchars($row["assign_id"]); ?>
            </p>

        </div>



        <form
            method="post"
            class="student-form"
        >


            <div class="form-group">

                <label for="subject_name">
                    Subject Name
                </label>

                <input
                    type="text"
                    id="subject_name"
                    name="subject_name"
                    value="<?php echo htmlspecialchars($row["subject_name"]); ?>"
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
                    value="<?php echo htmlspecialchars($row["teacher"]); ?>"
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

                    <option
                        value="Monday"
                        <?php if ($row["day"] == "Monday") echo "selected"; ?>
                    >
                        Monday
                    </option>

                    <option
                        value="Tuesday"
                        <?php if ($row["day"] == "Tuesday") echo "selected"; ?>
                    >
                        Tuesday
                    </option>

                    <option
                        value="Wednesday"
                        <?php if ($row["day"] == "Wednesday") echo "selected"; ?>
                    >
                        Wednesday
                    </option>

                    <option
                        value="Thursday"
                        <?php if ($row["day"] == "Thursday") echo "selected"; ?>
                    >
                        Thursday
                    </option>

                    <option
                        value="Friday"
                        <?php if ($row["day"] == "Friday") echo "selected"; ?>
                    >
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
                    value="<?php echo htmlspecialchars($row["time"]); ?>"
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
                    name="update"
                    class="update-btn"
                >
                    Update Assignment
                </button>

            </div>

        </form>

    </div>

</main>

</body>
</html>