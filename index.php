<?php
include('config.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educate - Online Learning Platform</title>
    <style>
      /* General Styling */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #74ebd5, #ACB6E5);
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

h1, h2 {
    text-align: center;
    color: #2c3e50;
    margin-top: 20px;
    font-size: 2.5em;
}

p {
    text-align: center;
    color: #7f8c8d;
    font-size: 1.2em;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 0;
}

/* Course Grid Styling */
.courses {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.course {
    background-color: #fff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.course::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 5px;
    width: 100%;
    background: #3498db;
    transition: width 0.3s ease;
}

.course:hover::before {
    width: 0;
}

.course:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
}

.course h3 {
    font-size: 1.6em;
    color: #2980b9;
    margin-bottom: 15px;
}

.course p {
    font-size: 1em;
    color: #7f8c8d;
    margin-bottom: 10px;
}

.course p strong {
    color: #2c3e50;
}

/* Button Styling */
.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    border-radius: 25px;
    text-decoration: none;
    font-size: 0.9em;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    align-self: flex-end;
    margin-top: auto;
}

.btn:hover {
    background-color: #2980b9;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(41, 128, 185, 0.3);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container {
        width: 95%;
        padding: 20px;
    }

    h1, h2 {
        font-size: 2em;
    }

    .course {
        padding: 20px;
    }

    .course h3 {
        font-size: 1.4em;
    }

    .btn {
        font-size: 0.9em;
        padding: 10px 15px;
    }
}

    </style>
</head>
<body>
    <?php include('Iheader.php'); ?>

    <div class="container">
        <h1>Welcome to Educate</h1>
        <p>Learn new skills from the best instructors around the world.</p>
        
        <h2>Available Courses</h2>
        <div class="courses">
            <?php
            // Fetch courses from the database
            $sql = "SELECT courses.id, courses.title, courses.description, courses.price, users.name as instructor
                    FROM courses
                    JOIN users ON courses.instructor_id = users.id
                    "; // Limit to 6 courses for demo //LIMIT 20
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='course'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . substr($row['description'], 0, 100) . "...</p>";
                    echo "<p><strong>Price:</strong> $" . $row['price'] . "</p>";
                    echo "<p><strong>Instructor:</strong> " . $row['instructor'] . "</p>";
                    echo "<a href='Cdetails.php?id=" . $row['id'] . "' class='btn'>View Details</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No courses available right now.</p>";
            }
            ?>
        </div>
    </div>

    <?php include('Ifooter.php'); ?>
</body>
</html>
