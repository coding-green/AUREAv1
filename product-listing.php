<?php
include_once("header.php");
include_once("config.php");
include_once("function.php");

$params = [
    'type' => isset($_GET['type']) ? $_GET['type'] : '',
    'name' => isset($_GET['name']) ? $_GET['name'] : '',
    'brand' => isset($_GET['brand']) ? $_GET['brand'] : '',
    'skin_type' => isset($_GET['skin_type']) ? $_GET['skin_type'] : '',
    'price_min' => isset($_GET['price_min']) ? $_GET['price_min'] / $exchangeRate : '',
    'price_max' => isset($_GET['price_max']) ? $_GET['price_max'] / $exchangeRate : '',
    'skin_concern' => isset($_GET['skin_concern']) ? $_GET['skin_concern'] : '',
];

$sql = "SELECT p.*, pi.main_image_path as MainPathImage FROM Products p
        LEFT JOIN product_images pi ON p.product_id = pi.product_id
        WHERE p.status = 'active'";

$result = $conn->query($sql);

$totalRows = $result->num_rows;
$conditions = [];
$values = [];

if ($params['type'] != '') {
    $conditions[] = "p.product_type LIKE ?";
    $values[] = '%' . $params['type'] . '%';
}
if ($params['name'] != '') {
    $conditions[] = "p.product_name LIKE ?";
    $values[] = '%' . $params['name'] . '%';
}
if ($params['skin_concern'] != '') {
    $conditions[] = "FIND_IN_SET(?, p.skin_concern)";
    $values[] = $params['skin_concern'];
}
if ($params['brand'] != '') {
    $conditions[] = "p.brand LIKE ?";
    $values[] = '%' . $params['brand'] . '%';
}
if ($params['skin_type'] != '') {
    $conditions[] = "p.skin_type LIKE ?";
    $values[] = '%' . $params['skin_type'] . '%';
}
if ($params['price_min'] != '') {
    $conditions[] = "p.price >= ?";
    $values[] = $params['price_min'];
}
if ($params['price_max'] != '') {
    $conditions[] = "p.price <= ?";
    $values[] = $params['price_max'];
}

if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);

if (!empty($values)) {
    $types = str_repeat('s', count($values));
     
    // Adjust the data type for price parameters if needed.
    $price_param_count = 0;
    if($params['price_min'] != ''){
        $price_param_count++;
    }
    if($params['price_max'] != ''){
        $price_param_count++;
    }

    if ($price_param_count > 0) {

         $types_array = str_split($types);
         $index_min_price = array_search( ($params['price_min'] != ''), $values, true );
         if($index_min_price !== false){
            $types_array[$index_min_price] = 'd';
         }
         $index_max_price = array_search( ($params['price_max'] != ''), $values, true );
         if($index_max_price !== false){
            $types_array[$index_max_price] = 'd';
         }

        $types =  implode('', $types_array);
    }
  
    
    $stmt->bind_param($types, ...$values);
}

$stmt->execute();

if ($stmt->error) {
    die('Execute error: ' . $stmt->error);
}

$result = $stmt->get_result();
$num_rows = $result->num_rows;
if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}

$stmt->close();
?>
<!-- breadcrumb section strats here -->
<div class="skin-care-breadcrumb-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center">
                <div class="banner-content text-center">
                    <h1>PRODUCT</h1>
                    <ul class="breadcrumb-list">
                        <li><a href="index.html">Home</a></li>
                        <li>PRODUCT</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb section ends here -->

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
                                    <a class="primary-btn1" href="cart.html">ADD TO BAG</a>
                                </div>

                                <ul class="product-info-list">
                                    <li> <span>SKU:</span> D32-5H23</li>
                                    <li> <span>Category:</span> <a href="shop-list.html">Sun Care</a></li>
                                    <li> <span>Tags:</span> <a href="product-listing.php">Skin Care</a>, <a
                                            href="product-listing.php">Sun Care</a></li>
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
<div class="product-page pt-20 mb-60">
    <div class="container">
        <div class="row g-xl-4 gy-5">
            <div class="col-xl-3 col-lg-4 order-lg-1 order-2 mobile-shop-menu" style="height: fit-content;position: sticky; top: 80px;
">
                <div class="shop-sidebar wow animate fadeInLeft" data-wow-delay="200ms" data-wow-duration="1500ms">
                    <div class="single-widgets widget_search mb-25" style="
    margin-bottom: 10px;
">
                        <form>
                            <div class="wp-block-search__inside-wrapper ">
                                <input type="search" id="wp-block-search__input-1" class="wp-block-search__input"
                                    name="name" value="" placeholder="Search Product" required="" style="
    height: 40px;
    border-bottom-left-radius: 14px;
    border-top-left-radius: 14px;
">
                                <button type="submit" class="wp-block-search__button" style="
    height: 40px;
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
">
                                    <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.7425 10.3418C12.7107 9.0205 13.1444 7.38236 12.9567 5.75508C12.769 4.1278 11.9739 2.63139 10.7303 1.56522C9.48666 0.49905 7.88635 -0.0582469 6.2495 0.0048239C4.61265 0.0678947 3.05997 0.746681 1.90209 1.90538C0.744221 3.06409 0.0665459 4.61725 0.00464636 6.25415C-0.0572531 7.89104 0.501188 9.49095 1.56825 10.7338C2.63531 11.9766 4.13229 12.7707 5.7597 12.9572C7.38711 13.1438 9.02494 12.7089 10.3455 11.7397H10.3445C10.3745 11.7797 10.4065 11.8177 10.4425 11.8547L14.2924 15.7046C14.4799 15.8922 14.7342 15.9977 14.9995 15.9977C15.2647 15.9978 15.5192 15.8926 15.7068 15.7051C15.8944 15.5176 15.9999 15.2632 16 14.9979C16.0001 14.7327 15.8948 14.4782 15.7073 14.2906L11.8575 10.4408C11.8217 10.4046 11.7833 10.3711 11.7425 10.3408V10.3418ZM12.0004 6.4979C12.0004 7.22015 11.8582 7.93532 11.5818 8.60258C11.3054 9.26985 10.9003 9.87614 10.3896 10.3868C9.87889 10.8975 9.2726 11.3027 8.60533 11.5791C7.93807 11.8554 7.2229 11.9977 6.50065 11.9977C5.77841 11.9977 5.06324 11.8554 4.39597 11.5791C3.72871 11.3027 3.12242 10.8975 2.61171 10.3868C2.10101 9.87614 1.6959 9.26985 1.41951 8.60258C1.14312 7.93532 1.00086 7.22015 1.00086 6.4979C1.00086 5.03927 1.5803 3.64037 2.61171 2.60896C3.64312 1.57755 5.04202 0.99811 6.50065 0.99811C7.95929 0.99811 9.35818 1.57755 10.3896 2.60896C11.421 3.64037 12.0004 5.03927 12.0004 6.4979Z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="main price-slider-main">
                        <div class="price-input-container">
                            <div class="price-input">
                                <div class="price-field">
                                    <input type="number" class="min-input"
                                        value="<?php echo isset($_GET['price_min']) ? $_GET['price_min'] : 0; ?>">
                                </div>
                                <div class="price-field">
                                    <input type="number" class="max-input"
                                        value="<?php echo isset($_GET['price_max']) ? $_GET['price_max'] : $roundedceilvalue; ?>">
                                </div>
                            </div>
                            <div class="slider-container">
                                <div class="price-slider">
                                </div>
                            </div>
                        </div>

                        <!-- Slider -->
                        <div class="range-input">
                            <input type="range" class="min-range" min="0" max="<?php echo $roundedceilvalue ?>"
                                value="<?php echo isset($_GET['price_min']) ? $_GET['price_min'] : 0; ?>" step="1">
                            <input type="range" class="max-range" min="0" max="<?php echo $roundedceilvalue ?>"
                                value="<?php echo isset($_GET['price_max']) ? $_GET['price_max'] : 0; ?>" step="1">
                        </div>
                    </div>
                    <div class="single-widgets style-2 pb-0">
                        <div class="widget-title" style="margin-bottom:18px !important">
                            <h5>skin types:</h5>
                        </div>
                        <p class="wp-block-tag-cloud" style="padding-left:10px;">
                            <?php
                            $sql = "SELECT * FROM SkinTypes";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();

                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                echo '<a href="product-listing.php?skin-type=' . $row['skin_type_id'] . '" style="width:100%;font-size:.9rem;font-family:"Roboto";margin-bottom:0px !important;" class="skin-type-link mb-2">' . htmlspecialchars($row['skin_type_name']) . '</a>';
                            }
                            ?>
                        </p>
                    </div>
                    <div class="single-widgets style-2 pb-0">
                        <div class="widget-title" style="margin-bottom:18px !important">
                            <h5>product types:</h5>
                        </div>
                        <p class="wp-block-tag-cloud" style="padding-left:10px;">
                            <?php
                            $sql = "SELECT * FROM ProductType"; // Assuming you have a 'Tags' table
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();

                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                echo '<a  style="width:100%;font-size:.9rem;font-family:"Roboto";margin-bottom:0px !important;" href="product-listing.php?type=' . $row['product_type_id'] . '">' . htmlspecialchars($row['product_type_name']) . '</a>';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 order-lg-2 order-1">
                <div class="row gy-5">
                    <?php if (!empty($products)):
                        foreach ($products as $product): ?>
                            <div class="shop-product-card col-xl-4 col-sm-6 wow animate fadeInDown" data-wow-delay="200ms"
                                data-wow-duration="1500ms" style="position:relative">
                                <div class="spa-product-card hover-img">
                                    <div class="spa-product-image" style="
    width: 100%;
    background-image:url('assets/image/skin-care/product_background_image.png')">
                                        <span class="batch" style="z-index:100">SALE!</span>
                                        <span class="batch sale-timer" style="z-index:100;left:65px !important;border-radius:100px">12:00:00</span>
                                        <script>function startAllDynamicCountdowns() {
    const saleTimerElements = document.querySelectorAll(".sale-timer");

    saleTimerElements.forEach(saleTimerElement => {

        let timeLeft;
        let timerInterval;

        function updateTimer() {
            const now = new Date();
            const currentHours = now.getHours();
            const currentMinutes = now.getMinutes();
            const currentSeconds = now.getSeconds();

             const currentTimeInSeconds = (currentHours * 60 * 60) + (currentMinutes * 60) + currentSeconds;
            timeLeft = (24 * 60 * 60) - currentTimeInSeconds;

            if (timeLeft <= 0) {
                timeLeft +=  (24 * 60 * 60)
            }


            const hours = String(Math.floor(timeLeft / (60 * 60))).padStart(2, '0');
            const minutes = String(Math.floor((timeLeft % (60 * 60)) / 60)).padStart(2, '0');
            const seconds = String(Math.floor(timeLeft % 60)).padStart(2, '0');

            saleTimerElement.textContent = `${hours}:${minutes}:${seconds}`;
            timeLeft -= 1;

        }

          updateTimer();
         timerInterval = setInterval(updateTimer, 1000);


        // Store the interval id and return a clear function.
       saleTimerElement.stopTimer = () => clearInterval(timerInterval)
    });
}

startAllDynamicCountdowns();
//To stop later use stopTimer() if required
//setTimeout(() => {document.querySelectorAll('.sale-timer').forEach(el=> el.stopTimer()); console.log('stopped')}, 60000) //To test stop after 1min</script>
                                        <a href="product-details.php">
                                        
                                            <img src="<?php echo isset($product['MainPathImage']) && $product['MainPathImage'] ? 'crm/' . $product['MainPathImage'] : 'assets/image/skin-care/default_product_image.jpg'; ?>" alt="Product Image">
                                        </a>
                                        <!-- <div class="view-and-cart-area">
                                            <ul>
                                                <li><span>Quick View</span>
                                                    <a class="view" data-bs-toggle="modal" data-bs-target="#product-view">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M18 9C18 9 14.625 2.8125 9 2.8125C3.375 2.8125 0 9 0 9C0 9 3.375 15.1875 9 15.1875C14.625 15.1875 18 9 18 9ZM1.31963 9C1.86275 8.17266 2.48846 7.40259 3.18712 6.70162C4.635 5.2515 6.615 3.9375 9 3.9375C11.385 3.9375 13.3639 5.2515 14.814 6.70162C15.5127 7.40259 16.1384 8.17266 16.6815 9C16.617 9.0975 16.5439 9.2055 16.4621 9.324C16.0853 9.864 15.5284 10.584 14.814 11.2984C13.3639 12.7485 11.3839 14.0625 9 14.0625C6.61613 14.0625 4.63613 12.7485 3.186 11.2984C2.48734 10.5974 1.86275 9.82734 1.31963 9Z"></path>
                                                            <path d="M9 6.1875C8.25408 6.1875 7.53871 6.48382 7.01126 7.01126C6.48382 7.53871 6.1875 8.25408 6.1875 9C6.1875 9.74592 6.48382 10.4613 7.01126 10.9887C7.53871 11.5162 8.25408 11.8125 9 11.8125C9.74592 11.8125 10.4613 11.5162 10.9887 10.9887C11.5162 10.4613 11.8125 9.74592 11.8125 9C11.8125 8.25408 11.5162 7.53871 10.9887 7.01126C10.4613 6.48382 9.74592 6.1875 9 6.1875ZM5.0625 9C5.0625 7.95571 5.47734 6.95419 6.21577 6.21577C6.95419 5.47734 7.95571 5.0625 9 5.0625C10.0443 5.0625 11.0458 5.47734 11.7842 6.21577C12.5227 6.95419 12.9375 7.95571 12.9375 9C12.9375 10.0443 12.5227 11.0458 11.7842 11.7842C11.0458 12.5227 10.0443 12.9375 9 12.9375C7.95571 12.9375 6.95419 12.5227 6.21577 11.7842C5.47734 11.0458 5.0625 10.0443 5.0625 9Z"></path>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="whistlist.html">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M13.3883 16.875H4.61328C2.75703 16.875 1.23828 15.3562 1.23828 13.5V13.3875L1.57578 4.3875C1.63203 2.53125 3.15078 1.125 4.95078 1.125H13.0508C14.8508 1.125 16.3695 2.53125 16.4258 4.3875L16.7633 13.3875C16.8195 14.2875 16.482 15.1313 15.8633 15.8063C15.2445 16.4812 14.4008 16.875 13.5008 16.875H13.3883ZM4.95078 2.25C3.71328 2.25 2.75703 3.20625 2.70078 4.3875L2.36328 13.5C2.36328 14.7375 3.37578 15.75 4.61328 15.75H13.5008C14.1195 15.75 14.682 15.4688 15.0758 15.0188C15.4695 14.5688 15.6945 14.0062 15.6945 13.3875L15.357 4.3875C15.3008 3.15 14.3445 2.25 13.107 2.25H4.95078Z"></path>
                                                            <path d="M9 7.875C6.80625 7.875 5.0625 6.13125 5.0625 3.9375C5.0625 3.6 5.2875 3.375 5.625 3.375C5.9625 3.375 6.1875 3.6 6.1875 3.9375C6.1875 5.5125 7.425 6.75 9 6.75C10.575 6.75 11.8125 5.5125 11.8125 3.9375C11.8125 3.6 12.0375 3.375 12.375 3.375C12.7125 3.375 12.9375 3.6 12.9375 3.9375C12.9375 6.13125 11.1937 7.875 9 7.875Z"></path>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> -->
                                    </div>
                                    <div class="spa-product-content text-center">

                                        <h4 class="product-card-text product-card-text-margin">
                                        <a class="product-card-text" target="_blank"
                                                href="product-details.php?id=<?php echo $product["product_id"] ?>"><?php echo htmlspecialchars($product['product_name']); ?></a>
                                        </h4>
                                        <span class="product-card-text"><?php if (strtolower($currencyCode) === 'inr') {
    $formattedPrice = round($product["price"] * $exchangeRate); // Round to an integer for INR
} else {
    $formattedPrice = round($product["price"] * $exchangeRate, 2); // Keep 2 decimal places for other currencies
};echo  strtoupper($currencySymbol) . " " . $formattedPrice ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products available at the moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const rangeInput = document.querySelectorAll(".range-input input");
    const priceInput = document.querySelectorAll(".price-input input");

    function updateInputValues() {
        const minRange = parseInt(rangeInput[0].value);
        const maxRange = parseInt(rangeInput[1].value);

        priceInput[0].value = minRange;
        priceInput[1].value = maxRange;
    }

    function updateQueryString() {
        const minPrice = parseInt(priceInput[0].value);
        const maxPrice = parseInt(priceInput[1].value);

        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('price_min', minPrice);
        urlParams.set('price_max', maxPrice);

        window.location.search = urlParams;
    }

    rangeInput.forEach(input => {
        input.addEventListener("change", () => {
            updateInputValues();
            updateQueryString();
        });
    });

    priceInput.forEach(input => {
        input.addEventListener("change", () => {
            updateQueryString();
        });
    });
</script>


<?php
include_once("footer.php")
    ?>