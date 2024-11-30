<!--/ End Header -->

<!-- Slider Area -->
<section class="hero-slider">
	<!-- Single Slider -->
	<div class="single-slider">
		<div class="container">
			<div class="row no-gutters">
				<div class="col-lg-9 offset-lg-3 col-12">
					<div class="text-inner">
						<div class="row">
							<div class=" col-12">
								<div class="hero-text">
									<div style="color: white;">
										<h2>Discover the latest sneaker collection!<br>Top quality – Reasonable price <br></h2>
									</div>
									<div class="button">
										<br><a href="?page=product" class="btn">Shop Now!</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/ End Single Slider -->
</section>
<!--/ End Slider Area -->


<!-- Start Product Area -->
<div class="product-area section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2>Trending Item</h2>
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
							$sql = "SELECT category_id, category_name FROM categories";
							$categories_result = $conn->query($sql);

							if ($categories_result->num_rows > 0) {
								while ($row = $categories_result->fetch_assoc()) {
									echo '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#category' . $row['category_id'] . '" role="tab">' . $row['category_name'] . '</a></li>';
								}
							} else {
								echo "Không có danh mục nào.";
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
									$product_sql = "SELECT p.product_id, p.product_name, p.price, p.description, pi.image_url 
										FROM products p
										LEFT JOIN (
											SELECT product_id, MIN(image_id) AS min_image_id
											FROM product_images
											GROUP BY product_id
										) min_pi ON p.product_id = min_pi.product_id
										LEFT JOIN product_images pi ON min_pi.min_image_id = pi.image_id";
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
										echo "Không có sản phẩm nào.";
									}
									?>
								</div>
							</div>
						</div>

						<!-- Tab danh mục -->
						<?php
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
									echo "Không có sản phẩm nào.";
								}

								echo '</div>';
								echo '</div>';
								echo '</div>';
							}
						} else {
							echo "Không có danh mục nào.";
						}
						?>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>
<!-- End Product Area -->

<!-- Start Midium Banner  -->

<!-- End Midium Banner -->
<?php
// $sql = "
// SELECT p.product_id, p.product_name, p.price, pi.image_url, COUNT(oi.product_id) AS order_count
// FROM products p
// JOIN order_items oi ON p.product_id = oi.product_id
// LEFT JOIN product_images pi ON p.product_id = pi.product_id
// GROUP BY p.product_id
// ORDER BY order_count DESC
// LIMIT 8
// ";
// $result = $conn->query($sql);

// $products = [];
// if ($result->num_rows > 0) {
// // Output data of each row
// while($row = $result->fetch_assoc()) {
// 	$products[] = $row;
// }
// } else {
// echo "0 results";
// }
?>
<!-- Start Most Popular -->
<!-- <div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Hot Item</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    <?php foreach ($products as $product): ?>
                    <div class="single-product">
                        <div class="product-img">
                            <a href="product-details.php?id=<?php echo $product['product_id']; ?>">
                                <img class="default-img" src="./images/<?php echo $product['image_url']; ?>" alt="#">
                                <img class="hover-img" src="./images/<?php echo $product['image_url']; ?>" alt="#">
                                <span class="out-of-stock">Hot</span>
                            </a>
                            <div class="button-head">
                                <div class="product-action">
								<a href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="<?php echo $product['product_id']; ?>" onclick="loadProductDetails(<?php echo $product['product_id']; ?>)">
                                </div>
                                <div class="product-action-2">
                                    <a title="Add to cart" href="#" data-toggle="modal" data-target="#exampleModal" data-product-id="<?php echo $product['product_id']; ?>" onclick="loadProductDetails(<?php echo $product['product_id']; ?>)">Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="product-details.php?id=<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></a></h3>
                            <div class="product-price">
                                <span><?php echo '$' . number_format($product['price'], 2); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div> -->
</div>
<!-- End Most Popular Area -->

<!-- <section class="section free-version-banner">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-8 offset-md-2 col-xs-12">
				<div class="section-title mb-60">
					<span class="text-white wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">Eshop Free Lite version</span>
					<h2 class="text-white wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">Currently You are using free<br> lite Version of Eshop.</h2>
					<p class="text-white wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">Please, purchase full version of the template to get all pages,<br> features and commercial license.</p>

					<div class="button">
						<a href="https://wpthemesgrid.com/downloads/eshop-ecommerce-html5-template/" target="_blank" rel="nofollow" class="btn wow fadeInUp" data-wow-delay=".8s">Purchase Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->