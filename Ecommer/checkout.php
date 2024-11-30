<?php
// Check if user is logged in


$user_id = $_SESSION['user_id'];

// Fetch user data
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch cart items
$query = "SELECT ci.*, p.product_name, p.price
          FROM cart_items ci
          JOIN products p ON ci.product_id = p.product_id
          WHERE ci.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();
$cart_items = $cart_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Calculate total
$subtotal = 0;
foreach ($cart_items as $item) {
	$subtotal += $item['price'] * $item['quantity'];
}
$total = $subtotal;
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
                        <li class="active"><a href="blog-single.html">Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->
<style>
.form-main .title {
    text-align: center;
    margin-bottom: 30px;
}

.form-main .title h2 {
    font-size: 22px;
    color: #333;
}

.form-main .title h4 {
    font-size: 18px;
    color: #ff5e14;
}

.form-main .form-group {
    margin-bottom: 20px;
}

.form-main .form-group label {
    display: block;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.form-main .form-group input,
.form-main .form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.form-main .form-group textarea {
    height: 150px;
    resize: none;
}
</style>
<!-- Start Checkout -->
<section class="shop checkout section">
    <div class="container">
        <form method="POST" action="checkout_handle.php" class="form-main" id="checkout-form">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="form-main">
                        <h2>Make Your Checkout Here</h2>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="username">User Name<span>*</span></label>
                                    <input type="text" id="username" name="username"
                                        value="<?php echo htmlspecialchars($user['username']); ?>" required readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="full_name">Full Name<span>*</span></label>
                                    <input type="text" id="full_name" name="full_name"
                                        value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email Address<span>*</span></label>
                                    <input type="email" id="email" name="email"
                                        value="<?php echo htmlspecialchars($user['email']); ?>" required readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number<span>*</span></label>
                                    <input type="tel" id="phone_number" name="phone_number"
                                        value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label for="address">Address<span>*</span></label>
                                    <input type="text" id="address" name="address"
                                        value="<?php echo htmlspecialchars($user['address']); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <div class="single-widget">
                            <h2>CART TOTALS</h2>
                            <div class="content">
                                <ul>
                                    <li>Sub Total<span>$<?php echo number_format($subtotal, 2); ?></span></li>
                                    <li class="last">Total<span>$<?php echo number_format($total, 2); ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="single-widget">
                            <h2>Payments</h2>
                            <div class="content">
                                <div class="payment-options">
                                    <!-- Cash On Delivery -->
                                    <div class="radio">
                                        <label for="payment_cod">
                                            <input name="payment_method" id="payment_cod" type="radio" value="cod"
                                                checked> Cash On Delivery
                                        </label>
                                    </div>
                                    <!-- Credit Card -->
                                    <div class="radio">
                                        <label for="payment_card">
                                            <input name="payment_method" id="payment_card" type="radio"
                                                value="credit_card"> Credit Card
                                        </label>
                                    </div>
                                </div>

                                <!-- Card information form, initially hidden -->
                                <div id="credit_card_form" style="display: none; margin-top: 20px;">
                                    <div class="form-group">
                                        <label for="card_number">Card Number<span>*</span></label>
                                        <input type="text" id="card_number" name="card_number" pattern="\d{16}"
                                            title="Please enter a valid 16-digit card number">
                                    </div>
                                    <div class="form-group">
                                        <label for="card_expiry">Expiry Date (MM/YY)<span>*</span></label>
                                        <input type="text" id="card_expiry" name="card_expiry" pattern="\d{2}/\d{2}"
                                            title="Expiry date must be in MM/YY format">
                                    </div>
                                    <div class="form-group">
                                        <label for="card_cvv">CVV<span>*</span></label>
                                        <input type="text" id="card_cvv" name="card_cvv" pattern="\d{3}"
                                            title="Please enter a valid 3-digit CVV">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Process button (Proceed to Checkout) -->
                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <button type="submit" class="btn">Proceed to Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--/ End Checkout -->

<!-- Start Shop Services Area  -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('checkout-form').addEventListener('submit', function(event) {
        const paymentMethodCheckbox = document.getElementById('payment_method');
        if (!paymentMethodCheckbox.checked) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You must select Payment methods.'
            });
            event.preventDefault(); // Prevent the form from being submitted
        }
    });
});
</script>
<script>
    // Check if the session has the variable 'user_id'
<?php if (!isset($_SESSION['user_id'])): ?>
// Redirect to login page if no 'user_id' is present
window.location.href = 'login.php';
<?php endif; ?>
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Listen to payment method changes
    const paymentCod = document.getElementById('payment_cod');
    const paymentCard = document.getElementById('payment_card');
    const creditCardForm = document.getElementById('credit_card_form');

    paymentCod.addEventListener('change', function() {
        if (this.checked) {
            creditCardForm.style.display = 'none';
        }
    });

    paymentCard.addEventListener('change', function() {
        if (this.checked) {
            creditCardForm.style.display = 'block';
        }
    });

    // Check form when submitting
    document.getElementById('checkout-form').addEventListener('submit', function(event) {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        // If you choose to pay by card, check that all information is filled in.
        if (paymentMethod === 'credit_card') {
            const cardNumber = document.getElementById('card_number').value;
            const cardExpiry = document.getElementById('card_expiry').value;
            const cardCVV = document.getElementById('card_cvv').value;

            if (!cardNumber || !cardExpiry || !cardCVV) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all the credit card information.'
                });
                event.preventDefault(); // Prevent form from being submitted
                return;
            }
        }

        // Nếu không có phương thức thanh toán nào được chọn
        if (!paymentCod.checked && !paymentCard.checked) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You must select a payment method.'
            });
            event.preventDefault(); // Prevent form from being submitted
        }
    });
});
</script>