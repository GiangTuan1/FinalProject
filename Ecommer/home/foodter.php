<!-- Start Shop Services Area -->
<section class="shop-services section home">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-12">
				<!-- Start Single Service -->
				<div class="single-service">
					<i class="ti-rocket"></i>
					<h4>Free shiping</h4>
					<p>Orders over $100</p>
				</div>
				<!-- End Single Service -->
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<!-- Start Single Service -->
				<div class="single-service">
					<i class="ti-reload"></i>
					<h4>Free Return</h4>
					<p>Within 30 days returns</p>
				</div>
				<!-- End Single Service -->
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<!-- Start Single Service -->
				<div class="single-service">
					<i class="ti-lock"></i>
					<h4>Sucure Payment</h4>
					<p>100% secure payment</p>
				</div>
				<!-- End Single Service -->
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<!-- Start Single Service -->
				<div class="single-service">
					<i class="ti-tag"></i>
					<h4>Best Price</h4>
					<p>Guaranteed price</p>
				</div>
				<!-- End Single Service -->
			</div>
		</div>
	</div>
</section>
<!-- End Shop Services Area -->

<!-- Start Shop Newsletter  -->
<!-- <section class="shop-newsletter section">
		<div class="container">
			<div class="inner-top">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 col-12">
						<div class="inner">
							<h4>Newsletter</h4>
							<p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
							<form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
								<input name="EMAIL" placeholder="Your email address" required="" type="email">
								<button class="btn">Subscribe</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
<!-- End Shop Newsletter -->
<!-- Modal -->
<?php
ob_start();

?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="modal-body-content">
				<!-- Modal content will be updated by JavaScript -->
				<p>Loading...</p>
			</div>
		</div>
	</div>
</div>

<!-- Modal end -->

<!-- Start Footer Area -->
<footer class="footer">
	<!-- Footer Top -->
	<div class="footer-top section">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer about">
						<div class="logo">
							<a href="index.html"><img src="images/estd2.png" alt="#"></a>
						</div>
						<p class="text">Are you passionate about sneakers and looking for quality products at reasonable prices? Kelvin Shoes Store is your ideal destination. Here, you will discover a diverse collection from classic sneakers to modern models, all carefully selected.</p>
						<p class="call">Got Question? Call us 24/7<span><a href="tel:123456789">+0911 246 641</a></span></p>
					</div>
					<!-- End Single Widget -->
				</div>
				<div class="col-lg-2 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer links">
						<h4>Information</h4>
						<ul style="color: white;">
							<li>About Us</li>
							<li>Faq</li>
							<li>Terms & Conditions</li>
							<li>Contact Us</li>
							<li>Help</li>
						</ul>
					</div>
					<!-- End Single Widget -->
				</div>
				<div class="col-lg-2 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer links">
						<h4>Customer Service</h4>
						<ul style="color: white;">
							<li>Payment Methods</li>
							<li>Money-back</li>
							<li>Returns</li>
							<li>Shipping</li>
							<li>Privacy Policy</li>
						</ul>
					</div>
					<!-- End Single Widget -->
				</div>

				<div class="col-lg-3 col-md-6 col-12">
					<!-- Single Widget -->
					<div class="single-footer social">
						<h4>Address</h4>
						<!-- Single Widget -->
						<div class="contact">
							<ul>
								<li>No. 209, 30/4 Street, Xuan Khanh Ward, Ninh Kieu District, Can Tho.</li>
								<li>(+84)911246641</li>
								<li>tuangiang2908@gmail.com</li>
							</ul>
						</div>
						<!-- End Single Widget -->
						<ul>
							<li><a href="https://www.facebook.com/profile.php?id=100004365105264"><i class="ti-facebook"></i></a></li>
							<li><a href="https://www.instagram.com/tuan_giang_/"><i class="ti-instagram"></i></a></li>
						</ul>
					</div>
					<!-- End Single Widget -->
				</div>
			</div>
		</div>
	</div>
	<!-- End Footer Top -->
	<div class="copyright">
		<div class="container">
			<div class="inner">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="left">
							<p>Copyright © 2024 <a href="" target="_blank"></a>KelvinShoesStore</p>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="right">
							<img src="images/payments.png" alt="#">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Attach event handler for modal toggle
		document.querySelectorAll('[data-toggle="modal"]').forEach(function(element) {
			element.addEventListener('click', function() {
				var productId = this.getAttribute('data-product-id');
				loadProductDetails(productId);
			});
		});

		document.querySelector('#modal-body-content').addEventListener('click', function(e) {
			if (e.target && e.target.id === 'add-to-cart') {
				e.preventDefault();
				addToCart();
			}
		});
	});

	function addToCart() {
		var productId = document.querySelector('#add-to-cart').getAttribute('data-product-id');
		var quantity = document.getElementById('quantity').value;
		var size = document.getElementById('size').value;

		// Show preloader (Add your preloader code here)

		$.ajax({
			url: 'add_to_cart.php',
			type: 'POST',
			data: {
				product_id: productId,
				quantity: quantity,
				size: size
			},
			success: function(response) {
				// Hide preloader (Add your preloader code here)
				Swal.fire({
					icon: 'success',
					title: 'Product added to cart successfully!',
					confirmButtonText: 'OK'
				}).then((result) => {
					if (result.isConfirmed) {
						location.reload();
					}
				});
				$('#modal-body-content').modal('hide');
			},
			error: function() {
				// Hide preloader (Add your preloader code here)
				Swal.fire({
					icon: 'error',
					title: 'There was an error adding the product to the cart.',
					confirmButtonText: 'OK'
				}).then((result) => {
					if (result.isConfirmed) {
						location.reload();
					}
				});
			}
		});
	}

	function loadProductDetails(productId) {
		$.ajax({
			url: 'get_product_details.php',
			type: 'GET',
			data: {
				product_id: productId
			},
			success: function(response) {
				$('#modal-body-content').html(response);

				// Initialize modal scripts after content is loaded
				initializeModalScripts();
			},
			error: function() {
				$('#modal-body-content').html('<p>Sorry, there was an error retrieving the product details.</p>');
			}
		});
	}

	function initializeModalScripts() {
		var minusButton = document.querySelector('.btn-number[data-type="minus"]');
		var plusButton = document.querySelector('.btn-number[data-type="plus"]');
		var quantityInput = document.getElementById('quantity');
		var productPriceElement = document.getElementById('product-price');
		var sizeSelect = document.getElementById('size');

		// Check if required elements exist
		if (!minusButton || !plusButton || !quantityInput || !productPriceElement || !sizeSelect) {
			console.error('One or more required elements are missing.');
			return;
		}

		var basePrice = parseFloat(productPriceElement.getAttribute('data-price'));

		// Update max quantity based on selected size
		sizeSelect.addEventListener('change', function() {
			const selectedOption = this.options[this.selectedIndex];
			const maxQuantity = parseInt(selectedOption.getAttribute('data-stock-quantity'), 10);
			quantityInput.setAttribute('data-max', maxQuantity);
			if (parseInt(quantityInput.value, 10) > maxQuantity) {
				quantityInput.value = maxQuantity;
			}
		});

		minusButton.addEventListener('click', function() {
			var currentQuantity = parseInt(quantityInput.value, 10);
			if (currentQuantity > 1) {
				quantityInput.value = currentQuantity - 1;
				updatePrice();
			}
		});

		plusButton.addEventListener('click', function() {
			var currentQuantity = parseInt(quantityInput.value, 10);
			const maxQuantity = parseInt(quantityInput.getAttribute('data-max'), 10);
			if (currentQuantity < maxQuantity) {
				quantityInput.value = currentQuantity + 1;
				updatePrice();
			}
		});

		quantityInput.addEventListener('change', function() {
			var currentQuantity = parseInt(quantityInput.value, 10);
			const maxQuantity = parseInt(quantityInput.getAttribute('data-max'), 10);
			if (currentQuantity < 1) {
				quantityInput.value = 1;
			} else if (currentQuantity > maxQuantity) {
				quantityInput.value = maxQuantity;
			}
			updatePrice();
		});

		function updatePrice() {
			var currentQuantity = parseInt(quantityInput.value, 10);
			var newPrice = basePrice * currentQuantity;
			productPriceElement.innerText = '$' + newPrice.toFixed(2);
		}
	}
</script>

<script>
	$(document).ready(function() {
		$('#updateProfileForm').on('submit', function(e) {
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				url: 'update_profile.php',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					Swal.fire({
						icon: 'success',
						title: 'Profile Updated',
						text: response,
						didClose: () => {
							location.reload(); // Ensure reload happens after the alert closes
						}
					});
				},
				error: function() {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'There was an error updating your profile.'
					});
				}
			});
		});

		$('#changePasswordForm').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: 'change_password.php',
				type: 'POST',
				data: $(this).serialize(),
				success: function(response) {
					Swal.fire({
						icon: 'success',
						title: 'Password Changed',
						text: response,
						didClose: () => {
							location.reload(); // Ensure reload happens after the alert closes
						}
					});
				},
				error: function() {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'There was an error changing your password.'
					});
				}
			});
		});
	});
</script>
<script>
	var swiper = new Swiper('.swiper-container', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		autoplay: {
			delay: 5000,
		},
	});
</script>



<?php

// Get output content
$html = ob_get_clean();

// Write HTML content to database or send to browser
echo $html;
?>
<!-- /End Footer Area -->
<!-- Jquery -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.0.js"></script>
<script src="js/jquery-ui.min.js"></script>
<!-- Popper JS -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="js/bootstrap.min.js"></script>
<!-- Slicknav JS -->
<script src="js/slicknav.min.js"></script>
<!-- Owl Carousel JS -->
<script src="js/owl-carousel.js"></script>
<!-- Magnific Popup JS -->
<script src="js/magnific-popup.js"></script>
<!-- Waypoints JS -->
<script src="js/waypoints.min.js"></script>
<!-- Countdown JS -->
<script src="js/finalcountdown.min.js"></script>
<!-- Nice Select JS -->
<script src="js/nicesellect.js"></script>
<!-- Flex Slider JS -->
<script src="js/flex-slider.js"></script>
<!-- ScrollUp JS -->
<script src="js/scrollup.js"></script>
<!-- Onepage Nav JS -->
<script src="js/onepage-nav.min.js"></script>
<!-- Easing JS -->
<script src="js/easing.js"></script>
<!-- Active JS -->
<script src="js/active.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>