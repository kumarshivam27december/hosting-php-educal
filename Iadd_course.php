<?php
include('config.php');
session_start();

if ($_SESSION['role'] != 'instructor') {
    header("Location: Alogin.php");
}

if (isset($_POST['add_course'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $instructor_id = $_SESSION['user_id'];

    $sql = "INSERT INTO courses (title, description, price, instructor_id) VALUES ('$title', '$description', '$price', '$instructor_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Course added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
