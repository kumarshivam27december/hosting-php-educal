<?php
include('config.php');
session_start();

// Ensure the user is logged in and has the instructor role
if ($_SESSION['role'] != 'instructor') {
    header("Location: Alogin.php");
    exit();
}

$instructor_id = $_SESSION['user_id'];

// Handle course deletion
if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];
    $delete_sql = "DELETE FROM courses WHERE id = $course_id AND instructor_id = $instructor_id";
    if ($conn->query($delete_sql)) {
        echo "Course deleted successfully!";
    } else {
        echo "Error deleting course!";
    }
}

// Handle course addition
if (isset($_POST['add_course'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $add_sql = "INSERT INTO courses (title, description, price, instructor_id) VALUES ('$title', '$description', '$price', '$instructor_id')";
    
    if ($conn->query($add_sql)) {
        echo "Course added successfully!";
    } else {
        echo "Error adding course!";
    }
}

// Fetch instructor's courses
$sql = "SELECT * FROM courses WHERE instructor_id = $instructor_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .btn {
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Instructor Dashboard</h1>

        <!-- Add Course Form -->
        <div class="form-container">
            <h2>Add a New Course</h2>
            <form method="POST">
                <input type="text" name="title" placeholder="Course Title" required>
                <textarea name="description" placeholder="Course Description" required></textarea>
                <input type="number" name="price" placeholder="Price" required>
                <button type="submit" name="add_course">Add Course</button>
            </form>
        </div>

        <!-- Display Instructor's Courses -->
        <h2>Your Courses</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($course = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $course['title'] . "</td>";
                        echo "<td>" . substr($course['description'], 0, 50) . "...</td>";
                        echo "<td>$" . $course['price'] . "</td>";
                        echo "<td>";
                        echo "<a href='Iedit_course.php?id=" . $course['id'] . "' class='btn'>Edit</a> ";
                        echo "<a href='Idashboard.php?delete=" . $course['id'] . "' class='btn'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No courses found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
