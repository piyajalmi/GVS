<?php
require "includes/auth.php";
$page = $_GET['page'] ?? 'home';
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

  <main class="flex-grow-1 p-4">

    <?php
    switch ($page) {

      case 'updates':
        include "homepage/updates.php";
        break;

      case 'about_sections':
        include "about/sections.php";
        break;

      case 'about_people':
        include "about/people.php";
        break;

      case 'gallery_events':
        include "gallery/events.php";
        break;

      default:
        echo "<h2>Dashboard</h2><p>Welcome, Admin</p>";
    }
    ?>

  </main>

</div>

</body>
</html>
