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
        $sql = "SELECT p.*,sk.concern_name, pt.product_type_name, b.brands_name, pi.main_image_path as MainPathImage,pi.image_paths
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
            $productId = $product['product_id'];
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
<div class="product-details-page pt-10 mb-50">
    <div class="container">
        <div class="row g-lg-4 gy-5 mb-70">
            <div class="col-xl-5 col-lg-6" style="position:sticky;top:100px;height:fit-content;">
                <div class="product-img-wrap">
                    <div class="swiper product-image-slider mySwiper2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" style="display:flex;justify-content:center">
                                <div class="product-img product-img--main" data-scale="1.4"
                                    style="height:450px;width:450px;">
                                    <img
                                        src="<?php echo isset($product['MainPathImage']) && $product['MainPathImage'] ? 'crm/' . $product['MainPathImage'] : 'https://placehold.co/450x450'; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-button-next" style="color: #000000ad;"></div>
                        <div class="swiper-button-prev" style="color: #000000ad;"></div>
                        <div thumbsSlider="" class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img style="height: 60px;background-color: #becacd;" src="<?php echo isset($product['MainPathImage']) && $product['MainPathImage'] ? 'crm/' . $product['MainPathImage'] : 'https://placehold.co/450x450'; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var swiper = new Swiper(".mySwiper", {
                    loop: true,
                    spaceBetween: 10,
                    slidesPerView: 3,
                    freeMode: true,
                    watchSlidesProgress: true,
                });
                var swiper2 = new Swiper(".mySwiper2", {
                    loop: true,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    thumbs: {
                        swiper: swiper,
                    },
                });
            </script>
            <div class="col-xl-7 col-lg-6">

                <div class="product-details-content style-2" style="
    margin-top: 10px;padding-left:0px;
">
                    <h4><span style="font-size:16px;margin-bottom: .1rem;" class="text-warning">
                            ★★★★☆
                        </span></h4>
                    <h4 style="font-size: 18px;color: grey;margin-bottom: .1rem;"><?php echo $product['brands_name'] ?>
                    </h4>
                    <h3 style="margin-bottom: .1rem; font-weight: 700;"><?php echo $product['product_name']; ?></h3>
                    <p style="margin-bottom: 5px;color: grey;"><?php echo $product['product_tagline'] ?></p>
                    <?php
                    // Split the skin type IDs
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
                                    "Combination Skin" => "#f8c8c8",
                                    "Blemishes" => "#e6d5f3",
                                    "Oily Skin" => "#ffeeba",
                                    "Dry Skin" => "#cce5ff",
                                    "Sensitive Skin" => "#f8d6d6",
                                    "Normal Skin" => "#d4f7d9",
                                    "All Skin Types" => "#f9e6e6",
                                ];

                                // Display skin types
                                if ($skin_types) {
                                    foreach ($skin_types as $skin_type) {
                                        $color = $skinTypeColors[$skin_type] ?? '#e2e3e5'; // Default color
                                        echo "<div class='category' style='background-color: $color;'>$skin_type</div>";
                                    }
                                } else {
                                    echo "<div class='category'>No skin types found.</div>";
                                }
                            } else {
                                echo "<div class='error'>Failed to execute query for skin types.</div>";
                            }
                        } else {
                            echo "<div class='error'>Failed to prepare query for skin types.</div>";
                        }
                    } else {
                        echo "<div class='error'>Invalid skin type IDs.</div>";
                    }

                    // Define concern colors
                    $concernColor = [
                        "Acne & Blemishes" => "#fad4cf",
                        "Dark Spot and Pigmentation" => "#decff5",
                        "Dryness & dehydration" => "#ffedcc",
                        "Dullness or Lackluster Tone" => "#d6e9ff",
                        "Textural Irregularities" => "#fcdede",
                        "Enlarged Pores" => "#d7fbd9",
                        "Redness or Rosacea" => "#ffe6e6",
                        "Signs of Congestion" => "#ffcfcf",
                        "Uneven Skin Tone" => "#fde0e0",
                        "Keratosis Pilaris or Small Bumps" => "#fdd7d7",
                        "Dark Circles" => "#fcf2d7",
                        "Anti-aging" => "#e8d9f7",
                    ];

                    // Display concern
                    $concern_name = $product['concern_name'] ?? 'Unknown';
                    $color = $concernColor[$concern_name] ?? '#e2e3e5'; // Default color
                    echo "<div class='category' style='background-color: $color;'>$concern_name</div>";
                    ?>

                    <style>
                        /* Common styling for categories */
                        .category {
                            display: inline-block;
                            padding: 5px 10px;
                            margin: 5px 0;
                            color: #333333;
                            font-family: Arial, sans-serif;
                            font-size: 14px;
                            font-weight: 500;
                            margin-right: 5px;
                            border-radius: 20px;
                        }

                        .error {
                            color: red;
                            font-weight: bold;
                        }
                    </style>





                    <!--<p style="margin-top:20px"><?php echo $productDescription; ?></p>-->
                    <ul class="product-info-list" style="margin: 10px 0px;">
                        <li>Product Type : <a
                                href="product-listing.php?type=<?php echo $product['product_type_name'] ?>"><?php echo $product['product_type_name'] ?></a>
                        </li>
                        <span class="price"
                            style="margin-bottom: 5px;
    font-size: 36px;
    -webkit-text-stroke: .5px black;"><?php echo round($price * $exchangeRate, 2) . " " . strtoupper($currencyCode); ?></span>
                        <li>Size: <?php echo $product['size']; ?></li>
                        <div class="quantity-bag">
                            <div class="quantity-counter" style="border-radius:10px;background-color:lightgrey;">
                                <a href="#" class="quantity__minus" style='background-color:transparent;'><i
                                        class='bi bi-dash'></i></a>
                                <input name="quantity" type="text" class="quantity__input"
                                    style="background-color:transparent;border:0.1px solid lightgoldenrodyellow;"
                                    value="01">
                                <a href="#" class="quantity__plus" style='background-color:transparent;'><i
                                        class='bi bi-plus'></i></a>
                            </div>

                            <a id="add-to-cart" class="primary-btn1"
                                style='background-color:lightgrey;border:none;border-radius:10px;'>ADD TO CART</a>
                            <script>
                                document.querySelector('#add-to-cart').addEventListener('click', function(e) {
                                    e.preventDefault();

                                    var qty = document.querySelector('.quantity__input').value;

                                    var productId = '<?php echo $product['product_id']; ?>';

                                    var newHref = 'addtocart.php?id=' + productId + '&qty=' + qty;

                                    window.location.href = newHref;
                                });
                            </script>
                        </div>
                        <?php if (isset($product['product_benefits'])) {
                        ?>
                            <h3 style="font-size: 24px;">Benefits: </h3>
                            <li><?php echo $product['product_benefits']; ?></li>
                        <?php } ?>
                        <?php if (isset($product['how_to_use'])) {
                        ?>
                            <h3 style="font-size: 24px;">How to Use: </h3>
                            <li><?php echo $product['product_benefits']; ?></li>
                        <?php } ?>
                    </ul>




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
                            <div class="description d-flex justify-content-between">
                                <div>
                                    <p><span style="font-weight:bold">Ideal for:
                                        </span><?php echo $product['ideal_for']; ?>
                                    </p>
                                    <p><?php echo $howToUse; ?></p>
                                    <p><?php echo $productBenefits; ?></p>
                                    <?php if (isset($warningStatement)) { ?>
                                        <p><strong>Warning:</strong> <?php echo $warningStatement; ?></p>
                                    <?php } ?>
                                </div>
                                <?php
                                $imagePaths = explode(',', $product['image_paths']);
                                ?>
                                <div class="d-none d-lg-block"><img style="max-width: 350px;"
                                        src="crm/<?php echo isset($imagePaths[2]) ? $imagePaths[2] : $product['MainPathImage']; ?>"
                                        alt="Product Image"></div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="ingredients" role="tabpanel" aria-labelledby="ingredients-tab">
                            <div class="d-flex justify-content-between">
                                <p><strong>Ingredients:</strong> <?php echo $allIngredients; ?></p>
                                <?php
                                $imagePaths = explode(',', $product['image_paths']);
                                ?>
                                <div class="d-none d-lg-block"><img style="max-width: 350px;"
                                        src="crm/<?php echo isset($imagePaths[2]) ? $imagePaths[2] : $product['MainPathImage']; ?>"
                                        alt="Product Image"></div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="review-tab">
                            <table class="table" style="width: 30rem;">
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
<?php
$sql = "SELECT
            p.*,
            pi.main_image_path as MainPathImage
        FROM Products p
        LEFT JOIN product_images pi ON p.product_id = pi.product_id
        WHERE p.status = 'active'
        AND p.product_type = ?
        AND p.product_id != ?
        LIMIT 4";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $product['product_type'], $product['product_id']);
$stmt->execute();
$result = $stmt->get_result();


// Check if there are any related products
if ($result->num_rows > 0) {
?>
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
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                // Use a default image if main_image_path is NULL or empty
                                $imagePath = !empty($row['MainPathImage']) ? "crm/" . $row['MainPathImage'] : "assets/image/skin-care/default_product_image.jpg";
                            ?>
                                <div class="swiper-slide border">
                                    <div class="spa-product-card hover-img">
                                        <div class="spa-product-image">
                                            <a href="product-details.php?id=<?php echo $row['product_id']; ?>">
                                                <img src="<?php echo $imagePath; ?>"
                                                    alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                                            </a>
                                        </div>
                                        <div class="spa-product-content text-center">
                                            <h4>
                                                <a href="product-details.php?id=<?php echo $row['product_id']; ?>">
                                                    <?php echo htmlspecialchars($row['product_name']); ?>
                                                </a>
                                            </h4>
                                            <span>$<?php echo htmlspecialchars($row['price']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
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
<?php
}

$stmt->close();
?>
<!-- related product strats here -->


<?php
include_once("footer.php")
?>