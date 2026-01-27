<?php
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";

$id = (int)$_GET['id'];

/* FETCH BLOG */
$blog = $conn->query("SELECT * FROM blogs WHERE id=$id")->fetch_assoc();

if (!$blog) {
  die("Blog not found");
}

/* UPDATE BLOG */
if (isset($_POST['update_blog'])) {
  $title = $_POST['title'];
  $desc  = $_POST['description'];

  $img = $blog['image'];

  if (!empty($_FILES['image']['name'])) {
    $img = time() . "_" . basename($_FILES['image']['name']);
    move_uploaded_file(
      $_FILES['image']['tmp_name'],
      __DIR__ . "/uploads/blogs/" . $img
    );
  }

  $stmt = $conn->prepare(
    "UPDATE blogs SET title=?, description=?, image=? WHERE id=?"
  );
  $stmt->bind_param("sssi", $title, $desc, $img, $id);
  $stmt->execute();

  header("Location: blog.php");
  exit;
}
?>

<?php include "../includes/header.php"; ?>

<h3 class="mb-3">Edit Blog</h3>

<form method="POST" enctype="multipart/form-data" class="card p-3">
  <input class="form-control mb-2"
         name="title"
         value="<?= htmlspecialchars($blog['title']) ?>"
         required>

  <textarea class="form-control mb-2"
            name="description"
            id="editor"><?= htmlspecialchars($blog['description']) ?></textarea>

  <?php if ($blog['image']): ?>
    <img src="/GVS/admin/blogs/uploads/blogs/<?= $blog['image'] ?>"
         width="120"
         class="mb-2">
  <?php endif; ?>

  <input type="file" class="form-control mb-2" name="image">

  <button name="update_blog" class="btn btn-dark">Update Blog</button>
  <a href="blog.php" class="btn btn-secondary mt-2">Cancel</a>
</form>

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
  .create(document.querySelector('#editor'))
  .catch(error => console.error(error));
</script>

<?php include "../includes/footer.php"; ?>
