<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Alogin.php");
}

if (isset($_POST['submit_review'])) {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $sql = "INSERT INTO reviews (user_id, course_id, rating, review) VALUES ('$user_id', '$course_id', '$rating', '$review')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Review submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
