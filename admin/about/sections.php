<?php
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";

/* EDIT SECTION */
$edit = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $edit = $conn->query("SELECT * FROM about_sections WHERE id=$id")->fetch_assoc();
}

/* ADD / UPDATE */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['section_name'];
    $page = $_POST['page'];

    if (!empty($_POST['section_id'])) {
        $id = (int)$_POST['section_id'];
        $stmt = $conn->prepare(
            "UPDATE about_sections SET section_name=?, page=? WHERE id=?"
        );
        $stmt->bind_param("ssi", $name, $page, $id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO about_sections (section_name, page) VALUES (?,?)"
        );
        $stmt->bind_param("ss", $name, $page);
        $stmt->execute();
    }

    header("Location: dashboard.php?page=about_sections");
exit;

}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM about_sections WHERE id=$id");
    header("Location: dashboard.php?page=about_sections");
exit;

}

$sections = $conn->query("SELECT * FROM about_sections ORDER BY id DESC");
?>

<div class="container mt-3">

<h3>Management Sections</h3>

<form method="POST" class="card p-3 mb-4">
<input type="hidden" name="section_id" value="<?= $edit['id'] ?? '' ?>">

<input type="text" name="section_name" class="form-control mb-2"
       placeholder="Section name"
       value="<?= $edit['section_name'] ?? '' ?>" required>

<select name="page" class="form-select mb-2">
  <option value="management">Management</option>
  <option value="staff">Staff</option>
</select>

<button class="btn btn-dark">
  <?= $edit ? "Update Section" : "Add Section" ?>
</button>

<?php if ($edit): ?>
  <a href="../dashboard.php?page=about_sections"
     class="btn btn-secondary mt-2">Cancel</a>
<?php endif; ?>
</form>

<table class="table table-bordered">
<tr>
  <th>Name</th>
  <th>Page</th>
  <th>Action</th>
</tr>

<?php while ($s = $sections->fetch_assoc()): ?>
<tr>
  <td><?= htmlspecialchars($s['section_name']) ?></td>
  <td><?= ucfirst($s['page']) ?></td>
  <td>
    <a href="dashboard.php?page=about_sections&edit=<?= $s['id'] ?>"
       class="btn btn-sm btn-warning">
       Edit
    </a>

    <a href="dashboard.php?page=about_sections&delete=<?= $s['id'] ?>"
       class="btn btn-sm btn-danger"
       onclick="return confirm('Delete this section?')">
       Delete
    </a>
  </td>
</tr>
<?php endwhile; ?>

</table>

</div>
