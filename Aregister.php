<?php
include('config.php');

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        echo "Email is already registered!";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
            header("Location: Alogin.php"); // Redirect to login page
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

input, select {
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

input:focus, select:focus {
    border-color: #3498db;
    box-shadow: 0 2px 10px rgba(52, 152, 219, 0.3);
}

select {
    padding-right: 35px;
    appearance: none;
    background: url('data:image/svg+xml,%3Csvg fill="%233498db" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M7 10l5 5 5-5z"/%3E%3Cpath d="M0 0h24v24H0z" fill="none"/%3E%3C/svg%3E') no-repeat right 10px center;
    background-size: 20px;
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

label {
    text-align: left;
    display: block;
    color: #333;
    font-weight: bold;
    margin-bottom: 10px;
    font-size: 1em;
}

    </style>
</head>

<body>
    <div class="auth-container">
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <label for="role">Role:</label>
            <select name="role" required>
                <option value="student">Student</option>
                <option value="instructor">Instructor</option>
            </select>

            <button type="submit" name="register">Register</button>
        </form>

        <p>Already have an account? <a href="Alogin.php">Login</a></p>
    </div>
</body>

</html>