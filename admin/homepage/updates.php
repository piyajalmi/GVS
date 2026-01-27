<?php

require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';


/* ===== FETCH UPDATE FOR EDIT ===== */
$editData = null;

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM updates WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}
/* ===== UPDATE UPDATE ===== */
if (isset($_POST['update_id'])) {
    $id = (int)$_POST['update_id'];
    $title = $_POST['title'];

    // keep old file by default
    $fileName = $_POST['old_file'];

    // if new file uploaded
    if (!empty($_FILES['file']['name'])) {
        $fileName = time() . "_" . $_FILES['file']['name'];
        move_uploaded_file(
            $_FILES['file']['tmp_name'],
            "../uploads/updates/" . $fileName
        );

        // remove old file
        if (!empty($_POST['old_file'])) {
            $oldPath = "../uploads/updates/" . $_POST['old_file'];
            if (file_exists($oldPath)) unlink($oldPath);
        }
    }

    $stmt = $conn->prepare(
        "UPDATE updates SET title = ?, file = ? WHERE id = ?"
    );
    $stmt->bind_param("ssi", $title, $fileName, $id);
    $stmt->execute();

    header("Location: /GVS/admin/dashboard.php?page=updates");
exit;

}

/* ===== DELETE UPDATE ===== */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // first get file name (optional but clean)
    $stmt = $conn->prepare("SELECT file FROM updates WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    // delete file from folder
    if ($row && $row['file']) {
        $filePath = "../uploads/updates/" . $row['file'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // delete DB record
    $stmt = $conn->prepare("DELETE FROM updates WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

   header("Location: /GVS/admin/dashboard.php?page=updates");
exit;

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];

    $fileName = null;
    if (!empty($_FILES['file']['name'])) {
        $fileName = time()."_".$_FILES['file']['name'];
    $uploadPath = __DIR__ . '/../uploads/updates/' . $fileName;
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath);
    }

    $stmt = $conn->prepare("INSERT INTO updates (title, file) VALUES (?,?)");
    $stmt->bind_param("ss", $title, $fileName);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Homepage Updates</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <h3>Homepage Updates</h3>

  <form method="POST" enctype="multipart/form-data" class="card p-3 mb-4">

  <?php if ($editData): ?>
    <h5>Edit Update</h5>
    <input type="hidden" name="update_id" value="<?= $editData['id'] ?>">
    <input type="hidden" name="old_file" value="<?= $editData['file'] ?>">
  <?php else: ?>
    <h5>Add Update</h5>
  <?php endif; ?>

  <input
    type="text"
    name="title"
    class="form-control mb-2"
    placeholder="Update title"
    value="<?= $editData['title'] ?? '' ?>"
    required
  >

  <input type="file" name="file" class="form-control mb-2">

  <?php if ($editData && $editData['file']): ?>
    <small>
      Current file:
      <a href="/GVS/admin/uploads/updates/<?= $editData['file'] ?>" target="_blank">
        View
      </a>
    </small>
  <?php endif; ?>

  <button class="btn btn-dark mt-3">
    <?= $editData ? 'Update' : 'Add' ?>
  </button>

  <?php if ($editData): ?>
    <a href="../dashboard.php?page=updates"
   class="btn btn-secondary mt-2">
   Cancel
</a>

  <?php endif; ?>

</form>

  <?php
$result = $conn->query("SELECT * FROM updates ORDER BY created_at DESC");
?>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Title</th>
      <th>File</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td>
          <?php if ($row['file']): ?>
            <a href="/GVS/admin/uploads/updates/<?= $row['file'] ?>" target="_blank">
              View File
            </a>
          <?php else: ?>
            —
          <?php endif; ?>
        </td>
        <td>
 <a href="/GVS/admin/dashboard.php?page=updates&edit=<?= $row['id'] ?>"
   class="btn btn-warning btn-sm">
   Edit
</a>



<a href="/GVS/admin/dashboard.php?page=updates&delete=<?= $row['id'] ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this update?')">
   Delete
</a>


</td>

      </tr>
    <?php endwhile; ?>
  </tbody>
</table>


  

</div>
</body>
</html>
