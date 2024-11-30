<?php

$userId = $_SESSION['user_id'];

$query = "SELECT ci.cart_item_id, ci.product_id, ci.quantity, s.size, p.product_name, p.price, 
                 ps.quantity as stock_quantity, 
                 GROUP_CONCAT(DISTINCT pi.image_url ORDER BY pi.image_url LIMIT 1) as image_url 
          FROM cart_items ci
          JOIN products p ON ci.product_id = p.product_id 
          JOIN sizes s ON ci.size_id = s.size_id
          LEFT JOIN product_images pi ON ci.product_id = pi.product_id 
          LEFT JOIN product_sizes ps ON ci.product_id = ps.product_id AND ci.size_id = ps.size_id
          WHERE ci.user_id = ?
          GROUP BY ci.cart_item_id, ci.product_id, ci.quantity, s.size, p.product_name, p.price, ps.quantity";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_amount = 0;
$total_quantity = 0;

while ($row = $result->fetch_assoc()) {
	$cart_items[] = $row;
	$total_amount += $row['price'] * $row['quantity'];
	$total_quantity += $row['quantity'];
}

// Close the statement and connection
$stmt->close();
?>


<!--/ End Header -->

<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="?page=cart">Cart</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

<!-- Shopping Cart -->
<div class="shopping-cart section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!-- Shopping Summery -->
				<table class="table shopping-summery">
					<thead>
						<tr class="main-hading">
							<th style="color: #000000">PRODUCT</th>
							<th style="color: #000000">NAME</th>
							<th class="text-center" style="color: #000000">UNIT PRICE</th>
							<th class="text-center" style="color: #000000">QUANTITY</th>
							<th class="text-center" style="color: #000000">STOCK QUANTITY</th>
							<th class="text-center" style="color: #000000">TOTAL</th>
							<th class="text-center" style="color: #000000"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($cart_items as $item) : ?>
							<tr data-product-id="<?php echo $item['product_id']; ?>">
								<td class="image" data-title="No">
									<img src="<?php echo htmlspecialchars($item['image_url'] ? 'images/' . $item['image_url'] : 'https://via.placeholder.com/100x100'); ?>" alt="#">
								</td>
								<td class="product-des" data-title="Description">
									<p class="product-name"><a href="#"><?php echo htmlspecialchars($item['product_name']); ?></a></p>
									<p class="product-des">Size: <?php echo htmlspecialchars($item['size']); ?></p>
								</td>
								<td class="price" data-title="Price"><span>$<?php echo number_format($item['price'], 2); ?> </span></td>
								<td class="qty" data-title="Qty">
									<!-- Input Order -->
									<div class="input-group">
										<div class="button minus">
											<button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[<?php echo $item['cart_item_id']; ?>]">
												<i class="ti-minus"></i>
											</button>
										</div>
										<input type="text" name="quant[<?php echo $item['cart_item_id']; ?>]" class="input-number" data-min="1" data-max="<?php echo htmlspecialchars($item['stock_quantity']); ?>" value="<?php echo htmlspecialchars($item['quantity']); ?>" data-stock-quantity="<?php echo htmlspecialchars($item['stock_quantity']); ?>" data-cart-item-id="<?php echo $item['cart_item_id']; ?>" readonly>
										<div class="button plus">
											<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[<?php echo $item['cart_item_id']; ?>]">
												<i class="ti-plus"></i>
											</button>
										</div>
									</div>

									<!--/ End Input Order -->
								</td>
								<td class="stock" data-title="Stock"><span>Available: <?php echo htmlspecialchars($item['stock_quantity']); ?></span></td>
								<td class="total-amount" data-title="Total"><span>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span></td>
								<td class="action" data-title="Remove"><a href="remove_item.php?product_id=<?php echo $item['product_id']; ?>"><i class="ti-trash remove-icon"></i></a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>


				</table>
				<!--/ End Shopping Summery -->
			</div>
		</div>
		<div class="row">
            <div class="col-12">
                <!-- Total Amount -->
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-5 col-12">
                        </div>
                        <div class="col-lg-4 col-md-7 col-12">
                            <div class="right">
                                <ul>
                                    <li>Cart Subtotal<span id="cart-subtotal">$<?php echo number_format($total_amount, 2); ?></span></li>
                                    <li>Shipping<span>Free</span></li>
                                    <li class="last">You Pay<span id="cart-total">$<?php echo number_format($total_amount, 2); ?></span></li>
                                </ul>
                                <div class="button5">
                                    <a href="javascript:void(0);" id="checkout-button" class="btn">Checkout</a>
                                    <a href="index.php" class="btn">Continue shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ End Total Amount -->
            </div>
        </div>
	</div>
</div>
<!--/ End Shopping Cart -->

<!-- Start Shop Services Area  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	$(document).ready(function() {
    // Function to update the quantity and ensure it does not exceed stock
    function updateQuantity(input, type) {
        var currentQuantity = parseInt($(input).val());
        var maxQuantity = parseInt($(input).data('stock-quantity'));
        var cartItemId = $(input).data('cart-item-id');
        var newQuantity = currentQuantity; // New quantity storage variable

        if (type === 'plus') {
            if (currentQuantity < maxQuantity) {
                newQuantity = currentQuantity ++; // Increase quantity
                updateCartItem(cartItemId, newQuantity);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached',
                    text: 'You cannot add more than available stock.',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
                return; // Stop execution if there is an error
            }
        } else if (type === 'minus') {
            if (currentQuantity > 1) {
                newQuantity = currentQuantity --; // Reduce quantity
                updateCartItem(cartItemId, newQuantity);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Quantity',
                    text: 'Quantity cannot be less than 1.',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
                return; // Stop execution if there is an error
            }
        }

        // Update cart on backend only if there are no errors
		updateCartItem(cartItemId, newQuantity);

    }

		function updateCartItem(cartItemId, quantity) {
			$.ajax({
				url: 'update_cart.php',
				type: 'POST',
				data: {
					cart_item_id: cartItemId,
					quantity: quantity
				},
				success: function(response) {
					console.log('Response from server:', response); // Check server response

					if (typeof response === 'string') {
						try {
							var jsonResponse = JSON.parse(response);
						} catch (e) {
							console.error('Error parsing response:', e);
							Swal.fire({
								icon: 'error',
								title: 'Error parsing response',
								text: 'Invalid response from server.',
							});
							return;
						}
					} else {
						var jsonResponse = response; // If the response is already a JSON object
					}

					if (jsonResponse.success) {
						Swal.fire({
							icon: 'success',
							title: 'Cart updated successfully!',
							text: 'Your cart has been updated.',
							confirmButtonText: 'OK' // Show "OK" button
						}).then((result) => {
							if (result.isConfirmed) {
								location.reload();
							}
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Error updating cart',
							text: jsonResponse.message,
						});
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.error('AJAX error:', textStatus, errorThrown);
					Swal.fire({
						icon: 'error',
						title: 'Error updating cart',
						text: 'An error occurred while updating the cart.',
					});
				}
			});
		}






		function updatePrice() {
			var totalAmount = 0;

			$('.input-number').each(function() {
				var quantity = parseInt($(this).val());
				var price = parseFloat($(this).closest('tr').find('.price span').text().replace('$', ''));
				totalAmount += quantity * price;
			});

			$('#cart-subtotal').text('$' + totalAmount.toFixed(2));
			$('#cart-total').text('$' + totalAmount.toFixed(2));
		}

		$('.btn-number').on('click', function() {
			var input = $(this).closest('tr').find('.input-number');
			var type = $(this).data('type');
			updateQuantity(input, type);
		});

		$('.input-number').on('change', function() {
			var currentQuantity = parseInt($(this).val());
			var maxQuantity = parseInt($(this).data('stock-quantity'));
			var cartItemId = $(this).data('cart-item-id');

			if (currentQuantity > maxQuantity) {
				$(this).val(maxQuantity);
				Swal.fire({
					icon: 'warning',
					title: 'Limit Reached',
					text: 'You cannot enter more than available stock.',
				});
			} else if (currentQuantity < 1) {
				$(this).val(1);
			}

			// Update the cart in the backend
			var newQuantity = $(this).val();
			updateCartItem(cartItemId, newQuantity);

			updatePrice();
		});
	});
	$('#checkout-button').click(function(e) {
            if (<?php echo count($cart_items); ?> === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Cart',
                    text: 'Your cart is empty. Please add items to the cart before checking out.',
                });
            } else {
                window.location.href = 'index.php?page=checkout';
            }
        });
</script>
<script>
        // Check if the session has the variable 'user_id'
        <?php if (!isset($_SESSION['user_id'])): ?>
            // Redirect to login page if no 'user_id' is present
            window.location.href = 'login.php';
        <?php endif; ?>
    </script>