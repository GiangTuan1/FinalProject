<?php
include 'config.php';
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product details
    $sql = "SELECT p.product_name, p.price, p.description, pi.image_url 
            FROM products p 
            JOIN product_images pi ON p.product_id = pi.product_id 
            WHERE p.product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $product = null;
    $images = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product = [
                'product_name' => $row['product_name'],
                'price' => $row['price'],
                'description' => $row['description']
            ];
            $images[] = $row['image_url'];
        }
    }

    // Fetch product sizes and stock quantities
    $sql_sizes = "SELECT s.size_id, s.size, ps.quantity
                  FROM product_sizes ps 
                  JOIN sizes s ON ps.size_id = s.size_id 
                  WHERE ps.product_id = ?";
    $stmt_sizes = $conn->prepare($sql_sizes);
    $stmt_sizes->bind_param("i", $product_id);
    $stmt_sizes->execute();
    $result_sizes = $stmt_sizes->get_result();

    $sizes = [];
    if ($result_sizes->num_rows > 0) {
        while ($row = $result_sizes->fetch_assoc()) {
            $sizes[] = [
                'id' => $row['size_id'],
                'name' => $row['size'],
                'quantity' => $row['quantity']
            ];
        }
    }

    // Return data as HTML using heredoc
    echo <<<HTML
<div class="row no-gutters">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <!-- Product Carousel -->
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner">
HTML;

    $first = true;
    foreach ($images as $image) {
        $activeClass = $first ? 'active' : '';
        $first = false;
        echo <<<HTML
            <div class="carousel-item {$activeClass}">
                <img src="images/{$image}" class="d-block w-100" alt="Image" style="max-height: 500px; object-fit: cover; width: 100%; height: auto;">
            </div>
HTML;
    }

    echo <<<HTML
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- End Product Carousel -->
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="quickview-content">
            <h2>{$product['product_name']}</h2>
            <h3 id="product-price" data-price="{$product['price']}">\${$product['price']}</h3>
            <div class="quickview-peragraph">
                <p>{$product['description']}</p>
            </div>
            <div class="size">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <h5 class="title">Size</h5>
                        <select id="size">
HTML;

    foreach ($sizes as $size) {
        echo <<<HTML
                    <option value="{$size['id']}" data-stock-quantity="{$size['quantity']}">{$size['name']}</option>
HTML;
    }

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    echo <<<HTML
                        </select>
                    </div>
                </div>
            </div>
            <div class="quantity">
                <div class="input-group">
                    <div class="button minus">
                        <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[1]">
                            <i class="ti-minus"></i>
                        </button>
                    </div>
                    <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="{$sizes[0]['quantity']}" value="1" id="quantity" data-stock-quantity="{$sizes[0]['quantity']}">
                    <div class="button plus">
                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                            <i class="ti-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
HTML;

    if ($user_id) {
        echo <<<HTML
            <div class="add-to-cart">
                <a href="#" class="btn" id="add-to-cart" data-product-id="{$product_id}">Add to cart</a>
            </div>
HTML;
    } else {
        echo <<<HTML
            <div class="add-to-cart">
                <a href="login.php" class="btn" id="login-to-add-to-cart">Login to continue....</a>
            </div>
HTML;
    }

    echo <<<HTML
        </div>
    </div>
</div>
HTML;
}
?>

