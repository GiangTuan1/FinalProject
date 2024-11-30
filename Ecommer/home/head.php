<?php
include 'config.php';
session_start();
if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];

	// Assuming $role is stored in the session as well
    if (isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
    }
}
// Truy vấn các mục trong giỏ hàng
$sql = "SELECT ci.cart_item_id, ci.product_id, ci.size_id, ci.quantity, ci.price, p.product_name, s.size
			FROM cart_items ci
			JOIN products p ON ci.product_id = p.product_id
			JOIN sizes s ON ci.size_id = s.size_id
			WHERE ci.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Tính tổng số lượng và tổng tiền
$total_quantity = 0;
$total_amount = 0;

// Mảng để lưu thông tin giỏ hàng
$cart_items = [];

while ($row = $result->fetch_assoc()) {
	$cart_items[] = $row;
	$total_quantity += $row['quantity'];
	$total_amount += $row['quantity'] * $row['price'];
}

$stmt->close();

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- Meta Tag -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
	<title>Kevin - Shoes Store</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/estd.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Web Font -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.css" />

	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

	<!-- StyleSheet -->

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="css/font-awesome.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="css/jquery.fancybox.min.css">
	<!-- Themify Icons -->
	<link rel="stylesheet" href="css/themify-icons.css">
	<!-- Nice Select CSS -->
	<link rel="stylesheet" href="css/niceselect.css">
	<!-- Animate CSS -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Flex Slider CSS -->
	<link rel="stylesheet" href="css/flex-slider.min.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="css/owl-carousel.css">
	<!-- Slicknav -->
	<link rel="stylesheet" href="css/slicknav.min.css">

	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="style.php">
	<link rel="stylesheet" href="css/responsive.css">



</head>

<body class="js">

	<!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<!-- End Preloader -->


	<!-- Header -->
	<header class="header shop">
		<!-- Topbar -->
		<div class="topbar">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-12 col-12">
						<!-- Top Left -->
						<div class="top-left">
							<ul class="list-main">
								<li><i class="ti-headphone-alt"></i> +84 911246641</li>
								<li><i class="ti-email"></i> kelvinshoesstore@gmail.com</li>
							</ul>
						</div>
						<!--/ End Top Left -->
					</div>
					<div class="col-lg-7 col-md-12 col-12">
						<!-- Top Right -->
						<div class="right-content">
							<ul class="list-main">
								<li><i class="ti-location-pin"></i> Can Tho</li>
								<?php if (isset($_SESSION['user_id'])) : ?>
									<li><i class="ti-user"></i> <a href="index.php?page=profile">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
									<?php if ($role == 'Admin') { ?>
										<li><i class="ti-power-off"></i><a href="Admin/UI/index.php">Admin page</a></li>
										<?php } ?>
										<?php if ($role == 'Staff') { ?>
										<li><i class="ti-power-off"></i><a href="Admin/UI/index.php">Staff page</a></li>
										<?php } ?>
									<li><i class="ti-power-off"></i><a href="logout.php">Logout</a></li>
								<?php else : ?>
									<li><i class="ti-user"></i> <a href="login.php">Login</a></li>
								<?php endif; ?>
							</ul>
						</div>

						<!-- End Top Right -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Topbar -->
		<div class="middle-inner">
			<div class="container">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-12">
						<!-- Logo -->
						<div class="logo">
							<a href="index.php"><img src="images/estd.png" alt="logo"></a>
						</div>
						<!--/ End Logo -->
						<!-- Search Form -->

						<!--/ End Search Form -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-lg-8 col-md-7 col-12">
						<div class="search-bar-top">
							<form action="index.php" method="GET">
								<input type="hidden" name="page" value="product">
								<div class="search-bar">
									<input name="search" placeholder="Search Products Here....." type="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" required>
									<button class="btnn" type="submit"><i class="ti-search"></i></button>
								</div>
							</form>


						</div>
					</div>


					<div class="col-lg-2 col-md-3 col-12">
						<div class="right-bar">
							<!-- Search Form -->

							<div class="sinlge-bar">
								<a href="index.php?page=profile" class="single-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
							</div>
							<div id="cart-content" class="sinlge-bar shopping">
								<a href="index.php?page=cart" class="single-icon"><i class="ti-bag"></i> <span class="total-count"><?php echo $total_quantity; ?></span></a>
								<!-- Shopping Item -->
								<div class="shopping-item">
									<div class="dropdown-cart-header">
										<span><?php echo $total_quantity; ?> Items</span>
										<a href="?page=cart">View Cart</a>
									</div>
									<ul class="shopping-list">
										<?php foreach ($cart_items as $item) : ?>
											<?php
											// Get product information from database
											$product_id = $item['product_id'];
											$product_query = "SELECT * FROM products WHERE product_id = $product_id";
											$product_result = mysqli_query($conn, $product_query);
											$product = mysqli_fetch_assoc($product_result);

											// Get product image
											$image_query = "SELECT image_url FROM product_images WHERE product_id = $product_id LIMIT 1";
											$image_result = mysqli_query($conn, $image_query);
											$image = mysqli_fetch_assoc($image_result);
											$image_url = $image['image_url'] ? 'images/' . $image['image_url'] : 'https://via.placeholder.com/70x70';
											?>
											<li>
												<a href="remove_item.php?product_id=<?php echo $item['product_id']; ?>" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
												<a class="cart-img" href="#"><img src="<?php echo htmlspecialchars($image_url); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>"></a>
												<h4><a href="#"><?php echo htmlspecialchars($product['product_name']); ?></a></h4>
												<p class="quantity"><?php echo htmlspecialchars($item['quantity']); ?>x - <span class="amount">$<?php echo number_format($item['price'], 2); ?></span></p>
												<p class="quantity">Size: <?php echo htmlspecialchars($item['size']); ?></p> <!-- Show size -->
											</li>
										<?php endforeach; ?>
									</ul>
									<div class="bottom">
										<div class="total">
											<span>Total</span>
											<span class="total-amount">$<?php echo number_format($total_amount, 2); ?></span>
										</div>
										<a href="checkout.html" class="btn animate">Checkout</a>
									</div>
								</div>
								<!--/ End Shopping Item -->
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- Header Inner -->
		<div class="header-inner">
			<div class="container">
				<div class="cat-nav-head">
					<div class="row justify-content-center">
						<?php
						$is_logged_in = isset($_SESSION['user_id']);

						// Get the current page from the query string or default to 'index'
						$page = isset($_GET['page']) ? $_GET['page'] : 'index';
						?>

						<div class="col-lg-9 col-12">
							<div class="menu-area" style="
    display: flex;
    justify-content: center;
">
								<!-- Main Menu -->
								<nav class="navbar navbar-expand-lg">
									<div class="navbar-collapse">
										<div class="nav-inner">
											<ul class="nav main-menu menu navbar-nav">
												<li class="<?php echo ($page === 'index') ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
												<li class="<?php echo ($page === 'product') ? 'active' : ''; ?>"><a href="?page=product">Shop</a></li>

												<?php if ($is_logged_in) : ?>
													<li class="<?php echo ($page === 'order_history') ? 'active' : ''; ?>"><a href="?page=order_history">Order History</a></li>
													<li class="<?php echo ($page === 'cart') ? 'active' : ''; ?>"><a href="?page=cart">Cart</a></li>
												<?php endif; ?>

												<li class="<?php echo ($page === 'about') ? 'active' : ''; ?>"><a href="?page=about">About Us</a></li>
												<li class="<?php echo ($page === 'contact') ? 'active' : ''; ?>"><a href="?page=contact">Contact Us</a></li>
											</ul>
										</div>
									</div>
								</nav>
								<!--/ End Main Menu -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--/ End Header Inner -->
	</header>