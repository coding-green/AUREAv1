<?php
include 'config.php';
session_start();

if (isset($_SESSION['user'])) {
    header("Location:dashboard.php");
    exit();
}

$message = ""; // Variable to store messages

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
            if ($password == $row['user_password']) {
                $_SESSION['user'] = $row['user_email']; // or better store user ID
                $message = "<div style='color: green; text-align: center;'>Login successful! Redirecting to dashboard...</div>";
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'dashboard.php';
                        }, 3000);
                      </script>";
            } else {
                $message = "<div style='color: red; text-align: center;'>Invalid email or password.</div>";
            }
        } else {
            $message = "<div style='color: red; text-align: center;'>Invalid email or password.</div>";
        }

        $stmt->close();
    } else {
        $message = "<div style='color: red; text-align: center;'>All fields are required.</div>";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kirti - CRM</title>
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
    <div class="wrapper">
        <section class="login-content">
            <div class="container">
                <div class="row align-items-center justify-content-center height-self-center">
                    <div class="col-lg-4">
                        <div class="card auth-card">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center">
                                    <div class="col-lg-12 align-self-center text-center">
                                        <div class="p-3">
                                            <img src="assets/images/logo.png" class="img-fluid rounded-normal" alt=""
                                                style="width: 300px; padding-bottom: 10px; padding-top: 30px;">
                                            <h2>Admin Panel</h2>
                                            <p>Login to manage your account</p>
                                            <!-- Display message -->
                                            <?php echo $message; ?>
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="email"
                                                                placeholder=" " name="email" required>
                                                            <label>Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input class="floating-input form-control" type="password"
                                                                placeholder="" name="password" required>    
                                                            <label>Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" name="login"
                                                    class="btn btn-primary btn-block btn-login">Login</button>
                                            </form>
                                        </div>
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