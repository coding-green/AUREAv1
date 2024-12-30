<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location:index.php");
    exit();
}
$sql = "SELECT * FROM users WHERE user_email = '" . $_SESSION['user'] . "'";
$resultuser = mysqli_query($conn, $sql);
$rowuser = mysqli_fetch_assoc($resultuser);

?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>AureaBliss CRM</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" href="assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="assets/css/backende209.css?v=1.0.0">
    <link rel="stylesheet" href="assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/remixicon/fonts/remixicon.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS (make sure this is included for modal functionality) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Optional: Include Popper.js if you're using Bootstrap 4. This is required for some Bootstrap components like modals -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>



</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

        <div class="iq-sidebar  sidebar-default ">
            <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
                <a href="dashboard.php" class="header-logo">
                    <img src="assets/images/icon.png" class="img-fluid rounded-normal light-logo" alt="logo">
                    &nbsp;
                    <h6><b>AUREA</b>/CRM</h6>
                </a>
                <div class="iq-menu-bt-sidebar ml-0">
                    <i class="las la-bars wrapper-menu"></i>
                </div>
            </div>
            <div class="data-scrollbar" data-scroll="1">
                <nav class="iq-sidebar-menu">
                    <?php
                    $current_page = basename($_SERVER['PHP_SELF']);
                    ?>
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                            <a href="dashboard.php" class="svg-icon">
                                <svg class="svg-icon" id="p-dash1" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                    </path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                                <span class="ml-4">Dashboards</span>
                            </a>
                        </li>
                        <li class="<?php echo $current_page == 'categorys.php' ? 'active' : ''; ?>">
                            <a href="categorys.php">
                                <svg  class="svg-icon" id="p-dash5" width="20" height="20"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 3h18v18H3z"></path>
                                <path d="M3 9h18"></path>
                                <path d="M9 21V9"></path>
                                </svg>
                                <span class="ml-4">Category's</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="#product" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <svg class="svg-icon" id="p-dash3" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                                <span class="ml-4">Products</span>
                                <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="10 15 15 20 20 15"></polyline>
                                    <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                                </svg>
                            </a>
                            <ul id="product" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li class="<?php echo $current_page == 'products.php' ? 'active' : ''; ?>">
                                    <a href="products.php">
                                        <i class="las la-arrow-right"></i><span>Products</span>
                                    </a>
                                </li>
                                <li class="<?php echo $current_page == 'tools.php' ? 'active' : ''; ?>">
                                    <a href="tools.php">
                                        <i class="las la-arrow-right"></i><span>Beauty Tools</span>
                                    </a>
                                </li>
                                <li class="<?php echo $current_page == 'reels.php' ? 'active' : ''; ?>">
                                    <a href="reels.php">
                                        <i class="las la-arrow-right"></i><span>Reels</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php echo $current_page == 'members.php' ? 'active' : ''; ?>">
                            <a href="members.php">
                                <svg class="svg-icon" id="p-dash4" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12c0 5.52 4.48 10 10 10s10-4.48 10-10c0-5.52-4.48-10-10-10z">
                                    </path>
                                    <path
                                        d="M8.21 13.89c-1.23 1.23-3.22 1.23-4.45 0s-1.23-3.22 0-4.45 3.22-1.23 4.45 0 1.23 3.22 0 4.45z">
                                    </path>
                                    <path
                                        d="M19.78 10.61c1.23-1.23 1.23-3.22 0-4.45s-3.22-1.23-4.45 0-1.23 3.22 0 4.45 3.22 1.23 4.45 0z">
                                    </path>
                                </svg>
                                <span class="ml-4">Members</span>
                            </a>
                        </li>
                        <li class="<?php echo $current_page == 'orders.php' ? 'active' : ''; ?>">
                            <a href="orders.php">
                            <svg class="svg-icon" id="p-dash2" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <span class="ml-4">Orders</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="logout.php">
                                <svg class="svg-icon" id="p-dash8" width="20" height="20"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                </svg>
                                <span class="ml-4">Logout</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="p-3"></div>
            </div>
        </div>
        <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                    <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                        <i class="ri-menu-line wrapper-menu"></i>
                        <a href="dashboard.php" class="header-logo">
                            <img src="aurea.png" class="img-fluid rounded-normal" alt="logo">
                        </a>
                        <h6 class="logo-title ml-3">Welcome</h6>
                    </div>
                </nav>
            </div>
        </div>