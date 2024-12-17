<?php
include('config.php');
session_start();

if (isset($_POST['course_id']) && isset($_POST['rating']) && isset($_POST['review']) && isset($_SESSION['user_id'])) {
    $course_id = intval($_POST['course_id']);
    $user_id = intval($_SESSION['user_id']);
    $rating = intval($_POST['rating']);
    $review = $conn->real_escape_string($_POST['review']);

    $sql = "INSERT INTO reviews (course_id, user_id, rating, review) VALUES ('$course_id', '$user_id', '$rating', '$review')";

    if ($conn->query($sql) === TRUE) {
        header("Location: Cdetails.php?id=$course_id");
        exit;
    } else {
        echo "<p>Failed to submit review. Please try again later.</p>";
    }
} else {
    echo "<p>Invalid request. Make sure you are logged in and provide all required information.</p>";
}
?>
