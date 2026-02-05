<?php
$conn = new mysqli("localhost", "root", "", "gvs_cms");

if ($conn->connect_error) {
    die("Database connection failed");
}
?>