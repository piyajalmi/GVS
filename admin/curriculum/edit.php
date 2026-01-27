<?php
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";

$id = (int)$_GET['id'];
$section = $conn->query("SELECT * FROM curriculum_sections WHERE id=$id")->fetch_assoc();

if (!$section) die("Not found");

if (isset($_POST['update'])) {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $image = $section['image'];
  $doc = $section['document'];

  if (!empty($_FILES['image']['name'])) {
    $image = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],
      __DIR__ . "/../uploads/curriculum/images/" . $image);
  }

  if (!empty($_FILES['document']['name'])) {
    $doc = time() . "_" . $_FILES['document']['name'];
    move_uploaded_file($_FILES['document']['tmp_name'],
      __DIR__ . "/../uploads/curriculum/docs/" . $doc);
  }

  $stmt = $conn->prepare(
    "UPDATE curriculum_sections
     SET title=?, content=?, image=?, document=?
     WHERE id=?"
  );
  $stmt->bind_param("ssssi", $title, $content, $image, $doc, $id);
  $stmt->execute();

 header("Location: /GVS/admin//dashboard.php?page=curriculum");
exit;


}
?>

<h3>Edit Curriculum</h3>

<form method="POST" enctype="multipart/form-data" class="card p-3">
  <input name="title" class="form-control mb-2"
         value="<?= htmlspecialchars($section['title']) ?>">

  <textarea name="content" id="editor"><?= htmlspecialchars($section['content']) ?></textarea>

  <input type="file" name="image" class="form-control mb-2">
  <input type="file" name="document" class="form-control mb-2">

  <button name="update" class="btn btn-dark">Update</button>
  <a href="../dashboard.php?page=curriculum" class="btn btn-secondary">
  Close
</a>

</form>

<script src="https://cdn.ckeditor.com/ckeditor5/41.3.0/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor'));
</script>
