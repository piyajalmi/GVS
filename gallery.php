<?php
$currentPage = basename($_SERVER['PHP_SELF']);
require "admin/includes/db.php";
$events = $conn->query(
  "SELECT * FROM gallery_events ORDER BY sort_order, id DESC"
);
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gallery | Gopalkrishna Vidhyprasarak Saunstha</title>

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

 <header class="main-header">
  <div class="header-inner">

    <!-- LEFT: Logo + Name -->
    <div class="header-left">
      <img src="assets/images/logo1.png" alt="School Logo">
      <div class="school-name">
        <h1>Gopalkrishna Pre-Primary, Primary & High School</h1>
        <p>Gopalkrishna Vidhyprasarak Saunstha</p>
      </div>
    </div>

    <!-- RIGHT: Navigation -->
    <nav class="header-nav">
      <a class="<?= ($currentPage=='index.php')?'active':'' ?>" href="index.php">Home</a>
      <a class="<?= ($currentPage=='about.php')?'active':'' ?>" href="about.php">About Us</a>
      <a class="<?= ($currentPage=='curriculum.php')?'active':'' ?>" href="curriculum.php">Curriculum</a>
      <a class="<?= ($currentPage=='gallery.php')?'active':'' ?>" href="gallery.php">Gallery</a>
      <a class="<?= ($currentPage=='blogs.php')?'active':'' ?>" href="blogs.php">Blogs</a>
    </nav>

    

  </div>
</header>

<section class="content-section">
  <div class="container">

    

    <?php while($e = $events->fetch_assoc()): ?>

      <h3 class="text-center mt-5 mb-2">
        <?= $e['title'] ?>
      </h3>

      <?php if($e['description']): ?>
        <p class="text-center mb-3"><?= $e['description'] ?></p>
      <?php endif; ?>

      <?php
        $imgs = $conn->query(
          "SELECT * FROM gallery_images WHERE event_id=".$e['id']
        );
      ?>

      <div class="carousel slide carousel-fade event-slider"
           data-bs-ride="carousel" data-bs-interval="3500">

        <div class="carousel-inner">
          <?php $first=true; ?>
          <?php while($img = $imgs->fetch_assoc()): ?>
            <div class="carousel-item <?= $first?'active':'' ?>">
              <img src="admin/gallery/uploads/gallery/<?= $img['image'] ?>">
            </div>
            <?php $first=false; ?>
          <?php endwhile; ?>
        </div>

        <button class="carousel-control-prev" type="button"
                data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button"
                data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>

    <?php endwhile; ?>

  </div>
</section>



<footer class="site-footer">
  <div class="container">

    <div class="row">

      <!-- School Info -->
      <div class="col-md-4">
        <h5>Gopalkrishna Vidhyprasarak Saunstha</h5>
        <p>
          Sankhali – Goa<br>
          Providing quality education with values, discipline,
          and holistic development.
        </p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4">
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
      <div class="col-md-4">
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