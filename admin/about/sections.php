<?php
require "../includes/auth.php";
require "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['section_name'];
  $page = $_POST['page'];
  $order = $_POST['sort_order'];

  $stmt = $conn->prepare("
    INSERT INTO about_sections (page, section_name, sort_order)
    VALUES (?,?,?)
  ");
  $stmt->bind_param("ssi", $page, $name, $order);
  $stmt->execute();
}

$sections = $conn->query("SELECT * FROM about_sections ORDER BY sort_order");
?>
<form method="post">
  <input name="section_name" placeholder="Section name" required>
  <select name="page">
    <option value="management">Management</option>
    <option value="staff">Staff</option>
  </select>
  <input name="sort_order" type="number">
  <button>Add Section</button>
</form>
