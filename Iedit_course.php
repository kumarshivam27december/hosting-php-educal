<?php
include('config.php');
session_start();

if ($_SESSION['role'] != 'instructor') {
    header("Location: Alogin.php");
    exit();
}

$instructor_id = $_SESSION['user_id'];
$course_id = $_GET['id'];

// Fetch course details
$sql = "SELECT * FROM courses WHERE id = $course_id AND instructor_id = $instructor_id";
$result = $conn->query($sql);
$course = $result->fetch_assoc();

// Update course
if (isset($_POST['update_course'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $update_sql = "UPDATE courses SET title='$title', description='$description', price='$price' WHERE id=$course_id AND instructor_id=$instructor_id";

    if ($conn->query($update_sql)) {
        echo "Course updated successfully!";
        header("Location: Idashboard.php");
    } else {
        echo "Error updating course!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
</head>
<body>
    <h1>Edit Course</h1>
    <form method="POST">
        <input type="text" name="title" value="<?php echo $course['title']; ?>" required>
        <textarea name="description" required><?php echo $course['description']; ?></textarea>
        <input type="number" name="price" value="<?php echo $course['price']; ?>" required>
        <button type="submit" name="update_course">Update Course</button>
    </form>
</body>
</html>
