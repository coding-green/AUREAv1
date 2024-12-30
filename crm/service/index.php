<?php
include 'database/config.php';
session_start();
  if (isset($_SESSION['user'])) {
      header("Location:dashboard.php");
      exit();
  }


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); 

    if (!empty($email) && !empty($password)) {
        // Prepare and bind statement to avoid SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verifying password using password_verify
            if ($row['user_role'] == "Sales & Service Admin" && $password == $row['user_password']) {
                $_SESSION['user'] = $row['user_email']; // or better store user ID
                header('Location: dashboard.php');
                exit();
            } else {
                echo "<script>alert('Invalid email or password.');</script>";
              

            }
        } else {
            echo "<script>alert('Invalid email or password.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GMD Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favi.jpg" />
    <link rel="stylesheet" href="assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="assets/css/backende209.css?v=1.0.0">
    <link rel="stylesheet" href="assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/remixicon/fonts/remixicon.css">
</head>
<body>
    <div id="loading" style="display: width: 100%; height: 100%; position: fixed; z-index: 999999; background: #fff; opacity: 0.7;">
        <div id="loading-center"></div>
    </div>
    <div class="wrapper">
        <section class="login-content">
            <div class="container">
                <div class="row align-items-center justify-content-center height-self-center">
                    <div class="col-lg-8">
                        <div class="card auth-card">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center auth-content">
                                    <div class="col-lg-7 align-self-center">
                                        <div class="p-3">
                                            <img src="assets/images/logo-d.png" class="img-fluid rounded-normal" alt="">
                                            <h2 class="mb-2">Login</h2>
                                            <p>Login to stay connected.</p>
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="email" placeholder=" " name="email" required>
                                                            <label>Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="password" placeholder="" name="password" required>
                                                            <label>Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" name="login" class="btn btn-primary">Login</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 content-right">
                                        <img src="assets/images/login/01.png" class="img-fluid image-right" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Backend Bundle JavaScript -->
    <script src="assets/js/backend-bundle.min.js"></script>
    <!-- Table Treeview JavaScript -->
    <script src="assets/js/table-treeview.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="assets/js/customizer.js"></script>
    <!-- Chart Custom JavaScript -->
    <script async src="assets/js/chart-custom.js"></script>
    <!-- app JavaScript -->
    <script src="assets/js/app.js"></script>
</body>
</html>
