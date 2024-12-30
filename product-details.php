<?php
include_once("header.php");
include_once("config.php");
include_once("function.php");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
global $skin_types;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id) {
        // Escape the ID to prevent SQL injection
        $escapedId = $conn->real_escape_string($id);

        // Adjust SQL to treat product_id as a string
        $sql = "SELECT p.*,sk.concern_name, pt.product_type_name, b.brands_name, pi.main_image_path as MainPathImage
                FROM Products p
                LEFT JOIN product_images pi ON p.product_id = pi.product_id
                LEFT JOIN Brands b ON b.brands_id = p.brand
                LEFT JOIN ProductType pt ON pt.product_type_id = p.product_type
                LEFT JOIN SkinConcerns sk ON sk.skin_concern_id = p.skin_concern
                WHERE p.status = 'active' AND p.product_id = '$escapedId'";

        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $price = $product['price'];
            $productId= $product['product_id'];
            $productDescription = $product['description'];
            $productBenefits = $product['product_benefits'];
            $howToUse = $product['how_to_use'];
            $allIngredients = $product['all_ingredients'];
            $warningStatement = $product['warning_statement'];
            $productImage = $product['product_image'];
            $size = $product['size'];
            $regimen = $product['regimen_recommendation'];
            $brandName = $product['brands_name'];
        } else {
            echo "Product not found.";
        }
    }
} else {
    echo "<script>window.location.href='index.php'</script>";
    exit();
}
?>



<!-- breadcrumb section ends here -->

<!-- product details strats here -->
<div class="product-details-page pt-50 mb-50">
    <div class="container">
        <div class="row g-lg-4 gy-5 mb-70">
            <div class="col-xl-5 col-lg-6">
                <div class="product-img-wrap">
                    <div class="slider-btn-groups">
                        <div class="slider-btn product-prev">
                            <!-- SVG for previous button -->
                        </div>
                        <div class="slider-btn product-next">
                            <!-- SVG for next button -->
                        </div>
                    </div>
                    <div class="swiper product-image-slider">
                        <div class="swiper-wrapper">
                            <!-- Loop through images (assuming you have multiple) -->
                            <div class="swiper-slide">
                                <div class="product-img product-img--main" data-scale="1.4"
                                    data-image="<?php echo $productImage; ?>">
                                    <img src="crm/<?php echo $product['MainPathImage']; ?>" alt="Product Image">
                                </div>
                            </div>
                            <!-- Repeat swiper-slide if there are more product images -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6">

                <div class="product-details-content style-2">
                    <h4><span style="font-size:16px" class="text-warning">
                                                ★★★★☆
                                            </span></h4>
                    <h4 style="font-size:18px"><?php echo $product['brands_name'] ?></h4>
                    <h3><?php echo $product['product_name']; ?></h3>
                    <p style="margin-bottom:20px;"><?php echo $product['product_tagline'] ?></p>
                    <?php
                    $skin_type_ids_array = explode(',', $product['skin_type']);

                    // Ensure the array is not empty and contains valid skin type IDs
                    if (!empty($skin_type_ids_array)) {
                        // Prepare placeholders for the query
                        $placeholders = implode(',', array_fill(0, count($skin_type_ids_array), '?'));
                        $stmt = $conn->prepare("SELECT skin_type_name FROM SkinTypes WHERE skin_type_id IN ($placeholders)");

                        if ($stmt) {
                            // Bind parameters dynamically (assuming IDs are strings)
                            $types = str_repeat('s', count($skin_type_ids_array)); // Use 's' for string type
                            $stmt->bind_param($types, ...$skin_type_ids_array);

                            // Execute the query
                            if ($stmt->execute()) {
                                // Fetch results
                                $result = $stmt->get_result();
                                $skin_types = [];
                                while ($row = $result->fetch_assoc()) {
                                    $skin_types[] = $row['skin_type_name'];
                                }

                                // Define skin type colors
                                $skinTypeColors = [
                                    'Combination Skin' => '#f8c8c8',
                                    'Blemishes' => '#e6d5f3',
                                    'Oily Skin' => '#ffeeba',
                                    'Dry Skin' => '#cce5ff',
                                    'Sensitive Skin' => '#f8d6d6',
                                    'Normal Skin' => '#d4f7d9',
                                    'All Skin Types' => '#f9c8c8',
                                ];

                                // Display skin types
                                if ($skin_types) {
                                    foreach ($skin_types as $skin_type) {
                                        // Use a default color if a skin type is not in the $skinTypeColors array
                                        $color = $skinTypeColors[$skin_type] ?? '#e2e3e5';
                                        echo "<div class='category' style='
                        background-color: $color;
                        display: inline-block;
                        padding: 6px 10px;
                        margin: 5px 0;
                        color: #333333;
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        font-weight: 600;
                        border-radius: 20px;'>
                        $skin_type
                      </div>";

                                    }
                                } else {
                                    echo "No skin types found.";
                                }
                            }
                        }
                    }
                    $concernColor = [
                        'Acne & Blemishes' => '#f8c8c8',
                        'Dark spot and pigmentation' => '#e6d5f3',
                        'Dryness / dehydration' => '#ffeeba',
                        'Dullness or lackluster tone' => '#cce5ff',
                        'Textural irregularities' => '#f8d6d6',
                        'Enlarged pores' => '#d4f7d9',
                        'Redness or rosacea' => '#f9c8c8',
                        'Signs of congestion' => '#f9c8c8',
                        'Uneven skin tone' => '#f9c8c8',
                        'Keratosis pilaris or small bumps' => '#f9c8c8',
                        'Dark Circles' => '#f9c8c8',
                        'Anti-aging' => '#f9c8c8',
                    ];


                    echo "<div class='category' style='
                        background-color: " . $concernColor[$product['concern_name']] . ";
                        display: inline-block;
                        padding: 6px 10px;
                        margin: 5px 0;
                        color: #333333;
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        font-weight: 600;
                        border-radius: 20px;'>" .
                        $product['concern_name'] . "
                      </div>";
                    ?>




                    <!--<p style="margin-top:20px"><?php echo $productDescription; ?></p>-->
                    <ul class="product-info-list" style="margin:20px 0px">
                        <li>Product Type : <a href="product-listing.php?type=<?php echo $product['product_type_name']?>"><?php echo $product['product_type_name'] ?></a></li>
                        <span
                            class="price"><?php echo round($price * $exchangeRate, 2) . " " . strtoupper($currencyCode); ?></span>
                        <li>Size: <?php echo $product['size']; ?></li>
                        <?php if (isset($product['product_benefits'])) {
                            ?>
                            <h3>Benefits: </h3>
                            <li><?php echo $product['product_benefits']; ?></li>
                        <?php } ?>
                        <?php if (isset($product['how_to_use'])) {
                            ?>
                            <h3>How to Use: </h3>
                            <li><?php echo $product['product_benefits']; ?></li>
                        <?php } ?>
                    </ul>

                    <div class="quantity-bag">
                        <div class="quantity-counter">
                            <a href="#" class="quantity__minus"><i class='bi bi-dash'></i></a>
                            <input name="quantity" type="text" class="quantity__input" value="01">
                            <a href="#" class="quantity__plus"><i class='bi bi-plus'></i></a>
                        </div>

                        <a id="add-to-cart" class="primary-btn1">ADD TO CART</a>
                        <script>
                            document.querySelector('#add-to-cart').addEventListener('click', function (e) {
                                e.preventDefault();

                                var qty = document.querySelector('.quantity__input').value;

                                var productId = '<?php echo $product['product_id']; ?>';

                                var newHref = 'addtocart.php?id=' + productId + '&qty=' + qty;

                                window.location.href = newHref;
                            });
                        </script>
                    </div>


                </div>
            </div>
        </div>

        <div class="product-description-and-review-area style-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="nav nav2 nav-pills" id="v-pills-tab2" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="pill"
                            data-bs-target="#description" type="button" role="tab" aria-controls="description"
                            aria-selected="true">Product Details</button>
                        <button class="nav-link" id="ingredients-tab" data-bs-toggle="pill"
                            data-bs-target="#ingredients" type="button" role="tab" aria-controls="ingredients"
                            aria-selected="false">Ingredients</button>
                        <button class="nav-link" id="review-tab" data-bs-toggle="pill" data-bs-target="#additional-info"
                            type="button" role="tab" aria-controls="additional-info" aria-selected="false">Additional
                            Information</button>
                        <button class="nav-link" id="customer-reviews-tab" data-bs-toggle="pill"
                            data-bs-target="#customer-reviews" type="button" role="tab" aria-controls="customer-reviews"
                            aria-selected="false">Customer Reviews</button>
                    </div>

                    <div class="tab-content tab-content2" id="v-pills-tabContent2">
                        <div class="tab-pane fade active show" id="description" role="tabpanel"
                            aria-labelledby="description-tab">
                            <div class="description">
                                <p><span style="font-weight:bold">Ideal for: </span><?php echo $product['ideal_for']; ?>
                                </p>
                                <p><?php echo $howToUse; ?></p>
                                <p><?php echo $productBenefits; ?></p>
                                <?php if (isset($warningStatement)) { ?>
                                    <p><strong>Warning:</strong> <?php echo $warningStatement; ?></p>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="ingredients" role="tabpanel" aria-labelledby="ingredients-tab">
                            <p><strong>Ingredients:</strong> <?php echo $allIngredients; ?></p>
                        </div>

                        <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="review-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Attribute</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Brand</td>
                                        <td><?php echo $brandName ?></td>
                                    </tr>
                                    <tr>
                                        <td>Product Type</td>
                                        <td><?php echo $product['product_type_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Skin Concerns</td>
                                        <td><?php echo $product['concern_name'] ?></td>

                                    </tr>
                                    <tr>
                                        <td>Size</td>
                                        <td><?php echo $size ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Regimen Recommendation
                                        </td>
                                        <td><?php echo $regimen ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="tab-pane fade" id="customer-reviews" role="tabpanel"
                            aria-labelledby="customer-reviews-tab">

                            <div class="review" style="display: flex; ">
                                <!-- Review Item 1 -->
                                <div class="card mb-3 w-auto">
                                    <div class="card-body">
                                        <h6 class="card-title">Jane Doe</h6>
                                        <p class="card-text">
                                            <strong>Rating:</strong>
                                            <span class="text-warning">
                                                ★★★★☆
                                            </span>
                                        </p>
                                        <p class="card-text">This toner is amazing! It helped clear up my acne and left
                                            my skin feeling fresh and hydrated. I use it every night before bed, and my
                                            skin has never looked better. Highly recommend!</p>
                                    </div>
                                </div>

                                <!-- Review Item 2 -->
                                <div class="card mb-3 w-auto">
                                    <div class="card-body">
                                        <h6 class="card-title">John Smith</h6>
                                        <p class="card-text">
                                            <strong>Rating:</strong>
                                            <span class="text-warning">
                                                ★★★☆☆
                                            </span>
                                        </p>
                                        <p class="card-text">I’ve been using this product for a few weeks now, and I
                                            noticed some improvement in my skin texture. However, I still have some
                                            breakouts, so it may take more time to see full results. It’s good but not a
                                            miracle worker.</p>
                                    </div>
                                </div>

                                <!-- Review Item 3 -->
                                <div class="card mb-3 w-auto">
                                    <div class="card-body">
                                        <h6 class="card-title">Alice Johnson</h6>
                                        <p class="card-text">
                                            <strong>Rating:</strong>
                                            <span class="text-warning">
                                                ★★★★★
                                            </span>
                                        </p>
                                        <p class="card-text">Absolutely love this toner! It’s perfect for my sensitive
                                            skin, and I haven’t had any irritation. It really helped with my pores and
                                            gave my skin a healthy glow. I will definitely repurchase!</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- product details ends here -->
<div class="skin-care-testimonials-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 position-relative pt-30">
                <div class="swiper feedback-slider swiper-initialized swiper-horizontal swiper-backface-hidden">
                    <div class="swiper-wrapper" id="swiper-wrapper-4101082c8c98aa39fa" aria-live="off">
                        <?php
                        $sql = "SELECT reel_url FROM reels WHERE product_id='$escapedId'";
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
                                <iframe src="<?php echo $row['reel_url'] ?>/embed" width="400" height="560" frameborder="0"
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
<!-- related product strats here -->
<div class="modal product-view-modal" id="product-view">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="close-btn" data-bs-dismiss="modal">
                </div>
                <div class="product-details-page">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-img-wrap">
                                <div class="slider-btn-groups">
                                    <div class="slider-btn product-prev">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.0039 13.0034C10.0037 10.503 5.00286 8.00255 2.00234 7.00237C5.00286 6.0022 9.50364 4.50194 11.0039 1.00133"
                                                stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                    <div class="slider-btn product-next">
                                        <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.998047 12.9995C1.99805 10.4995 6.99805 7.99951 9.99805 6.99951C6.99805 5.99951 2.49805 4.49951 0.998047 0.999512"
                                                stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="swiper product-image-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="product-img product-img--main" data-scale="1.4"
                                                data-image="assets/image/hair-salon/product/product-dt-01.png">
                                                <img src="assets/image/hair-salon/product/product-dt-01.png" alt="">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="product-img product-img--main" data-scale="1.4"
                                                data-image="assets/image/hair-salon/product/product-dt-01.png">
                                                <img src="assets/image/hair-salon/product/product-dt-01.png" alt="">
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="product-img product-img--main" data-scale="1.4"
                                                data-image="assets/image/hair-salon/product/product-dt-01.png">
                                                <img src="assets/image/hair-salon/product/product-dt-01.png" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details-content style-2">
                                <div class="rating">
                                    <div class="star">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <a href="#reviews">(2 REVIEWS)</a>
                                </div>
                                <h2>Toning Shampoo</h2>
                                <p>It provides an opportunity for people to connect with friends or family members
                                    while receiving treatments together.</p>
                                <span class="price">$150.00 <del>$200.00</del></span>
                                <div class="quantity-bag">
                                    <div class="quantity-counter">
                                        <a href="#" class="quantity__minus"><i class='bi bi-dash'></i></a>
                                        <input name="quantity" type="text" class="quantity__input" value="01">
                                        <a href="#" class="quantity__plus"><i class='bi bi-plus'></i></a>
                                    </div>
                                    <a class="primary-btn1" href="cart.php">ADD TO BAG</a>
                                </div>

                                <ul class="product-info-list">
                                    <li> <span>SKU:</span> D32-5H23</li>
                                    <li> <span>Category:</span> <a href="shop-list.html">Sun Care</a></li>
                                    <li> <span>Tags:</span> <a href="product-listing.html">Skin Care</a>, <a
                                            href="product-listing.html">Sun Care</a></li>
                                </ul>

                                <div class="payment-method">
                                    <h6>Safe Checkout</h6>
                                    <ul class="payment-card-list">
                                        <li><img src="assets/image/hair-salon/product/visa.png" alt=""></li>
                                        <li><img src="assets/image/hair-salon/product/discover.png" alt=""></li>
                                        <li><img src="assets/image/hair-salon/product/master-card.png" alt=""></li>
                                        <li><img src="assets/image/hair-salon/product/stripe.png" alt=""></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="related-product mb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-60">
                <div class="spa-section-title">
                    <h2>related products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="swiper related-product-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="spa-product-card hover-img">
                                <div class="spa-product-image">
                                    <a href="product-details.php">
                                        <img src="assets/image/beauty-spa/spa-product-image.png" alt="">
                                    </a>
                                    <div class="view-and-cart-area">
                                        <ul>
                                            <li><span>Quick View</span>
                                                <a class="view" data-bs-toggle="modal" data-bs-target="#product-view">
                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M18 9C18 9 14.625 2.8125 9 2.8125C3.375 2.8125 0 9 0 9C0 9 3.375 15.1875 9 15.1875C14.625 15.1875 18 9 18 9ZM1.31963 9C1.86275 8.17266 2.48846 7.40259 3.18712 6.70162C4.635 5.2515 6.615 3.9375 9 3.9375C11.385 3.9375 13.3639 5.2515 14.814 6.70162C15.5127 7.40259 16.1384 8.17266 16.6815 9C16.617 9.0975 16.5439 9.2055 16.4621 9.324C16.0853 9.864 15.5284 10.584 14.814 11.2984C13.3639 12.7485 11.3839 14.0625 9 14.0625C6.61613 14.0625 4.63613 12.7485 3.186 11.2984C2.48734 10.5974 1.86275 9.82734 1.31963 9Z">
                                                        </path>
                                                        <path
                                                            d="M9 6.1875C8.25408 6.1875 7.53871 6.48382 7.01126 7.01126C6.48382 7.53871 6.1875 8.25408 6.1875 9C6.1875 9.74592 6.48382 10.4613 7.01126 10.9887C7.53871 11.5162 8.25408 11.8125 9 11.8125C9.74592 11.8125 10.4613 11.5162 10.9887 10.9887C11.5162 10.4613 11.8125 9.74592 11.8125 9C11.8125 8.25408 11.5162 7.53871 10.9887 7.01126C10.4613 6.48382 9.74592 6.1875 9 6.1875ZM5.0625 9C5.0625 7.95571 5.47734 6.95419 6.21577 6.21577C6.95419 5.47734 7.95571 5.0625 9 5.0625C10.0443 5.0625 11.0458 5.47734 11.7842 6.21577C12.5227 6.95419 12.9375 7.95571 12.9375 9C12.9375 10.0443 12.5227 11.0458 11.7842 11.7842C11.0458 12.5227 10.0443 12.9375 9 12.9375C7.95571 12.9375 6.95419 12.5227 6.21577 11.7842C5.47734 11.0458 5.0625 10.0443 5.0625 9Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="whistlist.html">
                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13.3883 16.875H4.61328C2.75703 16.875 1.23828 15.3562 1.23828 13.5V13.3875L1.57578 4.3875C1.63203 2.53125 3.15078 1.125 4.95078 1.125H13.0508C14.8508 1.125 16.3695 2.53125 16.4258 4.3875L16.7633 13.3875C16.8195 14.2875 16.482 15.1313 15.8633 15.8063C15.2445 16.4812 14.4008 16.875 13.5008 16.875H13.3883ZM4.95078 2.25C3.71328 2.25 2.75703 3.20625 2.70078 4.3875L2.36328 13.5C2.36328 14.7375 3.37578 15.75 4.61328 15.75H13.5008C14.1195 15.75 14.682 15.4688 15.0758 15.0188C15.4695 14.5688 15.6945 14.0062 15.6945 13.3875L15.357 4.3875C15.3008 3.15 14.3445 2.25 13.107 2.25H4.95078Z">
                                                        </path>
                                                        <path
                                                            d="M9 7.875C6.80625 7.875 5.0625 6.13125 5.0625 3.9375C5.0625 3.6 5.2875 3.375 5.625 3.375C5.9625 3.375 6.1875 3.6 6.1875 3.9375C6.1875 5.5125 7.425 6.75 9 6.75C10.575 6.75 11.8125 5.5125 11.8125 3.9375C11.8125 3.6 12.0375 3.375 12.375 3.375C12.7125 3.375 12.9375 3.6 12.9375 3.9375C12.9375 6.13125 11.1937 7.875 9 7.875Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="spa-product-content text-center">
                                    <ul class="star">
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                    </ul>
                                    <h4><a href="product-details.php">Ordinary Niacinamide
                                            10% + Zinc 1%</a></h4>
                                    <span>$545.0</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="spa-product-card hover-img">
                                <div class="spa-product-image">
                                    <a href="product-details.php">
                                        <img src="assets/image/beauty-spa/spa-product-image2.png" alt="">
                                    </a>
                                    <div class="view-and-cart-area">
                                        <ul>
                                            <li><span>Quick View</span>
                                                <a class="view" data-bs-toggle="modal" data-bs-target="#product-view">

                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M18 9C18 9 14.625 2.8125 9 2.8125C3.375 2.8125 0 9 0 9C0 9 3.375 15.1875 9 15.1875C14.625 15.1875 18 9 18 9ZM1.31963 9C1.86275 8.17266 2.48846 7.40259 3.18712 6.70162C4.635 5.2515 6.615 3.9375 9 3.9375C11.385 3.9375 13.3639 5.2515 14.814 6.70162C15.5127 7.40259 16.1384 8.17266 16.6815 9C16.617 9.0975 16.5439 9.2055 16.4621 9.324C16.0853 9.864 15.5284 10.584 14.814 11.2984C13.3639 12.7485 11.3839 14.0625 9 14.0625C6.61613 14.0625 4.63613 12.7485 3.186 11.2984C2.48734 10.5974 1.86275 9.82734 1.31963 9Z">
                                                        </path>
                                                        <path
                                                            d="M9 6.1875C8.25408 6.1875 7.53871 6.48382 7.01126 7.01126C6.48382 7.53871 6.1875 8.25408 6.1875 9C6.1875 9.74592 6.48382 10.4613 7.01126 10.9887C7.53871 11.5162 8.25408 11.8125 9 11.8125C9.74592 11.8125 10.4613 11.5162 10.9887 10.9887C11.5162 10.4613 11.8125 9.74592 11.8125 9C11.8125 8.25408 11.5162 7.53871 10.9887 7.01126C10.4613 6.48382 9.74592 6.1875 9 6.1875ZM5.0625 9C5.0625 7.95571 5.47734 6.95419 6.21577 6.21577C6.95419 5.47734 7.95571 5.0625 9 5.0625C10.0443 5.0625 11.0458 5.47734 11.7842 6.21577C12.5227 6.95419 12.9375 7.95571 12.9375 9C12.9375 10.0443 12.5227 11.0458 11.7842 11.7842C11.0458 12.5227 10.0443 12.9375 9 12.9375C7.95571 12.9375 6.95419 12.5227 6.21577 11.7842C5.47734 11.0458 5.0625 10.0443 5.0625 9Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="whistlist.html">
                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13.3883 16.875H4.61328C2.75703 16.875 1.23828 15.3562 1.23828 13.5V13.3875L1.57578 4.3875C1.63203 2.53125 3.15078 1.125 4.95078 1.125H13.0508C14.8508 1.125 16.3695 2.53125 16.4258 4.3875L16.7633 13.3875C16.8195 14.2875 16.482 15.1313 15.8633 15.8063C15.2445 16.4812 14.4008 16.875 13.5008 16.875H13.3883ZM4.95078 2.25C3.71328 2.25 2.75703 3.20625 2.70078 4.3875L2.36328 13.5C2.36328 14.7375 3.37578 15.75 4.61328 15.75H13.5008C14.1195 15.75 14.682 15.4688 15.0758 15.0188C15.4695 14.5688 15.6945 14.0062 15.6945 13.3875L15.357 4.3875C15.3008 3.15 14.3445 2.25 13.107 2.25H4.95078Z">
                                                        </path>
                                                        <path
                                                            d="M9 7.875C6.80625 7.875 5.0625 6.13125 5.0625 3.9375C5.0625 3.6 5.2875 3.375 5.625 3.375C5.9625 3.375 6.1875 3.6 6.1875 3.9375C6.1875 5.5125 7.425 6.75 9 6.75C10.575 6.75 11.8125 5.5125 11.8125 3.9375C11.8125 3.6 12.0375 3.375 12.375 3.375C12.7125 3.375 12.9375 3.6 12.9375 3.9375C12.9375 6.13125 11.1937 7.875 9 7.875Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="spa-product-content text-center">
                                    <ul class="star">
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                    </ul>
                                    <h4><a href="product-details.php">EltaMD UV Clear Broad-Spectrum SPF 46</a></h4>
                                    <span>$545.0</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="spa-product-card hover-img">
                                <div class="spa-product-image">
                                    <a href="product-details.php">
                                        <img src="assets/image/beauty-spa/spa-product-image3.png" alt="">
                                    </a>
                                    <span class="batch">SALE!</span>
                                    <div class="view-and-cart-area">
                                        <ul>
                                            <li><span>Quick View</span>
                                                <a class="view" data-bs-toggle="modal" data-bs-target="#product-view">

                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M18 9C18 9 14.625 2.8125 9 2.8125C3.375 2.8125 0 9 0 9C0 9 3.375 15.1875 9 15.1875C14.625 15.1875 18 9 18 9ZM1.31963 9C1.86275 8.17266 2.48846 7.40259 3.18712 6.70162C4.635 5.2515 6.615 3.9375 9 3.9375C11.385 3.9375 13.3639 5.2515 14.814 6.70162C15.5127 7.40259 16.1384 8.17266 16.6815 9C16.617 9.0975 16.5439 9.2055 16.4621 9.324C16.0853 9.864 15.5284 10.584 14.814 11.2984C13.3639 12.7485 11.3839 14.0625 9 14.0625C6.61613 14.0625 4.63613 12.7485 3.186 11.2984C2.48734 10.5974 1.86275 9.82734 1.31963 9Z">
                                                        </path>
                                                        <path
                                                            d="M9 6.1875C8.25408 6.1875 7.53871 6.48382 7.01126 7.01126C6.48382 7.53871 6.1875 8.25408 6.1875 9C6.1875 9.74592 6.48382 10.4613 7.01126 10.9887C7.53871 11.5162 8.25408 11.8125 9 11.8125C9.74592 11.8125 10.4613 11.5162 10.9887 10.9887C11.5162 10.4613 11.8125 9.74592 11.8125 9C11.8125 8.25408 11.5162 7.53871 10.9887 7.01126C10.4613 6.48382 9.74592 6.1875 9 6.1875ZM5.0625 9C5.0625 7.95571 5.47734 6.95419 6.21577 6.21577C6.95419 5.47734 7.95571 5.0625 9 5.0625C10.0443 5.0625 11.0458 5.47734 11.7842 6.21577C12.5227 6.95419 12.9375 7.95571 12.9375 9C12.9375 10.0443 12.5227 11.0458 11.7842 11.7842C11.0458 12.5227 10.0443 12.9375 9 12.9375C7.95571 12.9375 6.95419 12.5227 6.21577 11.7842C5.47734 11.0458 5.0625 10.0443 5.0625 9Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="whistlist.html">
                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13.3883 16.875H4.61328C2.75703 16.875 1.23828 15.3562 1.23828 13.5V13.3875L1.57578 4.3875C1.63203 2.53125 3.15078 1.125 4.95078 1.125H13.0508C14.8508 1.125 16.3695 2.53125 16.4258 4.3875L16.7633 13.3875C16.8195 14.2875 16.482 15.1313 15.8633 15.8063C15.2445 16.4812 14.4008 16.875 13.5008 16.875H13.3883ZM4.95078 2.25C3.71328 2.25 2.75703 3.20625 2.70078 4.3875L2.36328 13.5C2.36328 14.7375 3.37578 15.75 4.61328 15.75H13.5008C14.1195 15.75 14.682 15.4688 15.0758 15.0188C15.4695 14.5688 15.6945 14.0062 15.6945 13.3875L15.357 4.3875C15.3008 3.15 14.3445 2.25 13.107 2.25H4.95078Z">
                                                        </path>
                                                        <path
                                                            d="M9 7.875C6.80625 7.875 5.0625 6.13125 5.0625 3.9375C5.0625 3.6 5.2875 3.375 5.625 3.375C5.9625 3.375 6.1875 3.6 6.1875 3.9375C6.1875 5.5125 7.425 6.75 9 6.75C10.575 6.75 11.8125 5.5125 11.8125 3.9375C11.8125 3.6 12.0375 3.375 12.375 3.375C12.7125 3.375 12.9375 3.6 12.9375 3.9375C12.9375 6.13125 11.1937 7.875 9 7.875Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="spa-product-content text-center">
                                    <ul class="star">
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                    </ul>
                                    <h4><a href="product-details.php">Cerave Hydrating Facial Cleanser</a></h4>
                                    <span>$767.0 <del>$837.0</del></span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="spa-product-card hover-img">
                                <div class="spa-product-image">
                                    <a href="product-details.php">
                                        <img src="assets/image/beauty-spa/product-page/spa-product-image5.png" alt="">
                                    </a>
                                    <div class="view-and-cart-area">
                                        <ul>
                                            <li><span>Quick View</span>
                                                <a class="view" data-bs-toggle="modal" data-bs-target="#product-view">

                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M18 9C18 9 14.625 2.8125 9 2.8125C3.375 2.8125 0 9 0 9C0 9 3.375 15.1875 9 15.1875C14.625 15.1875 18 9 18 9ZM1.31963 9C1.86275 8.17266 2.48846 7.40259 3.18712 6.70162C4.635 5.2515 6.615 3.9375 9 3.9375C11.385 3.9375 13.3639 5.2515 14.814 6.70162C15.5127 7.40259 16.1384 8.17266 16.6815 9C16.617 9.0975 16.5439 9.2055 16.4621 9.324C16.0853 9.864 15.5284 10.584 14.814 11.2984C13.3639 12.7485 11.3839 14.0625 9 14.0625C6.61613 14.0625 4.63613 12.7485 3.186 11.2984C2.48734 10.5974 1.86275 9.82734 1.31963 9Z">
                                                        </path>
                                                        <path
                                                            d="M9 6.1875C8.25408 6.1875 7.53871 6.48382 7.01126 7.01126C6.48382 7.53871 6.1875 8.25408 6.1875 9C6.1875 9.74592 6.48382 10.4613 7.01126 10.9887C7.53871 11.5162 8.25408 11.8125 9 11.8125C9.74592 11.8125 10.4613 11.5162 10.9887 10.9887C11.5162 10.4613 11.8125 9.74592 11.8125 9C11.8125 8.25408 11.5162 7.53871 10.9887 7.01126C10.4613 6.48382 9.74592 6.1875 9 6.1875ZM5.0625 9C5.0625 7.95571 5.47734 6.95419 6.21577 6.21577C6.95419 5.47734 7.95571 5.0625 9 5.0625C10.0443 5.0625 11.0458 5.47734 11.7842 6.21577C12.5227 6.95419 12.9375 7.95571 12.9375 9C12.9375 10.0443 12.5227 11.0458 11.7842 11.7842C11.0458 12.5227 10.0443 12.9375 9 12.9375C7.95571 12.9375 6.95419 12.5227 6.21577 11.7842C5.47734 11.0458 5.0625 10.0443 5.0625 9Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="whistlist.html">
                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13.3883 16.875H4.61328C2.75703 16.875 1.23828 15.3562 1.23828 13.5V13.3875L1.57578 4.3875C1.63203 2.53125 3.15078 1.125 4.95078 1.125H13.0508C14.8508 1.125 16.3695 2.53125 16.4258 4.3875L16.7633 13.3875C16.8195 14.2875 16.482 15.1313 15.8633 15.8063C15.2445 16.4812 14.4008 16.875 13.5008 16.875H13.3883ZM4.95078 2.25C3.71328 2.25 2.75703 3.20625 2.70078 4.3875L2.36328 13.5C2.36328 14.7375 3.37578 15.75 4.61328 15.75H13.5008C14.1195 15.75 14.682 15.4688 15.0758 15.0188C15.4695 14.5688 15.6945 14.0062 15.6945 13.3875L15.357 4.3875C15.3008 3.15 14.3445 2.25 13.107 2.25H4.95078Z">
                                                        </path>
                                                        <path
                                                            d="M9 7.875C6.80625 7.875 5.0625 6.13125 5.0625 3.9375C5.0625 3.6 5.2875 3.375 5.625 3.375C5.9625 3.375 6.1875 3.6 6.1875 3.9375C6.1875 5.5125 7.425 6.75 9 6.75C10.575 6.75 11.8125 5.5125 11.8125 3.9375C11.8125 3.6 12.0375 3.375 12.375 3.375C12.7125 3.375 12.9375 3.6 12.9375 3.9375C12.9375 6.13125 11.1937 7.875 9 7.875Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="spa-product-content text-center">
                                    <ul class="star">
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                    </ul>
                                    <h4><a href="product-details.php">olaplex hair perfector repairing treatment</a>
                                    </h4>
                                    <span>$345.0</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="spa-product-card hover-img">
                                <div class="spa-product-image">
                                    <a href="product-details.php">
                                        <img src="assets/image/beauty-spa/product-page/spa-product-image6.png" alt="">
                                    </a>
                                    <div class="view-and-cart-area">
                                        <ul>
                                            <li><span>Quick View</span>
                                                <a class="view" data-bs-toggle="modal" data-bs-target="#product-view">

                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M18 9C18 9 14.625 2.8125 9 2.8125C3.375 2.8125 0 9 0 9C0 9 3.375 15.1875 9 15.1875C14.625 15.1875 18 9 18 9ZM1.31963 9C1.86275 8.17266 2.48846 7.40259 3.18712 6.70162C4.635 5.2515 6.615 3.9375 9 3.9375C11.385 3.9375 13.3639 5.2515 14.814 6.70162C15.5127 7.40259 16.1384 8.17266 16.6815 9C16.617 9.0975 16.5439 9.2055 16.4621 9.324C16.0853 9.864 15.5284 10.584 14.814 11.2984C13.3639 12.7485 11.3839 14.0625 9 14.0625C6.61613 14.0625 4.63613 12.7485 3.186 11.2984C2.48734 10.5974 1.86275 9.82734 1.31963 9Z">
                                                        </path>
                                                        <path
                                                            d="M9 6.1875C8.25408 6.1875 7.53871 6.48382 7.01126 7.01126C6.48382 7.53871 6.1875 8.25408 6.1875 9C6.1875 9.74592 6.48382 10.4613 7.01126 10.9887C7.53871 11.5162 8.25408 11.8125 9 11.8125C9.74592 11.8125 10.4613 11.5162 10.9887 10.9887C11.5162 10.4613 11.8125 9.74592 11.8125 9C11.8125 8.25408 11.5162 7.53871 10.9887 7.01126C10.4613 6.48382 9.74592 6.1875 9 6.1875ZM5.0625 9C5.0625 7.95571 5.47734 6.95419 6.21577 6.21577C6.95419 5.47734 7.95571 5.0625 9 5.0625C10.0443 5.0625 11.0458 5.47734 11.7842 6.21577C12.5227 6.95419 12.9375 7.95571 12.9375 9C12.9375 10.0443 12.5227 11.0458 11.7842 11.7842C11.0458 12.5227 10.0443 12.9375 9 12.9375C7.95571 12.9375 6.95419 12.5227 6.21577 11.7842C5.47734 11.0458 5.0625 10.0443 5.0625 9Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="whistlist.html">
                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13.3883 16.875H4.61328C2.75703 16.875 1.23828 15.3562 1.23828 13.5V13.3875L1.57578 4.3875C1.63203 2.53125 3.15078 1.125 4.95078 1.125H13.0508C14.8508 1.125 16.3695 2.53125 16.4258 4.3875L16.7633 13.3875C16.8195 14.2875 16.482 15.1313 15.8633 15.8063C15.2445 16.4812 14.4008 16.875 13.5008 16.875H13.3883ZM4.95078 2.25C3.71328 2.25 2.75703 3.20625 2.70078 4.3875L2.36328 13.5C2.36328 14.7375 3.37578 15.75 4.61328 15.75H13.5008C14.1195 15.75 14.682 15.4688 15.0758 15.0188C15.4695 14.5688 15.6945 14.0062 15.6945 13.3875L15.357 4.3875C15.3008 3.15 14.3445 2.25 13.107 2.25H4.95078Z">
                                                        </path>
                                                        <path
                                                            d="M9 7.875C6.80625 7.875 5.0625 6.13125 5.0625 3.9375C5.0625 3.6 5.2875 3.375 5.625 3.375C5.9625 3.375 6.1875 3.6 6.1875 3.9375C6.1875 5.5125 7.425 6.75 9 6.75C10.575 6.75 11.8125 5.5125 11.8125 3.9375C11.8125 3.6 12.0375 3.375 12.375 3.375C12.7125 3.375 12.9375 3.6 12.9375 3.9375C12.9375 6.13125 11.1937 7.875 9 7.875Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="spa-product-content text-center">
                                    <ul class="star">
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                    </ul>
                                    <h4><a href="product-details.php">skinActive micellar cleansing water</a></h4>
                                    <span>$588.0</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="spa-product-card hover-img">
                                <div class="spa-product-image">
                                    <a href="product-details.php">
                                        <img src="assets/image/beauty-spa/spa-product-image4.png" alt="">
                                    </a>
                                    <div class="view-and-cart-area">
                                        <ul>
                                            <li><span>Quick View</span>
                                                <a class="view" data-bs-toggle="modal" data-bs-target="#product-view">

                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M18 9C18 9 14.625 2.8125 9 2.8125C3.375 2.8125 0 9 0 9C0 9 3.375 15.1875 9 15.1875C14.625 15.1875 18 9 18 9ZM1.31963 9C1.86275 8.17266 2.48846 7.40259 3.18712 6.70162C4.635 5.2515 6.615 3.9375 9 3.9375C11.385 3.9375 13.3639 5.2515 14.814 6.70162C15.5127 7.40259 16.1384 8.17266 16.6815 9C16.617 9.0975 16.5439 9.2055 16.4621 9.324C16.0853 9.864 15.5284 10.584 14.814 11.2984C13.3639 12.7485 11.3839 14.0625 9 14.0625C6.61613 14.0625 4.63613 12.7485 3.186 11.2984C2.48734 10.5974 1.86275 9.82734 1.31963 9Z">
                                                        </path>
                                                        <path
                                                            d="M9 6.1875C8.25408 6.1875 7.53871 6.48382 7.01126 7.01126C6.48382 7.53871 6.1875 8.25408 6.1875 9C6.1875 9.74592 6.48382 10.4613 7.01126 10.9887C7.53871 11.5162 8.25408 11.8125 9 11.8125C9.74592 11.8125 10.4613 11.5162 10.9887 10.9887C11.5162 10.4613 11.8125 9.74592 11.8125 9C11.8125 8.25408 11.5162 7.53871 10.9887 7.01126C10.4613 6.48382 9.74592 6.1875 9 6.1875ZM5.0625 9C5.0625 7.95571 5.47734 6.95419 6.21577 6.21577C6.95419 5.47734 7.95571 5.0625 9 5.0625C10.0443 5.0625 11.0458 5.47734 11.7842 6.21577C12.5227 6.95419 12.9375 7.95571 12.9375 9C12.9375 10.0443 12.5227 11.0458 11.7842 11.7842C11.0458 12.5227 10.0443 12.9375 9 12.9375C7.95571 12.9375 6.95419 12.5227 6.21577 11.7842C5.47734 11.0458 5.0625 10.0443 5.0625 9Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="whistlist.html">
                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13.3883 16.875H4.61328C2.75703 16.875 1.23828 15.3562 1.23828 13.5V13.3875L1.57578 4.3875C1.63203 2.53125 3.15078 1.125 4.95078 1.125H13.0508C14.8508 1.125 16.3695 2.53125 16.4258 4.3875L16.7633 13.3875C16.8195 14.2875 16.482 15.1313 15.8633 15.8063C15.2445 16.4812 14.4008 16.875 13.5008 16.875H13.3883ZM4.95078 2.25C3.71328 2.25 2.75703 3.20625 2.70078 4.3875L2.36328 13.5C2.36328 14.7375 3.37578 15.75 4.61328 15.75H13.5008C14.1195 15.75 14.682 15.4688 15.0758 15.0188C15.4695 14.5688 15.6945 14.0062 15.6945 13.3875L15.357 4.3875C15.3008 3.15 14.3445 2.25 13.107 2.25H4.95078Z">
                                                        </path>
                                                        <path
                                                            d="M9 7.875C6.80625 7.875 5.0625 6.13125 5.0625 3.9375C5.0625 3.6 5.2875 3.375 5.625 3.375C5.9625 3.375 6.1875 3.6 6.1875 3.9375C6.1875 5.5125 7.425 6.75 9 6.75C10.575 6.75 11.8125 5.5125 11.8125 3.9375C11.8125 3.6 12.0375 3.375 12.375 3.375C12.7125 3.375 12.9375 3.6 12.9375 3.9375C12.9375 6.13125 11.1937 7.875 9 7.875Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="spa-product-content text-center">
                                    <ul class="star">
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                    </ul>
                                    <h4><a href="product-details.php">SkinActive Micellar
                                            Cleansing Water</a></h4>
                                    <span>$234.0</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="spa-product-card hover-img">
                                <div class="spa-product-image">
                                    <a href="product.html">
                                        <img src="assets/image/beauty-spa/product-page/spa-product-image7.png" alt="">
                                    </a>
                                    <div class="view-and-cart-area">
                                        <ul>
                                            <li><span>Quick View</span>
                                                <a class="view" data-bs-toggle="modal" data-bs-target="#product-view">

                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M18 9C18 9 14.625 2.8125 9 2.8125C3.375 2.8125 0 9 0 9C0 9 3.375 15.1875 9 15.1875C14.625 15.1875 18 9 18 9ZM1.31963 9C1.86275 8.17266 2.48846 7.40259 3.18712 6.70162C4.635 5.2515 6.615 3.9375 9 3.9375C11.385 3.9375 13.3639 5.2515 14.814 6.70162C15.5127 7.40259 16.1384 8.17266 16.6815 9C16.617 9.0975 16.5439 9.2055 16.4621 9.324C16.0853 9.864 15.5284 10.584 14.814 11.2984C13.3639 12.7485 11.3839 14.0625 9 14.0625C6.61613 14.0625 4.63613 12.7485 3.186 11.2984C2.48734 10.5974 1.86275 9.82734 1.31963 9Z">
                                                        </path>
                                                        <path
                                                            d="M9 6.1875C8.25408 6.1875 7.53871 6.48382 7.01126 7.01126C6.48382 7.53871 6.1875 8.25408 6.1875 9C6.1875 9.74592 6.48382 10.4613 7.01126 10.9887C7.53871 11.5162 8.25408 11.8125 9 11.8125C9.74592 11.8125 10.4613 11.5162 10.9887 10.9887C11.5162 10.4613 11.8125 9.74592 11.8125 9C11.8125 8.25408 11.5162 7.53871 10.9887 7.01126C10.4613 6.48382 9.74592 6.1875 9 6.1875ZM5.0625 9C5.0625 7.95571 5.47734 6.95419 6.21577 6.21577C6.95419 5.47734 7.95571 5.0625 9 5.0625C10.0443 5.0625 11.0458 5.47734 11.7842 6.21577C12.5227 6.95419 12.9375 7.95571 12.9375 9C12.9375 10.0443 12.5227 11.0458 11.7842 11.7842C11.0458 12.5227 10.0443 12.9375 9 12.9375C7.95571 12.9375 6.95419 12.5227 6.21577 11.7842C5.47734 11.0458 5.0625 10.0443 5.0625 9Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="whistlist.html">
                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13.3883 16.875H4.61328C2.75703 16.875 1.23828 15.3562 1.23828 13.5V13.3875L1.57578 4.3875C1.63203 2.53125 3.15078 1.125 4.95078 1.125H13.0508C14.8508 1.125 16.3695 2.53125 16.4258 4.3875L16.7633 13.3875C16.8195 14.2875 16.482 15.1313 15.8633 15.8063C15.2445 16.4812 14.4008 16.875 13.5008 16.875H13.3883ZM4.95078 2.25C3.71328 2.25 2.75703 3.20625 2.70078 4.3875L2.36328 13.5C2.36328 14.7375 3.37578 15.75 4.61328 15.75H13.5008C14.1195 15.75 14.682 15.4688 15.0758 15.0188C15.4695 14.5688 15.6945 14.0062 15.6945 13.3875L15.357 4.3875C15.3008 3.15 14.3445 2.25 13.107 2.25H4.95078Z">
                                                        </path>
                                                        <path
                                                            d="M9 7.875C6.80625 7.875 5.0625 6.13125 5.0625 3.9375C5.0625 3.6 5.2875 3.375 5.625 3.375C5.9625 3.375 6.1875 3.6 6.1875 3.9375C6.1875 5.5125 7.425 6.75 9 6.75C10.575 6.75 11.8125 5.5125 11.8125 3.9375C11.8125 3.6 12.0375 3.375 12.375 3.375C12.7125 3.375 12.9375 3.6 12.9375 3.9375C12.9375 6.13125 11.1937 7.875 9 7.875Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="spa-product-content text-center">
                                    <ul class="star">
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                    </ul>
                                    <h4><a href="product-details.php">cerave hydrating facial cleanser</a></h4>
                                    <span>$234.0</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="spa-product-card hover-img">
                                <div class="spa-product-image">
                                    <a href="product.html">
                                        <img src="assets/image/beauty-spa/product-page/spa-product-image8.png" alt="">
                                    </a>
                                    <div class="view-and-cart-area">
                                        <ul>
                                            <li><span>Quick View</span>
                                                <a class="view" data-bs-toggle="modal" data-bs-target="#product-view">

                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M18 9C18 9 14.625 2.8125 9 2.8125C3.375 2.8125 0 9 0 9C0 9 3.375 15.1875 9 15.1875C14.625 15.1875 18 9 18 9ZM1.31963 9C1.86275 8.17266 2.48846 7.40259 3.18712 6.70162C4.635 5.2515 6.615 3.9375 9 3.9375C11.385 3.9375 13.3639 5.2515 14.814 6.70162C15.5127 7.40259 16.1384 8.17266 16.6815 9C16.617 9.0975 16.5439 9.2055 16.4621 9.324C16.0853 9.864 15.5284 10.584 14.814 11.2984C13.3639 12.7485 11.3839 14.0625 9 14.0625C6.61613 14.0625 4.63613 12.7485 3.186 11.2984C2.48734 10.5974 1.86275 9.82734 1.31963 9Z">
                                                        </path>
                                                        <path
                                                            d="M9 6.1875C8.25408 6.1875 7.53871 6.48382 7.01126 7.01126C6.48382 7.53871 6.1875 8.25408 6.1875 9C6.1875 9.74592 6.48382 10.4613 7.01126 10.9887C7.53871 11.5162 8.25408 11.8125 9 11.8125C9.74592 11.8125 10.4613 11.5162 10.9887 10.9887C11.5162 10.4613 11.8125 9.74592 11.8125 9C11.8125 8.25408 11.5162 7.53871 10.9887 7.01126C10.4613 6.48382 9.74592 6.1875 9 6.1875ZM5.0625 9C5.0625 7.95571 5.47734 6.95419 6.21577 6.21577C6.95419 5.47734 7.95571 5.0625 9 5.0625C10.0443 5.0625 11.0458 5.47734 11.7842 6.21577C12.5227 6.95419 12.9375 7.95571 12.9375 9C12.9375 10.0443 12.5227 11.0458 11.7842 11.7842C11.0458 12.5227 10.0443 12.9375 9 12.9375C7.95571 12.9375 6.95419 12.5227 6.21577 11.7842C5.47734 11.0458 5.0625 10.0443 5.0625 9Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="whistlist.html">
                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13.3883 16.875H4.61328C2.75703 16.875 1.23828 15.3562 1.23828 13.5V13.3875L1.57578 4.3875C1.63203 2.53125 3.15078 1.125 4.95078 1.125H13.0508C14.8508 1.125 16.3695 2.53125 16.4258 4.3875L16.7633 13.3875C16.8195 14.2875 16.482 15.1313 15.8633 15.8063C15.2445 16.4812 14.4008 16.875 13.5008 16.875H13.3883ZM4.95078 2.25C3.71328 2.25 2.75703 3.20625 2.70078 4.3875L2.36328 13.5C2.36328 14.7375 3.37578 15.75 4.61328 15.75H13.5008C14.1195 15.75 14.682 15.4688 15.0758 15.0188C15.4695 14.5688 15.6945 14.0062 15.6945 13.3875L15.357 4.3875C15.3008 3.15 14.3445 2.25 13.107 2.25H4.95078Z">
                                                        </path>
                                                        <path
                                                            d="M9 7.875C6.80625 7.875 5.0625 6.13125 5.0625 3.9375C5.0625 3.6 5.2875 3.375 5.625 3.375C5.9625 3.375 6.1875 3.6 6.1875 3.9375C6.1875 5.5125 7.425 6.75 9 6.75C10.575 6.75 11.8125 5.5125 11.8125 3.9375C11.8125 3.6 12.0375 3.375 12.375 3.375C12.7125 3.375 12.9375 3.6 12.9375 3.9375C12.9375 6.13125 11.1937 7.875 9 7.875Z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="spa-product-content text-center">
                                    <ul class="star">
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                        <li><i class="bi bi-star-fill"></i></li>
                                    </ul>
                                    <h4><a href="product-details.php">opi nail envy nail strengthener</a></h4>
                                    <span>$200.0 <del>$234.0</del></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center pt-50">
                <div class="slider-btn-wrap">
                    <div class="slider-btn feedback-slider-prev">
                        <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 13C11 10.5 6 8 3 7C6 6 10.5 4.5 12 1" stroke-width="1.5"
                                stroke-linecap="round"></path>
                        </svg>
                    </div>
                    <div class="fractional-pagination"></div>
                    <div class="slider-btn feedback-slider-next">
                        <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1C2 3.5 7 6 10 7C7 8 2.5 9.5 1 13" stroke-width="1.5" stroke-linecap="round">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- related product strats here -->


<?php
include_once("footer.php")
    ?>