<?php
$servername = "sql208.infinityfree.com";
$username = "if0_37679072";
$password = "mU0lP85EZxog";
$dbname = "if0_37679072_educal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>