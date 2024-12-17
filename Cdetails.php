<?php
include('config.php');
session_start();

if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']);
    
    // Fetch course details
    $course_sql = "SELECT courses.*, users.name as instructor 
                   FROM courses 
                   JOIN users ON courses.instructor_id = users.id 
                   WHERE courses.id = $course_id";
    $course_result = $conn->query($course_sql);
    
    if ($course_result->num_rows > 0) {
        $course = $course_result->fetch_assoc();
    } else {
        echo "<p>Course not found.</p>";
        exit;
    }
} else {
    echo "<p>No course selected.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $course['title']; ?> - Educate</title>
    <style>
        /* General Styling */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #e0eafc, #cfdef3);
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    color: #34495e;
}

h1 {
    text-align: center;
    color: #2c3e50;
    font-size: 2.5em;
    margin-top: 30px;
    margin-bottom: 10px;
}

h3 {
    color: #2980b9;
    font-size: 1.8em;
    margin-top: 20px;
    text-align: center;
}

p {
    text-align: left;
    color: #7f8c8d;
    font-size: 1.2em;
    margin-bottom: 10px;
}

.container {
    width: 90%;
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 20px;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Course Details Styling */
.course-details {
    margin-top: 30px;
    padding: 20px;
    border-radius: 10px;
    background-color: #f7f9fb;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.course-details h1, .course-details p {
    text-align: left;
}

.course-details p strong {
    color: #2c3e50;
}

.course-details p {
    margin-bottom: 15px;
}

/* Reviews Section */
.review {
    background: #f0f4f8;
    padding: 15px;
    border-radius: 10px;
    margin-top: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.review p {
    font-size: 1em;
    color: #34495e;
}

.review strong {
    color: #2980b9;
}

.review p:last-child {
    margin-top: 5px;
    color: #7f8c8d;
}

/* Review Form */
.review-form {
    background-color: #f7f9fb;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
    text-align: left;
}

.review-form label {
    font-weight: 600;
    margin-top: 10px;
    display: block;
    color: #2c3e50;
}

.review-form select, .review-form textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ddd;
    font-size: 1em;
    transition: border 0.3s ease;
}

.review-form select:focus, .review-form textarea:focus {
    border-color: #3498db;
    outline: none;
}

.review-form button {
    padding: 12px 20px;
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 50px;
    font-size: 1.1em;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.review-form button:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(41, 128, 185, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 95%;
        padding: 20px;
    }

    h1 {
        font-size: 2em;
    }

    .review-form button {
        font-size: 1em;
        padding: 10px 15px;
    }

    .course-details, .review-form {
        padding: 20px;
    }
}

/* styling the add review part */
/* Add Your Review Section Styling */
.add-review {
    background-color: #f7f9fb;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
    text-align: left;
}

.add-review h3 {
    color: #2c3e50;
    font-size: 1.8em;
    margin-bottom: 20px;
    text-align: center;
}

.add-review label {
    font-weight: 600;
    margin-top: 10px;
    display: block;
    color: #2c3e50;
}

.add-review select, 
.add-review textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ddd;
    font-size: 1em;
    transition: border 0.3s ease;
}

.add-review select:focus, 
.add-review textarea:focus {
    border-color: #3498db;
    outline: none;
}

.add-review button {
    padding: 12px 20px;
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 50px;
    font-size: 1.1em;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    display: block;
    margin: 0 auto;
}

.add-review button:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(41, 128, 185, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .add-review {
        padding: 20px;
    }

    .add-review button {
        font-size: 1em;
        padding: 10px 15px;
    }
}

    </style>
</head>
<body>
    <?php include('Iheader.php'); ?>

    <div class="container">
        <h1><?php echo $course['title']; ?></h1>
        <p><strong>Instructor:</strong> <?php echo $course['instructor']; ?></p>
        <p><strong>Description:</strong> <?php echo $course['description']; ?></p>
        <p><strong>Price:</strong> $<?php echo $course['price']; ?></p>

        <h3>Course Reviews</h3>
        <?php
        // Fetch and display reviews
        $review_sql = "SELECT reviews.*, users.name FROM reviews 
                       JOIN users ON reviews.user_id = users.id 
                       WHERE course_id = $course_id";
        $review_result = $conn->query($review_sql);

        if ($review_result->num_rows > 0) {
            while ($review = $review_result->fetch_assoc()) {
                echo "<p><strong>" . $review['name'] . ":</strong> ";
                echo "Rating: " . $review['rating'] . "/5</p>";
                echo "<p>" . $review['review'] . "</p>";
            }
        } else {
            echo "<p>No reviews yet. Be the first to review this course!</p>";
        }
        ?>
    </div>

    <?php include('Ifooter.php'); ?>
</body>
</html>
<?php
// Check if the user is logged in to allow posting a review
if (isset($_SESSION['user_id'])) {
?>
    <div class="add-review">
        <h3>Add Your Review</h3>
        <form action="submit_review.php" method="POST">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <label for="rating">Rating (1-5):</label>
            <select name="rating" id="rating" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <label for="review">Review:</label>
            <textarea name="review" id="review" rows="4" required></textarea>
            <button type="submit">Submit Review</button>
        </form>
    </div>
<?php
} else {
    echo "<p><a href='Alogin.php'>Log in</a> to add your review.</p>";
}


