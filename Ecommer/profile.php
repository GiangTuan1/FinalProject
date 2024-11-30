<?php
 // Assuming config.php contains the database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT username, full_name, email, phone_number, avatar FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>


    <style>
        .profile-card {
            max-width: 600px;
            margin: auto;
        }
        .avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .card-header {
            text-align: center;
        }
    </style>
    <div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="?page=profile">Cart</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="container mt-5">
        <div class="card profile-card">
            <div class="card-header">
                <h2>Profile</h2>
                <?php if ($user['avatar']): ?>
                    <img src="images/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="avatar img-thumbnail">
                <?php else: ?>
                    <img src="images/default-avatar.png" alt="Default Avatar" class="avatar img-thumbnail">
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form id="updateProfileForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">User Name</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" class="form-control" id="avatar" name="avatar">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                </form>
            </div>
        </div>

        <div class="card profile-card mt-4">
            <div class="card-header">
                <h2>Change Password</h2>
            </div>
            <div class="card-body">
                <form id="changePasswordForm">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    


