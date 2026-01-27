<?php
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/db.php";

/* ADD EVENT */
if (isset($_POST['add_event'])) {
  $title = $_POST['title'];
  $desc  = $_POST['description'];

  $stmt = $conn->prepare(
    "INSERT INTO gallery_events (title, description) VALUES (?,?)"
  );
  $stmt->bind_param("ss", $title, $desc);
  $stmt->execute();
}

/* DELETE EVENT */
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $conn->query("DELETE FROM gallery_events WHERE id=$id");
}

/* FETCH EVENTS */
$events = $conn->query(
  "SELECT * FROM gallery_events ORDER BY sort_order, id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Gallery Events</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h3>Gallery Events</h3>

<!-- ADD EVENT FORM -->
<form method="POST" class="card p-3 mb-4">
  <input type="text" name="title" class="form-control mb-2"
         placeholder="Event title" required>

  <textarea name="description" class="form-control mb-2"
            placeholder="Event description (optional)"></textarea>

  <button name="add_event" class="btn btn-dark">Add Event</button>
</form>

<!-- EVENT LIST -->
<table class="table table-bordered">
  <tr>
    <th>Title</th>
    <th>Images</th>
    <th>Action</th>
  </tr>

  <?php while($e = $events->fetch_assoc()): ?>
    <tr>
      <td><?= $e['title'] ?></td>
      <td>
        <a class="btn btn-secondary btn-sm"
   href="/GVS/admin/gallery/images.php?event=<?= $e['id'] ?>">
   Manage Images
</a>


      </td>
      <td>
        <a href="dashboard.php?page=gallery_events&delete=<?= $e['id'] ?>"
   onclick="return confirm('Delete event?')"
   class="btn btn-sm btn-danger">
   Delete
</a>

      </td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
