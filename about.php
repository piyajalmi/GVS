<?php
$currentPage = basename($_SERVER['PHP_SELF']);
require "admin/includes/db.php";

$managementSections = $conn->query("
  SELECT * FROM about_sections
  WHERE page='management'
  ORDER BY sort_order
");

// STAFF SECTIONS
$staffSections = $conn->query("
  SELECT * FROM about_sections
  WHERE page='staff'
  ORDER BY sort_order
");

// Prepare people query ONCE
$peopleStmt = $conn->prepare("
  SELECT * FROM about_people
  WHERE section_id=?
  ORDER BY sort_order
");
?>
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About | Gopalkrishna Vidhyprasarak Saunstha</title>

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
<body >

  <!-- ===== HEADER ===== -->
 <!-- ===== HEADER ===== -->
<header class="header">
<div class="page-banner"></div>

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


<section class="content-section reveal">
  <div class="container">

    <h2 class="text-center mb-4">Saunstha & School History</h2>

    <p class="text-center mx-auto" style="max-width: 900px;">
      Gopalkrishna Vidhyprasarak Saunstha was established in the year 2006
      with the vision of providing quality education to the local community
      of Sankhali and surrounding areas. Since its inception, the institution
      has steadily grown through dedication, community support, and academic
      excellence.
    </p>

  </div>
</section>
<section class="content-section light-bg">
  <div class="container">

    <div class="history-timeline">

      <div class="history-item">
        <h5>2006 – Foundation</h5>
        <p>
          The Gopalkrishna Vidhyprasarak Saunstha was established under the
          guidance of Late Shri Shriram G. Kanekar. The primary objective
          was to establish an educational institute that would impart
          quality education to local students.
        </p>
      </div>

      <div class="history-item">
        <h5>Early Growth</h5>
        <p>
          The journey began with Shishuvatika (nursery) classes.
          Due to positive response from parents and increasing demand,
          LKG and UKG classes were introduced. The pre-primary section
          soon grew to more than 80 students.
        </p>
      </div>

      <div class="history-item">
        <h5>2011 – Primary Section</h5>
        <p>
          In 2011, the Saunstha was formally registered. Permission was
          granted to start the Primary section in Marathi medium.
          STD I classes commenced and expanded year after year.
        </p>
      </div>

      <div class="history-item">
        <h5>Academic Excellence & Activities</h5>
        <p>
          Students actively participated in school, inter-school,
          taluka, and state-level competitions. Achievements in drawing,
          singing, dance, and drama brought recognition to the institution.
        </p>
      </div>

      <div class="history-item">
        <h5>2020–21 – Secondary Section</h5>
        <p>
          With growing demand from parents, approval was received to
          commence STD V and secondary section in English medium.
          Even during the pandemic, online classes ensured continuity
          of learning.
        </p>
      </div>

      <div class="history-item">
        <h5>Present Day</h5>
        <p>
          Today, the institution operates nursery, pre-primary, primary,
          and secondary sections. Plans are underway to expand up to
          STD X, continuing the mission of quality education.
        </p>
      </div>

    </div>

  </div>
</section>
<section class="content-section pt-0">
  <div class="container text-end" style="max-width: 900px;">

    <p >
      <strong>Mr. Prabhakar N. Kanekar</strong><br>
      Life Member, Gopalkrishna Vidhyprasarak Saunstha
    </p>

  </div>
</section>


<section class="content-section light-bg">
  <div class="container">
    <div class="row text-center">

      <div class="col-md-6 mb-4">
        <div class="vm-card">
          <h3>Our Vision</h3>
          <p>
            To nurture knowledgeable, responsible, and ethical individuals
            through quality education and holistic development.
          </p>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="vm-card reveal">
          <h3>Our Mission</h3>
          <p>
            To provide a learner-centric environment that promotes academic
            excellence, character building, and lifelong learning.
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="content-section light-bg">
  <div class="container">
    <h2 class="text-center mb-5">Management & Committees</h2>

    <?php while ($sec = $managementSections->fetch_assoc()): ?>
  <div class="accordion-item mb-3">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button"
              data-bs-toggle="collapse"
              data-bs-target="#section<?= $sec['id'] ?>">
        <?= $sec['section_name'] ?>
      </button>
    </h2>

    <div id="section<?= $sec['id'] ?>" class="accordion-collapse collapse">
      <div class="accordion-body">

        <?php
          $peopleStmt->bind_param("i", $sec['id']);
          $peopleStmt->execute();
          $people = $peopleStmt->get_result();
        ?>

        <?php while ($p = $people->fetch_assoc()): ?>
          <div class="d-flex gap-3 mb-3 align-items-start">

            <?php if (!empty($p['image'])): ?>
              <img src="/GVS/admin/uploads/about/<?= $p['image'] ?>"
     style="width:60px;height:60px;object-fit:cover;border-radius:50%;">

            <?php endif; ?>

            <div>
              <strong><?= $p['name'] ?></strong><br>
              <?= $p['description'] ?>
            </div>

          </div>
        <?php endwhile; ?>

      </div>
    </div>
  </div>
<?php endwhile; ?>

  </div>
</section>







<section class="content-section">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-md-4 text-center mb-3">
        <img src="assets/images/chairperson.jpg"
             class="img-fluid rounded"
             alt="Chairperson">
      </div>

      <div class="col-md-8">
        <h2>Chairperson’s Desk</h2>
        <p>
          Education plays a vital role in shaping the future of society.
          At Gopalkrishna Vidhyprasarak Saunstha, we are committed to
          creating an environment where students are encouraged to grow
          intellectually, morally, and socially.
        </p>
        <p>
          We believe in nurturing curiosity, discipline, and confidence
          to help students become responsible citizens of tomorrow.
        </p>
        <p><strong>— Chairperson</strong></p>
      </div>

    </div>
  </div>
</section>
<section class="content-section light-bg">
  <div class="container">
    <h2 class="text-center mb-4">Our Staff</h2>

    <div class="accordion staff-accordion" id="staffAccordion">

      <!-- Pre-Primary -->
      <?php while ($sec = $staffSections->fetch_assoc()): ?>
  <div class="accordion-item mb-3">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button"
              data-bs-toggle="collapse"
              data-bs-target="#staff<?= $sec['id'] ?>">
        <?= $sec['section_name'] ?>
      </button>
    </h2>

    <div id="staff<?= $sec['id'] ?>" class="accordion-collapse collapse">
      <div class="accordion-body">

        <?php
          $peopleStmt->bind_param("i", $sec['id']);
          $peopleStmt->execute();
          $people = $peopleStmt->get_result();
        ?>

        <?php while ($p = $people->fetch_assoc()): ?>
          <div class="d-flex gap-3 mb-3 align-items-start">

            <?php if (!empty($p['image'])): ?>
              <img src="/GVS/admin/uploads/about/<?= $p['image'] ?>"
     style="width:60px;height:60px;object-fit:cover;border-radius:50%;">

            <?php endif; ?>

            <div>
              <strong><?= $p['name'] ?></strong><br>
              <?= $p['description'] ?>
            </div>

          </div>
        <?php endwhile; ?>

      </div>
    </div>
  </div>
<?php endwhile; ?>

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