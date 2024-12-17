<?php
include('config.php');
session_start();

// Ensure the user is logged in as a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: Alogin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Display success message if available
if (isset($_SESSION['success_message'])) {
    echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
       /* General Styling */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to bottom, #f4f4f9, #e9eef5);
    margin: 0;
    padding: 0;
    color: #34495e;
}

/* Main Heading */
h1 {
    text-align: center;
    color: #2c3e50;
    font-size: 2.5em;
    margin-top: 30px;
    margin-bottom: 20px;
}

/* Container Styling */
.container {
    width: 85%;
    max-width: 1200px;
    margin: 30px auto;
    background-color: #ffffff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.container:hover {
    transform: scale(1.01);
}

/* Enrolled Course Item Styling */
.enrolled-course-item {
    background: #f5f7ff;
    border: 2px solid #3498db;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
}

.enrolled-course-item:hover {
    background-color: #ebf2ff;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.enrolled-course-item h2 {
    font-size: 1.8em;
    color: #3498db;
    margin-bottom: 15px;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
}

.enrolled-course-item p {
    color: #333;
    font-size: 1.1em;
    line-height: 1.6em;
}

/* Available Course Item Styling */
.course-item {
    background: #e8f0fe;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
}

.course-item:hover {
    background-color: #cfe3fc;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.course-item h2 {
    font-size: 1.8em;
    color: #3498db;
    margin-bottom: 15px;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
}

.course-item p {
    color: #555;
    font-size: 1.1em;
    line-height: 1.6em;
}

/* Success Message Styling */
.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    border: 1px solid #c3e6cb;
    border-radius: 10px;
    margin-bottom: 25px;
    text-align: center;
    font-size: 1.2em;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}

/* Button Styling */
button {
    background-color: #3498db;
    color: #fff;
    border: none;
    padding: 12px 25px;
    font-size: 1.1em;
    cursor: pointer;
    border-radius: 25px;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    margin-top: 15px;
}

button:hover {
    background-color: #2c80b4;
    transform: translateY(-3px);
    box-shadow: 0 7px 20px rgba(41, 128, 185, 0.3);
}

button:active {
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 95%;
        padding: 25px;
    }

    h1 {
        font-size: 2em;
    }

    .course-item h2, 
    .enrolled-course-item h2 {
        font-size: 1.5em;
    }

    .course-item p, 
    .enrolled-course-item p {
        font-size: 1em;
    }

    button {
        width: 100%;
        padding: 10px 15px;
    }
}

    </style>
</head>
<body>

<?php include('Iheader.php'); ?>

<div class="container">
    <h1>My Enrolled Courses</h1>
    <?php
    // Fetch enrolled courses for the student
    $enrolled_sql = "SELECT courses.* FROM courses 
                     JOIN enrollments ON courses.id = enrollments.course_id 
                     WHERE enrollments.user_id = $user_id";
    $enrolled_result = $conn->query($enrolled_sql);

    if ($enrolled_result->num_rows > 0) {
        while ($course = $enrolled_result->fetch_assoc()) {
            echo "<div class='enrolled-course-item'>";
            echo "<h2>" . $course['title'] . "</h2>";
            echo "<p>" . $course['description'] . "</p>";
            echo "<p>Price: $" . $course['price'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>You have not enrolled in any courses yet.</p>";
    }
    ?>

    <h1>Available Courses to Enroll</h1>
    <?php
    // Fetch courses that the student is not enrolled in (available to join)
    $available_sql = "SELECT * FROM courses WHERE id NOT IN 
                      (SELECT course_id FROM enrollments WHERE user_id = $user_id)";
    $available_result = $conn->query($available_sql);

    if ($available_result->num_rows > 0) {
        while ($course = $available_result->fetch_assoc()) {
            echo "<div class='course-item'>";
            echo "<h2>" . $course['title'] . "</h2>";
            echo "<p>" . $course['description'] . "</p>";
            echo "<p>Price: $" . $course['price'] . "</p>";
            echo "<form action='Spayment.php' method='POST'>";
            echo "<input type='hidden' name='course_id' value='" . $course['id'] . "'>";
            echo "<input type='hidden' name='amount' value='" . $course['price'] . "'>";
            echo "<button type='submit' name='buy_course'>Enroll Now</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No courses available to enroll at the moment.</p>";
    }
    ?>
</div>

<?php include('Ifooter.php'); ?>

</body>
</html>
