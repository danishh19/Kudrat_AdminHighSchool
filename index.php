<?php

session_start();
include 'db.php';

// User mesti login dulu
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// Ambil semua users
$result = $conn->query("SELECT * FROM users ORDER BY id ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kudrat High School | Student List</title>

    <link rel="stylesheet" href="styles.css">
</head>

<body class="dashboard-body">

    <!-- =========================
         NAVBAR
    ========================== -->

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


    <!-- =========================
         MAIN CONTENT
    ========================== -->

    <main class="dashboard-container">

        <div class="page-header">

    <div>

        <h1>Student List</h1>

        <p>
            Manage students registered in Kudrat High School.
        </p>

    </div>


    <div class="page-buttons">

        <a href="assign.php" class="secondary-btn">
            Subject Assignment
        </a>

        <a href="add.php" class="add-btn">
            + Add New Student
        </a>

    </div>

</div>


        <!-- =========================
             TABLE CARD
        ========================== -->

        <div class="student-card">

            <div class="table-title">

                <div>
                    <h3>Registered Students</h3>
                    <p>Student account information</p>
                </div>

            </div>


            <div class="table-responsive">

                <table class="student-table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Actions</th>
                        </tr>

                    </thead>


                    <tbody>

                        <?php if ($result->num_rows > 0) { ?>

                            <?php while ($row = $result->fetch_assoc()) { ?>

                                <tr>

                                    <td>
                                        <span class="student-id">
                                            <?php echo htmlspecialchars($row["id"]); ?>
                                        </span>
                                    </td>


                                    <td>

                                        <div class="student-info">

                                            <div class="student-avatar">

                                                <?php
                                                echo strtoupper(
                                                    substr($row["name"], 0, 1)
                                                );
                                                ?>

                                            </div>

                                            <span>
                                                <?php
                                                echo htmlspecialchars($row["name"]);
                                                ?>
                                            </span>

                                        </div>

                                    </td>


                                    <td>
                                        <?php
                                        echo htmlspecialchars($row["email"]);
                                        ?>
                                    </td>


                                    <td>
                                        <?php
                                        echo htmlspecialchars($row["phone_number"]);
                                        ?>
                                    </td>


                                    <td>

                                        <div class="action-buttons">

                                            <a
                                                href="edit.php?id=<?php echo $row['id']; ?>"
                                                class="edit-btn"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="delete.php?id=<?php echo $row['id']; ?>"
                                                class="delete-btn"
                                                onclick="return confirm('Are you sure you want to delete this student?');"
                                            >
                                                Delete
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>

                                <td colspan="5" class="empty-table">

                                    No students found.

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