<?php
require_once 'conn.php';
$id = $_POST['id'];
$sql = "DELETE FROM users WHERE id = $id";
$conn->query($sql);
$conn->close();
?>
