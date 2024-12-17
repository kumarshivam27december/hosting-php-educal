<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Alogin.php");
    exit();
}

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Fetch course details
    $course_sql = "SELECT * FROM courses WHERE id = $course_id";
    $course_result = $conn->query($course_sql);

    if ($course_result->num_rows > 0) {
        $course = $course_result->fetch_assoc();
    } else {
        echo "Course not found!";
        exit;
    }
} else {
    echo "No course selected!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Review</title>
    <link rel="stylesheet" href="Astyles.css">
</head>
<body>

<?php include('Iheader.php'); ?>

<div class="container">
    <h1>Review Your Course and Payment</h1>
    <p>Course Title: <?php echo htmlspecialchars($course['title']); ?></p>
    <p>Course Description: <?php echo htmlspecialchars($course['description']); ?></p>
    <p>Price: $<?php echo htmlspecialchars($course['price']); ?></p>

    <form action="Spayment.php" method="post">
        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
        <input type="hidden" name="amount" value="<?php echo htmlspecialchars($course['price']); ?>">
        <button type="submit" name="proceed_payment">Proceed to Payment</button>
    </form>
</div>

<?php include('Ifooter.php'); ?>

</body>
</html>
