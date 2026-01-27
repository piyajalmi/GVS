<?php
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";

/* FETCH SECTIONS */
$sections = $conn->query("SELECT * FROM about_sections ORDER BY page, sort_order");

/* FETCH PERSON FOR EDIT */
$editPerson = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = $conn->query("SELECT * FROM about_people WHERE id=$id");
    $editPerson = $res->fetch_assoc();
}

/* ADD / UPDATE PERSON */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section_id  = $_POST['section_id'];
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $imageName   = $_POST['old_image'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            __DIR__ . "/../uploads/about/" . $imageName
        );
    }

    if (!empty($_POST['person_id'])) {
        // UPDATE
        $id = (int)$_POST['person_id'];
        $stmt = $conn->prepare(
            "UPDATE about_people SET section_id=?, name=?, description=?, image=? WHERE id=?"
        );
        $stmt->bind_param("isssi", $section_id, $name, $description, $imageName, $id);
        $stmt->execute();
    } else {
        // INSERT
        $stmt = $conn->prepare(
            "INSERT INTO about_people (section_id, name, description, image)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("isss", $section_id, $name, $description, $imageName);
        $stmt->execute();
    }

   header("Location: dashboard.php?page=about_people");
exit;

}

/* DELETE PERSON */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $img = $conn->query("SELECT image FROM about_people WHERE id=$id")->fetch_assoc();
    if ($img && $img['image']) {
        @unlink(__DIR__ . "/../uploads/about/" . $img['image']);
    }

    $conn->query("DELETE FROM about_people WHERE id=$id");
   header("Location: dashboard.php?page=about_people");
exit;

}

/* FETCH ALL PEOPLE */
$people = $conn->query("
    SELECT ap.*, s.section_name
    FROM about_people ap
    JOIN about_sections s ON s.id = ap.section_id
    ORDER BY ap.id DESC
");
?>

<div class="container mt-3">

<h3><?= $editPerson ? "Edit Member" : "Add Management / Staff Member" ?></h3>

<form method="POST" enctype="multipart/form-data" class="card p-3 mb-4">

<input type="hidden" name="person_id" value="<?= $editPerson['id'] ?? '' ?>">
<input type="hidden" name="old_image" value="<?= $editPerson['image'] ?? '' ?>">

<select name="section_id" class="form-select mb-2" required>
  <option value="">Select Section</option>
  <?php while ($s = $sections->fetch_assoc()): ?>
    <option value="<?= $s['id'] ?>"
      <?= ($editPerson && $editPerson['section_id'] == $s['id']) ? 'selected' : '' ?>>
      <?= $s['section_name'] ?>
    </option>
  <?php endwhile; ?>
</select>

<input type="text" name="name" class="form-control mb-2"
       placeholder="Person name"
       value="<?= $editPerson['name'] ?? '' ?>" required>

<textarea name="description" class="form-control mb-2"
          placeholder="Designation / Qualification"><?= $editPerson['description'] ?? '' ?></textarea>

<input type="file" name="image" class="form-control mb-2">

<?php if ($editPerson && $editPerson['image']): ?>
  <img src="/GVS/admin/uploads/about/<?= $editPerson['image'] ?>"
       width="80" class="mb-2">
<?php endif; ?>

<button class="btn btn-dark">
  <?= $editPerson ? "Update Member" : "Add Member" ?>
</button>

<?php if ($editPerson): ?>
  <a href="../dashboard.php?page=about_people" class="btn btn-secondary mt-2">Cancel</a>
<?php endif; ?>

</form>

<table class="table table-bordered">
<thead>
<tr>
  <th>Name</th>
  <th>Section</th>
  <th>Image</th>
  <th>Action</th>
</tr>
</thead>
<tbody>

<?php while ($p = $people->fetch_assoc()): ?>
<tr>
  <td><?= htmlspecialchars($p['name']) ?></td>
  <td><?= $p['section_name'] ?></td>
  <td>
    <?php if ($p['image']): ?>
      <img src="/GVS/admin/uploads/about/<?= $p['image'] ?>" width="50">
    <?php endif; ?>
  </td>
  <td>
    <a href="dashboard.php?page=about_people&edit=<?= $p['id'] ?>"
       class="btn btn-sm btn-warning">Edit</a>

   <a href="dashboard.php?page=about_people&delete=<?= $p['id'] ?>"
   onclick="return confirm('Delete this member?')"
   class="btn btn-sm btn-danger">
   Delete
</a>
  </td>
</tr>
<?php endwhile; ?>

</tbody>
</table>

</div>
