<?php
include('config.php');
session_start();

if ($_SESSION['role'] != 'student') {
    header("Location: Alogin.php");
}

// Fetch enrolled courses for the logged-in student
$student_id = $_SESSION['user_id'];

$sql = "SELECT courses.id, courses.title, courses.description, courses.price, users.name as instructor 
        FROM enrollments 
        JOIN courses ON enrollments.course_id = courses.id 
        JOIN users ON courses.instructor_id = users.id
        WHERE enrollments.user_id = $student_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <style>
        /* General styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .courses {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .course {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .course:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .course h3 {
            font-size: 1.4em;
            color: #3498db;
            margin-bottom: 10px;
        }

        .course p {
            font-size: 1em;
            color: #7f8c8d;
            margin-bottom: 15px;
        }

        .course p strong {
            color: #2c3e50;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
            position: absolute;
            bottom: 20px;
            right: 20px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            .course {
                padding: 15px;
            }

            .course h3 {
                font-size: 1.2em;
            }

            .btn {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <?php include('Iheader.php'); ?>

    <div class="container">
        <h1>My Courses</h1>
        <div class="courses">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='course'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . substr($row['description'], 0, 100) . "...</p>";
                    echo "<p><strong>Price:</strong> $" . $row['price'] . "</p>";
                    echo "<p><strong>Instructor:</strong> " . $row['instructor'] . "</p>";
                    echo "<a href='Cdetails.php?id=" . $row['id'] . "' class='btn'>View Course</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>You haven't enrolled in any courses yet.</p>";
            }
            ?>
        </div>
    </div>

    <?php include('Ifooter.php'); ?>
</body>
</html>
