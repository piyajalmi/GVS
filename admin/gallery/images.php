<?php
require "../includes/auth.php";
require "../includes/db.php";

$event_id = (int)$_GET['event'];

/* UPLOAD IMAGE */
if (isset($_POST['upload'])) {
  $img = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];

  if ($img) {
    $name = time()."_".$img;
    move_uploaded_file($tmp, "uploads/gallery/".$name);

    $stmt = $conn->prepare(
      "INSERT INTO gallery_images (event_id, image) VALUES (?,?)"
    );
    $stmt->bind_param("is", $event_id, $name);
    $stmt->execute();
  }
}

/* DELETE IMAGE */
if (isset($_GET['delimg'])) {
  $id = (int)$_GET['delimg'];
  $conn->query("DELETE FROM gallery_images WHERE id=$id");
}

$images = $conn->query(
  "SELECT * FROM gallery_images WHERE event_id=$event_id"
);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Gallery Images</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h4>Event Images</h4>

<form method="POST" enctype="multipart/form-data" class="mb-3">
  <input type="file" name="image" required>
  <button name="upload" class="btn btn-dark btn-sm">Upload</button>
</form>

<div class="row">
<?php while($i = $images->fetch_assoc()): ?>
  <div class="col-md-3 mb-3 text-center">
    <img src="uploads/gallery/<?= $i['image'] ?>"
         class="img-fluid rounded mb-2">
    <br>
    <a href="?event=<?= $event_id ?>&delimg=<?= $i['id'] ?>"
       class="btn btn-sm btn-danger">Delete</a>
  </div>
<?php endwhile; ?>
</div>

</body>
</html>
