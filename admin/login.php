<?php
session_start();
require __DIR__ . '/includes/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();


   if ($admin && password_verify($password, $admin['password'])) {
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_email'] = $admin['email'];
    header("Location: dashboard.php");
    exit;
}
 else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f6f2e8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Inter', sans-serif;
    }
    .login-card {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      width: 100%;
      max-width: 380px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .login-card h3 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: 700;
      color: #1e1e38;
    }
    .btn-primary {
      background: #1e1e38;
      border: none;
    }
  </style>
</head>
<body>

<div class="login-card">
  <h3>Admin Login</h3>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button class="btn btn-primary w-100">Login</button>
  </form>
</div>

</body>
</html>
