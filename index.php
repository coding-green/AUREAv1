<?php
include 'header.php';
include_once('function.php');
?>
<!-- Banner section strats here -->
<div class="skin-care-banner-section">
    
    <div class="swiper banner-swiper-slide">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="banner-wrapper"
                    style="background-image: linear-gradient(180deg, rgba(0 ,0 ,0 , 0.4) 0%, rgba(0 ,0 ,0 , 0.4) 100%), url(assets/image/skin-care/banner-img1.jpg);">
                    <div class="container">
                        <div class="banner-content" style="width: 1349px;margin-right: 15px;transform: translate3d(0px, 0px, 0px);transition-duration: 0ms;">
                            <span>한국 스킨케어</span>
                            <h2 style="color:white">Unleash Your Glow with the Best of Korean Skincare</h2>
                            <p>Welcome to Aurea Bliss—your trusted destination for authentic Korean skincare. Discover
                                lab-certified products crafted to meet all your skin’s needs, from deep hydration to
                                youthful radiance. Elevate your skincare routine with solutions you can rely on for
                                real, glowing results.</p>
                            <a class="primary-btn4 breadcram-btn" href="product-listing.php">
                                Shop Now
                                <svg class="arrow" width="10" height="10" viewBox="0 0 10 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9"
                                        stroke="#1E1E1E" stroke-width="3" stroke-linecap="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="banner-wrapper"
                    style="background-image: linear-gradient(180deg, rgba(0 ,0 ,0 , 0.4) 0%, rgba(0 ,0 ,0 , 0.4) 100%), url(assets/image/skin-care/banner-img2.jpg);">
                    <div class="container">
                        <div class="banner-content" style="width: 1349px;margin-right: 15px;transform: translate3d(0px, 0px, 0px);transition-duration: 0ms;">
                            <span>한국 스킨케어</span>
                            <h2 style="color:white">Unleash Your Glow with the Best of Korean Skincare</h2>
                            <p>Welcome to Aurea Bliss—your trusted destination for authentic Korean skincare. Discover
                                lab-certified products crafted to meet all your skin’s needs, from deep hydration to
                                youthful radiance. Elevate your skincare routine with solutions you can rely on for
                                real, glowing results.</p>
                            <a class="primary-btn4 breadcram-btn" href="product-listing.php">
                                Shop Now
                                <svg class="arrow" width="10" height="10" viewBox="0 0 10 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9"
                                        stroke="#1E1E1E" stroke-width="3" stroke-linecap="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="banner-wrapper"
                    style="background-image: linear-gradient(180deg, rgba(0 ,0 ,0 , 0.4) 0%, rgba(0 ,0 ,0 , 0.4) 100%), url(assets/image/skin-care/banner-img3.jpg);">
                    <div class="container">
                        <div class="banner-content" style="width: 1349px;margin-right: 15px;transform: translate3d(0px, 0px, 0px);transition-duration: 0ms;">
                            <span>한국 스킨케어</span>
                            <h2 style="color:white">Unleash Your Glow with the Best of Korean Skincare</h2>
                            <p>Welcome to Aurea Bliss—your trusted destination for authentic Korean skincare. Discover
                                lab-certified products crafted to meet all your skin’s needs, from deep hydration to
                                youthful radiance. Elevate your skincare routine with solutions you can rely on for
                                real, glowing results</p>
                            <a class="primary-btn4 breadcram-btn" href="product-listing.php">
                                Shop Now
                                <svg class="arrow" width="10" height="10" viewBox="0 0 10 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9"
                                        stroke="#1E1E1E" stroke-width="3" stroke-linecap="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Banner section ends here -->
<div class="my-5 shop-by-concern">
    <h2 style="justify-content:center;display:flex;">Shop by Skin Concern</h2>
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
            
            <?php
$sql = "SELECT skin_concern_id,concern_name FROM SkinConcerns";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $concern_name=$row['concern_name'];
        $productListingURL = "product-listing.php?skin_concern=" . $row['skin_concern_id'];
        echo '<div class="card" onclick="window.location.href=\'' . $productListingURL . '\'">';
        echo '<img src="assets/image/skin-care/skinconcern/' . $concern_name . '.jpg" class="card-img-top" alt="' . $concern_name . '">';
        echo '<h5 class="card-title">' . $concern_name . '</h5>';
        echo '</div>';
    }
} 
?>
            
           
        </div>
    </div>


</div>
<!-- product section strats here -->
<div class="skin-care-product-section mb-120 pt-120">
    <div class="container">
        <div class="row wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
            <div class="col-lg-12 mb-60 d-flex align-items-center justify-content-between gap-3 flex-wrap">
                <div class="skin-care-section-title">
                    <span>New Arrivals</span>
                    <h2>OUR BEST SELLING</h2>
                </div>
                <div class="slider-btn-groups2">
                    <div class="slider-btn prev-1">
                        <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path d="M11 13C10 10.5 5 8 2 7C5 6 9.5 4.5 11 1" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </g>
                        </svg>
                    </div>
                    <div class="slider-btn next-1">
                        <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path d="M3 13C4 10.5 9 8 12 7C9 6 4.5 4.5 3 1" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="row wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
            <div class="col-lg-12">
                <div class="swiper skin-care-product-swiper">
                    <div class="swiper-wrapper">

                        <?php
                        include_once('config.php');

                        $sql = "SELECT p.*, pi.main_image_path as MainPathImage FROM Products p
        LEFT JOIN product_images pi ON p.product_id = pi.product_id
        WHERE p.status = 'active'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="swiper-slide" style="cursor: pointer;">
                                <div class="product-card-section">
                                    <div class="product-image"
                                        onclick='window.location.href="product-details.php?id=<?php echo $row["product_id"]; ?>"'>
                                        <img src="<?php echo isset($row['MainPathImage']) && $row['MainPathImage'] ? 'crm/' . $row['MainPathImage'] : 'assets/image/skin-care/default_product_image.jpg'; ?>" alt="Product Image">
                                    </div>
                                    <div class="product-content text-center">
                                        <h4
                                            onclick='window.location.href="product-details.php?id=<?php echo $row["product_id"]; ?>"'>
                                            <?php echo $row["product_name"]; ?>
                                        </h4>
                                        <h6><?php echo round($row["price"] * $exchangeRate, 2) . " " . strtoupper($currencyCode) ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <div class="progress-pagination"></div>
            </div>
        </div>
    </div>
</div>
<!-- product section ends here -->

<!-- our company section strats here -->
<div class="our-company-section mb-120">
    <div class="container">
        <div class="row g-4 mb-50">
            <div class="col-lg-6 text-center wow animate fadeInLeft" data-wow-delay="200ms" data-wow-duration="1500ms">
                <img src="assets/image/skin-care/our-company-image.png" alt="">
            </div>
            <div class="col-lg-6 d-flex align-items-center wow animate fadeInRight" data-wow-delay="200ms"
                data-wow-duration="1500ms">
                <div class="our-story">
                    <div class="skin-care-section-title text-center">
                        <span>Our Story</span>
                        <h2>OUR COMPANY</h2>
                    </div>
                    <div class="our-company-content text-center">
                        <p>We launched <span>Aurea Bliss</span> in 2020 with a simple mission: to bring together the
                            best, most authentic skincare brands on one platform. Our passion for skincare led us to
                            curate a collection of tried-and-tested products that actually work. And because we believe
                            in the power of Korean skincare, we’ve made sure to feature the finest K-beauty products to
                            help you achieve your skincare goals.
                        </p>
                        <p>In a world full of countless skincare options, we make your journey easier. We showcase only
                            the most effective products, carefully selected to address your unique needs. With our
                            AI-powered skin analysis, you can discover the perfect products for your specific skin
                            concerns and skin type, so you can shop with confidence.
                        </p>
                        <p>
                            If you’re new to skincare, explore our Aurea Collection to find curated skincare regimens
                            designed to work harmoniously for your skin. For a more personalized approach, fill out our
                            skin analysis to receive tailored recommendations just for you.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- our company section ends here -->

<!-- offer section strats here -->
<div class="skin-care-service-section mb-120">
    <div class="container">
        <div class="row wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
            <div class="col-lg-12 mb-60">
                <div class="skin-care-section-title text-center">
                    <span>Our Story</span>
                    <h2>What We offer</h2>
                </div>
            </div>
        </div>
        <div class="row wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
            <div class="col-lg-12 position-relative">
                <div class="slider-btn-groups3">
                    <div class="slider-btn prev-1">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_1583_345" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                width="14" height="14">
                                <rect width="14" height="14" fill="#DA8E8E" />
                            </mask>
                            <g mask="url(#mask0_1583_345)">
                                <path d="M11 13C10 10.5 5 8 2 7C5 6 9.5 4.5 11 1" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </g>
                        </svg>
                    </div>
                    <div class="slider-btn next-1">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_1583_340" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                width="14" height="14">
                                <rect width="14" height="14" transform="matrix(-1 0 0 1 14 0)" fill="#DA8E8E" />
                            </mask>
                            <g mask="url(#mask0_1583_340)">
                                <path d="M3 13C4 10.5 9 8 12 7C9 6 4.5 4.5 3 1" stroke="#1E1E1E" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="swiper offer-section-swiper mb-50">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="skin-care-service-card">
                                <a href="services-details.php" class="service-image">
                                    <img src="assets/image/skin-care/service-image1.png" alt="">
                                </a>
                                <div class="service-content">
                                    <a href="services01.html">Facials</a>
                                    <h5><a href="services-details.html">FACIALS TREATMENT</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="skin-care-service-card">
                                <a href="services-details.html" class="service-image">
                                    <img src="assets/image/skin-care/service-image2.png" alt="">
                                </a>
                                <div class="service-content">
                                    <a href="services01.html">Therapy</a>
                                    <h5><a href="services-details.html">Microneedling</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="skin-care-service-card">
                                <a href="services-details.html" class="service-image">
                                    <img src="assets/image/skin-care/service-image3.png" alt="">
                                </a>
                                <div class="service-content">
                                    <a href="services01.html">Treatments</a>
                                    <h5><a href="services-details.html">Laser Treatments</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="skin-care-service-card">
                                <a href="services-details.html" class="service-image">
                                    <img src="assets/image/skin-care/service-image4.png" alt="">
                                </a>
                                <div class="service-content">
                                    <a href="services01.html">LED Therapy</a>
                                    <h5><a href="services-details.html">LED Light Therapy</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="skin-care-service-card">
                                <a href="services-details.html" class="service-image">
                                    <img src="assets/image/skin-care/service-image5.png" alt="">
                                </a>
                                <div class="service-content">
                                    <a href="services01.html">Injectable</a>
                                    <h5><a href="services-details.html">Injectables</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="skin-care-service-card">
                                <a href="services-details.html" class="service-image">
                                    <img src="assets/image/skin-care/service-image6.png" alt="">
                                </a>
                                <div class="service-content">
                                    <a href="services01.html">Therapy</a>
                                    <h5><a href="services-details.html">Body Treatments</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="skin-care-service-card">
                                <a href="services-details.html" class="service-image">
                                    <img src="assets/image/skin-care/service-image7.png" alt="">
                                </a>
                                <div class="service-content">
                                    <a href="services01.html">Treatments</a>
                                    <h5><a href="services-details.html">Consultations</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress-pagination2"></div>
            </div>
        </div>
    </div>
</div>
<!-- offer section End here -->

<!-- skin protection section strats here -->
<div class="skin-protection-section mb-120">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 d-flex align-items-center wow animate fadeInLeft" data-wow-delay="200ms"
                data-wow-duration="1500ms">
                <div class="skin-care-section-title text-center">
                    <span>Why Need Skin Care?</span>
                    <h2>Skin protection</h2>
                    <p>Skin care is not just about aesthetics; it is a vital part of overall health and well-being.
                        By adopting a regular skincare routine, you can protect your skin, prevent premature aging,
                        manage skin conditions, and maintain a healthy, glowing complexion. Taking care of your skin
                        is an investment
                        in your health and confidence.</p>
                    <p class="list-top-text">Here are several reasons why proper skin care is important:</p>
                    <ul>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1587_577)">
                                    <path
                                        d="M12 6C12 7.5913 11.3679 9.11742 10.2426 10.2426C9.11742 11.3679 7.5913 12 6 12C4.4087 12 2.88258 11.3679 1.75736 10.2426C0.632141 9.11742 0 7.5913 0 6C0 4.4087 0.632141 2.88258 1.75736 1.75736C2.88258 0.632141 4.4087 0 6 0C7.5913 0 9.11742 0.632141 10.2426 1.75736C11.3679 2.88258 12 4.4087 12 6ZM9.0225 3.7275C8.96893 3.67411 8.90514 3.63208 8.83495 3.60391C8.76476 3.57574 8.68961 3.56202 8.61399 3.56356C8.53838 3.5651 8.46385 3.58187 8.39486 3.61288C8.32588 3.64388 8.26385 3.68848 8.2125 3.744L5.60775 7.06275L4.038 5.49225C3.93137 5.39289 3.79033 5.3388 3.64461 5.34137C3.49888 5.34394 3.35984 5.40297 3.25678 5.50603C3.15372 5.60909 3.09469 5.74813 3.09212 5.89386C3.08955 6.03958 3.14364 6.18062 3.243 6.28725L5.2275 8.2725C5.28096 8.32586 5.34462 8.36791 5.41469 8.39614C5.48475 8.42437 5.55979 8.43819 5.63531 8.43679C5.71083 8.43539 5.7853 8.4188 5.85427 8.38799C5.92324 8.35719 5.9853 8.31281 6.03675 8.2575L9.03075 4.515C9.13282 4.40887 9.18921 4.26696 9.18781 4.11972C9.1864 3.97248 9.12732 3.83166 9.02325 3.7275H9.0225Z"
                                        fill="#595959" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1587_577">
                                        <rect width="12" height="12" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            Moisture Retention
                        </li>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1587_577)">
                                    <path
                                        d="M12 6C12 7.5913 11.3679 9.11742 10.2426 10.2426C9.11742 11.3679 7.5913 12 6 12C4.4087 12 2.88258 11.3679 1.75736 10.2426C0.632141 9.11742 0 7.5913 0 6C0 4.4087 0.632141 2.88258 1.75736 1.75736C2.88258 0.632141 4.4087 0 6 0C7.5913 0 9.11742 0.632141 10.2426 1.75736C11.3679 2.88258 12 4.4087 12 6ZM9.0225 3.7275C8.96893 3.67411 8.90514 3.63208 8.83495 3.60391C8.76476 3.57574 8.68961 3.56202 8.61399 3.56356C8.53838 3.5651 8.46385 3.58187 8.39486 3.61288C8.32588 3.64388 8.26385 3.68848 8.2125 3.744L5.60775 7.06275L4.038 5.49225C3.93137 5.39289 3.79033 5.3388 3.64461 5.34137C3.49888 5.34394 3.35984 5.40297 3.25678 5.50603C3.15372 5.60909 3.09469 5.74813 3.09212 5.89386C3.08955 6.03958 3.14364 6.18062 3.243 6.28725L5.2275 8.2725C5.28096 8.32586 5.34462 8.36791 5.41469 8.39614C5.48475 8.42437 5.55979 8.43819 5.63531 8.43679C5.71083 8.43539 5.7853 8.4188 5.85427 8.38799C5.92324 8.35719 5.9853 8.31281 6.03675 8.2575L9.03075 4.515C9.13282 4.40887 9.18921 4.26696 9.18781 4.11972C9.1864 3.97248 9.12732 3.83166 9.02325 3.7275H9.0225Z"
                                        fill="#595959" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1587_577">
                                        <rect width="12" height="12" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            Sun Protection
                        </li>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1587_577)">
                                    <path
                                        d="M12 6C12 7.5913 11.3679 9.11742 10.2426 10.2426C9.11742 11.3679 7.5913 12 6 12C4.4087 12 2.88258 11.3679 1.75736 10.2426C0.632141 9.11742 0 7.5913 0 6C0 4.4087 0.632141 2.88258 1.75736 1.75736C2.88258 0.632141 4.4087 0 6 0C7.5913 0 9.11742 0.632141 10.2426 1.75736C11.3679 2.88258 12 4.4087 12 6ZM9.0225 3.7275C8.96893 3.67411 8.90514 3.63208 8.83495 3.60391C8.76476 3.57574 8.68961 3.56202 8.61399 3.56356C8.53838 3.5651 8.46385 3.58187 8.39486 3.61288C8.32588 3.64388 8.26385 3.68848 8.2125 3.744L5.60775 7.06275L4.038 5.49225C3.93137 5.39289 3.79033 5.3388 3.64461 5.34137C3.49888 5.34394 3.35984 5.40297 3.25678 5.50603C3.15372 5.60909 3.09469 5.74813 3.09212 5.89386C3.08955 6.03958 3.14364 6.18062 3.243 6.28725L5.2275 8.2725C5.28096 8.32586 5.34462 8.36791 5.41469 8.39614C5.48475 8.42437 5.55979 8.43819 5.63531 8.43679C5.71083 8.43539 5.7853 8.4188 5.85427 8.38799C5.92324 8.35719 5.9853 8.31281 6.03675 8.2575L9.03075 4.515C9.13282 4.40887 9.18921 4.26696 9.18781 4.11972C9.1864 3.97248 9.12732 3.83166 9.02325 3.7275H9.0225Z"
                                        fill="#595959" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1587_577">
                                        <rect width="12" height="12" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            Dehydration
                        </li>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1587_577)">
                                    <path
                                        d="M12 6C12 7.5913 11.3679 9.11742 10.2426 10.2426C9.11742 11.3679 7.5913 12 6 12C4.4087 12 2.88258 11.3679 1.75736 10.2426C0.632141 9.11742 0 7.5913 0 6C0 4.4087 0.632141 2.88258 1.75736 1.75736C2.88258 0.632141 4.4087 0 6 0C7.5913 0 9.11742 0.632141 10.2426 1.75736C11.3679 2.88258 12 4.4087 12 6ZM9.0225 3.7275C8.96893 3.67411 8.90514 3.63208 8.83495 3.60391C8.76476 3.57574 8.68961 3.56202 8.61399 3.56356C8.53838 3.5651 8.46385 3.58187 8.39486 3.61288C8.32588 3.64388 8.26385 3.68848 8.2125 3.744L5.60775 7.06275L4.038 5.49225C3.93137 5.39289 3.79033 5.3388 3.64461 5.34137C3.49888 5.34394 3.35984 5.40297 3.25678 5.50603C3.15372 5.60909 3.09469 5.74813 3.09212 5.89386C3.08955 6.03958 3.14364 6.18062 3.243 6.28725L5.2275 8.2725C5.28096 8.32586 5.34462 8.36791 5.41469 8.39614C5.48475 8.42437 5.55979 8.43819 5.63531 8.43679C5.71083 8.43539 5.7853 8.4188 5.85427 8.38799C5.92324 8.35719 5.9853 8.31281 6.03675 8.2575L9.03075 4.515C9.13282 4.40887 9.18921 4.26696 9.18781 4.11972C9.1864 3.97248 9.12732 3.83166 9.02325 3.7275H9.0225Z"
                                        fill="#595959" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1587_577">
                                        <rect width="12" height="12" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            Anti-Aging Benefits
                        </li>
                    </ul>
                    <a class="primary-btn1 service-menu-btn" href="product-listing.php">
                        VIEW Products
                        <svg class="arrow" width="10" height="10" viewBox="0 0 10 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9"
                                stroke="#1E1E1E" stroke-width="1.5" stroke-linecap="round"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 position-relative wow animate fadeInRight" data-wow-delay="200ms"
                data-wow-duration="1500ms">
                <div class="swiper skin-protection-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="assets/image/skin-care/skin-protection-image.png" alt="">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/image/skin-care/skin-protection-image2.png" alt="">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/image/skin-care/skin-protection-image.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
<!-- skin protection section ends here -->

<!-- skin care discount section -->
<div class="skin-care-discount-section mb-120"
    style="background-image: url(assets/image/skin-care/discount-image.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="skin-care-discount-content wow animate fadeInUp" data-wow-delay="200ms"
                    data-wow-duration="1500ms">
                    <span class="offer-tag">50% DISCOUNT</span>
                    <h2>every new customer has
                        been <span>50% discount</span> to every
                        single service package.</h2>
                    <a class="primary-btn4 breadcram-btn" href="product-listing.php">
                        Shop Now
                        <svg class="arrow" width="10" height="10" viewBox="0 0 10 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 9L9 1M9 1C7.22222 1.33333 3.33333 2 1 1M9 1C8.66667 2.66667 8 6.33333 9 9"
                                stroke="#1E1E1E" stroke-width="3" stroke-linecap="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- skin care discount section-->

<!-- testimonials section strats here -->
<div class="skin-care-testimonials-section mb-120">
    <div class="container">
        <div class="row wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
            <div class="col-lg-12 mb-40">
                <div class="skin-care-section-title text-center">
                    <span>Testimonials</span>
                    <h2>love from customer</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 position-relative pt-30">
                <div class="slider-btn-groups4">
                    <div class="slider-btn prev-1">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_1583_345" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                width="14" height="14">
                                <rect width="14" height="14" fill="#DA8E8E" />
                            </mask>
                            <g mask="url(#mask0_1583_345)">
                                <path d="M11 13C10 10.5 5 8 2 7C5 6 9.5 4.5 11 1" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </g>
                        </svg>
                    </div>
                    <div class="slider-btn next-1">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_1583_340" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                width="14" height="14">
                                <rect width="14" height="14" transform="matrix(-1 0 0 1 14 0)" fill="#DA8E8E" />
                            </mask>
                            <g mask="url(#mask0_1583_340)">
                                <path d="M3 13C4 10.5 9 8 12 7C9 6 4.5 4.5 3 1" stroke="#1E1E1E" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="swiper feedback-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="feedback-content">
                                <div class="author-area">
                                    <div class="author-content">
                                        <h6>Lazie Juie</h6>
                                        <span>25 Age, Mirpur (DOSH)</span>
                                    </div>
                                </div>
                                <div class="author-text">
                                    <div class="rating">
                                        <ul class="star">
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                        </ul>
                                    </div>
                                    <p class="farst-para">Go to beauty and spa salons is to prioritize self-care.
                                    </p>
                                    <p>Regular exfoliation and cleansing remove dead skin cells, revealing a
                                        brighter, more radiant complexion.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="feedback-content">
                                <div class="author-area">
                                    <div class="author-content">
                                        <h6>Emy Ecolite</h6>
                                        <span>22 Age, Khilkhet, Dhaka</span>
                                    </div>
                                </div>
                                <div class="author-text">
                                    <div class="rating">
                                        <ul class="star">
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                        </ul>
                                    </div>
                                    <p class="farst-para">Certain skincare products stimulate collagen production.
                                    </p>
                                    <p>Effective skin care can help manage and prevent conditions like acne, eczema,
                                        and rosacea..</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="feedback-content">
                                <div class="author-area">
                                    <div class="author-content">
                                        <h6>amelia bella</h6>
                                        <span>30 Age, Baridhara (DOSH)</span>
                                    </div>
                                </div>
                                <div class="author-text">
                                    <div class="rating">
                                        <ul class="star">
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                        </ul>
                                    </div>
                                    <p class="farst-para">Good skin can make a positive impression.</p>
                                    <p>Certain skincare products stimulate collagen production, maintaining skin
                                        elasticity and firmness.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="feedback-content">
                                <div class="author-area">
                                    <div class="author-content">
                                        <h6>Lazie Juie</h6>
                                        <span>25 Age, Mirpur (DOSH)</span>
                                    </div>
                                </div>
                                <div class="author-text">
                                    <div class="rating">
                                        <ul class="star">
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                        </ul>
                                    </div>
                                    <p class="farst-para">Go to beauty and spa salons is to prioritize self-care.
                                    </p>
                                    <p>Regular exfoliation and cleansing remove dead skin cells, revealing a
                                        brighter, more radiant complexion.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="feedback-content">
                                <div class="author-area">
                                    <div class="author-content">
                                        <h6>Emy Ecolite</h6>
                                        <span>22 Age, Khilkhet, Dhaka</span>
                                    </div>
                                </div>
                                <div class="author-text">
                                    <div class="rating">
                                        <ul class="star">
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                        </ul>
                                    </div>
                                    <p class="farst-para">Certain skincare products stimulate collagen production.
                                    </p>
                                    <p>Effective skin care can help manage and prevent conditions like acne, eczema,
                                        and rosacea..</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="feedback-content">
                                <div class="author-area">
                                    <div class="author-content">
                                        <h6>amelia bella</h6>
                                        <span>30 Age, Baridhara (DOSH)</span>
                                    </div>
                                </div>
                                <div class="author-text">
                                    <div class="rating">
                                        <ul class="star">
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                        </ul>
                                    </div>
                                    <p class="farst-para">Good skin can make a positive impression.</p>
                                    <p>Certain skincare products stimulate collagen production, maintaining skin
                                        elasticity and firmness.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress-pagination3"></div>
            </div>
        </div>
    </div>
</div>
<!-- testimonials section strats here -->

<!-- partner section strats here -->
<div class="partner-logo-section mb-120 wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="logo-wrap">
                    <div class="logo-title">
                        <h5>We have 5 Brands & 20+ Trusted Partner</h5>
                    </div>
                    <div class="logo-area">
                        <div class="marquee_text2">
                            <?php
                            $sql = "SELECT * FROM Brands";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();

                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <a href="product-listing.php?brand=<?php echo urlencode($row['brands_name']); ?>">
                                    <img style="aspect-ratio: 18/9;height:80px"
                                        src="assets/image/brands/<?php echo $row['brand_image'] ?>" alt="">
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex flex-row justify-content-center gap-4">
    <div class="feature-card">
        <div class="feature-icon"><svg fill="#000000" height="30px" width="30px" version="1.1" id="Layer_1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                xml:space="preserve">
                <g>
                    <g>
                        <path d="M511.957,185.214L512,15.045l-67.587,67.587l-7.574-7.574c-48.332-48.332-112.593-74.95-180.946-74.95
            C114.792,0.107,0,114.901,0,256s114.792,255.893,255.893,255.893S511.785,397.099,511.785,256h-49.528
            c0,113.79-92.575,206.365-206.365,206.365S49.528,369.79,49.528,256S142.103,49.635,255.893,49.635
            c55.124,0,106.947,21.467,145.925,60.445l7.574,7.574l-67.58,67.58L511.957,185.214z" />
                    </g>
                </g>
            </svg></div>
        <div class="feature-content">
            <h3 class="feature-title">Easy Returns</h3>
            <p class="feature-description">15-Day Return Policy</p>
        </div>
    </div>

    <div class="feature-card">
        <div class="feature-icon"><svg fill="#000000" width="30px" height="30px" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M11.593965,2.08736316 C11.8155418,1.98891464 12.0639725,1.97485056 12.2932219,2.04517094 L12.406035,2.08736316 L21.406035,6.08614246 C21.7680046,6.24696874 21.9974374,6.60402426 22.0000116,6.99295906 L21.9938837,7.11043153 L21.421479,12.2620742 C21.1288947,14.8953332 19.6919006,17.2604209 17.5024605,18.7341239 L17.2465158,18.9001752 L12.5299989,21.8479983 C12.2417587,22.0281485 11.8846299,22.0481651 11.5810811,21.9080484 L11.4700011,21.8479983 L6.75348416,18.9001752 C4.50674338,17.4959623 2.9973732,15.1763947 2.61733718,12.5646862 L2.57852101,12.2620742 L2.00611627,7.11043153 C1.96237547,6.71676437 2.15492555,6.3385415 2.48944458,6.14011287 L2.59396504,6.08614246 L11.593965,2.08736316 Z M12,4.09548316 L4.074684,7.61677088 L4.56628848,12.0412112 C4.79233189,14.0756019 5.89660391,15.904196 7.58032075,17.0519337 L7.81348204,17.2041786 L12,19.8207524 L16.186518,17.2041786 C17.9222943,16.1193184 19.0922069,14.3320083 19.3974719,12.3173079 L19.4337115,12.0412112 L19.925316,7.61677088 L12,4.09548316 Z M14.2136429,8.38221966 C14.5548556,7.94794959 15.1835091,7.87251128 15.6177798,8.21372347 C16.018645,8.52868858 16.1137597,9.0885733 15.8576477,9.51441088 L15.7862762,9.61785831 L11.7862996,14.6178079 C11.4423592,15.0555496 10.8149977,15.1228552 10.3877107,14.7908187 L10.2928777,14.7070928 L8.2928926,12.707118 C7.90236913,12.3165951 7.90236913,11.6834324 8.2928926,11.2929096 C8.65337579,10.9324269 9.22060564,10.9046975 9.61289601,11.2097213 L9.70710315,11.2929096 L10.9100574,12.4958547 L14.2136429,8.38221966 Z" />
            </svg></div>
        <div class="feature-content">
            <h3 class="feature-title">100% Authentic</h3>
            <p class="feature-description">Products Sourced Directly</p>
        </div>
    </div>

    <div class="feature-card">
        <div class="feature-icon"><svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7.0498 7.0498H7.0598M10.5118 3H7.8C6.11984 3 5.27976 3 4.63803 3.32698C4.07354 3.6146 3.6146 4.07354 3.32698 4.63803C3 5.27976 3 6.11984 3 7.8V10.5118C3 11.2455 3 11.6124 3.08289 11.9577C3.15638 12.2638 3.27759 12.5564 3.44208 12.8249C3.6276 13.1276 3.88703 13.387 4.40589 13.9059L9.10589 18.6059C10.2939 19.7939 10.888 20.388 11.5729 20.6105C12.1755 20.8063 12.8245 20.8063 13.4271 20.6105C14.112 20.388 14.7061 19.7939 15.8941 18.6059L18.6059 15.8941C19.7939 14.7061 20.388 14.112 20.6105 13.4271C20.8063 12.8245 20.8063 12.1755 20.6105 11.5729C20.388 10.888 19.7939 10.2939 18.6059 9.10589L13.9059 4.40589C13.387 3.88703 13.1276 3.6276 12.8249 3.44208C12.5564 3.27759 12.2638 3.15638 11.9577 3.08289C11.6124 3 11.2455 3 10.5118 3ZM7.5498 7.0498C7.5498 7.32595 7.32595 7.5498 7.0498 7.5498C6.77366 7.5498 6.5498 7.32595 6.5498 7.0498C6.5498 6.77366 6.77366 6.5498 7.0498 6.5498C7.32595 6.5498 7.5498 6.77366 7.5498 7.0498Z"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>️</div>
        <div class="feature-content">
            <h3 class="feature-title">1900+ Brands</h3>
            <p class="feature-description">1.2 Lakh+ Products</p>
        </div>
    </div>
</div>

<!-- partner section ends here -->

<!--reel start-->

<div class="skin-care-testimonials-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 position-relative pt-30">
                <div class="swiper feedback-slider swiper-initialized swiper-horizontal swiper-backface-hidden">
                    <div class="swiper-wrapper" id="swiper-wrapper-4101082c8c98aa39fa" aria-live="off">
                        <?php
                        $sql = "SELECT reel_url FROM reels WHERE Reel_type = 'Home'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $result = $stmt->get_result();
                        $slideIndex = 1; // Initialize slide counter
                        $totalSlides = $result->num_rows; // Get total number of slides
                        
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="swiper-slide" role="group"
                                aria-label="<?php echo $slideIndex . ' / ' . $totalSlides; ?>"
                                data-swiper-slide-index="<?php echo $slideIndex - 1; ?>"
                                style="width: auto; margin-right: 10px;">
                                <iframe src="<?php echo $row['reel_url'] ?>/embed" width="400" height="600" frameborder="0"
                                    scrolling="no" allowtransparency="true" allow="autoplay; fullscreen"></iframe>
                            </div>
                            <?php
                            $slideIndex++; // Increment slide counter
                        }
                        ?>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                    <div class="progress-pagination3 swiper-pagination-progressbar swiper-pagination-horizontal">
                        <span class="swiper-pagination-progressbar-fill"
                            style="transform: translate3d(0px, 0px, 0px) scaleX(0.666667) scaleY(1); transition-duration: 1300ms;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- reel section -->

<?php include 'reel-popup.php'; ?>
<?php
include 'footer.php';
?>