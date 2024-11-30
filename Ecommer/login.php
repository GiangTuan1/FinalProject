<!DOCTYPE html>
<html lang="en">
<?php
include 'config.php';
?>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/login.css" />
	<title>Sign in & Sign up Form</title>
</head>

<body>
	<?php
	include 'config.php'; // Includes database connection

	function json_response($status, $message)
	{
		return json_encode(['status' => $status, 'message' => $message]);
	}

	function redirectBasedOnRole($role)
	{
		switch ($role) {
			case 'Admin':
				return 'Admin/UI/index.php';
			case 'User':
				return 'index.php';
			default:
				return 'Admin/UI/index.php';
		}
	}


	if (isset($_POST['signup'])) {
		$username = $_POST['username'];
		$fullname = $_POST['fullname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirm_password'];
		$phone_number = $_POST['phone_number'];
	
		// Validate password and confirm password
		if ($password !== $confirmPassword) {
			echo "<script>
				Swal.fire({
					icon: 'error',
					title: 'Registration Failed',
					text: 'Passwords do not match.',
					confirmButtonText: 'OK'
				}).then(function() {
					window.location.href = 'login.php'; // Reload the page after user confirms
				});
			  </script>";
		} else {
			// Check if email already exists
			$stmtEmail = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
			$stmtEmail->bind_param("s", $email);
			$stmtEmail->execute();
			$stmtEmail->bind_result($emailExists);
			$stmtEmail->fetch();
			$stmtEmail->close();
	
			if ($emailExists > 0) {
				echo "<script>
					Swal.fire({
						icon: 'error',
						title: 'Registration Failed',
						text: 'Email is already registered.',
						confirmButtonText: 'OK'
					}).then(function() {
						window.location.href = 'login.php'; // Reload the page after user confirms
					});
				  </script>";
			} else {
				// Hash the password
				$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
	
				// Fetch the role_id for the role name 'User'
				$roleName = 'User'; // Change this as needed
				$stmtRole = $conn->prepare("SELECT role_id FROM roles WHERE role_name = ?");
				$stmtRole->bind_param("s", $roleName);
				$stmtRole->execute();
				$stmtRole->bind_result($roleId);
				$stmtRole->fetch();
				$stmtRole->close();
	
				// Check if role_id was found
				if (!$roleId) {
					echo "<script>
						Swal.fire({
							icon: 'error',
							title: 'Registration Failed',
							text: 'Role not found.',
							confirmButtonText: 'OK'
						}).then(function() {
							window.location.href = 'login.php'; // Reload the page after user confirms
						});
					  </script>";
				} else {
					// Prepare the INSERT query
					$stmt = $conn->prepare("INSERT INTO users (username, full_name, email, password, phone_number) VALUES (?, ?, ?, ?, ?)");
					$stmt->bind_param("sssss", $username, $fullname, $email, $hashedPassword, $phone_number);
	
					// Execute the query
					if ($stmt->execute()) {
						$newUserId = $stmt->insert_id;
	
						// Insert user_role
						$stmtUserRole = $conn->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
						$stmtUserRole->bind_param("ii", $newUserId, $roleId);
						$stmtUserRole->execute();
						$stmtUserRole->close();
	
						echo "<script>
							Swal.fire({
								icon: 'success',
								title: 'Registration Successful',
								text: 'New record created successfully.',
								confirmButtonText: 'OK'
							}).then(function() {
								window.location.href = 'login.php'; // Redirect to login page after user confirms
							});
						  </script>";
					} else {
						$error_message = $stmt->error;
						echo "<script>
							Swal.fire({
								icon: 'error',
								title: 'Registration Failed',
								text: 'Error: " . addslashes($error_message) . "',
								confirmButtonText: 'OK'
							}).then(function() {
								window.location.href = 'login.php'; // Reload the page after user confirms
							});
						  </script>";
					}
	
					// Close command
					$stmt->close();
				}
			}
		}
	}
	
	



	// Handling user logins
	if (isset($_POST['signin'])) {
		$username_email = $_POST['username_email'];
		$password = $_POST['password'];

		// Process queries to retrieve user and role information
		$sql = "SELECT u.user_id, u.username, u.password, r.role_name 
                FROM users u
                LEFT JOIN user_roles ur ON u.user_id = ur.user_id
                LEFT JOIN roles r ON ur.role_id = r.role_id
                WHERE u.username = ? OR u.email = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $username_email, $username_email);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$user = $result->fetch_assoc();
			if (password_verify($password, $user['password'])) {
				// Save user information to session
				session_start(); // Make sure the session has been initialized
				$_SESSION['user_id'] = $user['user_id'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['role'] = $user['role_name'];

				// Success messages and user navigation
				echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            text: 'Welcome back, " . addslashes($user['username']) . "!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = '" . redirectBasedOnRole($user['role_name']) . "';
                        });
                      </script>";
				exit();
			} else {
				echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Password',
                            text: 'Please check your password and try again.'
                        });
                      </script>";
			}
		} else {
			echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'User not found',
                        text: 'No user found with that username or email.'
                    });
                  </script>";
		}
	}

	?>

	<div class="container">
		<div class="forms-container">
			<div class="signin-signup">
				<form action="#" method="POST" class="sign-in-form">
					<h2 class="title">Sign in</h2>
					<p>
						Enter your information to sign in
					</p>
					<div class="input-field">
						<i class="fas fa-user"></i>
						<input type="text" name="username_email" placeholder="Username or Email" required />
					</div>
					<div class="input-field">
						<i class="fas fa-lock"></i>
						<input type="password" name="password" placeholder="Password" required />
					</div>
					
					<a href="forgot_password.php" class="forgot-password-link">Forgot your password?</a>
					<input type="submit" name="signin" value="Login" class="btn solid" />
					<!-- <p class="social-text">Or Sign in with social platforms</p>
					<div class="social-media">
						<a href="#" class="social-icon">
							<i class="fab fa-facebook-f"></i>
						</a>
						<a href="#" class="social-icon">
							<i class="fab fa-twitter"></i>
						</a>
						<a href="#" class="social-icon">
							<i class="fab fa-google"></i>
						</a>
						<a href="#" class="social-icon">
							<i class="fab fa-linkedin-in"></i>
						</a>
					</div> -->
				</form>
				<form action="#" method="POST" class="sign-up-form">
					<h2 class="title">Sign up</h2>
					<p>
						Enter your information to sign up
					</p>
					<div class="input-field">
						<i class="fas fa-user"></i>
						<input type="text" name="username" placeholder="Username" required />
					</div>
					<div class="input-field">
						<i class="fas fa-user"></i>
						<input type="text" name="fullname" placeholder="Fullname" required />
					</div>
					<div class="input-field">
						<i class="fas fa-envelope"></i>
						<input type="email" name="email" placeholder="Email" required />
					</div>
					<div class="input-field">
						<i class="fas fa-lock"></i>
						<input type="password" name="password" placeholder="Password" required />
					</div>
					<div class="input-field">
						<i class="fas fa-lock"></i>
						<input type="password" name="confirm_password" placeholder="confirm_password" required />
					</div>
					<div class="input-field">
						<i class="fas fa-phone"></i>
						<input type="text" name="phone_number" placeholder="Phone Number" required />
					</div>
					<input type="submit" name="signup" class="btn" value="Sign up" />
					<!-- <p class="social-text">Or Sign up with social platforms</p>
					<div class="social-media">
						<a href="#" class="social-icon">
							<i class="fab fa-facebook-f"></i>
						</a>
						<a href="#" class="social-icon">
							<i class="fab fa-twitter"></i>
						</a>
						<a href="#" class="social-icon">
							<i class="fab fa-google"></i>
						</a>
						<a href="#" class="social-icon">
							<i class="fab fa-linkedin-in"></i>
						</a>
					</div> -->
				</form>
			</div>
		</div>

		<div class="panels-container">
    <div class="panel left-panel">
        <div class="content">
            <!-- Existing content for Sign Up -->
            <button class="btn transparent" id="sign-up-btn">
                Sign up
            </button>
			<b>OR</b>
            <button class="btn transparent" id="home-btn-left">
                Home
            </button>
        </div>
        <img src="https://i.ibb.co/6HXL6q1/Privacy-policy-rafiki.png" class="image" alt="" />
    </div>
    <div class="panel right-panel">
        <div class="content">
            <!-- Existing content for Sign In -->
            <button class="btn transparent" id="sign-in-btn">
                Sign in
            </button>
			<b>OR</b>
            <button class="btn transparent" id="home-btn-right">
                Home
            </button>
        </div>
        <img src="https://i.ibb.co/nP8H853/Mobile-login-rafiki.png" class="image" alt="" />
    </div>
</div>

	</div>
	<script>
document.getElementById('home-btn-left').addEventListener('click', function() {
    window.location.href = 'index.php'; // Redirect to main page
});

document.getElementById('home-btn-right').addEventListener('click', function() {
    window.location.href = 'index.php'; // Redirect to main page
});
</script>

	<script src="js/login.js"></script>
</body>

</html>