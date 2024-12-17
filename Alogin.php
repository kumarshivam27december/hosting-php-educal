<?php
include('config.php');
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] == 'instructor') {
                header("Location: Idashboard.php");
            } else {
                header("Location: Sdashboard.php");
            }
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #74ebd5, #ACB6E5);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.auth-container {
    background-color: #fff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    text-align: center;
    width: 350px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.auth-container:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

h2 {
    margin-bottom: 30px;
    color: #333;
    font-size: 1.8em;
}

input {
    width: 100%;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-size: 1em;
    transition: border 0.3s ease, box-shadow 0.3s ease;
    outline: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

input:focus {
    border-color: #3498db;
    box-shadow: 0 2px 10px rgba(52, 152, 219, 0.3);
}

button {
    background-color: #3498db;
    color: #fff;
    padding: 15px 20px;
    border: none;
    border-radius: 25px;
    width: 100%;
    cursor: pointer;
    font-size: 1.1em;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
}

button:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(41, 128, 185, 0.4);
}

p {
    margin-top: 20px;
    color: #666;
}

a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

a:hover {
    text-decoration: underline;
    color: #2980b9;
}

    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="Aregister.php">Register</a></p>
    </div>
</body>
</html>
