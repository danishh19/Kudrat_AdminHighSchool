<?php

session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: assign.php");
    exit();
}

$id = (int) $_GET["id"];

$stmt = $conn->prepare(
    "DELETE FROM assign
     WHERE assign_id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: assign.php");
exit();

?>