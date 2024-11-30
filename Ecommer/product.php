<?php
// Database connection
// Assuming your connection is established as $conn
// ...

// Search keyword processing
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Catalog Processing
$categories_result = $conn->query("SELECT category_id, category_name FROM categories");
?>

<!-- Search Form -->


<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="?page=product">Product</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Product Area -->
<div class="product-area section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Product Item</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    <div class="nav-main">
                        <!-- Tab Nav -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#all" role="tab">Show All</a></li>
                            <?php
                            if ($categories_result->num_rows > 0) {
                                while ($row = $categories_result->fetch_assoc()) {
                                    echo '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#category' . $row['category_id'] . '" role="tab">' . $row['category_name'] . '</a></li>';
                                }
                            } else {
                                echo "There are no categories.";
                            }
                            ?>
                        </ul>
                        <!--/ End Tab Nav -->
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <!-- Tab "Show All" -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            <div class="tab-single">
                                <div class="row">
                                    <?php
                                    // Sanitize the search input to prevent SQL injection
                                    $search = $conn->real_escape_string($search);

                                    // Updated product SQL query to include search functionality
                                    $product_sql = "SELECT p.product_id, p.product_name, p.price, p.description, pi.image_url 
                                        FROM products p
                                        LEFT JOIN (
                                            SELECT product_id, MIN(image_id) AS min_image_id
                                            FROM product_images
                                            GROUP BY product_id
                                        ) min_pi ON p.product_id = min_pi.product_id
                                        LEFT JOIN product_images pi ON min_pi.min_image_id = pi.image_id
                                        WHERE p.product_name LIKE '%$search%'";  // Search condition

                                    $product_result = $conn->query($product_sql);

                                    if ($product_result->num_rows > 0) {
                                        while ($row = $product_result->fetch_assoc()) {
                                            echo '<div class="col-xl-3 col-lg-4 col-md-4 col-12">';
                                            echo '<div class="single-product">';
                                            echo '<div class="product-img">';
                                            echo '<a href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="' . $row['product_id'] . '" onclick="loadProductDetails(' . $row['product_id'] . ')">';
                                            echo '<img class="default-img fixed-size" src="images/' . $row['image_url'] . '" alt="#">';
                                            echo '<img class="hover-img fixed-size" src="images/' . $row['image_url'] . '" alt="#">';
                                            echo '</a>';
                                            echo '<div class="button-head">';
                                            ?>
                                            <div class="product-action">
                                                <a href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="<?php echo $row['product_id']; ?>" onclick="loadProductDetails(<?php echo $row['product_id']; ?>)">
                                                    <i class="ti-eye"></i><span>Quick Shop</span>
                                                </a>
                                            </div>
                                            <?php
                                            echo '<div class="product-action-2">';
                                            echo '<a title="Add to cart" href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="' . $row['product_id'] . '" onclick="loadProductDetails(' . $row['product_id'] . ')">Add to cart</a>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '<div class="product-content">';
                                            echo '<h3><a href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="' . $row['product_id'] . '" onclick="loadProductDetails(' . $row['product_id'] . ')">' . $row['product_name'] . '</a></h3>';
                                            echo '<div class="product-price">';
                                            echo '<span>$' . $row['price'] . '</span>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo "Không có sản phẩm nào."; // No products found
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Category Tab -->
                        <?php
                        // Re-fetch categories to display in category tabs
                        $categories_result = $conn->query("SELECT category_id, category_name FROM categories");
                        if ($categories_result->num_rows > 0) {
                            while ($category = $categories_result->fetch_assoc()) {
                                echo '<div class="tab-pane fade" id="category' . $category['category_id'] . '" role="tabpanel">';
                                echo '<div class="tab-single">';
                                echo '<div class="row">';

                                $product_sql = "SELECT p.product_id, p.product_name, p.price, p.description, pi.image_url 
                                    FROM products p
                                    LEFT JOIN (
                                        SELECT product_id, MIN(image_id) AS min_image_id
                                        FROM product_images
                                        GROUP BY product_id
                                    ) min_pi ON p.product_id = min_pi.product_id
                                    LEFT JOIN product_images pi ON min_pi.min_image_id = pi.image_id
                                    WHERE p.category_id = " . $category['category_id'];
                                $product_result = $conn->query($product_sql);

                                if ($product_result->num_rows > 0) {
                                    while ($row = $product_result->fetch_assoc()) {
                                        echo '<div class="col-xl-3 col-lg-4 col-md-4 col-12">';
                                        echo '<div class="single-product">';
                                        echo '<div class="product-img">';
                                        echo '<a href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="' . $row['product_id'] . '" onclick="loadProductDetails(' . $row['product_id'] . ')">';
                                        echo '<img class="default-img fixed-size" src="images/' . $row['image_url'] . '" alt="#">';
                                        echo '<img class="hover-img fixed-size" src="images/' . $row['image_url'] . '" alt="#">';
                                        echo '</a>';
                                        echo '<div class="button-head">';
                                        ?>
                                        <div class="product-action">
                                            <a href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="<?php echo $row['product_id']; ?>" onclick="loadProductDetails(<?php echo $row['product_id']; ?>)">
                                                <i class="ti-eye"></i><span>Quick Shop</span>
                                            </a>
                                        </div>
                                        <?php
                                        echo '<div class="product-action-2">';
                                        echo '<a title="Add to cart" href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="' . $row['product_id'] . '" onclick="loadProductDetails(' . $row['product_id'] . ')">Add to cart</a>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '<div class="product-content">';
                                        echo '<h3><a href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="' . $row['product_id'] . '" onclick="loadProductDetails(' . $row['product_id'] . ')">' . $row['product_name'] . '</a></h3>';
                                        echo '<div class="product-price">';
                                        echo '<span>$' . $row['price'] . '</span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "Không có sản phẩm nào."; // No products found
                                }

                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "Không có danh mục nào."; // No categories found
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<!-- End Product Area -->
<script src="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.js"></script>

<script>
function loadProductDetails(productId) {
    // AJAX call to fetch product details by productId
    // Add your AJAX logic here to show the product details in the modal
}
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var search = "<?php echo addslashes($search); ?>";
    console.log("Search keyword:", search); // Check search value

    if (search) {
        // If there is a search keyword, select the "Show All" tab
        var tabAll = document.querySelector('a[href="#all"]');
        if (tabAll) {
            tabAll.classList.add('active');
            var tabContentAll = document.querySelector('#all');
            if (tabContentAll) {
                tabContentAll.classList.add('show', 'active');
            } else {
                console.error("Tab content for 'all' not found");
            }
        } else {
            console.error("Tab link for 'all' not found");
        }
    }
});

</script>


