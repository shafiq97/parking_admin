<?php
require_once 'conn.php';
$id = $_POST['id'];
$user_id = $_POST['user_id'];
$email = $_POST['email'];
$student_id = $_POST['student_id'];
$license_number = $_POST['license_number'];
$license_plate = $_POST['license_plate'];

$sql = "UPDATE users SET user_id='$user_id', email='$email', student_id='$student_id', license_number='$license_number', license_plate='$license_plate' WHERE id=$id";
$conn->query($sql);
$conn->close();
?>
