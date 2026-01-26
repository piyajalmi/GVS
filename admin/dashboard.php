<?php
session_start();
require __DIR__ . '/includes/auth.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex">
  <?php include "includes/sidebar.php"; ?>

  <main class="p-4 flex-grow-1">
    <h2>Dashboard</h2>
    <p>Welcome, Admin</p>
  </main>
</div>

</body>
</html>
