<?php
include('config.php');

$limit = 5; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT courses.*, users.name as instructor_name FROM courses 
        JOIN users ON courses.instructor_id = users.id
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$count_sql = "SELECT COUNT(*) as total_courses FROM courses";
$count_result = $conn->query($count_sql);
$total_courses = $count_result->fetch_assoc()['total_courses'];
$total_pages = ceil($total_courses / $limit);

if ($result->num_rows > 0) {
    echo "<h1>All Courses</h1>";
    while($course = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>" . $course['title'] . "</h2>";
        echo "<p>Instructor: " . $course['instructor_name'] . "</p>";
        echo "<p>Price: $" . $course['price'] . "</p>";
        echo "<a href='Cdetails.php?id=" . $course['id'] . "'>View Details</a>";
        echo "</div>";
    }

    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='Cindex.php?page=$i'>$i</a> ";
    }
    echo "</div>";
} else {
    echo "No courses available.";
}
?>

