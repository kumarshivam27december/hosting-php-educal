<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Alogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buy_course'])) {
    $course_id = $_POST['course_id'];
    $amount = $_POST['amount'];

    $course_sql = "SELECT * FROM courses WHERE id = $course_id";
    $course_result = $conn->query($course_sql);

    if ($course_result->num_rows > 0) {
        $course = $course_result->fetch_assoc();
    } else {
        echo "Course not found!";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Review</title>
    <style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

h1, h2 {
    text-align: center;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
}

.container {
    width: 60%;
    margin: 0 auto;
    background-color: #fff;
    padding: 30px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.container:hover {
    transform: scale(1.02);
}

/* Course Info Styling */
.course-info p {
    font-size: 1.2em;
    margin-bottom: 10px;
}

strong {
    color: #333;
}

/* Payment Form Styling */
.payment-form {
    margin-top: 20px;
}

.payment-form label {
    display: block;
    font-weight: 500;
    margin-bottom: 10px;
}

.payment-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1em;
    transition: all 0.3s ease;
}

.payment-form input:focus {
    border-color: #007bff;
    box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
}

.payment-form .btn {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: white;
    font-size: 1.2em;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.payment-form .btn:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

.payment-form .btn i {
    margin-left: 10px;
}

/* Small Animations */
@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
}

.container {
    animation: fadeIn 0.5s ease-in-out;
}

.payment-form input::placeholder {
    color: #999;
}

    </style>
    
    <!-- Include Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    
    <!-- Include FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link rel="stylesheet" href="Astyles.css"> <!-- Include your CSS here -->
</head>
<body>

<?php include('Iheader.php'); ?>

<div class="container">
    <h1>Review Your Course and Payment</h1>
    
    <!-- Course Info -->
    <div class="course-info">
        <p><strong>Course Title:</strong> <?php echo htmlspecialchars($course['title']); ?></p>
        <p><strong>Course Description:</strong> <?php echo htmlspecialchars($course['description']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($course['price']); ?></p>
    </div>

    <!-- Payment Form -->
    <form action="Sprocess_payment.php" method="post" class="payment-form">
        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
        <input type="hidden" name="amount" value="<?php echo htmlspecialchars($course['price']); ?>">

        <h2>Payment Information</h2>
        <label for="card_number">Card Number <i class="fas fa-credit-card"></i>:</label>
        <input type="text" name="card_number" required maxlength="16" pattern="\d{16}" placeholder="1234 5678 9012 3456">

        <label for="expiry">Expiry Date <i class="far fa-calendar-alt"></i> (MM/YY):</label>
        <input type="text" name="expiry" required pattern="\d{2}/\d{2}" placeholder="MM/YY">

        <label for="cvv">CVV <i class="fas fa-lock"></i>:</label>
        <input type="text" name="cvv" required maxlength="3" pattern="\d{3}" placeholder="123">

        <button type="submit" name="pay_now" class="btn btn-primary">Pay Now <i class="fas fa-arrow-right"></i></button>
    </form>
</div>

<?php include('Ifooter.php'); ?>

</body>
</html>
