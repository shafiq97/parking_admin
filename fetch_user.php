<?php
require_once 'conn.php';
$id = $_POST['id'];
$sql = "SELECT id, user_id, email, student_id, license_number, license_plate FROM users WHERE id = $id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
echo json_encode($user);
$conn->close();
