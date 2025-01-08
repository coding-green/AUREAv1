<?php
session_start();
include_once("config.php");
if (isset($_SESSION["user_email"])) {
    $link = "onclick = \"window.location.href='auth/account'\"";
} else {
    $link = 'data-bs-target="#popup-auth-product-view"';
}
if (isset($_SESSION["user_id"])) {
    $id = $_SESSION["user_id"];
    $query = "SELECT COUNT(*) as cart_count FROM cart WHERE user_id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($cart_count);
        $stmt->fetch();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- swiper link -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <!-- fancybox link -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
    <!-- Animation link -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <!-- Bootstrap link -->
    <link rel="stylesheet" href="assets/css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- boxicon link -->
    <link rel="stylesheet" href="assets/css/boxicons.min.css">
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- My css link -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- TrustBox script -->
<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
<!-- End TrustBox script -->
    <title>Aurea Bliss</title>
    <link rel="icon" href="assets/image/icon/favi.png" type="image/gif" sizes="20x20">
    <style>
       #img1,
        #img2 {
            width: 50px;
            height: 50px;
            object-fit: cover;
            position: relative;
            z-index: 100;
        }

        .loader {
            position: absolute;
            border: 4px solid transparent;
            border-top: 4px solid #F1B968;
            border-radius: 50%;
            width: 55px;
            height: 55px;
            animation: spin 1s linear infinite;
            right: -3px;
            bottom: 0px;
            z-index: 10;
        }

        .hidden {
            display: none;
        }

        #loader-overlay {
            position: fixed;
            width: 50px;
            height: 50px;
            left: 48vw;
            z-index: 1000;
            top: 48vh;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div id="loader-overlay">
        <img id="img1" src="assets/image/icon/logo-loading.png" alt="Image 1" />
        <img id="img2" src="assets/image/icon/1.svg" alt="Image 2" class="hidden" />
        <div class="loader hidden"></div>
    </div>

    <script>
        const img1 = document.getElementById("img1");
        const img2 = document.getElementById("img2");
        const loader = document.querySelector(".loader");
        const loader_overlay = document.querySelector("#loader-overlay");

        // At 0.8 seconds, show img2 and loader
        setTimeout(() => {
            img1.classList.add("hidden");
            img2.classList.remove("hidden");
            loader.classList.remove("hidden");
        }, 800);

        // At 3 seconds, show img1 again and hide the loader
        setTimeout(() => {
            img2.classList.add("hidden");
            loader.classList.add("hidden");
            img1.classList.remove("hidden");
        }, 2000);
        setTimeout(() => { loader_overlay.style.display = "none"; }, 4000);
    </script>

    <!-- login popup modal start here -->

    <div class="modal product-view-modal" id="popup-auth-product-view">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="close-btn" data-bs-dismiss="modal"></div>
                    <div class="product-details-page">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="popup-auth-container popup-auth-active" id="popup-auth-loginFormContainer">
                                    <h1 class="popup-auth-title">Login</h1>
                                    <form id="popup-auth-loginForm" action="auth/login_handle.php" method="POST">
                                        <input type="email" id="popup-auth-loginEmail" name="email"
                                            placeholder="Enter your email" required>
                                        <input type="password" id="popup-auth-loginPassword" name="password"
                                            placeholder="Enter your password" required>
                                        <input type="submit" value="Login">
                                    </form>
                                    <p>Don't have an account? <span onclick="signupPopup()">Sign up</span></p>
                                </div>
                                <div class="popup-auth-container" id="popup-auth-signupFormContainer">
                                    <h1 class="popup-auth-title">Sign Up</h1>
                                    <form id="popup-auth-signupForm" action="auth/signup_handle.php" method="POST">
                                        <input type="text" id="popup-auth-signupName" name="user_name"
                                            placeholder="Enter your name" required>
                                        <input type="email" id="popup-auth-signupEmail" name="email"
                                            placeholder="Enter your email" required>
                                        <input type="password" id="popup-auth-signupPassword" name="password"
                                            placeholder="Create a password" required>
                                        <input type="password" id="popup-auth-confirmPassword" name="confirm_password"
                                            placeholder="Confirm a password" required>
                                        <input type="submit" value="Sign Up">
                                    </form>
                                    <p>Already have an account? <span onclick="loginPopup()">Login</span></p>
                                </div>
                                <script>
                                    function loginPopup() {
                                        document.getElementById("popup-auth-signupFormContainer").classList.remove("popup-auth-active");
                                        document.getElementById("popup-auth-loginFormContainer").classList.add("popup-auth-active");
                                    }

                                    function signupPopup() {
                                        document.getElementById("popup-auth-loginFormContainer").classList.remove("popup-auth-active");
                                        document.getElementById("popup-auth-signupFormContainer").classList.add("popup-auth-active");
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- login popup modal end here -->

    <!-- hearder section strats here -->
    <div class="skin-header-topbar-wrap">
        <div class="skin-care-topbar d-sm-block d-none">
            <div class="container">
                <span>
                    <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path
                                d="M9.42859 11.1426C8.57145 8.99972 4.28573 6.85686 1.7143 5.99972C4.28573 5.14258 8.14287 3.85686 9.42859 0.856863"
                                stroke-width="1.5" stroke-linecap="round" />
                        </g>
                    </svg>
                    Limited Time Offer: 20% Off All Serums! Use Code: SERUM20 at Checkout.
                    <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path
                                d="M2.57153 11.1426C3.42868 8.99972 7.71439 6.85686 10.2858 5.99972C7.71439 5.14258 3.85725 3.85686 2.57153 0.856863"
                                stroke-width="1.5" stroke-linecap="round" />
                        </g>
                    </svg>
                </span>
            </div>
        </div>
        <header class="header-area skin-care">
            <div class="header-logo">
                <a href="index.php"><img alt="image" class="img-fluid" src="assets/image/icon/light-logo.png"
                        style="width:150px"></a>
            </div>
            <div class="main-menu">
                <div class="mobile-menu-logo">
                    <a href="index.html"><img alt="image" class="img-fluid" src="assets/image/icon/dark-logo.png"
                            style="width:150px"></a>
                </div>
                <ul class="menu-list">
                    <!--<li class="active"><a href="index.php">HOME</a></li>-->
                    <li class="menu-item-has-children" class="active"><a class="drop-down" href="#">SHOP</a>
                        <ul class="sub-menu">
                            <div class="d-flex flex-row" style="display: flex; flex-direction: row;">
                                <li style="list-style: none;margin-right: 20px;padding-left: 20px;">
                                    <h5 class="sub-menu-heading" style="font-size: 1em;font-weight: 600;margin-bottom: 10px;text-transform: uppercase;margin-left: 0;color: #a0cddb;">Product Type</h5>
                                    <a href="product-listing.php?type=ABPT10012" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Ampoule serum treatment</a>
                                    <a href="product-listing.php?type=ABPT10005" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Eye care</a>
                                    <a href="product-listing.php?type=ABPT10011" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Face Scrubs</a>
                                    <a href="product-listing.php?type=ABPT10010" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Lip care</a>
                                    <a href="product-listing.php?type=ABPT10007" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Mask</a>
                                    <a href="product-listing.php?type=ABPT10006" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        UV protection</a>
                                </li>
                                <li class="active" style="list-style: none;margin-right: 20px;padding-left: 20px;">
                                    <h5 class="sub-menu-heading" style="font-size: 1em;font-weight: 600;margin-bottom: 10px;text-transform: uppercase;margin-left: 0;color: #a0cddb;">Skin Concern</h5>
                                    <a href="product-listing.php?skin_concern=ABSC10001" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Acne & Blemishes</a>
                                    <a href="product-listing.php?skin_concern=ABSC10013" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Anti-aging</a>
                                    <a href="product-listing.php?skin_concern=ABSC10012" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Dark Circles</a>
                                    <a href="product-listing.php?skin_concern=ABSC10003" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Dark spot and pigmentation</a>
                                    <a href="product-listing.php?skin_concern=ABSC10004" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Dryness & dehydration</a>
                                    <a href="product-listing.php?skin_concern=ABSC10005" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Dullness or lackluster tone</a>
                                    <a href="product-listing.php?skin_concern=ABSC10007" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Enlarged pores</a>
                                    <a href="product-listing.php?skin_concern=ABSC10011" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Keratosis pilaris or small bumps</a>
                                    <a href="product-listing.php?skin_concern=ABSC10008" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Redness or rosacea</a>
                                    <a href="product-listing.php?skin_concern=ABSC10009" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Signs of congestion</a>
                                    <a href="product-listing.php?skin_concern=ABSC10006" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Textural irregularities</a>
                                    <a href="product-listing.php?skin_concern=ABSC10010" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Uneven skin tone</a>
                                </li>
                                <li style="list-style: none;margin-right: 20px;padding-left: 20px;">
                                    <h5 class="sub-menu-heading" style="font-size: 1em;font-weight: 600;margin-bottom: 10px;text-transform: uppercase;margin-left: 0;color: #a0cddb;">Skin Type</h5>
                                    <a href="product-listing.php?skin_type=ABST10006" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        All Skin Types</a>
                                    <a href="product-listing.php?skin_type=ABST10002" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Combination Skin</a>
                                    <a href="product-listing.php?skin_type=ABST10007" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Dry Skin </a>
                                    <a href="product-listing.php?skin_type=ABST10004" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Normal Skin</a>
                                    <a href="product-listing.php?skin_type=ABST10003" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Oily Skin</a>
                                    <a href="product-listing.php?skin_type=ABST10005" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                        Sensitive Skin</a>
                                </li>
                                <li style="list-style: none;margin-right: 20px;padding-left: 20px;">
                                    <h5 class="sub-menu-heading" style="font-size: 1em;font-weight: 600;margin-bottom: 10px;text-transform: uppercase;margin-left: 0;color: #a0cddb;">Popular Brands</h5>
                                    <div class="product-type-columns" style="display: flex; flex-direction: column;">
                                        <a href="product-listing.php?brand=ABB10018" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            CeraVe</a>
                                        <a href="product-listing.php?brand=ABB10027" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            Drunk Elephant</a>
                                        <a href="product-listing.php?brand=ABB10020" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            Estee Lauder</a>
                                        <a href="product-listing.php?brand=ABB10025" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            Beauty of Joseon</a>
                                        <a href="product-listing.php?brand=ABB10003" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            Garnier</a>
                                        <a href="product-listing.php?brand=ABB10037" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            Nars</a>
                                        <a href="product-listing.php?brand=ABB10021" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            Neutrogena</a>
                                        <a href="product-listing.php?brand=ABB10022" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            SKIN1004 - Madagascar Centella</a><a href="product-listing.php?brand=ABB10013" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            The ordinary</a><a href="product-listing.php?brand=ABB10024" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">
                                            Pixi</a>
                                    </div>
                                </li>
                                <li style="list-style: none;margin-right: 20px;padding-left: 20px;">
                                    <h5 class="sub-menu-heading" style="font-size: 1em;font-weight: 600;margin-bottom: 10px;text-transform: uppercase;margin-left: 0;color: #a0cddb;">Aurea collection</h5>
                                    <a href="product-listing.php?brands_id=1" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">Gift sets</a>
                                    <a href="product-listing.php?brands_id=2" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">Gift cards</a>
                                    <a href="product-listing.php?brands_id=3" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">Regimen sets</a>
                                    <a href="product-listing.php?brands_id=4" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">Bestsellers</a>
                                </li>
                                <li style="list-style: none;">
                                    <h5 class="sub-menu-heading" style="font-size: 1em;font-weight: 600;margin-bottom: 10px;text-transform: uppercase;margin-left: 0;color: #a0cddb;">Beauty tools</h5>
                                    <a href="product-listing.php?brands_id=2" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">Body Care</a>
                                    <a href="product-listing.php?brands_id=1" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">Face Care</a>
                                    <a href="product-listing.php?brands_id=3" style="display: block;text-decoration: none;color: #f8f9fa;padding: 5px 0;transition: color 0.3s ease;white-space: nowrap;font-size: .7em;letter-spacing: .01em;">Hair Care</a>
                                </li>
                            </div>
                        </ul>
                    </li>
                    <li><a href="our-story.php">AUREA DIARIES</a></li>
                    <li><a href="product-listing.php">SALES</a></li>
                    <li><a href="why-we-are-different.php">WHY WE ARE DIFFERENT</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="skin_concern.php">SKIN ANALYSIS</a></li>
                </ul>
                <div class="d-xl-none d-block">
                    <div class="mobile-search-area mb-30">
                        <form id="searchForm" action="product-listing.php" method="get">
                            <div class="form-inner">
                                <input type="text" id="searchInput" name="name" placeholder="Enter your keywords"
                                    required>
                                <button type="submit" class="primary-btn1">Search Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="nav-right">
                <ul>
                    <li>
                        <div class="search-bar d-xl-flex d-none">
                            <div class="search-btn">
                                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.20349 1.44849C6.41514 1.45148 4.70089 2.16323 3.43633 3.42779C2.17178 4.69235 1.46003 6.40659 1.45703 8.19494C1.45853 9.9848 2.16943 11.7011 3.43399 12.9678C4.69855 14.2345 6.41364 14.9482 8.20349 14.9527C9.79089 14.9527 11.2536 14.3943 12.4101 13.4702L16.0578 17.1182C16.2002 17.2505 16.3882 17.3225 16.5825 17.3191C16.7768 17.3157 16.9622 17.2372 17.0998 17.0999C17.2374 16.9627 17.3165 16.7775 17.3204 16.5832C17.3243 16.3889 17.2528 16.2007 17.1208 16.058L13.4731 12.4072C14.4325 11.214 14.9556 9.72887 14.9556 8.19778C14.9556 4.47872 11.9225 1.44849 8.20349 1.44849ZM8.20349 2.95085C11.1118 2.95085 13.4533 5.28943 13.4533 8.19494C13.4533 11.1005 11.1118 13.4532 8.20349 13.4532C5.29514 13.4532 2.95656 11.109 2.95656 8.20061C2.95656 5.29227 5.29514 2.95085 8.20349 2.95085Z" />
                                </svg>
                            </div>
                            <div class="search-input">
                                <div class="serch-close"></div>
                                <form action="product-listing.php" method="get">
                                    <div class="search-group">
                                        <div class="form-inner2">
                                            <input type="text" name="name" placeholder="Enter your keywords">
                                            <button type="submit"><i class="bi bi-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="quick-search">
                                        <ul>
                                            <li>Quick Search :</li>
                                            <li><a href="services01.html">Classic Haircut,</a></li>
                                            <li><a href="services01.html">Coloring Services,</a></li>
                                            <li><a href="services01.html">Hair Extensions,</a></li>
                                            <li><a href="services01.html">Specialty Services,</a></li>
                                            <li><a href="services01.html">Haircuts and Styling,</a></li>
                                            <li><a href="services01.html">Men's Grooming,</a></li>
                                            <li><a href="services01.html">Makeover Package,</a></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="user" data-bs-toggle="modal" <?php echo $link; ?>>
                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.7135 8.34627C12.8653 7.50628 13.6153 6.14686 13.6153 4.61538C13.6153 2.07046 11.5448 0 8.99989 0C6.45497 0 4.38451 2.07046 4.38451 4.61538C4.38451 6.14686 5.1345 7.50628 6.28629 8.34627C3.42316 9.44191 1.38452 12.2179 1.38452 15.4615C1.38452 16.8613 2.52327 18 3.92298 18H14.0768C15.4765 18 16.6153 16.8613 16.6153 15.4615C16.6153 12.2179 14.5766 9.44191 11.7135 8.34627ZM5.76914 4.61538C5.76914 2.83395 7.21845 1.38463 8.99989 1.38463C10.7813 1.38463 12.2306 2.83395 12.2306 4.61538C12.2306 6.39682 10.7813 7.84617 8.99989 7.84617C7.21845 7.84617 5.76914 6.39682 5.76914 4.61538ZM14.0768 16.6154H3.92298C3.28676 16.6154 2.76915 16.0978 2.76915 15.4615C2.76915 12.0258 5.56421 9.23073 8.99993 9.23073C12.4356 9.23073 15.2307 12.0258 15.2307 15.4615C15.2307 16.0978 14.7131 16.6154 14.0768 16.6154Z" />
                            </svg>
                        </div>
                    </li>
                    <li>
                        <div class="cart-area" onclick="window.location.href='cart.php'">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3.375 4.78125H14.625M6.1875 4.78125V3.51562C6.1875 1.96232 7.44669 0.703125 9 0.703125C10.5533 0.703125 11.8125 1.96232 11.8125 3.51562V4.78125M11.8125 7.59375C11.8125 9.14706 10.5533 10.4062 9 10.4062C7.44669 10.4062 6.1875 9.14706 6.1875 7.59375"
                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M14.625 4.78125L16.0201 15.7131C16.0275 15.772 16.0313 15.8313 16.0312 15.8906C16.0312 16.6673 15.4016 17.2969 14.625 17.2969H3.375C2.59836 17.2969 1.96875 16.6673 1.96875 15.8906C1.96875 15.8305 1.97251 15.7712 1.97986 15.7131L3.375 4.78125"
                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span><?php if (isset($_SESSION['user_id'])) {
                                echo $cart_count;
                            } else {
                                echo 0;
                            } ?></span>
                        </div>
                    </li>
                </ul>
                <div class="sidebar-button mobile-menu-btn">
                    <span></span>
                </div>
            </div>
        </header>
    </div>