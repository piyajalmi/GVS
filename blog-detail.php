<?php
$currentPage = basename($_SERVER['PHP_SELF']);
require "admin/includes/db.php";
$id = (int)$_GET['id'];

$blog = $conn->query(
  "SELECT * FROM blogs WHERE id=$id"
)->fetch_assoc();
?>


<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Read-More | Blogs | Gopalkrishna Vidhyprasarak Saunstha</title>

  <!-- Meta for responsiveness -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
  rel="stylesheet"
>
 

  <!-- Main CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

</head>
<body class="inner-page">

  <!-- ===== HEADER ===== -->
 <!-- ===== HEADER ===== -->
<header class="header">

  <!-- Top Header -->
  <div class="top-header">
    <div class="container top-header-flex">

      <div class="logo-center">
        <img src="assets/images/logo1.png" alt="School Logo">
        <div class="school-name">
          <h1>Gopalkrishna Pre-Primary, Primary & High School</h1>
          <p>Gopalkrishna Vidhyprasarak Saunstha</p>
        </div>
      </div>
<div class="header-socials">
      <a href="https://www.facebook.com/gopalkrishnaschool" aria-label="Facebook" target="_blank">
        <img src="assets/icons/facebook.png" alt="Facebook">
      </a>
      <a href="//www.instagram.com/gopalkrishna_high_school" aria-label="Instagram" target="_blank">
        <img src="assets/icons/instagram.png" alt="Instagram">
      </a>
    </div>
    </div>
  </div>

  <!-- Bottom Navigation -->
  <div class="nav-header">
    <div class="container">
      <nav class="nav">
  <ul>
    <li class="<?= ($currentPage == 'index.php') ? 'active' : '' ?>">
      <a href="index.php">Home</a>
    </li>

    <li class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>">
      <a href="about.php">About Us</a>
    </li>

    <li class="<?= ($currentPage == 'curriculum.php') ? 'active' : '' ?>">
      <a href="curriculum.php">Curriculum</a>
    </li>

    <li class="<?= ($currentPage == 'gallery.php') ? 'active' : '' ?>">
      <a href="gallery.php">Gallery</a>
    </li>

    <li class="<?= ($currentPage == 'blogs.php') ? 'active' : '' ?>">
      <a href="blogs.php">Blogs</a>
    </li>
  </ul>
</nav>

    </div>
  </div>

</header>
<section class="page-banner">
  <div class="container text-center">
    <h1><?= htmlspecialchars($blog['title']) ?></h1>
    <p class="text-muted">
      Published on <?= date("d F Y", strtotime($blog['created_at'])) ?>
    </p>
  </div>
</section>

<section class="content-section">
  <div class="container">

    <!-- BLOG TITLE 
    <h1 class="mb-3"><?= htmlspecialchars($blog['title']) ?></h1>

    DATE 
    <p class="text-muted mb-4">
      Published on <?= date("d F Y", strtotime($blog['created_at'])) ?>
    </p> -->

    <!-- IMAGE (ONLY IF EXISTS) -->
    <?php if (!empty($blog['image'])): ?>
      <img src="admin/blogs/uploads/blogs/<?= $blog['image'] ?>"
           class="img-fluid mb-4"
           alt="<?= htmlspecialchars($blog['title']) ?>">
    <?php endif; ?>

    <!-- FULL BLOG CONTENT -->
  <div class="blog-detail-content">
  <?= $blog['description'] ?>
</div>


  </div>
    </section>

<footer class="site-footer">
  <div class="container">

    <div class="row">

      <!-- School Info -->
      <div class="col-md-4 mb-4">
        <h5>Gopalkrishna Vidhyprasarak Saunstha</h5>
        <p>
          Sankhali – Goa<br>
          Providing quality education with values, discipline,
          and holistic development.
        </p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-4">
        <h5>Quick Links</h5>
        <ul class="footer-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="curriculum.php">Curriculum</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="blogs.php">Blogs</a></li>
        </ul>
      </div>

      <!-- Contact & Social -->
      <div class="col-md-4 mb-4">
        <h5>Connect With Us</h5>

        <p>
          📞 +91 XXXXX XXXXX<br>
          ✉️ info@gopalkrishnaschool.com
        </p>

        <div class="footer-socials">
          <a href="https://www.facebook.com/gopalkrishnaschool" target="_blank">
            <img src="assets/icons/facebook.png" alt="Facebook">
          </a>
          <a href="https://www.instagram.com/gopalkrishna_high_school" target="_blank">
            <img src="assets/icons/instagram.png" alt="Instagram">
          </a>
        </div>
      </div>

    </div>

    <hr>

    <div class="text-center footer-bottom">
      <p>
        © <?php echo date("Y"); ?>
        Gopalkrishna Vidhyprasarak Saunstha. All Rights Reserved.
      </p>
    </div>

  </div>
</footer>
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
</script>




  <!-- Custom JS -->
  <script src="assets/js/main.js"></script>


</body>
</html>