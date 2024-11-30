<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image" href="../../images/estd.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="../../src/img/logo.jpg" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <?php
          // Kiểm tra xem người dùng đã đăng nhập chưa
          if (isset($_SESSION['user_id'])) {
            // Kết nối đến cơ sở dữ liệu
            include_once("../../config.php");

            // Lấy vai trò của người dùng từ cơ sở dữ liệu
            $userId = $_SESSION['user_id'];
            $query = "
              SELECT r.role_name 
              FROM roles r 
              JOIN user_roles ur ON r.role_id = ur.role_id 
              WHERE ur.user_id = ?
            ";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $role = $row['role_name'];
              if ($role == 'User') {
                header("Location: ../../index.php");
              }

              // Hiển thị thanh điều hướng dựa trên vai trò của người dùng
          ?>
              <ul id="sidebarnav">
                <li class="nav-small-cap">
                  <i class="fa fa-home"></i>
                  <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="./index.php" aria-expanded="false">
                    <span>
                      <i class="fa fa-tachometer-alt"></i>
                    </span>
                    <span class="hide-menu">Dashboard</span>
                  </a>
                </li>
                <ul class="sidebar">
    <?php if ($role == 'Admin') { ?>
        <li class="sidebar-item">
            <a class="sidebar-link" href="?page=account" aria-expanded="false">
                <span>
                    <i class="fa fa-user-cog"></i>
                </span>
                <span class="hide-menu">Account Manager</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="?page=role" aria-expanded="false">
                <span>
                    <i class="fa fa-user-shield"></i>
                </span>
                <span class="hide-menu">Role Manager</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="?page=category" aria-expanded="false">
                <span>
                    <i class="fa fa-tags"></i>
                </span>
                <span class="hide-menu">Category Manager</span>
            </a>
        </li>
    <?php } ?>

    <li class="sidebar-item">
        <a class="sidebar-link" href="?page=size" aria-expanded="false">
            <span>
                <i class="fa fa-ruler"></i>
            </span>
            <span class="hide-menu">Size Manager</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="?page=contact" aria-expanded="false">
            <span>
                <i class="fa fa-address-book"></i>
            </span>
            <span class="hide-menu">Contact Manager</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="?page=product" aria-expanded="false">
            <span>
                <i class="fa fa-box"></i>
            </span>
            <span class="hide-menu">Product Manager</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="?page=banner" aria-expanded="false">
            <span>
                <i class="fa fa-image"></i>
            </span>
            <span class="hide-menu">Banner Manager</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="?page=order" aria-expanded="false">
            <span>
                <i class="fa fa-shopping-cart"></i>
            </span>
            <span class="hide-menu">Order Manager</span>
        </a>
    </li>

    



          <?php
            } else {
              // Nếu không tìm thấy vai trò, hiển thị một thông báo hoặc chuyển hướng đến trang khác
              // Ví dụ:
              echo "Role not found!";
            }

            // Đóng kết nối
            $stmt->close();
          } else {
            // Nếu người dùng chưa đăng nhập, bạn có thể chuyển hướng đến trang đăng nhập hoặc hiển thị một thông báo khác
            // Ví dụ:
            header("Location: ../../index.php"); // Chuyển hướng đến trang đăng nhập
          }
          ?>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li> -->
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <!-- Hiển thị avatar -->
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                  </svg>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="../../index.php" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-home fs-6"></i>
                      <p class="mb-0 fs-3">Home</p>
                    </a>
                    <a href="../../index.php?page=profile" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="../../logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>