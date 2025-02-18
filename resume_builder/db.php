<!-- database connection -->

<?php
$host = "localhost";
$user = "root"; // Change if using a different DB user
$password = ""; // Set your database password if applicable
$dbname = "resume_builder";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
