<?php
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM curriculum_sections WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: /GVS/admin//dashboard.php?page=curriculum");
exit;

}
/* ADD SECTION */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $order = (int)$_POST['sort_order'];

  $image = null;
  $doc = null;

  if (!empty($_FILES['image']['name'])) {
    $image = time() . "_" . basename($_FILES['image']['name']);
    move_uploaded_file(
      $_FILES['image']['tmp_name'],
      __DIR__ . "/../uploads/curriculum/images/" . $image
    );
  }

  if (!empty($_FILES['document']['name'])) {
    $doc = time() . "_" . basename($_FILES['document']['name']);
    move_uploaded_file(
      $_FILES['document']['tmp_name'],
      __DIR__ . "/../uploads/curriculum/docs/" . $doc
    );
  }

  $stmt = $conn->prepare(
    "INSERT INTO curriculum_sections
     (title, content, image, document, sort_order)
     VALUES (?,?,?,?,?)"
  );
  $stmt->bind_param("ssssi", $title, $content, $image, $doc, $order);
  $stmt->execute();
}

$sections = $conn->query(
  "SELECT * FROM curriculum_sections ORDER BY sort_order"
);
?>

<h3>Curriculum Sections</h3>

<form method="POST" enctype="multipart/form-data" class="card p-3 mb-4">
  <input name="title" class="form-control mb-2"
         placeholder="Section Title" required>

  <textarea name="content" id="editor"
            class="form-control mb-2"></textarea>

  <input type="file" name="image" class="form-control mb-2">
  <input type="file" name="document" class="form-control mb-2">

  <input type="number" name="sort_order"
         class="form-control mb-2"
         placeholder="Sort order">

  <button class="btn btn-dark">Add Section</button>
</form>

<table class="table table-bordered">
  <tr>
    <th>Title</th>
    <th>Image</th>
    <th>Document</th>
    <th>Action</th>
  </tr>

  <?php while ($c = $sections->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($c['title']) ?></td>
      <td><?= $c['image'] ? 'Yes' : '—' ?></td>
      <td><?= $c['document'] ? 'Yes' : '—' ?></td>
      <td>
       <a href="/GVS/admin/dashboard.php?page=curriculum_edit&id=<?= $c['id'] ?>"
   class="btn btn-sm btn-warning">
   Edit
</a>



     <a href="/GVS/admin/dashboard.php?page=curriculum&delete=<?= $c['id'] ?>"
   onclick="return confirm('Delete this section?')"
   class="btn btn-sm btn-danger">
   Delete
</a>

</a>


      </td>
    </tr>
  <?php endwhile; ?>
</table>

<script src="https://cdn.ckeditor.com/ckeditor5/41.3.0/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor'));
</script>
