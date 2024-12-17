<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* General styles for both header and footer */
.main-header, .main-footer {
    background-color: #007bff; /* Main theme color */
    color: #fff;
    padding: 15px 0;
    text-align: center;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Navbar Styling */
.navbar {
    display: flex;
    justify-content: center; /* Align links in the center */
    gap: 30px; /* Space between links */
}

.nav-link {
    color: #fff;
    text-decoration: none;
    font-size: 1.1em;
    font-weight: 500;
    padding: 10px 20px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.nav-link:hover {
    background-color: #0056b3; /* Darker blue on hover */
    color: #fff;
    border-radius: 5px;
}

/* Footer Styling */
.main-footer {
    background-color: #343a40; /* Darker background for footer */
    color: #f8f9fa;
    padding: 20px 0;
    font-size: 0.9em;
}

.main-footer p {
    margin: 0;
}

.main-footer p:hover {
    color: #007bff; /* Highlight color when hovering over footer text */
}

/* Responsive Design */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        gap: 15px;
    }

    .nav-link {
        font-size: 1em;
        padding: 8px 15px;
    }
}

    </style>
</head>
<body>
    
<footer class="main-footer">
    <p>&copy; 2024 Educate. All Rights Reserved.</p>
</footer>
</body>
</html>