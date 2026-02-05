<?php
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";

/* ADD BLOG */
if (isset($_POST['add_blog'])) {
  $title = $_POST['title'];
  $desc  = $_POST['description'];

  $img = null;
  if (!empty($_FILES['image']['name'])) {
    $img = time() . "_" . basename($_FILES['image']['name']);
    move_uploaded_file(
      $_FILES['image']['tmp_name'],
      __DIR__ . "/uploads/blogs/" . $img
    );
  }

  $stmt = $conn->prepare(
    "INSERT INTO blogs (title, description, image) VALUES (?,?,?)"
  );
  $stmt->bind_param("sss", $title, $desc, $img);
  $stmt->execute();

  header("Location: blogs.php");
  exit;
}

/* DELETE BLOG */
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $conn->query("DELETE FROM blogs WHERE id=$id");
  header("Location: blogs.php");
  exit;
}

/* FETCH BLOGS */
$blogs = $conn->query("SELECT * FROM blogs ORDER BY id DESC");
?>



<h3 class="mb-3">Blogs</h3>


<!-- ADD BLOG FORM -->
<form method="POST" enctype="multipart/form-data" class="card p-3 mb-4">
  <input class="form-control mb-2" name="title" placeholder="Blog title" required>

  <textarea class="form-control mb-2"
            name="description"
            id="editor"
            placeholder="Blog content"></textarea>

  <input type="file" class="form-control mb-2" name="image">

  <button name="add_blog" class="btn btn-dark">Add Blog</button>
</form>

<!-- BLOG LIST -->
<table class="table table-bordered">
  <tr>
    <th>Title</th>
    <th>Image</th>
    <th>Action</th>
  </tr>

  <?php while($b = $blogs->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($b['title']) ?></td>
      <td>
        <?php if($b['image']): ?>
          <img src="/GVS/admin/blogs/uploads/blogs/<?= $b['image'] ?>" width="80">
        <?php endif; ?>
      </td>
      <td>
        <a href="edit.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-warning">
          Edit
        </a>
        <a href="?delete=<?= $b['id'] ?>"
           class="btn btn-sm btn-danger"
           onclick="return confirm('Delete blog?')">
          Delete
        </a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
  .create(document.querySelector('#editor'))
  .catch(error => console.error(error));
</script>


