<?php
header("Content-type: text/css"); // Đặt tiêu đề Content-type để trình duyệt biết đây là CSS

include_once("./config.php");

// Truy vấn cơ sở dữ liệu để lấy URL hình ảnh của banner có trạng thái 'active'
$sql = "SELECT image_url FROM banners WHERE status = 'active' LIMIT 1";
$result = $conn->query($sql);

// Đặt URL hình ảnh dự phòng
$defaultImageUrl = "https://via.placeholder.com/1900x700";
$backgroundImageUrl = $defaultImageUrl;

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imageUrl = $row['image_url'];
    $backgroundImageUrl = "./images/" . $imageUrl;
}
?>
/* =====================================
Template Name: Eshop
Author Name: Naimur Rahman
Author URI: http://www.wpthemesgrid.com/
Description: Eshop - eCommerce HTML5 Template.
Version:1.0
========================================*/
/*======================================
[ CSS Table of contents ]
01. Preloader CSS
02. Header CSS
	+ Logo
	+ Category Menu
	+ Main Menu
03. Hero Area CSS
04. Small Banner CSS
05. Medium Banner CSS
06. Single Product CSS
07. Shop Sidebar CSS
08. Shop Single CSS
09. Shop Home List CSS
10. Cart CSS
11. Checkout CSS
12. Login & Register CSS
13. Cowndown CSS
14. Shop Services CSS
15. Newslatter CSS
16. About Us CSS
17. Team CSS
18. Blog CSS	
	+ Blog Archive
	+ Blog Sidebar
	+ Blog Single
19. Contact CSS
20. 404 Error CSS
21. Footer CSS
========================================*/
.color-plate {
	position: fixed;
	display: block;
	z-index: 99998;
	padding: 20px;
	width: 245px;
	background: #fff;
	right: -245px;
	text-align: left;
	top: 30%;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
	-webkit-box-shadow: -3px 0px 25px -2px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: -3px 0px 25px -2px rgba(0, 0, 0, 0.2);
	box-shadow: -3px 0px 25px -2px rgba(0, 0, 0, 0.2);
}
.color-plate.active{
	right:0;
}
.color-plate .color-plate-icon {
	position: absolute;
	left: -48px;
	width: 48px;
	height: 45px;
	line-height: 45px;
	font-size: 21px;
	border-radius: 5px 0 0 5px;
	background: #fff;
	text-align: center;
	color: #333;
	top: 0;
	cursor: pointer;
	box-shadow: -4px 0px 5px #00000036;
}
.color-plate h4 {
	display: block;
	font-size: 15px;
	margin-bottom: 5px;
	font-weight: 500;
}
.color-plate p {
	font-size: 13px;
	margin-bottom: 15px;
	line-height: 20px;
}
.color-plate span {
	width: 42px;
	height: 35px;
	border-radius: 0;
	cursor: pointer;
	display: inline-block;
	margin-right: 3px;
}
.color-plate span:hover{
	cursor:pointer;
}
.color-plate span.color1{
	background:#F7941D;
}
.color-plate span.color2{
	background:#0088CC;
}
.color-plate span.color3{
	background:#32B87D;
}
.color-plate span.color4{
	background:#FE754A;
}
.color-plate span.color5{
	background:#F82F56;
}
.color-plate span.color6{
	background:#00cec9;
}
.color-plate span.color7{
	background:#6c5ce7;
}
.color-plate span.color8{
	background:#85BA46;
}
.color-plate span.color9{
	background:#fd79a8;
}
.color-plate span.color10{
	background:#a29bfe;
}
.color-plate span.color11{
	background:#badc58;
}
.color-plate span.color12{
	background:#FF1D38;
}
/* Preloader */
.preloader {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 999999999;
  width: 100%;
  height: 100%;
  background-color: #fff;
  overflow: hidden;
}
.preloader-inner {
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%,-50%);
  -moz-transform: translate(-50%,-50%);
  transform: translate(-50%,-50%);
}
.preloader-icon {
  width: 100px;
  height: 100px;
  display: inline-block;
  padding: 0px;
}
.preloader-icon span {
  position: absolute;
  display: inline-block;
  width: 100px;
  height: 100px;
  border-radius: 100%;
  background:#F7941D;
  -webkit-animation: preloader-fx 1.6s linear infinite;
  animation: preloader-fx 1.6s linear infinite;
}
.preloader-icon span:last-child {
  animation-delay: -0.8s;
  -webkit-animation-delay: -0.8s;
}
@keyframes preloader-fx {
  0% {transform: scale(0, 0); opacity:0.5;}
  100% {transform: scale(1, 1); opacity:0;}
}
@-webkit-keyframes preloader-fx {
  0% {-webkit-transform: scale(0, 0); opacity:0.5;}
  100% {-webkit-transform: scale(1, 1); opacity:0;}
}
/* End Preloader */

.btn {
	position: relative;
	font-weight: 500;
	font-size:14px;
	color: #fff;
	background: #333;
	display: inline-block;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
	z-index: 5;
	display: inline-block;
	padding: 13px 32px;
	border-radius: 0px;
	text-transform:uppercase;
}
.btn:hover{
	color:#fff;
	background:#F7941D;
}
#scrollUp {
	right: 10px;
	z-index: 33;
	bottom: 10px;
	text-align: center;
}
#scrollUp i{
	height: 40px;
    width: 40px;
    line-height: 40px;
	background:transparent;
    background:#222;
    border-radius: 0;
	font-size: 18px;
	-webkit-transition: all 500ms ease;
    -moz-transition: all 500ms ease;
    transition: all 500ms ease;
	display:block;
	color: #fff;
	box-shadow: 0px 4px 19px #00000038;
}
#scrollUp i:hover{
	background:#F7941D;
	color:#fff;
}
/*======================================
	01. Header CSS
========================================*/
/* Topbar */
.topbar {
	background-color: #fff;
	border-bottom: 1px solid #e2e2e2;
	padding: 15px 0;
}
/* Logo */
.header .logo {
	float: left;
	margin-top: 35px;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
}
.header .navbar {
	padding: 0;
}
/* Main Menu */
.navbar-expand-lg .navbar-collapse{
	display:block !important;
}
.header.v3 .navbar-expand-lg .navbar-collapse{
	display:block !important;
	background:#333;
}
.header .nav li a i {
	margin-left: 6px;
	font-size: 10px;
}
/* Dropdown Menu */
.header .nav li .dropdown {
	background: #fff;
	width: 220px;
	position: absolute;
	top: 100%;
	z-index: 999;
	-webkit-box-shadow: 0px 3px 5px #3333334d;
	-moz-box-shadow: 0px 3px 5px #3333334d;
	box-shadow: 0px 3px 5px #3333334d;
	transform-origin: 0 0 0;
	transform: scaleY(0.2);
	-webkit-transition: all 0.3s ease 0s;
	-moz-transition: all 0.3s ease 0s;
	transition: all 0.3s ease 0s;
	opacity: 0;
	visibility: hidden;
	padding: 10px;
	left: 0;
	margin: 0;
}
.header .nav li:hover .dropdown{
	opacity:1;
	visibility:visible;
	transform:translateY(0px);
}
.header .nav li .dropdown li{
	float:none;
	margin:0;
}
.header .nav li .dropdown li a {
	padding: 8px 15px;
	color: #666;
	display: block;
	font-weight: 400;
	text-transform: capitalize;
	background: transparent;
}
.header .nav li .dropdown li a:before{
	display:none;
}
.header .nav li .dropdown li:last-child a{
	border-bottom:0px;
}
.header .nav li .dropdown li:hover a{
	color:#fff;
	background:#F7941D;
}
.header .nav li .dropdown li a:hover{
	border-color:transparent;
}
.header .nav li .dropdown li i {
	float: right;
	margin-top: 8px;
	font-size:10px;
	z-index:5;
}
.header .nav li .dropdown.sub-dropdown {
	background: #fff;
    width: 220px;
    position: absolute;
    left: 186px;
    top: 0;
    z-index: 999;
   -webkit-box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2);
	box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
	box-shadow: 0px 3px 5px #3333334d;
    transform-origin: 0 0 0;
    transform: scaleY(0.2);
    -webkit-transition: all 0.3s ease 0s;
    -moz-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
    opacity: 0;
    visibility: hidden;
    padding: 10px;
}
.header .nav li .dropdown li:hover .dropdown.sub-dropdown{
	opacity:1;
	visibility:visible;
	transform:translateY(0px);
}
.header .nav li .dropdown.sub-dropdown li a{
	padding: 8px 15px;
	color: #666;
	display: block;
	font-weight: 400;
	text-transform: capitalize;
	background: transparent;
}
.header .nav li .dropdown li:hover .dropdown.sub-dropdown li a{
	background:transparent;
}
.header .nav li .dropdown li .dropdown.sub-dropdown li a:hover{
	color:#fff;
	background:#F7941D;
}
.header .nav li .dropdown.sub-dropdown li:last-child a{
	border-bottom:0px solid;
}
.mobile-search{
	display:none;
}
.header.shop .topbar {
	border: none;
	padding: 12px 0px;
}
.header.shop .nav-inner {
	margin-right: 188px;
}
.header.shop .logo {
	float: left;
	margin-top: 0px;
}
.header.shop .top-contact {
	margin-top:0px;
}
.header.shop .topbar p {
	color: #ccc;
}
.header.shop .topbar .login a {
	color: #F7941D;
}
/* Topbar Left Nav */
.header.shop .left-nav{
	
}
.header.shop .top-left .list-main li:first-child{
	padding-left:0;
}
.header.shop .top-left .list-main li i{
	display: inline-block;
	margin-right: 4px;
	font-size: 15px;
	color: #F7941D;
	position: relative;
	top: 3px;
}
.header.shop .right-content{
	float:right;
}
.header.shop .list-main li {
	display: inline-block;
	color: #333;
	font-size: 13px;
	font-weight: 500;
	border-right: 1px solid #f0f0f0;
	padding: 0px 13px;
}
.header.shop .list-main li i {
	display: inline-block;
	margin-right: 4px;
	font-size: 15px;
	color: #F7941D;
	position: relative;
	top: 1px;
}
.header.shop .list-main li:last-child{
	padding-right:0;
	border:none;
}
.header.shop .list-main li a{
	color:#333;
}
.header.shop .list-main li a:hover{
	color:#F7941D;
}
.header.shop .nav li {
	margin-right: 40px;
	float: left;
	position: relative;
}
.header.shop .nav li {
	margin-right: 38px;
	position: relative;
}
.header.shop .nav li:last-child {
	margin: 0 !important;
}
.header.shop .nav li .new {
	background: #F7941D;
	color: #fff;
	text-transform: uppercase;
	font-size: 10px;
	padding: 0px 9px;
	position: absolute;
	left: 0;
	top: 6px;
	font-weight: 500;
}
.header.shop .nav li .new::before {
	position: absolute;
	content: "";
	left: 4px;
	bottom: -8px;
	border: 4px solid #F7941D;
	border-bottom-color: transparent;
	border-left-color: transparent;
	border-right-color: transparent;
}
/* Shopping Cart */
.header .shopping {
	display: inline-block;
	z-index: 9999;
}
.header .shopping .icon {
	position: relative;
	cursor:pointer;
	color:#222;
}
.header .shopping .shopping-item {
	position: absolute;
	top: 68px;
	right: 0;
	width: 300px;
	background: #fff;
	padding: 20px 25px;
	-webkit-transition: all 0.3s ease 0s;
	-moz-transition: all 0.3s ease 0s;
	transition: all 0.3s ease 0s;
	-webkit-transform: translateY(10px);
	-moz-transform: translateY(10px);
	transform: translateY(10px);
	-webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
	box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
	opacity:0;
	visibility:hidden;
	z-index:99;
}
.header .shopping:hover .shopping-item{
	transform: translateY(0px);
	opacity:1;
	visibility:visible;
}
.header .shopping .dropdown-cart-header{
	padding-bottom: 10px;
    margin-bottom: 15px;
	border-bottom:1px solid #e6e6e6;
}
.header .shopping .dropdown-cart-header span {
	text-transform: uppercase;
	color: #222;
	font-size: 13px;
	font-weight: 600;
}
.header .shopping .dropdown-cart-header a {
	float: right;
	text-transform: uppercase;
	color: #222;
	font-size: 13px;
	font-weight: 600;
}
.header .shopping .dropdown-cart-header a:hover{
	color:#F7941D;
}
.header .shopping-list li {
	overflow: hidden;
	border-bottom: 1px solid #e6e6e6;
	padding-bottom: 15px;
	margin-bottom: 15px;
	position:relative;
}
.header .shopping-list li .remove {
	position: absolute;
	left: 0;
	bottom: 16px;
	margin-top: -20px;
	height: 20px;
	width: 20px;
	line-height: 18px;
	text-align: center;
	background: #fff;
	color: #222;
	border-radius: 0;
	font-size: 11px;
	border: 1px solid #ededed;
}
.header .shopping-list li .remove:hover{
	background:#222;
	color:#fff !important;
	border-color:transparent;
}
.header .shopping-list .cart-img {
	float: right;
	border: 1px solid #ededed;
	overflow:hidden;
}
.header .shopping-list .cart-img img {
	width: 70px;
	height: 70px;
	border-radius:0;
	
}
.header .shopping-list .cart-img:hover img{
	transform:scale(1.09);
}
.header .shopping-list .quantity{
	line-height: 22px;
    font-size: 13px;
	padding-bottom: 30px;
}
.header .shopping-list h4 {
	font-size: 14px;
}
.header .shopping-list h4 a {
	font-weight: 600;
	font-size: 13px;
	color: #333;
}
.header .shopping-list h4 a:hover{
	color:#F7941D;
}
.header .shopping-item .bottom {
	text-align: center;
}
.header .shopping-item .total {
	overflow:hidden;
	display: block;
    padding-bottom: 10px;
}
.header .shopping-item .total span {
	text-transform:uppercase;
	color:#222;
	font-size:13px;
	font-weight:600;
	float:left;
}
.header .shopping-item .total .total-amount {
	float:right;
	font-size:14px;
}
.header .shopping-item .bottom .btn {
	background: #222;
	padding: 10px 20px;
	display: block;
	color: #fff;
	margin-top: 10px;
	border-radius: 0px;
	text-transform: uppercase;
	font-size: 14px;
	font-weight: 500;
}
.header .shopping-item .bottom .btn:hover{
	background:#F7941D;
	color:#fff;
}
.header.shop{
	background:#fff;
}
.header.shop .nav-inner {
	margin: 0;
	float: left;
}
.header.shop .topbar {
	background-color: #fff;
	border: none;
}
.header.shop.v3 .topbar{
	padding:0;
}
.header.shop.v3 .topbar .inner-content{
	border-bottom:1px solid #eee;
	padding: 12px 0px;
}
.header.shop .right-nav li a {
	color: #333;
}
.header.shop .logo {
	float: left;
	margin: 0px 0 0;
}
.header.shop .top-contact {
	margin-top:0px;
}
/* Header Middle */
.header.shop .search-bar-top {
	text-align: center;
	margin-top: 10px;
}
.header.shop .search-bar {
	margin-top: 33px;
	width: 460px;
	height: 40px;
	display: inline-block;
	background: #fff;
	position: relative;
}
.header.shop .search-bar {
	width: 535px;
	height: 50px;
	display: inline-block;
	background: #fff;
	position: relative;
	margin: 0;
	line-height: 45px;
	border-radius: 5px;
	border: 1px solid #ececec;
}
.header.shop .nice-select {
	clear: initial;
	margin: 0;
	height: 48px;
	width: 150px;
	border: none;
	text-align: center;
	background: transparent;
	text-transform: capitalize;
	padding: 0 0 0 20px;
	border-right: 1px solid #eee;
	line-height: 50px;
	font-size: 14px;
	font-weight: 400;
}
.header.shop .nice-select::after {
	border-color: #666;
	right: 20px;
}
.header.shop .nice-select .list {
	border-radius:0px;
}
.header.shop .nice-select .list li.focus{
	font-weight:400;
}
.header.shop .nice-select .list li {
	color: #666;
	border-radius: 0px;
	font-size: 14px;
	font-weight: 400;
}
.header.shop .nice-select .list li:hover{
	background:#F7941D;
	color:#fff;
}
.header.shop .search-bar form {
	display: inline-block;
	float: left;
	width: 260px;
}
.header.shop .search-bar input {
	height: 48px;
	background: transparent;
	color: #666;
	border-radius: 0;
	border: none;
	font-size: 14px;
	font-weight: 400;
	padding: 0 25px 0 20px;
	width: 328px;
}
.header.shop .search-bar .btnn {
	height: 50px;
	line-height: 53px;
	width: 62px;
	text-align: center;
	font-size: 18px;
	color: #fff;
	background: #333333;
	position: absolute;
	right: -2px;
	top: -1px;
	border: none;
	border-radius: 0 5px 5px 0;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
}
.header.shop .search-bar .btnn:hover{
	color:#fff;
	background:#F7941D;
}
/* Search Form */
.header.shop .search-top {
	opacity: 1;
	visibility: visible;
	top: 0;
	background: transparent;
	border: none;
	box-shadow: none;
	padding: 0;
	top: 0;
}
.header.shop .middle-inner {
	padding: 20px 0;
	background: #fff;
	border-top: 1px solid #eee;
}
.header.shop.v3 .middle-inner {
	border:none;
}
.header.shop .header-inner {
	background: #333;
}
.header.shop.v3 .header-inner {
	background: transparent;
}
.header.shop.v2 .header-inner {
	background: #fff;
	border-top:1px solid #eee;
}
.header.shop .topbar p {
	color: #333;
}
.header.shop .all-category {
	color: #fff;
	background: transparent;
	position: relative;
	background: #f7941d;
}
.header.shop .all-category h3{
	padding: 20px 25px;
}
.header.shop .cat-heading {
	font-size: 20px;
	color: #fff;
}
.header.shop .cat-heading i {
	color: #fff;
	display: inline-block;
	margin-right: 15px;
	font-size: 22px;
}
.header.shop .main-category {
	position: absolute;
	left: 0;
	top: 64px;
	background: #fff;
	z-index: 1;
	width: 100%;
	-webkit-box-shadow: 0px 5px 15px #0000000a;
	-moz-box-shadow: 0px 5px 15px #0000000a;
	box-shadow: 0px 5px 15px #0000000a;
}
.header.shop .main-category li{
	display:block;
	border-bottom:1px solid #f6f6f6;
	position:relative;
}
.header.shop .main-category li:last-child{
	border:none;
}
.header.shop .main-category li a {
	font-size: 14px;
	font-weight: 600;
	color: #333;
	padding: 13px 25px 13px 25px;
	display: block;
	text-transform: uppercase;
}
.header.shop .main-category li a i{
	display:inline-block;
	float:right;
}
.header.shop .sub-category {
	background: #fff;
	width: 220px;
	position: absolute;
	left: 238px;
	top: 0;
	z-index: 999999;
	opacity: 0;
	visibility: hidden;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
	border-left: 3px solid #F7941D;
	-webkit-box-shadow: 0px 5px 15px #0000000a;
	-moz-box-shadow: 0px 5px 15px #0000000a;
	box-shadow: 0px 5px 15px #0000000a;
}
.header.shop .main-category li:hover .sub-category{
	opacity:1;
	visibility:visible;
}
.header.shop .main-category li a{
	text-transform:capitalize;
	font-weight:400;
}
.header.shop .main-category li a:hover{
	color:#F7941D;
}
.header.shop .main-category .main-mega{
	position:relative;
}
.header.shop .main-category li .mega-menu {
	width: 850px;
	display: inline-block;
	height: auto;
	position: absolute;
	left: 238px;
	top: 0;
	z-index: 99999;
	background: #fff;
	border: none;
	padding: 30px;
	border-left: 3px solid #F7941D;
	opacity:0;
	visibility:hidden;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.header.shop .main-category li:hover .mega-menu{
	opacity:1;
	visibility:visible;
}
.header.shop .main-category li .mega-menu .single-menu {
	width: 33%;
	display: inline-block;
	border: none;
	padding: 0;
	padding-right: 20px;
}
.header.shop .main-category li .mega-menu .single-menu a{
	padding:0;
}
.header.shop .main-category li .mega-menu .single-menu .image{
	overflow:hidden;
}
.header.shop .main-category li .mega-menu .single-menu img{
	display:block;
	height:100%;
	width:100%;
	cursor:pointer;
}
.header.shop .main-category li .mega-menu .single-menu .image:hover img{
	transform:scale(1.1);
}
.header.shop .main-category li .mega-menu .single-menu .title-link {
	margin-bottom: 20px;
	background: #F7941D;
	color: #fff;
	padding: 2px 13px;
	border-radius: 3px;
	display: inline-block;
	font-size: 14px;
}
.header.shop .main-category li .mega-menu .single-menu .title-link:hover{
	background:#333;
	color:#fff;
}
.header.shop .main-category li .mega-menu .single-menu .inner-link{
	margin-top:25px;
}
.header.shop .main-category li .mega-menu .single-menu .inner-link a{
	margin-bottom:10px;
}
.header.shop .main-category li .mega-menu .single-menu .inner-link a:hover{
	color:#F7941D;
	background:transparent;
}
.header.shop .main-category li .mega-menu .single-menu .inner-link a:last-child{
	margin-bottom:0px;
}
.header.shop .menu-origin {
	float:none;
	display: inline-block;
	float: right;
}
.header.shop .nav li {
	margin-right: 40px;
	float: left;
	position: relative;
}
.header.shop .nav li {
	margin-right:5px;
	position: relative;
	float: none;
}
.header.shop .nav li:last-child{
	margin-right:0;
}
.header.shop .nav li .new {
	background: #F7941D;
	color: #fff;
	text-transform: uppercase;
	font-size: 9px;
	position: absolute;
	left: 21px;
	top: 2px;
	font-weight: 500;
	height: 18px;
	line-height: 18px;
	text-align: center;
	display: block;
}
.header.shop.v2 .nav li a{
	color:#333;
}
.header.shop .nav li a {
	color: #fff;
	text-transform: capitalize;
	font-size: 15px;
	padding: 20px 15px;
	font-weight: 500;
	display: block;
	position: relative;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
}
.header.shop .nav li:hover a{
	color:#fff;
	background:#F7941D;
}
.header.shop.v2 .nav li:hover a{
	color:#F7941D;
	background:transparent;
}
.header.shop .nav li.active a{
	color:#fff;
	background:#F7941D;
}
.header.shop.v2 .nav li.active a{
	color:#333 !important;
	background:transparent !important;
}
.header.shop.v2 .nav li.active a{
	color:#F7941D !important;
}
.header.shop .nav .dropdown li{
	margin:0;
}
.header.shop .nav li .dropdown li:hover a{
	background:#F7941D;
}
.header.shop.v2 .nav li.active .dropdown li a{
	color:#333 !important;
}
.header.shop.v2 .nav li.active .dropdown li a:hover{
	color:#fff !important;
	background:#F7941D !important;
}
.header.shop.v2 .nav li.active .dropdown li a:hover{
	color:#fff !important;
}
.header.shop.v2 .nav li .dropdown li:hover a{
	color:#F7941D;
}
.header.shop .nav li .dropdown li a {
	color: #333;
	padding: 8px 15px;
	font-weight: 400;
	background:#fff;
}
.header.shop.v2 .nav li .dropdown li a {
	color: #333;
	background:#fff;
}
.header.shop .nav li .dropdown li a {
	font-weight: 400;
	font-size: 14px;
}
.header.shop .nav li .dropdown li a:hover{
	color:#fff;
}
.header.shop.v2 .nav li .dropdown li a:hover{
	color:#fff !important;
	background:#F7941D;
}
.header.shop .nav li .dropdown li .dropdown.sub-dropdown li a:hover{
	background:#F7941D;
}
.header.shop .right-bar {
	display: inline-block;
	padding: 0;
	margin: 0;
	top: 20px;
	float: right;
	position: relative;
}
.header.shop .right-bar .sinlge-bar.top-search a {
	transform: translateY(3px);
}
.header.shop .right-bar .sinlge-bar.top-search a:hover {
	color:#F7941D;
}
.header.shop .right-bar .sinlge-bar .single-icon{
	color:#333;
	font-size:20px;
	position:relative;
}
.header.shop .right-bar .sinlge-bar .single-icon:hover{
	color:#F7941D;
}
.header.shop .right-bar .sinlge-bar .single-icon .total-count {
	position: absolute;
	top: -7px;
	right: -8px;
	background: #f6931d;
	width: 18px;
	height: 18px;
	line-height: 18px;
	text-align: center;
	color: #fff;
	border-radius: 100%;
	font-size: 11px;
}
.header.shop .right-bar .sinlge-bar{
	display:inline-block;
	margin-right:25px;
}
.header.shop .right-bar .sinlge-bar:last-child{
	margin-right:0px;
}
.header.shop .right-bar .sinlge-bar li a:hover{
	color:#F7941D;
}
.mobile-search{
	display:none;
}
/* Header Search */
/* Search */
.header .search-top{
	display:none;
}
.header .search-top a{
	font-size:17px;
}
.header .search-top a:hover{
	color:#F7941D;
}
.header .search-form {
	position: absolute;
	left: -128px;
	z-index: 9999;
	opacity: 0;
	visibility: hidden;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	transition: all 0.5s ease;
	top: 46px;
	background: #ffffff75;
	padding: 7px;
	border-radius: 5px;
	transform: scaleY(0);
	box-shadow: 0px 4px 7px #0000003b;
	padding: 0;
	border-radius: 0;
}
.header .search-top.active .search-form {
	opacity:1;
	visibility:visible;
	transform: scaleY(1);
}
.header .search-form input {
	width: 220px;
	height: 45px;
	line-height: 45px;
	padding: 0 60px 0 15px;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
	border-radius: 3px;
	border: none;
	background: #fff;
	color: #333;
	border-radius: 0;
}
.header .search-form button {
	position: absolute;
	right: 0;
	height: 45px;
	top: 0;
	width: 45px;
	background: transparent;
	border: none;
	color: #3353ea;
	border-radius: 0 3px 3px 0;
	border-radius: 0;
	border-left: 1px solid #eee;
	font-size: 15px;
	color: #333;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
}
.header .search-form button:hover{
	color:#fff;
	background:#F7941D;
	border-color:transparent;
}
/* Header Sticky */
.header .header-inner{
	width:100%;
	z-index:999;
}
.header.sticky .all-category{}
.header.sticky .all-category h3{
	cursor:pointer;
	
}
.header.sticky .all-category .main-category{
	opacity:0;
	visibility:hidden;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.header.sticky .all-category:hover .main-category{
	opacity:1;
	visibility:visible;
}
.header.sticky .header-inner .nav li a {
	color: #333;
}
.header.sticky.v3 .header-inner .nav li a {
	color: #fff;
}
.header.sticky .header-inner .nav li:hover a{
	color:#fff;
}
.header.sticky.v2 .header-inner .nav li:hover a{
	color:#F7941D;
}
.header.sticky .header-inner .nav li .dropdown li a{
	color:#333;
}
.header.sticky.v2 .header-inner .nav li .dropdown li a{
	color:#333;
}
.header.sticky .header-inner .nav li .dropdown li a:hover{
	color:#fff;
}
.header.sticky .header-inner .nav li.active a {
	color: #fff;
}
.header.sticky .header-inner{
	position:fixed;
	top:0;
	left:0;
	background:#fff;
	animation: fadeInDown 1s both 0.2s;
	-webkit-box-shadow:0px 0px 10px rgba(0, 0, 0, 0.3);
	-moz-box-shadow:0px 0px 10px rgba(0, 0, 0, 0.3);
	box-shadow:0px 0px 10px rgba(0, 0, 0, 0.3);
	z-index:999;
}
.header.sticky.v3 .header-inner{
	box-shadow:none;
}
.header.sticky.v3 .navbar-expand-lg .navbar-collapse{
	animation: fadeInDown 1s both 0.2s;
	-webkit-box-shadow:0px 0px 10px rgba(0, 0, 0, 0.3);
	-moz-box-shadow:0px 0px 10px rgba(0, 0, 0, 0.3);
	box-shadow:0px 0px 10px rgba(0, 0, 0, 0.3);
}
/*======================================
	End Header CSS
========================================*/

/*======================================
   Hero Area CSS
========================================*/ 
.hero-slider {
	background: #fff;
	overflow: hidden;
}

.hero-slider .single-slider {
	height: auto;
	background-image: url('<?php echo $backgroundImageUrl; ?>');
	background-size: cover;
	background-position: center;
	background-repeat: no-repeat;
    height: 510px;
}
.hero-slider .text-inner {
	
}
.hero-slider .hero-text {
	padding: 0 30px;
	margin-top:100px;
}
.hero-slider .hero-text h1 {
	line-height: 50px;
	font-size: 47px;
	font-weight: 700;
	color: #F7941D;
	margin-bottom: 20px;
}
.hero-slider .hero-text h1 span {
	font-size: 20px;
	display: block;
	margin-bottom: 12px;
	color: #333;
	font-weight: 700;
	line-height: initial;
}
.hero-slider .hero-text p {
	color: #fff;
	margin-bottom: 35px;
}
.hero-slider .hero-text .button{
	margin:0;
}
.hero-slider .hero-text .btn {
	color: #fff;
	background: #333;
	padding: 13px 30px;
	line-height: initial;
	border: none;
	height: auto;
	z-index: 0;
}
.hero-slider .hero-text .btn:hover{
	background:#F7941D;
	color:#fff;
}
/* Start Hero Area 2 CSS */
.hero-area2{
	position:relative;
}
.hero-area2 .single-slider.overlay:before{
	background:#F7941D;
	opacity:0;
	visibility:hidden;
	transform:scale(0.9);
}
.hero-area2 .single-slider.overlay:hover:before{
	opacity:0.9;
	visibility:visible;
	transform:scale(1);
}
.hero-area2 .single-slider{
	height:500px;
	position:relative;
	background-size:cover;
	background-position:center;
	background-repeat:no-repeat;
}
.hero-area2 .single-slider .content{
	position:relative;
}
.hero-area2 .single-slider .content {
	width: 100%;
	padding: 15px;
	z-index: 2;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
	text-align: center;
	padding-top: 120px;
	opacity:0;
	visibility:hidden;
	transform:scale(1.1);
}
.hero-area2 .single-slider:hover .content{
	opacity:1;
	visibility:visible;
	transform:scale(1);
}
.hero-area2 .single-slider .content .sub-title{
	color:#fff;
	text-transform: uppercase;
	font-size:15px;
	font-weight:500;
}
.hero-area2 .single-slider .content .title {
	color: #fff;
	text-transform: uppercase;
	font-size: 24px;
	display: block;
	margin-top: 10px;
	margin-bottom: 10px;
}
.hero-area2 .single-slider .content .des{
	color:#fff;
}
.hero-area2 .single-slider .content .button{}
.hero-area2 .single-slider .content .button .btn {
	padding: 9px 25px;
	border: 2px solid #fff;
	background: transparent;
	color: #fff;
	margin-top: 25px;
}
.hero-area2 .single-slider .content .button .btn:hover{
	background:#fff;
	color:#333;
	border-color:transparent;
}
/* Owl Nav CSS */
.hero-area2 .owl-carousel .owl-nav {
	margin: 0;
    position: absolute;
    top: 50%;
    width: 100%;
	margin-top:-30px;
}
.hero-area2 .owl-carousel .owl-nav div {
	height: 60px;
	width: 40px;
	line-height: 60px;
	text-align: center;
	background: #333;
	color: #fff;
	font-size: 14px;
	position: absolute;
	margin: 0;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
	padding: 0;
	border-radius: 0;
}
.hero-area2 .owl-carousel .owl-nav div:hover{
	background:#F7941D;
	color:#fff;
}
.hero-area2 .owl-carousel .owl-controls .owl-nav .owl-prev{
	left:0;
}
.hero-area2 .owl-carousel .owl-controls .owl-nav .owl-next{
	right:0;
}
/* Hero Area 3 */
.hero-area3{}
.hero-area3 .big-content{
	background-image: url('https://via.placeholder.com/850x530');
	background-size: cover;
	background-position: center;
	background-repeat: no-repeat;
    height: 511px;
	margin-top:30px;
	position:relative;
}
.hero-area3 .big-content .inner {
	position: absolute;
	right: 0;
	top: 50%;
	padding: 0 50px 0 360px;
	transform: translateY(-50%);
}
.hero-area3 .big-content .title {
	font-size: 28px;
	margin-bottom: 20px;
	font-weight: 700;
	text-transform: capitalize;
	line-height: 37px;
}
.hero-area3 .big-content .title span{
	color:#F7941D;
}
.hero-area3 .big-content .des{}
.hero-area3 .big-content .button{
	margin-top:40px;
	display:block;
}
.hero-area3 .big-content .button .btn{
	color:#fff;
}

.hero-area3 .small-content{
	height:240px;
	background-size: cover;
	background-position: center;
	background-repeat: no-repeat;
	margin-top:30px;
	position:relative;
}
.hero-area3 .small-content.first{
	background-image: url('https://via.placeholder.com/450x300');
}
.hero-area3 .small-content.secound{
	background-image: url('https://via.placeholder.com/450x300');
}
.hero-area3 .small-content .inner {
	padding: 30px;
	text-align:right;
	position:absolute;
	right:0;
	bottom:0;
}
.hero-area3 .small-content .title {
	font-size: 18px;
	margin-bottom: 20px;
	font-weight: 600;
	text-transform: capitalize;
}
.hero-area3 .small-content .title span{
	color:#F7941D;
}
.hero-area3 .small-content .des{}
.hero-area3 .small-content .button{
	margin-top:10px;
	display:block;
}
.hero-area3 .small-content .button .btn {
	background: transparent;
	padding: 0;
	color: #333;
	border-bottom: 2px solid #333;
	font-size: 13px;
}
.hero-area3 .small-content .button .btn:hover{
	color:#F7941D;
	border-color:#F7941D;
}
/* Hero Area 4 */

.hero-area4 {
    width: 100vw; /* Đặt chiều rộng bằng chiều rộng của viewport */
    overflow: hidden; /* Ẩn bất kỳ nội dung nào vượt ra ngoài phần tử */
    position: relative; /* Đặt vị trí tương đối để căn chỉnh các phần tử con */
}

.hero-area4 .big-content {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 510px; /* Đặt chiều cao cụ thể nếu cần */
    margin-top: 30px; /* Khoảng cách trên nếu cần */
    position: relative; /* Đảm bảo phần tử này hoạt động tốt với position absolute bên trong */
}

.hero-area4 .big-content .inner {
    position: absolute;
    right: 0;
    top: 50%;
    padding: 0 80px 0 50px;
    transform: translateY(-50%);
    color: #fff; /* Đảm bảo nội dung bên trong có màu chữ tương phản với nền */
}

.hero-area4 .big-content .title {
    font-size: 32px;
    margin-bottom: 20px;
    font-weight: 700;
    text-transform: capitalize;
    line-height: 35px;
}

.hero-area4 .big-content .title span {
    color: #F7941D; /* Màu cho phần span bên trong tiêu đề */
}

.hero-area4 .big-content .des {
    /* Thêm kiểu cho phần mô tả nếu cần */
}

.hero-area4 .big-content .button {
    margin-top: 40px;
    display: block;
}

.hero-area4 .big-content .button .btn {
    color: #fff;
}

.hero-area4 .owl-carousel {
    width: 100%; /* Đặt chiều rộng của carousel bằng 100% */
    position: relative; /* Để các điều khiển carousel có thể căn chỉnh đúng */
}

.hero-area4 .owl-carousel .owl-nav {
    margin: 0;
    position: absolute;
    top: 50%;
    width: 100%;
    margin-top: -20px; /* Điều chỉnh nếu cần để các nút nav nằm chính giữa */
}

.hero-area4 .owl-carousel .owl-nav div {
    height: 40px;
    width: 40px;
    line-height: 40px;
    text-align: center;
    background: #333;
    color: #fff;
    font-size: 14px;
    position: absolute;
    margin: 0;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    transition: all 0.4s ease;
    padding: 0;
    border-radius: 50%; /* Đặt đường viền thành tròn */
}

.hero-area4 .owl-carousel .owl-nav div:hover {
    background: #F7941D;
    color: #fff;
}

.hero-area4 .owl-carousel .owl-controls .owl-nav .owl-prev {
    left: 10px; /* Khoảng cách từ bên trái */
}

.hero-area4 .owl-carousel .owl-controls .owl-nav .owl-next {
    right: 10px; /* Khoảng cách từ bên phải */
}

/*======================================
   End Hero Area CSS
========================================*/ 

/*======================================
   Start Small Banner CSS
========================================*/ 
.small-banner{
	padding:30px 0;
	padding-bottom:0;
}
.small-banner .single-banner {
	overflow:hidden;
	position:relative;
}
.small-banner .single-banner img{
	height:100%;
	width:100%;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.small-banner .single-banner .content {
	position: absolute;
	left: 0;
	top: 50%;
	transform: translateY(-50%);
	padding-left: 35px;
}
.small-banner .single-banner h3 {
	font-size: 22px;
	font-weight: 700;
	text-transform: capitalize;
	color: #333;
}
.small-banner .single-banner h3 span{
	color:#F7941D;
}
.small-banner .single-banner p {
	font-size: 14px;
	color: #F7941D;
	font-weight: 500;
	margin-bottom: 5px;
	text-transform: capitalize;
}
.small-banner .single-banner a {
	color: #333;
	margin-top: 22px;
	display: block;
	font-size: 12px;
	font-weight:500;
	display: inline-block;
	text-transform:uppercase;
	border-bottom:2px solid #333;
}
.small-banner .single-banner a:hover{
	color:#F7941D;
	border-color:#F7941D;
}
/*======================================
   End Small Banner CSS
========================================*/ 

/*======================================
   Start Mid Banner CSS
========================================*/ 
.midium-banner{
	padding:0;
}
.midium-banner .single-banner{
	position:relative;
}
.midium-banner .single-banner img{
	height:100%;
	width:100%;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.midium-banner .single-banner .content {
	padding-left:50px;
	position: absolute;
	left: 0;
	top: 50%;
	transform:translateY(-50%);
}
.midium-banner .single-banner h3 {
	font-size: 27px;
	font-weight: 700;
	text-transform: uppercase;
	color: #333;
	line-height: 30px;
}
.midium-banner .single-banner h3 span{
	color:#F7941D;
}
.midium-banner .single-banner p {
	font-size: 13px;
	color: #F7941D;
	font-weight: 500;
	margin-bottom: 5px;
	text-transform: uppercase;
}
.midium-banner .single-banner a {
	display: inline-block;
	font-weight: 600;
	text-align: center;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	padding: .375rem .75rem;
	font-size: 13px;
	border-radius: .25rem;
	background: #333;
	color: #fff !important;
	padding: 10px 27px;
	border-radius: 30px;
	margin-top: 25px;
	text-transform: uppercase;
}
.midium-banner .single-banner a:hover{
	background:#F7941D;
	color:#fff;
}
/*======================================
   End Mid Banner CSS
========================================*/ 

/*======================================
   Start Most Popular CSS
========================================*/
.pro-tab-viewmore-wrap {
	position: relative;
	text-align: center;
}
.most-popular .section-title{
	margin-bottom:40px;
}
.pro-tab-viewmore-wrap .pro-viewmore {
  position: absolute;
  right: 40px;
  top: 0;
}
.most-popular .single-product{
	margin:50px 15px 0 15px;
}
/* Slider Nav */
.most-popular .owl-nav{
	margin: 0;
    position: absolute;
    top: 50%;
    width: 100%;
	margin-top:-25px;
}
.most-popular .owl-carousel .owl-nav div {
	height: 60px;
	width: 30px;
	line-height: 58px;
	background: #fff;
	color: #333;
	position: absolute;
	margin: 0;
	border-radius: 0;
	font-size: 15px;
	text-align: center;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
	box-shadow: 0px 0px 10px #3333331c;
}
.most-popular .owl-carousel .owl-nav div:hover{
	color:#fff;
	background:#F7941D;
}
.most-popular .owl-carousel .owl-controls .owl-nav .owl-prev{
	left:0;
}
.most-popular .owl-carousel .owl-controls .owl-nav .owl-next{
	right:0;
}
/*======================================
   End Most Popular CSS
========================================*/

/*======================================
   Start Single Product CSS
========================================*/
.product-area .nav-tabs {
	text-align: center;
	display: inline-block;
	width: 100%;
	border:none;
}
.product-area .nav-tabs .nav-item {
	margin-bottom: -1px;
	display: inline-block;
}
.product-area .nav-tabs li a {
	color: #333;
	text-transform: uppercase;
	display: inline-block;
	position: relative;
	margin-right: 5px;
	font-weight: 500;
	background: #fff;
	color: #333;
	padding: 3px 14px;
	border-radius: 3px;
	font-size: 13px;
}
.product-area .nav-tabs li:last-child a{
	border-color:transparent;
} 
.product-area .nav-tabs li a i{
	margin-right:10px;
}
.product-area .nav-tabs li a.active,
.product-area .nav-tabs li:hover a{
	background:#F7941D;
	color:#fff;
	border-color:transparent;
}
/* Sinlge Product */
.single-product{
	margin-top:50px;
}
.single-product .product-img {
  position: relative;
  overflow: hidden;
  cursor:pointer;
}
.single-product .product-img a {
  display: block;
  position: relative;
}
.single-product .product-img a img {
  width: 100%;
}
.single-product .product-img a img.hover-img {
  position: absolute;
  left: 0;
  top: 0;
  z-index: 1;
  opacity: 0;
  transition: opacity 0.5s ease, transform 2s cubic-bezier(0, 0, 0.44, 1.18), -webkit-transform 2s cubic-bezier(0, 0, 0.44, 1.18);
}
.single-product .product-img a span.price-dec {
	background-color: #f6931d;
	display: inline-block;
	font-size: 11px;
	color: #fff;
	right: 20px;
	top: 20px;
	padding: 1px 16px;
	font-weight: 700;
	border-radius: 0;
	text-align: center;
	position: absolute;
	text-transform: uppercase;
	border-radius: 30px;
	height: 26px;
	line-height: 25px;
}
.single-product .product-img a span.new {
	background-color: #8493ca;
	display: inline-block;
	font-size: 11px;
	color: #fff;
	right: 20px;
	top: 20px;
	padding: 1px 16px;
	font-weight: 700;
	border-radius: 0;
	text-align: center;
	position: absolute;
	text-transform: uppercase;
	border-radius: 30px;
	height: 26px;
	line-height: 24px;
}
.single-product .product-img a span.out-of-stock {
	background-color: #ed1b24;
	display: inline-block;
	font-size: 11px;
	color: #fff;
	right: 20px;
	top: 20px;
	padding: 1px 16px;
	font-weight: 700;
	border-radius: 0;
	text-align: center;
	position: absolute;
	text-transform: uppercase;
	border-radius: 30px;
	height: 26px;
	line-height: 24px;
}
.single-product .product-img .product-action {
	display: inline-block;
	position: absolute;
	right: 0;
	bottom: 0;
	z-index: 99;
	border-radius: 3px;
}
.single-product .product-img .product-action a {
	background-color: transparent;
	color: #333;
	display: block;
	font-size: 16px;
	display: inline-block;
	margin-right: 15px;
	text-align: right;
	height: 52px;
	position: relative;
	top: 2px;
}
.single-product .product-img .product-action a:last-child{
	margin-right:0;
	border:none;
}
.single-product .product-img .product-action a i {
  line-height: 40px;
}
.single-product .product-img .product-action a span {
	visibility: hidden;
	position: absolute;
	background: #F7941D !important;
	color: #fff !important;
	text-align: center;
	padding: 5px 12px;
	z-index: 3;
	opacity: 0;
	-webkit-transition: opacity .6s, margin .3s;
	-o-transition: opacity .6s, margin .3s;
	transition: opacity .6s, margin .3s;
	font-size: 11px;
	right: 0;
	line-height: 14px;
	top: -12px;
	margin-top: -5px;
	margin-right: 0;
	display: inline-block;
	width: 120px;
	border-radius:15px 0 0 15px;
}
.single-product .product-img .button-head .product-action a span::after {
	position: absolute;
	content: "";
	right: 0;
	bottom: -12px;
	border: 6px solid #F7941D;
	border-left:0px solid transparent;
	border-right:6px solid transparent;
	border-bottom:6px solid transparent;
}
.single-product .product-img .product-action a:hover {
	color:#F7941D;
}
.single-product .product-img .product-action a:hover span {
  visibility: visible;
  opacity: 1;
  color:#333;
  background:#fff;
  margin-top: -12px;
}
.single-product .product-img .product-action.pro-action-width-dec a {
  width: 30px;
  height: 30px;
  font-size: 14px;
}
.single-product .product-img .product-action.pro-action-width-dec a i {
  line-height: 30px;
}
.single-product .product-img .product-action.pro-action-width-dec-2 {
  bottom: 45px;
}
.single-product .product-img .product-action-2 {
	position: absolute;
	left: 0;
	bottom: 0;
	text-align: left;
	z-index: 99;
	-webkit-transition: all 250ms ease-out;
	-o-transition: all 250ms ease-out;
	transition: all 250ms ease-out;
}
.single-product .product-img .product-action-2 a {
	display: block;
	background-color: transparent;
	color: #333;
	text-align: left;
	font-size: 12px;
	font-weight: 600;
	text-transform: uppercase;
	line-height: 1;
	display: inline-block;
}
.single-product .product-img .product-action-2 a:hover {
  color:#F7941D;
}
.single-product .button-head {
	background: #fff;
	display: inline-block;
	height: 40px;
	width: 100%;
	position: absolute;
	left: 0;
	bottom: -50px;
	z-index: 9;
	height: 50px;
	line-height: 50px;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.single-product:hover .button-head{
	bottom:0;
}
.single-product .product-img .shop-list-quickview {
  position: absolute;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
  left: 0;
  right: 0;
  text-align: center;
  z-index: 99;
  margin-top: 20px;
  visibility: hidden;
  opacity: 0;
  -webkit-transition: all .35s ease 0s;
  -o-transition: all .35s ease 0s;
  transition: all .35s ease 0s;
}
.single-product .product-img .shop-list-quickview a {
  color: #000;
  background-color: #fff;
  display: inline-block;
  width: 50px;
  height: 50px;
  border-radius: 100%;
  font-size: 18px;
}
.single-product .product-img .shop-list-quickview a:hover {
  background-color: #222;
  color: #fff;
}
.single-product .product-img .shop-list-quickview a i {
  line-height: 50px;
}
.single-product .product-content{
	margin-top:20px;
}
.single-product .product-img:hover.default-overlay::before {
  background-color: rgba(38, 38, 38, 0.2);
  z-index: 9;
  -webkit-transition: all 250ms ease-out;
  -o-transition: all 250ms ease-out;
  transition: all 250ms ease-out;
  pointer-events: none;
  opacity: 1;
}
.single-product .product-img:hover.default-overlay.metro-overlay::before {
  background-color: rgba(38, 38, 38, 0.4);
  z-index: 9;
  -webkit-transition: all 250ms ease-out;
  -o-transition: all 250ms ease-out;
  transition: all 250ms ease-out;
  pointer-events: none;
  opacity: 1;
}
.single-product .product-img:hover img.hover-img {
  opacity: 1;
}
.single-product .product-content h3 {
    line-height: 22px;
}
.single-product .product-content h3 a {
	font-size: 14px;
	font-weight: 500;
	margin: 0;
}
.single-product .product-content h3 a:hover{
	color:#F7941D;
}
.single-product .product-content .product-price {
  margin: 6px 0 0 0;
}
.single-product .product-content .product-price span {
	font-size: 15px;
	font-weight: 500;
}
.single-product .product-content .product-price span.old {
  text-decoration: line-through;
  opacity: .6;
  margin-right: 2px;
}
/*======================================
   End Single Product CSS
========================================*/

/*======================================
   Start Shop Sidebar CSS
========================================*/
.shop-sidebar .single-widget {
	margin-top: 30px;
	background: #F6F7FB;
	padding: 30px;
}
.shop-sidebar .single-widget:first-child {
	margin-top: 0;
}
.shop-sidebar .single-widget .title {
	position: relative;
	font-size: 18px;
	font-weight: 500;
	text-transform: capitalize;
	margin-bottom: 25px;
	display: block;
	border-bottom: 1px solid #ddd;
	padding-bottom: 15px;
}
/* Shop Price */
.shop .range .price-filter {
	display: block;
	margin-top: 20px;
}
.shop .range #slider-range {
	box-shadow: none;
	border: none;
	height: 4px;
	background: #F7941D;
	color: #F7941D;
	border-radius: 0px;
}
.shop .range #slider-range .ui-slider-range {
	box-shadow: none;
	background: #222;
	border-radius: 0px;
	border: none;
}
.shop .range .ui-slider-handle.ui-state-default.ui-corner-all {
	width: 14px;
	height: 14px;
	line-height: 10px;
	background: #222;
	border: none;
	border-radius: 100%;
	top: -5px;
}
.shop .range .label-input {
	margin-top: 15px;
}
.shop .range .label-input span{
	margin-right:5px;
	color:#282828;
}
.shop .range .ui-slider-handle.ui-state-default.ui-corner-all {
	background: #F7941D;
	color: #F7941D;
	cursor:pointer;
}
.shop .range .label-input input {
	border: none;
	margin: 0;
	font-weight: 600;
	font-size: 14px;
	color: #222;
	background: transparent;
}
.shop .range .check-box-list {
	margin-top: 15px;
}
.shop .range .check-box-list li {
	margin-bottom: 5px;
}
.shop .range .check-box-list li:last-child{
	margin:0;
}
.shop .range .check-box-list li label input {
	display: inline-block;
	margin-right: 6px;
	position: relative;
	top: 1px;
}
.shop .range .check-box-list li label {
	margin: 0;
	font-size: 14px;
	font-weight: 400;
	color:#333;
	cursor:pointer;
}
.shop .range .check-box-list .count{
	margin-left:5px;
	color:#666;
}
/* Category List */
.shop-sidebar .categor-list {
	margin-top: 10px;
}
.shop-sidebar .categor-list li{
	
}
.shop-sidebar .categor-list li {
	margin-bottom: 10px;
}
.shop-sidebar .categor-list li:last-child{
	margin-bottom:0px;
}
.shop-sidebar .categor-list li a {
	display: inline-block;
	color: #666;
	font-weight: 400;
	font-size: 14px;
	text-transform: capitalize;
}
.shop-sidebar .categor-list li a:hover{
	color:#F7941D;
}
/* Recent Post */
.shop-sidebar .single-post {
	position: relative;
	margin-top: 30px;
    padding-bottom: 30px;
	border-bottom: 1px solid #ddd;
}
.shop-sidebar .single-post.first{
	padding-top:0px;
}
.shop-sidebar .single-post:last-child{
	padding-bottom:0px;
	border:none;
}
.shop-sidebar .single-post .image img{
	height: 80px;
	width: 80px;
	position:absolute;
	left:0;
	top:0;
	border-radius:100%;
}
.shop-sidebar .single-post .content{
	padding-left:100px;
}
.shop-sidebar .single-post .content h5 {
	line-height: 18px;
}
.shop-sidebar .single-post .content h5 a {
	color: #222;
	font-weight: 500;
	font-size: 14px;
	font-weight: 500;
	display: block;
}
.shop-sidebar .single-post .content h5 a:hover{
	color:#F7941D;
}
.shop-sidebar .single-post .content .price {
	display: block;
	color: #333;
	font-weight: 500;
	margin: 5px 0 0px 0;
	text-transform: uppercase;
	font-size: 14px;
}
.shop-sidebar .single-post .reviews li{
	display:inline-block;
}
.shop-sidebar .single-post .reviews li i{
	color:#999;
}
.shop-sidebar .single-post .reviews li.yellow i{
	color:#F7941D;
}
/* Shop Topbar */
.shop .shop-top {
	clear: both;
	background: #f6f7fb;
	padding: 18px 20px 50px 20px;
}
.shop .shop-shorter {
	float: left;
}
.shop .single-shorter {
	display: inline-block;
	margin-right: 10px;
}
.shop .single-shorter:last-child{
	margin:0;
}
.shop .single-shorter label {
	display: inline-block;
	float: left;
	margin: 4px 5px 0 0;
	font-weight:500;
}
.shop .single-shorter option{}
.shop .nice-select {
	clear: initial;
	display: inline-block;
	margin: 0;
	border: 1px solid #e6e6e6;
	border-radius: 0px;
	height: auto;
	width: auto;
	border-radius: 0px;
}
.shop .nice-select::after{
	border-color:#888;
}
.shop .nice-select .list {
	border-radius:0px;
}
.shop .nice-select .option.selected {
	font-weight: 500;
}
.shop .nice-select .list li{
	color:#666;
	border-radius:0px;
}
.shop .nice-select .list li:hover{
	background:#F7941D;
	color:#fff;
}
.shop .view-mode {
	float: right;
}
.shop .view-mode li {
	display: inline-block;
	margin-right: 5px;
}
.shop .view-mode li:last-child{
	margin:0;
}
.shop .view-mode li a {
	width: 43px;
	height: 32px;
	background: transparent;
	border: 1px solid #77777775;
	text-align: center;
	display: block;
	line-height: 32px;
	color: #888;
	border-radius: 0px;
}
.shop .view-mode li.active a,
.shop .view-mode li:hover a {
	background: #F7941D;
	color:#fff;
	border-color:transparent;
}
/*======================================
   End Shop Sidebar CSS
========================================*/

/*======================================
   Start Shop Single CSS
========================================*/
.shop.single{
	padding:70px 0 100px;
}
.shop.single .product-gallery {
	margin-top: 30px;
}
.shop.single .flexslider-thumbnails {
	position: relative;
}
.shop.single .product-gallery .slides li{
	position:relative;
}
.shop.single .product-gallery .slides li img{
	width:100%;
}
.shop.single .flex-control-nav{
	margin-top:15px;
}
.shop.single .flex-control-thumbs li {
	width: 20%;
	position: relative;
	margin: 0 8px 10px -3px;
}
.shop.single .flex-control-thumbs li img {
	border: none;
	padding: 0;
	border:1px solid transparent;
}
.shop.single .flex-control-thumbs li img.flex-active{
	border-color:#F7941D;
}
.shop.single .flex-direction-nav{
	display:none;
}
.shop.single .product-des{
	margin-top:30px;
}
.shop.single .product-des .short h4 {
	font-size: 22px;
	font-weight: 600;
	margin-top: -5px;
	line-height: 28px;
}
.shop.single .product-des .short .description {
	font-size: 14px;
	color: #555555;
	margin-top: 20px;
	margin-bottom: 20px;
	padding-bottom: 20px;
	border-bottom: 1px solid #eee;
}
.shop.single .product-des {}
.shop.single .product-des .total-review{
	font-size:14px;
	font-weight:500;
	margin-left:10px;
	display:inline-block;
}
.shop.single .product-des .total-review:hover{
	color:#F7941D;
}
.shop.single .product-des  .rating{
	margin-top:20px;
	display:inline-block;
}
.shop.single .product-des .rating li{
	display:inline-block;
}
.shop.single .product-des .rating li i{
	color:#F7941D;
}
.shop.single .product-des .rating li.dark i{
	color:#555;
}
.shop.single .product-des .price {
	font-size: 20px;
	color: #333;
	font-weight: 600;
	margin-top: 15px;
}
.shop.single .product-des .price s{
	color:#333;
}
.shop.single .product-des .price span{
	display:inline-block;
	margin-right:15px;
	color:#F7941D;
}
.shop.single .product-des .product-buy {
	margin-top: 40px;
}
.shop.single .product-des .product-buy{}
.shop.single .product-des .color {
	display: inline-block;
	margin-right: 50px;
}
.shop.single .product-des .color h4 {
	font-size: 18px;
	font-weight: 600;
}
.shop.single .product-des .color h4 span {
	display: block;
	font-size: 14px;
	font-weight: 500;
	margin-top: 4px;
}
.shop.single .product-des .color ul{
	margin-top: 10px;
}
.shop.single .product-des .color ul li{
	display:inline-block;
	margin-right:5px;
}
.shop.single .product-des .color ul li:last-child{
	margin-right:0;
}
.shop.single .product-des .color ul li a{
	height:30px;
	width:30px;
	line-height:30px;
	text-align:center;
	display:block;
	background:#333;
}
.shop.single .product-des .color ul li a i{
	font-size:11px;
	color:#fff;
	opacity:0;
	visibility:hidden;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.shop.single .product-des .color ul li a:hover i{
	opacity:1;
	visibility:visible;
}
.shop.single .product-des .color ul li .one{
	background:#3498db;
}
.shop.single .product-des .color ul li .two{
	background:#F7941D;
}
.shop.single .product-des .color ul li .three{
	background:#8e44ad;
}
.shop.single .product-des .color ul li .four{
	background:#2ecc71;
}
/* Size */
.shop.single .product-des .size{
	display:inline-block;
}
.shop.single .product-des .size h4{
	display: block;
	font-size: 14px;
	font-weight: 500;
	margin-top: 0px;
}
.shop.single .product-des .size ul{
	display:inline-block;
	margin-top: 10px;
}
.shop.single .product-des .size ul li {
	display: inline-block;
	margin-right: 5px;
}
.shop.single .product-des .size ul li:last-child{
	margin-right:0;
}
.shop.single .product-des .size ul li a {
	display: block;
	height: 30px;
	width: 36px;
	border: 1px solid #eee;
	text-align: center;
	line-height: 30px;
	font-size: 14px;
}
.shop.single .product-des .size ul li a:hover{
	color:#F7941D;
}
.shop.single .quantity {
	display: inline-block;
	margin-right: 10px;
}
.shop.single .quantity h6 {
	display: inline-block;
	margin-right: 10px;
	font-size: 15px;
	font-weight: 500;
}
.shop.single .quantity .input-group {
	width: 151px;
	display: inline-block;
}
.shop.single .quantity .button {
	display: inline-block;
	position: absolute;
	top: 0;
	display:inline-block;
}
.shop.single .quantity .button.minus{
	left:0;
	border-radius:0;
	overflow:hidden;
}
.shop.single .quantity .button.plus {
	right: 0;
	border-radius:0;
	overflow:hidden;
}
.shop.single .quantity .button .btn {
	padding: 0;
	width: 35px;
	height: 45px;
	line-height: 45px;
	border-radius: 0px;
	background: transparent;
	color: #282828;
	font-size: 12px;
	border: none;
}
.shop.single .quantity .button .btn:hover{
	color:#F7941D;
}
.shop.single .quantity .input-number {
	border: 1px solid #eceded;
	width: 100%;
	text-align: center;
	height: 45px;
	border-radius: 0px;
	overflow: hidden;
	padding: 0px 38px;
}
.shop.single .add-to-cart {
	display:inline-block;
}
.shop.single .add-to-cart .btn {
	height: 45px;
	width: auto;
	padding: 0 42px;
	line-height: 45px;
	text-align: center;
	text-transform: capitalize;
	margin-right: 5px;
	border-radius: 0px;
	background: #333;
	color: #fff;
	display: inline-block;
	font-weight: 500;
}
.shop.single .add-to-cart .btn:hover{
	color:#fff;
	background:#F7941D;
}
.shop.single .add-to-cart .btn.min {
	padding: 0 20px;
	font-size: 17px;
	position: relative;
	top: 1px;
	line-height: 45px;
}
.shop.single .cat{
	font-size: 14px;
	font-weight: 500;
	color:#333;
	margin-top:30px;
}
.shop.single .cat a{
	display:inline-block;
	margin-left:10px;
}
.shop.single .cat a:hover{
	color:#F7941D;
}
.shop.single .availability{
	color:#333;
	font-size:14px;
	margin-top:6px;
}
/* Product Tab */
.shop.single .product-info {
	margin-top: 50px;
}
.shop.single .nav-tabs {
	border:none;
}
.shop.single .nav-tabs li {
	margin-right: 10px;
}
.shop.single .nav-tabs li:last-child{
	margin-right:0;
}
.shop.single .nav-tabs li a {
	border: 0px solid;
	border-radius: 0px;
	background: #fff;
	color: #333;
	padding: 10px 30px;
	font-weight: 500;
	font-size: 14px;
	border: 1px solid #eee;
}
.shop.single .nav-tabs li a i{
	margin-right:10px;
}
.shop.single .nav-tabs li a.active,
.shop.single .nav-tabs li:hover a{
	background:#F7941D;
	color:#fff;
	border-color:transparent;
}
.shop.single .tab-single {
	
}
.shop.single .single-des {
	margin-top:35px;
}
.shop.single .single-des h4{
	margin-bottom:15px;
	font-weight:500;
	font-size:22px;
	
}
.shop.single .single-des ul{}
.shop.single .single-des ul li {
	color: #555;
	display: block;
	margin-bottom: 10px;
	position:relative;
	padding-left:20px;
}
.shop.single .single-des ul li::before {
	position: absolute;
	content: "";
	left: 0;
	top: 9px;
	height: 7px;
	width: 7px;
	background: #f7941d;
	border-radius: 50%;
}
.shop.single .single-des p{}

.shop.single .item-info {
	width: 100%;
}
.shop.single .item-info tbody{}
.shop.single .item-info tbody tr{}
.shop.single .item-info tbody td {
	border: 1px solid #e6e6e6;
	padding: 10px;
}
.shop.single .item-info tbody strong{}
.shop.single .ratting-main{}
.shop.single .avg-ratting {
	margin-bottom: 20px;
}
.shop.single .avg-ratting h4 {
	font-size: 18px;
	margin: 0;
}
.shop.single .avg-ratting h4 span{
	font-size:14px;
}
.shop.single .single-rating {
	margin-bottom: 20px;
}
.shop.single .single-rating:last-child{
	margin:0;
	border:none;
	padding:0;
}
.shop.single .rating-author {
	float: left;
	margin-right: 10px;
	padding: 20px;
	padding-right: 10px;
}
.shop.single .rating-author img {
	width: 60px;
	border-radius: 100%;
	height: 60px;
}
.shop.single .rating-des {
	padding-left: 72px;
	background: #f9f8f8;
	padding: 17px 20px 17px 107px;
}
.shop.single .rating-des .ratings {
	margin: 0;
}
.shop.single .rating-des h6 {
	font-size: 14px;
	font-weight: 600;
	line-height: 18px;
}
.shop.single .ratting-main .single-rating ul{}
.shop.single .ratting-main .single-rating ul li{
	display:inline-block;
}
.shop.single .ratting-main .single-rating ul li i{
	color:#F7941D;
	font-size:14px;
}
.shop.single .review-inner label {
	display: inline-block;
	margin: 0 5px 0 0;
}
.shop.single .review-inner .ratings {
	overflow: visible;
	display: inline-block;
	margin: 0;
}
.shop.single .review-inner .ratings ul{
	display:inline-block;
}
.shop.single .ratting-main .single-rating ul {
	display: inline-block;
	margin-right: 5px;
}
.shop.single .ratings .rate-count {
	display: inline-block;
	color: #666;
	font-size: 13px;
}
.shop.single .comment-review {
	margin-bottom: 30px;
}
.shop.single .comment-review .add-review{
	margin-top:30px;
}
.shop.single .comment-review .add-review h5{
	font-size: 18px;
	font-weight: 600;
	margin-bottom: 7px;
}
.shop.single .comment-review .add-review p{
	color:#333;
}
.shop.single .comment-review h4 {
	font-size: 15px;
	font-weight: 600;
	margin-bottom: 7px;
	margin-top:20px;
}
.shop.single .comment-review .review-inner{
	margin-bottom:15px;
	display:block;
}
.shop.single .comment-review .rating li {
	display:inline-block;
}
.shop.single .comment-review .rating li i{
	color:#F7941D;
	font-size: 14px;
}
.shop.single .rating-des p{
	margin-top:5px;
}
.shop.single .avg-ratting h4 {
	font-size: 20px;
	color: #333;
}
.shop.single .avg-ratting{}
.shop.single .form .form-group input {
	width: 100%;
	height: 45px;
	padding: 10px 20px;
	background: #fff;
	border: 1px solid #ddd;
	resize: none;
	border-radius: 0;
	color: #333;
}
.shop.single .form .form-group button {
	border: none;
	padding: 17px 50px;
}
.shop.single .form .form-group textarea {
	width: 100%;
	height:200px;
	padding: 20px;
	background:#fff;
	border:1px solid #ddd;
	resize:none;
	border-radius:0;
	color:#333;
}
.shop.single .form .form-group label {
	color: #333;
	position: relative;
}
.shop.single .form .form-group label span {
	color: #ff2c18;
	display: inline-block;
	position: absolute;
	right: -12px;
	top: 4px;
	font-size: 16px;
}
.shop.single .review-panel{
	margin-top:35px;
}
/*======================================
   End Shop Single CSS
========================================*/

/*======================================
   Start Shop Home List CSS
========================================*/
.shop-home-list{
	padding:0;
	padding-bottom:100px;
}
.shop-home-list .shop-section-title{
	margin-bottom:20px;
}
.shop-home-list .shop-section-title h1 {
	font-size: 22px;
	margin-bottom: 0;
	text-transform: capitalize;
	position: relative;
	color: #2c2d3f;
	font-weight: 700;
	margin-bottom: 10px;
	padding-bottom: 10px;
}
.shop-home-list .shop-section-title h1::before {
	position: absolute;
	content: "";
	height: 2px;
	width: 50px;
	background: #F7941D;
	left: 0;
	bottom: -1px;
}
.shop-home-list .single-list {
	overflow: hidden;
	position: relative;
	margin-top: 30px;
	border: 1px solid #eee;
	padding: 10px;
}
.shop-home-list .single-list .list-image{
	position:relative;
}
.shop-home-list .single-list .list-image.overlay:before{
	background:#000;
	opacity:0;
	visibility:hidden;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.shop-home-list .single-list .list-image.overlay:hover:before{
	opacity:0.3;
	visibility:visible;
}
.shop-home-list .single-list .list-image .buy{
	height:40px;
	width:40px;
	line-height:40px;
	font-size:14px;
	color:#fff;
	background:#F7941D;
	border-radius:100%;
	display:block;
	position:absolute;
	left:50%;
	top:50%;
	margin-left:-20px;
	margin-top:-20px;
	text-align:center;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
	transform:scale(0);
	opacity:0;
	visibility:hidden;
}
.shop-home-list .single-list .list-image .buy:hover{
	background:#fff;
	color:#333;
}
.shop-home-list .single-list .list-image:hover .buy{
	opacity:1;
	visibility:visible;
	transform:scale(1);
}
.shop-home-list .single-list .no-padding{
	padding-right:0px;
}
.shop-home-list .single-list img{
	width:100%;
	height:100%;
}
.shop-home-list .single-list .content {
	padding-top: 45px;
	padding-right: 12px;
}
.shop-home-list .single-list .content .title {
	line-height: 18px;
}
.shop-home-list .single-list .content .title a{
	font-size: 14px;
	font-weight: 600;
}
.shop-home-list .single-list .content .titlea {
	color: #333;
}
.shop-home-list .single-list .content a:hover{
	color: #F7941D;
}
.shop-home-list .single-list .content .price {
	margin-top: 15px;
	font-weight: 500;
	background: #f7941d;
	display: inline-block;
	color: #fff;
	padding: 2px 18px;
	border-radius: 30px;
	font-size: 14px;
	font-weight: 500;
}
/*======================================
   End Shop Home List CSS
========================================*/

/*======================================
   Start Shopping Cart CSS
========================================*/
.table.shopping-summery {
	background: #fff;
}
.shopping-cart {
	background: #f6f6f6;
	padding: 50px 0;
}
.shopping-summery thead .main-hading{
	padding:0px 50px;
}
.shopping-summery thead {
	background: #F7941D;
	color: #fff;
}
.shopping-summery thead tr th {
	border: none;
	font-weight: 600;
	color: #fff;
	text-align: center;
}
.shopping-summery tbody tr {
	border-bottom: 1px solid #F7941D;
	margin-top: 20px;
}
.shopping-summery tbody tr img {
	border-radius: 0;
	width: 80px;
	height: 80px;
}
.shopping-summery tbody tr:last-child{
	border:none;
}
.shopping-summery tbody .product-name a {
	font-weight: 600;
	color: #282828;
	font-weight: 600;
	font-size: 17px;
}
.shopping-cart .table p {
	font-size: 14px;
	color: #666;
}
.shopping-summery tbody .product-name a:hover{
	color:#F7941D;
}
.shopping-summery tbody .product img {
	max-width: 70px;
	border-radius: 100%;
	max-height: 65px;
	border: 1px solid #e6e6e6;
	padding: 4px;
}
.shopping-summery tbody .product:hover img{
	border-color:#F7941D;
	-webkit-transform:rotate(360deg);
	-moz-transform:rotate(360deg);
	transform:rotate(360deg);
}
.shopping-cart .border{
	
}
.shopping-cart .table .remove-icon{
	font-size:16px;
}
.shopping-cart .table td {
	vertical-align: middle;
	border-top: 1px solid #eee;
	padding: 30px;
}
.shopping-summery tbody .price {
	text-align: center;
}
.shopping-summery tbody .price span{}
.shopping-cart tbody .qty .input-group {
	width: 175px;
	display: inline-block;
}
.shopping-cart .qty .button {
	display: inline-block;
	position: absolute;
	top: 0;
}
.shopping-cart .qty .button.minus{
	left:0;
	border-radius:0;
	overflow:hidden;
}
.shopping-cart .qty .button.plus {
	right: 0;
	border-radius:0;
	overflow:hidden;
}
.shopping-cart .qty .button .btn {
	padding: 0;
	width: 44px;
	height: 47px;
	line-height: 50px;
	border-radius: 0px;
	background: transparent;
	color: #282828;
	border: none;
	font-size: 12px;
}
.shopping-cart .qty .button .btn:hover{
	color:#F7941D;
}
.shopping-cart .qty .input-number {
	border: 1px solid #eceded;
	width: 100%;
	text-align: center;
	height: 47px;
	border-radius:0;
	overflow: hidden;
	padding: 0px 45px;
}
.shopping-summery tbody .total-amount {
	text-align: center;
}
.shopping-summery tbody .total-amount span{}
.shopping-summery tbody .action {
	text-align: center;
}
.shopping-summery tbody .action a:hover{
	color:#F7941D;
}
.shopping-cart .total-amount{
	margin-top:50px;
}
.shopping-cart .total-amount .left{}
.shopping-cart .total-amount .left .coupon{}
.shopping-cart .total-amount .left .coupon form{}
.shopping-cart .total-amount .left .coupon form input {
	width: 220px;
	display: inline-block;
	height: 48px;
	color: #333;
	padding: 0px 20px;
	border: none;
	box-shadow: 0px 0px 5px #0000000a;
}
.shopping-cart .total-amount .left .coupon form .btn {
	display: inline-block;
	height: 48px;
	border: navajowhite;
	margin-left: 4px;
	background: transparent;
	color: #333;
	background: #fff;
	box-shadow: 0px 0px 5px #00000012;
}
.shopping-cart .total-amount .left .coupon form .btn:hover{
	background:#fff;
	color:#F7941D;
}
.shopping-cart .total-amount .left label{
	font-size:22px;
	font-weight:500;
	color:#333;
}
.shopping-cart .total-amount .left .checkbox {
	text-align: left;
	margin: 0;
	margin-top: 20px;
}
.shopping-cart .total-amount .left .checkbox label {
	font-size: 15px;
	font-weight: 400;
	color: #333;
	position: relative;
	padding-left: 30px;
}
.shopping-cart .total-amount .left .checkbox label:hover{
	cursor:pointer;
}
.shopping-cart .total-amount .left .checkbox label input{
	display:none;
}
.shopping-cart .total-amount .left .checkbox label::before {
	position: absolute;
	content: "";
	left: 0;
	top: 4px;
	width: 16px;
	height: 16px;
	border: 1px solid #555555;
	border-radius: 0px;
}
.shopping-cart .total-amount .left .checkbox label::after {
	position: absolute;
	content: "\f00c";
	font-family: "Fontawesome";
	left: 0;
	top: 0;
	width: 22px;
	height: 22px;
	line-height: 24px;
	left: 3px;
	top: 0px;
	opacity: 0;
	visibility: hidden;
	transform: scale(0);
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
	display: block;
	font-size: 11px;
}
.shopping-cart .total-amount .left .checkbox label.checked::after{
	opacity:1;
	visibility:visible;
	transform:scale(1);
}
.shopping-cart .total-amount .right {
	padding-left: 100px;
}
.shopping-cart .total-amount .right ul{
	
}
.shopping-cart .total-amount .right ul li {
	font-size: 15px;
	font-weight: 400;
	color: #333;
	margin-bottom: 12px;
}
.shopping-cart .total-amount .right ul li.last {
	padding-top: 12px;
	border-top: 1px solid #c8c8c8;
	color: #333;
	font-size: 15px;
	font-weight: 400;
}
.shopping-cart .total-amount .right ul li span{
	display:inline-block;
	float:right;
}
.shopping-cart .total-amount .right .button5 .btn {
	text-align: center;
	border-radius: 0;
	width: 100%;
	margin-top: 10px;
	height: 46px;
	line-height: 18px;
	font-size: 13px;
	color: #fff;
}
/*======================================
   End Shopping Cart CSS
========================================*/

/*======================================
   Start Checkout Form CSS
========================================*/
.shop.checkout {
	padding: 0;
	background: #fff;
	padding-top: 20px;
	padding-bottom: 50px;
}
.shop.checkout .checkout-form {
	margin-top: 30px;
}
.shop.checkout .checkout-form h2 {
	font-size: 25px;
	color: #333;
	font-weight: 700;
	line-height: 27px;
}
.shop.checkout .checkout-form p {
	font-size: 16px;
	color: #333;
	font-weight: 400;
	margin-top: 12px;
	margin-bottom: 30px;
}
.shop.checkout .form{}
.shop.checkout .form .form-group {
	margin-bottom: 25px;
}
.shop.checkout .form .form-group label{
	color:#333;
	position:relative;
}
.shop.checkout .form .form-group label span {
	color: #ff2c18;
	display: inline-block;
	position: absolute;
	right: -12px;
	top: 4px;
	font-size: 16px;
}
.shop.checkout .form .form-group input {
	width: 100%;
	height: 45px;
	line-height: 50px;
	padding: 0 20px;
	border-radius: 3px;
	border-radius: 0px;
	color: #333 !important;
	border: none;
	background: #F6F7FB;
}
.shop.checkout .form .form-group input:hover{
	
}
.shop.checkout .nice-select {
	width: 100%;
	height: 45px;
	line-height: 50px;
	margin-bottom: 25px;
	background: #F6F7FB;
	border-radius: 0px;
	border:none;
}
.shop.checkout .nice-select .list {
	width: 100%;
	height: 300px;
	overflow: scroll;
}
.shop.checkout .nice-select .list li{}
.shop.checkout .nice-select .list li.option{
	color:#333;
}
.shop.checkout .nice-select .list li.option:hover{
	background:#F6F7FB;
	color:#333;
}
.shop.checkout .form .address input {
	margin-bottom: 15px;
}
.shop.checkout .form .address input:last-child{
	margin:0;
}
.shop.checkout .form .create-account {
	margin: 0;
}
.shop.checkout .form .create-account input {
	width: auto;
	display: inline-block;
	height: auto;
	border-radius: 100%;
	margin-right: 3px;
}
.shop.checkout .form .create-account label {
	display: inline-block;
	margin: 0;
}
.shop.checkout .order-details {
	margin-top: 30px;
	background: #fff;
	padding: 15px 0 30px 0;
	border: 1px solid #eee;
}
.shop.checkout .single-widget {
	margin-bottom: 30px;
}
.shop.checkout .single-widget:last-child{
	margin:0;
}
.shop.checkout .single-widget h2 {
	position:relative;
	font-size: 15px;
	font-weight: 600;
	padding: 10px 30px;
	line-height: 24px;
	text-transform: uppercase;
	color: #333;
	padding-bottom: 5px;
}
.shop.checkout .single-widget h2:before{
	position:absolute;
	content:"";
	left:30px;
	bottom:0;
	height:2px;
	width:50px;
	background:#F7941D;
}
.shop.checkout .single-widget .content ul{
	margin-top:30px;
}
.shop.checkout .single-widget .content ul li {
	display: block;
	padding: 0px 30px;
	font-size: 15px;
	font-weight: 400;
	color: #333;
	margin-bottom: 12px;
}
.shop.checkout .single-widget .content ul li span{
	display:inline-block;
	float:right;
}
.shop.checkout .single-widget .content ul li.last {
	padding-top: 12px;
	border-top: 1px solid #ebebeb;
	display: block;
	font-size: 15px;
	font-weight: 400;
	color: #333;
}
.shop.checkout .single-widget .checkbox {
	text-align: left;
	margin: 0;
	padding: 0px 30px;
	margin-top:30px;
}
.shop.checkout .single-widget .checkbox label {
	color: #555555;
	position: relative;
	font-size: 14px;
	padding-left: 20px;
	margin-top: -5px;
	font-weight: 400;
	display: block;
	margin-bottom: 15px;
}
.shop.checkout .single-widget .checkbox label:last-child{
	margin-bottom:0;
}
.shop.checkout .single-widget .checkbox label:hover{
	cursor:pointer;
}
.shop.checkout .single-widget .checkbox label input{
	display:none;
}
.shop.checkout .single-widget .checkbox label::before {
	position: absolute;
	content: "";
	left: 0;
	top: 7px;
	width: 12px;
	height: 12px;
	line-height: 16px;
	border: 1px solid #666;
	border-radius: 100%;
}
.shop.checkout .single-widget .checkbox label::after {
	position: absolute;
	content: "";
	left: 0;
	top: 7px;
	width: 12px;
	height: 12px;
	line-height: 16px;
	border-radius: 100%;
	display:block;
	background:#666;
	transform:scale(0);
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.shop.checkout .single-widget .checkbox label.checked::after{
	opacity:1;
	visibility:visible;
	transform:scale(1);
}
.shop.checkout .single-widget.payement {
	padding: 0px 38px;
	text-align: center;
	margin-top: 30px;
}
.shop.checkout .single-widget.get-button {
	text-align: center;
	padding:0px 35px;
}
.shop.checkout .single-widget.get-button .btn {
	height: 46px;
	width: 100%;
	line-height: 19px;
	text-align: center;
	border-radius: 0;
	text-transform: uppercase;
	color: #fff;
}
/*======================================
   End Checkout Form CSS
========================================*/

/*======================================
   Login & Register CSS
========================================*/
.shop.login {
	padding: 100px 0;
}
.shop.login .login-form h2 {
	position:relative;
	font-size: 35px;
	color: #333;
	font-weight: 400;
	line-height: 27px;
	text-transform: uppercase;
	margin-bottom: 12px;
	padding-bottom: 20px;
	text-align: center;
}
.shop.login .login-form h2:before{
	position:absolute;
	content:"";
	left:50%;
	bottom:0;
	height:2px;
	width:50px;
	background:#F7941D;
	margin-left:-25px;
}
.shop.login .login-form p {
	font-size: 14px;
	color: #333;
	font-weight: 400;
	text-align: center;
	margin-bottom:50px;
}
.shop.login .form {
	margin-top: 30px;
}
.shop.login .form .form-group {
	margin-bottom: 22px;
}
.shop.login .form .form-group input {
	width: 100%;
	height: 45px;
	line-height: 50px;
	padding: 0 20px;
	border-radius: 3px;
	border-radius: 0px;
	color:#333 !important;
	border: none;
	background:#F6F7FB;
}
.shop.login .form .form-group label {
	color: #333;
	position: relative;
}
.shop.login .form .form-group label span {
	color: #ff2c18;
	display: inline-block;
	position: absolute;
	right: -12px;
	top: 4px;
	font-size: 16px;
}
.shop.login .form .form-group input:hover{
	border-color:#1308a3;
	color:#1308a3;
}
.shop.login .form .form-group.login-btn {
	margin: 0;
}
.shop.login .form button {
	border: none;
}
.shop.login .form .btn {
	display: inline-block;
	margin-right: 10px;
	height: 46px;
	color: #fff;
	line-height: 20px;
}
.shop.login .form .btn:hover{
	background:#F7941D;
	color:#fff;
}
.shop.login .login-form .checkbox {
	text-align: left;
	margin: 0;
	margin-top: 20px;
	display:inline-block;
}
.shop.login .login-form .checkbox label {
	font-size: 14px;
	font-weight: 400;
	color: #333;
	position: relative;
	padding-left: 20px;
}
.shop.login .login-form .checkbox label:hover{
	cursor:pointer;
}
.shop.login .login-form .checkbox label input{
	display:none;
}
.shop.login .login-form .checkbox label::before {
	position: absolute;
	content: "";
	left: 0;
	top: 6px;
	width: 12px;
	height: 12px;
	border: 1px solid #555555;
	border-radius: 0px;
}
.shop.login .login-form .checkbox label::after {
	position: absolute;
	content: "\f00c";
	font-family: "Fontawesome";
	width: 12px;
	height: 12px;
	line-height: 23px;
	left: 2px;
	top: 0px;
	opacity: 0;
	visibility: hidden;
	transform: scale(0);
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
	display: block;
	font-size: 9px;
}
.shop.login .login-form .checkbox label.checked::after{
	opacity:1;
	visibility:visible;
	transform:scale(1);
}
.shop.login .login-form .lost-pass{
	display:inline-block;
	margin-left:25px;
	color:#333;
	font-size:14px;
	font-weight:400;
}
.shop.login .login-form .lost-pass:hover{
	color:#F7941D;
}
/*======================================
	End Login CSS
========================================*/

/*======================================
   Start Shop List CSS
========================================*/
.shop-list .list-content{
	margin-top:50px;
}
.shop-list .list-content .product-price{}
.shop-list .list-content .product-price span {
	font-size: 14px;
	font-weight: 600;
	margin-bottom: 3px;
	display: block;
}
.shop-list .list-content .title {
	line-height: 20px;
}
.shop-list .list-content .title a:hover{
	color:#F7941D;
}
.shop-list .list-content .title a {
	font-size: 18px;
	font-weight: 600;
}
.shop-list .list-content .rating {
	margin: 5px 0 8px 0;
}
.shop-list .list-content .rating li{
	display:inline-block;
}
.shop-list .list-content .rating li i{
	color: #F7941D;
}
.shop-list .list-content .rating li.total {
	color: #333;
	font-size: 12px;
	margin-left: 3px;
}
.shop-list .list-content .des{}
.shop-list .list-content .btn {
	margin-top: 22px;
	height: 42px;
	line-height: 15px;
	color: #333;
	background: transparent;
	border: 1px solid #cecece;
	font-size: 13px;
	border-radius: 30px;
	height: auto;
	line-height: a;
	padding: 13px 32px;
}
.shop-list .list-content .btn:hover{
	background:#F7941D;
	color:#fff;
	border-color:transparent;
}
/* Pagination CSS */
.pagination {
	text-align: left;
	margin: 50px 0 0 0;
	display:block;
}
.pagination.center {
	text-align: center;
}
.pagination .pagination-list li {
	margin-right: 5px;
	display: inline-block;
}
.pagination .pagination-list li:last-child{
	margin-right:0px;
}
.pagination .pagination-list li a {
	background: #F6F7FB;
	color: #666;
	padding: 6px 18px;
	font-weight: 400;
	border: 1px solid #e1e1e1;
	font-size: 16px;
	border-radius: 0px;
}
.pagination .pagination-list li.active a,
.pagination .pagination-list li:hover a{
	background: #F7941D;
	color: #fff;
	border-color: transparent;
}
.pagination .pagination-list li a i{
	font-size:13px;
}
.pagination .pagination-list li a i{}
.blog-grids.pagination{
	margin-top:50px;
	text-align:center;
}
/*======================================
   End Shop List CSS
========================================*/

/*=============================
	Start Cowndown CSS
===============================*/
.cown-down {
	position: relative;
	height: 515px;
	overflow:hidden;
}
.cown-down .padding-right{
	padding-right:0;
}
.cown-down .padding-left{
	padding-left:0;
}
.cown-down .image img {
	width:100%;
	height:100%;
}
.cown-down .content {
	text-align: center;
	background: #FDFBEF;
	height: 100%;
	position:relative;
}
.cown-down .content .heading-block{
	position:absolute;
	left:0;
	top:50%;
	transform:translateY(-50%);
	padding: 75px;
}
.cown-down .content .small-title {
	font-size: 13px;
	color: #777;
	display: block;
	text-transform: uppercase;
	margin-bottom: 5px;
	font-weight: 600;
}
.cown-down .content .title {
	font-size: 25px;
	font-weight: 600;
	margin-bottom: 20px;
	text-transform: capitalize;
}
.cown-down .content .price {
	margin-top: 35px;
	font-size: 35px;
	font-weight: 700;
	color: #F7941D;
}
.cown-down .content .price s{
	margin-top: 35px;
	font-size: 24px;
	font-weight: 500;
	color:#666;
}
.cown-down .content .cdown {
	float: none;
	text-align:center;
	margin-top:40px;
	width: 80px;
	display:inline-block;
	
}
.cown-down .content .cdown {
	text-align: center;
}
.cown-down .content .cdown{
	display:inline-block;
}
.cown-down .content .cdown span {
	color: #333;
	font-size: 22px;
	font-weight:400;
	text-transform:uppercase;
}
.cown-down .content .cdown p{
	font-size:13px;
	color:#666;
	text-transform:uppercase;
}
/*=============================
	End Cowndown CSS
===============================*/

/*======================================
   Start Shop Services CSS
========================================*/
.shop-services.section {
	padding: 80px 0 0px 0;
	background: #fff;
}
.shop-services.home{
	padding:60px 0;
	background:#F6F7FB;
}
.shop-services .single-service {
	position: relative;
	padding-left: 65px;
}
.shop-services .single-service i {
	height: 50px;
	width: 50px;
	line-height: 50px;
	text-align: center;
	color: #333;
	background: transparent;
	border-radius: 100%;
	display: block;
	font-size: 32px;
	position: absolute;
	left: 0;
	top: 0;
}
.shop-services .single-service h4 {
	font-size: 14px;
	font-weight: 600;
	text-transform: uppercase;
	line-height: 22px;
	color: #333;
}
.shop-services .single-service p {
	color: #898989;
	line-height: 28px;
	font-size:14px;
}
/*======================================
   End Shop Services CSS
========================================*/

/*======================================
   Start Shop Newsletter CSS
========================================*/
.shop-newsletter{
	background:#fff;
}
.shop-newsletter .inner{
	text-align:center;
}
.shop-newsletter .inner h4 {
	color: #333;
	font-size: 17px;
	font-weight: 600;
	margin-bottom: 5px;
	text-transform: uppercase;
}
.shop-newsletter .inner p{
	color:#777;
	font-size:14px;
	font-weight:400;
	margin-bottom:30px;
}
.shop-newsletter .inner p span{
	color:#F7941D;
}
.shop-newsletter .newsletter-inner{
	position:relative;
	display: inline-block;
}
.shop-newsletter .newsletter-inner input {
	width: 480px;
	height: 55px;
	border-radius: 0px;
	padding: 0px 30px;
	font-weight: 400;
	display: inline-block;
	text-shadow: none;
	box-shadow: none;
	border-radius: 0;
	border: none;
	border: 1px solid #ececec;
	border-radius: 30px 0 0 30px;
}
.shop-newsletter .newsletter-inner button{
	border:none;
	text-shadow:none;
	box-shadow:none;
	border-radius:0;
}
.shop-newsletter .newsletter-inner .btn {
	display: inline-block;
	height: 55px;
	padding: 10px 30px;
	position: relative;
	top: 0;
	background: #F7941D;
	color: #fff;
	left: -4px;
	border-radius: 0 30px 30px 0;
	font-size: 14px;
	font-weight: 500;
	text-transform: uppercase;
}
.shop-newsletter .newsletter-inner .btn:hover{
	background:#333;
	color:#fff;
}
/*======================================
   End Shop Newsletter CSS
========================================*/

/*=============================
	About US CSS
===============================*/
.about-us{
	background:#fff;
}
.about-us .about-content {
	padding-right: 50px;
}
.about-us .about-content .story{
	display:block;
	color:#04AAF4;
	margin-bottom:20px;
	font-size:17px;
}
.about-us .about-content .story i{
	color:#04AAF4;
	margin-right:5px;
	font-size:22px;
}
.about-us .about-content h3 {
	font-size: 30px;
	font-weight: 600;
	position: relative;
	margin-bottom: 15px;
	padding-bottom: 15px;
}
.about-us .about-content h3::before {
	position: absolute;
	content: "";
	left: 0;
	bottom: -1px;
	height: 2px;
	width: 60px;
	background: #F7941D;
}
.about-us .about-content h3 span{
	display:inline-block;
	font-weight:700;
	color:#F7941D;
}
.about-us .about-content p {
	line-height: 26px;
	margin-bottom: 10px;
}
.about-us .about-content p:last-child{
	margin:0;
}
.about-us .about-content .button{
	margin-top:40px;
}
.about-us .about-content .button .btn{
	background:#333;
	color:#fff;
	margin-right:15px;
}
.about-us .about-content .button .btn:hover{
	background:#F7941D;
	color:#fff;
}
.about-us .about-content .button .btn.primary{
	background:#F7941D;
	color:#fff;
}
.about-us .about-content .button .btn.primary:hover{
	background:#333;
	color:#fff;
}
.about-us .about-content .button .btn:last-child{
	margin:0;
}
.about-us .about-img {
	position: relative;
	-webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
	-moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
	box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
	border: 10px solid #fff;
}
.about-us .about-img:before{
	opacity:0;
	visibility:hidden;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.about-us .about-img:hover:before{
	opacity:0.6;
	visibility:visible;
}
.about-us .about-img .video {
	height: 64px;
	width: 64px;
	line-height: 64px;
	background: #F7941D;
	color: #fff;
	font-size: 20px;
	border-radius: 100%;
	display: block;
	text-align: center;
	position: absolute;
	left: 50%;
	top: 50%;
	margin-left: -32px;
	margin-top: -32px;
	padding-left: 4px;
	transform: scale(0);
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
}
.about-us .about-img .video:hover{
	background:#fff;
	color:#F7941D;
}
.about-us .about-img:hover .video{
	transform:scale(1);
}
.about-us .about-img img{
	height:100%;
	width:100%;
	
}
/*=============================
	End About US CSS
===============================*/

/*======================================
  10. Start Team CSS
========================================*/  
.team{
	background:#F6F7FB;
}
.team .title-line{
	margin-bottom:40px;
}
.team .single-team {
	margin-top: 30px;
	position:relative;
	-webkit-transition: all 500ms ease;
    -moz-transition: all 500ms ease;
    transition: all 500ms ease;
	display: inline-block;
	overflow:hidden;
	text-align:center;
	background:#fff;
}
.team .single-team .info-head {
	padding: 35px 30px;
}
.team .single-team .image img{
	height:100%;
	width:100%;
}
.team .single-team .info-box {
	text-align:center;
}
.team .single-team .info-box .name {
	display: block;
	font-size: 17px;
	color: #333;
	font-weight: 500;
	margin-bottom: 3px;
	text-transform:capitalize;
}
.team .single-team .info-box .designation{
	color:#aaa;
	font-size:13px;
}
.team .single-team .social-links {
	-webkit-transition: all 500ms ease;
    -moz-transition: all 500ms ease;
    transition: all 500ms ease;
	margin-top:15px;
}
.team .single-team .social-links .social li{
	display:inline-block;
	margin-right:15px;
}
.team .single-team .social-links .social li:last-child{
	margin-right:0px;
}
.team .single-team .social-links .social li a {
	color: #666;
	display: block;
	font-size: 14px;
}
.team .single-team .social-links .social li a:hover{
	color:#F7941D;
}
/*======================================
  End Team CSS
========================================*/ 

/*======================================
   Start Shop Blog CSS
========================================*/
.shop-blog.grid .shop-single-blog{
	margin-top:30px;
}
.shop-blog .shop-single-blog{
	text-align:center;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.shop-blog .shop-single-blog:hover{
	box-shadow: 0px 10px 10px #0000000a;
}
.shop-blog .shop-single-blog img{
	height:100%;
	width:100%;
}
.shop-blog .shop-single-blog .content {
	padding: 40px;
}
.shop-blog .shop-single-blog .content .title {
	font-size: 17px;
	font-weight: 600;
	color: #333;
}
.shop-blog .shop-single-blog .content .title:hover{
	color:#F7941D;
}
.shop-blog .shop-single-blog .content .date {
	font-size: 14px;
	font-weight: 400;
	margin-bottom: 5px;
	color: #B7B7B7;
}
.shop-blog .shop-single-blog .content .more-btn {
	font-size: 14px;
	font-weight: 400;
	color: #3c3c3c;
	margin-top: 10px;
	display: block;
}
.shop-blog .shop-single-blog .content .more-btn:hover{
	color:#F7941D;
}
/* Related Product */
.related-product{
	padding-top:0;
}
.related-product .section-title {
	text-align: center;
	margin-bottom: 10px;
	padding: 0;
}
.related-product .section-title h2 {
	font-size: 25px;
	margin-bottom: 0;
	text-transform: capitalize;
	position: relative;
	color: #2c2d3f;
	font-weight: 700;
	padding-bottom: 15px;
}
/* Blog Sidebar */
.main-sidebar {
	background: #fff;
	margin-top: 30px;
	padding: 40px;
	background: transparent;
	border: 1px solid #eeeeeec2;
}
.main-sidebar .single-widget{
	margin-bottom:50px;
}
.main-sidebar .single-widget .title {
	position: relative;
	font-size: 18px;
	font-weight: 600;
	text-transform: capitalize;
	margin-bottom: 30px;
	display: block;
	background: #fff;
	padding-left: 12px;
}
.main-sidebar .single-widget .title::before {
	position: absolute;
	content: "";
	left: 0;
	bottom: -1px;
	height: 100%;
	width: 3px;
	background: #F7941D;
}
.main-sidebar .single-widget:last-child{
	margin:0;
}
.main-sidebar .search{
	position:relative;
}
.main-sidebar .search input {
	width: 100%;
	height: 45px;
	box-shadow: none;
	text-shadow: none;
	font-size: 14px;
	border: none;
	color: #222;
	background: transparent;
	padding: 0 70px 0 20px;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
	border-radius: 0;
	border: 1px solid #eee;
}
.main-sidebar .search .button {
	position: absolute;
	right: 0;
	top: 0;
	height: 44px;
	width: 50px;
	line-height: 45px;
	box-shadow: none;
	text-shadow: none;
	text-align: center;
	border: none;
	font-size: 14px;
	color: #fff;
	background: #333;
	-webkit-transition: all 0.4s ease;
	-moz-transition: all 0.4s ease;
	transition: all 0.4s ease;
}
.main-sidebar .search .button:hover {
	background:#F7941D;
	color:#fff;
}
/* Category List */
.main-sidebar .categor-list {
	margin-top: 15px;
}
.main-sidebar .categor-list li{
	
}
.main-sidebar .categor-list li {
	margin-bottom: 10px;
}
.main-sidebar .categor-list li:last-child{
	margin-bottom:0px;
}
.main-sidebar .categor-list li a {
	display: inline-block;
	color: #333;
	font-size:14px;
}
.main-sidebar .categor-list li a:hover{
	color:#F7941D;
	padding-left:7px;
}
.main-sidebar .categor-list li a i {
	display: inline-block;
	margin-right:0px;
	font-size: 9px;
	transform: translateY(-1px);
	opacity:0;
	visibility:hidden;
	-webkit-transition:all 0.4s ease;
	-moz-transition:all 0.4s ease;
	transition:all 0.4s ease;
}
.main-sidebar .categor-list li a:hover i{
	margin-right: 6px;
	opacity:1;
	visibility:visible;
}
/* Recent Post */
.main-sidebar .recent-post{}
.main-sidebar .single-post {
	position: relative;
	border-bottom: 1px solid #ddd;
	display: inline-block;
	padding: 17px 0;
}
.main-sidebar .single-post:last-child{
	padding-bottom:0px;
	border:none;
}
.main-sidebar .single-post .image {
	
}
.main-sidebar .single-post .image img{
	float: left;
	width: 80px;
	height: 80px;
	margin-right: 20px;
}
.main-sidebar .single-post .content{
	padding-left:100px;
}
.main-sidebar .single-post .content h5 {
	line-height: 18px;
}
.main-sidebar .single-post .content h5 a {
	color: #2C2D3F;
	font-weight: 500;
	font-size: 14px;
	font-weight: 500;
	margin-top: 10px;
	display: block;
	margin-bottom: 10px;
	margin-top: 0;
}
.main-sidebar .single-post .content h5 a:hover{
	color:#F7941D;
}
.main-sidebar .single-post .content .comment{}
.main-sidebar .single-post .content .comment li{
	color:#888;
	display:inline-block;
	margin-right:15px;
	font-weight:400;
	font-size:14px;
}
.main-sidebar .single-post .content .comment li:last-child{
	margin-right:0;
}
.main-sidebar .single-post .content .comment li i{
	display:inline-block;
	margin-right:5px;
}
/* Blog Tags */
.main-sidebar .side-tags{}
.main-sidebar .side-tags .tag{
	margin-top:40px;
}
.main-sidebar .side-tags .tag li {
	display: inline-block;
	margin-right: 7px;
	margin-bottom: 20px;
}
.main-sidebar .side-tags .tag li a {
	background: #fff;
	color: #333;
	padding: 8px 14px;
	text-transform: capitalize;
	border-radius: 0;
	font-size: 13px;
	background: #F6F7FB;
}
.main-sidebar .side-tags .tag a:hover{
	color:#fff;
	background:#F7941D;
	border-color:transparent;
}
/* Blog Newslatter CSS */
.main-sidebar .newsletter{
	
}
.main-sidebar .newsletter .letter-inner {
	position:relative;
	padding: 35px 30px;
	box-shadow: 0px 0px 12px #00000014;
	z-index:2;
	overflow:hidden;
}
.main-sidebar .newsletter .letter-inner h4 {
	text-transform: capitalize;
	margin-bottom: 25px;
	font-size: 18px;
	font-weight: 600;
	line-height: 24px;
}
.main-sidebar .newsletter .letter-inner p{
	margin-bottom: 20px;
}
.main-sidebar .newsletter .letter-inner .form-inner{
	position:relative;
}
.main-sidebar .newsletter .letter-inner input {
	width: 100%;
	height: 45px;
	background: #fff;
	border: none;
	border: 1px solid #ddd;
	padding: 0px 60px 0px 20px;
	box-shadow: none;
	text-shadow: none;
	border-radius: 0;
}
.main-sidebar .newsletter .letter-inner .form-inner a {
	height: 42px;
	width: 100%;
	background: #F7941D;
	color: #fff;
	font-size: 14px;
	display: block;
	text-align: center;
	line-height: 42px;
	margin-top: 10px;
	text-transform: uppercase;
	font-weight: 500;
}
.main-sidebar .newsletter .letter-inner .form-inner a:hover{
	background:#333;
	color:#fff;
}
/* Blog Single CSS */
.blog-single{
	background:#fff;
	padding:70px 0 100px;
}
.blog-single .blog-single-main {
	margin-top: 30px;
	background: #fff;
}
.blog-single .blog-detail {
	background: #fff;
}
.blog-single .image{
	position:relative;
}
.blog-single .image img{
	width:100%;
	height:100%;
}
.blog-single .blog-title {
	font-size: 24px;
	font-weight: 600;
	text-transform: capitalize;
	margin: 40px 0 15px 0;
}
.blog-single .blog-meta {
	margin-bottom: 0;
	overflow: hidden;
	border-bottom: 1px solid #dddddd6e;
	padding-bottom: 20px;
	margin-bottom: 25px;
}
.blog-single .blog-meta .author i {
	color: #F7941D;
	margin-right: 10px;
	font-size: 13px;
}
.blog-single .blog-meta .author a {
	font-size: 13px;
	border-right:1px solid #ddd;
	padding:0px 15px;
}
.blog-single .blog-meta .author  a:first-child{
	padding-left:0;
}
.blog-single .blog-meta .author  a:last-child{
	padding-right:0;
	border:none;
}
.blog-single .blog-meta span {
	display: inline-block;
	font-size: 14px;
	color: #666;
}
.blog-single .blog-meta span a i {
	margin-right: 10px;
	color: #F7941D;
}
.blog-single .blog-meta span a:hover{
	color:#F7941D;
}
.blog-single .content p {
	margin-bottom: 25px;
	line-height: 26px;
}
.blog-single .content p:last-child{
	margin:0;
}
.blog-single blockquote {
	position: relative;
	font-size: 13px;
	font-weight: 400;
	padding-left: 20px;
	padding: 10px 20px;
	background: #F6F6F6;
	padding: 30px 40px 30px 70px;
	color: #555;
	border: none;
	margin-bottom: 25px;
	border-left: 3px solid #F7941D;
}
.blog-single blockquote i {
	font-size: 30px;
	color: #F7941D;
	position: absolute;
	left: 20px;
	top: 20px;
}
.blog-single .content .img-post{
	margin-bottom: 25px;
}
.blog-single .share-social .content-tags {
	position: relative;
	margin-top: 25px;
}
.blog-single .share-social .content-tags h4 {
	position: absolute;
	left: 0;
	top: 7px;
	font-size: 15px;
	font-weight: 500;
}
.blog-single .share-social .content-tags .tag-inner{
	padding-left:60px;
}
.blog-single .share-social .content-tags .tag-inner li {
	display: inline-block;
	margin-right: 7px;
	margin-bottom: 10px;
	margin-top: 4px;
}
.blog-single .share-social .content-tags .tag-inner li:last-child{
	margin-right: 0px;
	margin-bottom: 0px;
}
.blog-single .share-social .content-tags .tag-inner li a {
	border-radius: 30px;
	padding: 5px 15px;
	background:#f4f7fc;
	font-size: 13px;
}
.blog-single .share-social .content-tags .tag-inner li a:hover{
	color:#fff;
	background:#F7941D;
}
/* Comments */
.blog-single .comments{
	margin-top:40px;
}
.blog-single .comments .comment-title {
	position: relative;
	font-size: 18px;
	font-weight: 600;
	text-transform: capitalize;
	margin-bottom: 30px;
	display: block;
	background: #fff;
	padding-left: 12px;
}
.blog-single .comments .comment-title:before{
	position: absolute;
	content: "";
	left: 0;
	bottom: -1px;
	height: 100%;
	width: 3px;
	background:#F7941D;
}
.blog-single .comments{
	
}
.blog-single .comments .single-comment {
	position: relative;
	margin-bottom: 40px;
	border-radius: 5px;
	padding-left: 95px;
}
.blog-single .comments .single-comment.left{
	margin-left:110px;
}
.blog-single .comments .single-comment img {
	height: 70px;
	width: 70px;
	border-radius: 100%;
	position: absolute;
	left: 0;
}
.blog-single .single-comment .content {
	
}
.blog-single .single-comment .content h4 {
	color: #333;
	font-size: 16px;
	font-weight: 500;
	margin-bottom: 10px;
	display: inline-block;
	margin-bottom: 18px;
	text-transform: capitalize;
}
.blog-single .single-comment .content h4 span {
	display: inline-block;
	font-size: 13px;
	color: #8D8D8D;
	margin: 0;
	font-weight: 400;
	text-transform: capitalize;
	display: block;
	margin-top: 5px;
}
.blog-single .single-comment .content p {
	color: #666;
	font-weight: 400;
	display: block;
	margin: 0;
	margin-bottom: 20px;
	line-height: 22px;
}
.blog-single .single-comment .content .button{}
.blog-single .single-comment .content .btn {
	display: inline-block;
	color: #666;
	font-weight: 400;
	color: #6a6a6a;
	border-radius: 4px;
	text-transform: capitalize;
	font-size: 14px;
	background: transparent;
	padding: 0;
}
.blog-single .single-comment .content a i{
	display:inline-block;
	margin-right:5px;
}
.blog-single .single-comment .content a:hover{
	color:#F7941D;
}
/* Comment Form */
.blog-single .reply form {
	padding: 40px;
	border: 1px solid #eee;
}
.blog-single .reply .reply-title {
	position: relative;
	font-size: 18px;
	font-weight: 600;
	text-transform: capitalize;
	margin-bottom: 30px;
	display: block;
	background: #fff;
	padding-left: 12px;
}
.blog-single .reply .reply-title:before{
	position: absolute;
	content: "";
	left: 0;
	bottom: -1px;
	height: 100%;
	width: 3px;
	background:#F7941D;
}
.blog-single .reply .form-group {
	margin-bottom: 20px;
}
.blog-single .reply .form-group input {
	width: 100%;
	height: 45px;
	line-height: 50px;
	padding: 0 20px;
	border-radius: 0px;
	color: #333 !important;
	border: none;
	border: 1px solid #eee;
}
.blog-single .reply .form-group textarea {
	width: 100%;
	height: 200px;
	line-height: 50px;
	padding: 0 20px;
	border-radius: 0px;
	color: #333 !important;
	border: none;
	border: 1px solid #eee;
}
.blog-single .reply .form-group label {
	color: #333;
	position: relative;
}
.blog-single .reply .form-group label span {
	color:#ff2c18;
	display: inline-block;
	position: absolute;
	right: -12px;
	top: 4px;
	font-size: 16px;
}
.blog-single .reply .button {
	text-align: left;
	margin-bottom:0px;
}
.blog-single .reply .button .btn {
	height: 50px;
	border: none;
}
/*======================================
   End Shop Blog CSS
========================================*/


/*======================================
  21. Contact CSS
========================================*/
.contact-us {
	position: relative;
	z-index: 43;
}
.contact-us .title{
	margin-bottom: 30px;
}
.contact-us .title h4 {
	font-size: 17px;
	font-weight: 500;
	margin-bottom: 5px;
	color: #F7941D;
}
.contact-us .title h3 {
	font-size: 25px;
	text-transform: capitalize;
	font-weight: 600;
}
.contact-us .single-head {
	padding: 50px;
	box-shadow: 0px 0px 15px #0000001a;
	height: 100%;
}
.contact-us .single-info {
	text-align: left;
	margin-bottom:30px;
}
.contact-us .single-info i {
	color: #fff;
	font-size: 18px;
	display: inline-block;
	margin-bottom: 15px;
	height: 40px;
	width: 40px;
	display: block;
	text-align: center;
	border-radius: 3px;
	line-height: 40px;
	background:#F7941D;
}
.contact-us .single-info ul
.contact-us .single-info ul li{
	margin-bottom:5px;
}
.contact-us .single-info ul li:last-child{
	margin-bottom:0;
}
.contact-us .single-info ul li a{
	font-weight:400;
}
.contact-us .single-info ul li a:hover{
	color:#F7941D;
}
.contact-us .single-info .title {
	margin-bottom: 10px;
	font-weight: 500;
	color: #333;
	font-size: 18px;
}
.contact-us .form-main {
	box-shadow: 0px 0px 15px #0000001a;
	padding: 50px;
}
.contact-us .form .form-group input {
	height: 48px;
	line-height: 48px;
	width: 100%;
	border: 1px solid #e6e2f5;
	padding: 0px 20px;
	color: #333;
	border-radius: 0px;
	font-weight: 400;
}
.contact-us .form .form-group textarea {
	height: 180px;
	width: 100%;
	border: 1px solid #e6e2f5;
	padding: 15px 20px;
	color: #333;
	border-radius: 0px;
	resize: none;
	font-weight:400;
}
.contact-us .form .form-group label {
	color: #333;
	position: relative;
}
.contact-us .form .form-group label span {
	color: #ff2c18;
	display: inline-block;
	position: absolute;
	right: -12px;
	top: 4px;
	font-size: 16px;
}
.contact-us .form .button {
	margin:0;
}
.contact-us .form .button .btn {
	height: 50px;
	border: none;
}
#myMap {
	height: 500px;
	width: 100%;
}
/*======================================
  End Contact CSS
========================================*/

/* Mail Success */
.mail-success .mail-inner {
	text-align: center;
	background: #fff;
	padding: 0px 30px;
}
.mail-success .mail-inner h2 {
	margin-bottom: 10px;
	display: block;
	font-weight: 600;
	color: #F7941D;
	text-transform: uppercase;
	font-size: 30px;
}
.mail-success .mail-inner p {
	font-size: 14;
	color: #333;
	margin-bottom: 30px;
	line-height: 22px;
}
.mail-success .mail-inner .btn {
	color: #fff;
	padding: 10px 30px;
}
.mail-success .mail-inner .btn i{
	margin-right:5px;
}

/*=============================
	Start 404 Error CSS
===============================*/
.error-page {
	background:#fff;
	width: 100%;
	height: 100%;
	overflow: hidden;
	position:relative;
}
.error-page .error-inner {
	text-align: center;
	flex-direction: initial;
	height: auto;
	text-align: center;
}
.error-page .error-inner h2 {
	color: #F7941D;
	margin-bottom: 0;
	font-weight: 700;
	font-size: 100px;
	display: inline-block;
	font-size: 120px;
}
.error-page .error-inner h5 {
	display: block;
	color: #444;
	font-size: 20px;
	margin-bottom: 20px;
	font-weight: 600;
	text-transform: capitalize;
}
.error-page .error-inner p {
	color: #666;
	font-weight: 400;
	line-height: 22px;
	font-size: 15px;
	padding: 0 30px;
}
.error-page .button {
	margin-top: 30px;
}
.error-page .button .btn {
	margin-right: 15px;
	border-radius: 30px;
	background: #333;
	color: #fff;
	font-weight: 600;
	font-size: 14px;
	font-weight: 500;
	border: 1px solid #d7d7d7;
	background: transparent;
	color: #333;
	padding: 10px 28px;
}
.error-page .button .btn:hover{
	color:#fff;
	background:#F7941D;
	border-color:transparent;
}
/*=============================
	/End 404 Error CSS
===============================*/

.free-version-banner {
  position: relative;
  background: #333;
  text-align: center;
  background-color: #F7941D;
  margin-bottom:100px;
}

.free-version-banner .section-title span {
  font-weight: 500;
  text-transform: capitalize;
}

.free-version-banner .section-title {
  margin: 0;
  padding: 0;
  text-align: center;
}

.free-version-banner .section-title h2 {
  padding-bottom: 15px;
}

.free-version-banner .section-title h2::before {
  background-color: #fff;
}

.free-version-banner .button {
  z-index: 5;
  margin-top: 40px;
}

.free-version-banner .button .btn {
  background-color: #fff;
  color: #333;
  text-transform:capitalize;
}

/*=============================
	20. Start Footer CSS
===============================*/
.footer{
	background:#222;
}
.footer .about {
	padding-right: 50px;
}
.footer .single-footer h4 {
	font-size: 17px;
	font-weight: 600;
	color: #fff;
	text-transform: capitalize;
	margin-bottom: 30px;
}
.footer .about .logo{
	margin-bottom:20px;
}
.footer .about .logo img{}
.footer .about .text{
	color:#fff;
	font-weight: 400;
}
.footer .about .call {
	color: #fff;
	margin-top: 15px;
	font-weight: 400;
}
.footer .about .call span{
	display: block;
}
.footer .about .call a {
	color: #f7941d;
	font-size: 20px;
	font-weight: 600;
}
.footer .links ul{}
.footer .links ul li {
	display: block;
	margin-bottom: 8px;
}
.footer .links ul li:last-child{
	margin-bottom:0;
}
.footer .links ul li a{
	color:#fff;
	font-weight: 400;
}
.footer .links ul li a:hover{
	color:#F7941D;
	padding-left:10px;
}
.footer .social{}
.footer .social .contact{}
.footer .social .contact ul{}
.footer .social .contact ul li {
	color: #fff;
	display: block;
	margin-bottom: 4px;
	font-weight: 400;
}
.footer .contact ul li:last-child{
	margin-bottom:0;
}
.footer .social ul {
	margin-top: 20px;
}
.footer .social ul li{
	display:inline-block;
	margin-right:25px;
}
.footer .social ul li:last-child{
	margin-right:0;
}
.footer .social ul li a{
	color:#fff;
	display:block;
	font-size:16px;
}
.footer .social ul li a:hover{
	color:#F7941D;
}
/* Copyright */
.footer .copyright{
	
}
.footer .copyright .inner{
	border-top:1px solid #eeeeee3d;
	padding:20px 0;
}
.footer .copyright .left{}
.footer .copyright .right{
	float:right;
}
.footer .copyright p{
	color:#fff;
}
.footer .copyright p a{
	color:#fff;
	text-decoration:underline;
}
/*=============================
	End Footer CSS
===============================*/

.fixed-size {
    width: 100%;
    height: 350px; /* Bạn có thể thay đổi chiều cao này */
    object-fit: cover; /* Đảm bảo ảnh giữ tỷ lệ khi thay đổi kích thước */
}

