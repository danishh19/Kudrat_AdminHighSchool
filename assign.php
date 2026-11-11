<?php

session_start();
include 'db.php';

// Prevent access without login
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// Get assignment data
$result = $conn->query(
    "SELECT * FROM assign ORDER BY assign_id ASC"
);

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
        Kudrat High School | Subject Assignment
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

            <h2>KUDRAT HIGH SCHOOL</h2>

            <p>School Management System</p>

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
     CONTENT
========================= -->

<main class="dashboard-container">


    <div class="page-header">

    <div>
        <h1>Subject Assign</h1>
        <p>
            Assign subject, teacher, day and class time.
        </p>
    </div>

    <div class="page-buttons">

        <a href="index.php" class="secondary-btn">
            Student List
        </a>

        <a href="add_assign.php" class="add-btn">
            + Add Assignment
        </a>

    </div>

</div>


    <!-- TABLE -->

    <div class="student-card">

        <div class="table-title">

            <h3>Class Schedule</h3>

            <p>
                Kudrat High School subject assignments
            </p>

        </div>


        <div class="table-responsive">

            <table class="student-table">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Subject</th>

                        <th>Teacher</th>

                        <th>Day</th>

                        <th>Time</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                <?php if ($result->num_rows > 0) { ?>


                    <?php while ($row = $result->fetch_assoc()) { ?>

                        <tr>

                            <td>

                                <span class="student-id">

                                    <?php
                                    echo htmlspecialchars(
                                        $row["assign_id"]
                                    );
                                    ?>

                                </span>

                            </td>


                            <td>

                                <strong>

                                    <?php
                                    echo htmlspecialchars(
                                        $row["subject_name"]
                                    );
                                    ?>

                                </strong>

                            </td>


                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $row["teacher"]
                                );
                                ?>

                            </td>


                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $row["day"]
                                );
                                ?>

                            </td>


                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $row["time"]
                                );
                                ?>

                            </td>


                            <td>

                                <div class="action-buttons">

                                    <a
                                        href="edit_assign.php?id=<?php echo $row['assign_id']; ?>"
                                        class="edit-btn"
                                    >
                                        Edit
                                    </a>


                                    <a
                                        href="delete_assign.php?id=<?php echo $row['assign_id']; ?>"
                                        class="delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this assignment?');"
                                    >
                                        Delete
                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php } ?>


                <?php } else { ?>

                    <tr>

                        <td
                            colspan="6"
                            class="empty-table"
                        >
                            No assignments found.
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</main>


</body>

</html>