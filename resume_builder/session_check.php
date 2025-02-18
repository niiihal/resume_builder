<!-- verify log in  -->

<?php
session_start();
$response = ["logged_in" => isset($_SESSION['user_id'])];
echo json_encode($response);
?>