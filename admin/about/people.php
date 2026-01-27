<?php
require "../includes/auth.php";
require "../includes/db.php";

// Fetch sections for dropdown
$sections = $conn->query("SELECT * FROM about_sections ORDER BY page, sort_order");

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section_id = $_POST['section_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../uploads/about/" . $imageName
        );
    }

    $stmt = $conn->prepare("
        INSERT INTO about_people (section_id, name, description, image)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("isss", $section_id, $name, $description, $imageName);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add People</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <h3>Add Management / Staff Member</h3>

  <form method="POST" enctype="multipart/form-data" class="card p-3 mb-4">

    <label class="mb-1">Category</label>
    <select name="section_id" class="form-select mb-3" required>
      <option value="">Select Section</option>
      <?php while ($s = $sections->fetch_assoc()): ?>
        <option value="<?= $s['id'] ?>">
          <?= ucfirst($s['page']) ?> — <?= $s['section_name'] ?>
        </option>
      <?php endwhile; ?>
    </select>

    <input type="text" name="name" class="form-control mb-2"
           placeholder="Person name" required>

    <textarea name="description" class="form-control mb-2"
              placeholder="Designation / Qualification"></textarea>

    <input type="file" name="image" class="form-control mb-2">

    <button class="btn btn-dark">Add Person</button>
  </form>
</div>

</body>
</html>
