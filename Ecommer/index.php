<?php
include_once ("config.php");
include_once ("./home/head.php");
?>
 

 <?php
if (isset ($_GET['page'])) {
	$page = $_GET['page'];
	if ($page == "product") {
		include_once ("./product.php");
	} elseif ($page == "order_history") {
		include_once ("./order_history.php");
	} elseif ($page == "order_details") {
		include_once ("./order_details.php");
	} elseif ($page == "cart") {
		include_once ("./cart.php");
	} elseif ($page == "checkout") {
		include_once ("./checkout.php");
	} elseif ($page == "profile") {
		include_once ("./profile.php");
	} elseif ($page == "contact") {
		include_once ("contact.php");
	} elseif ($page == "about") {
		include_once ("about.php");
	} 
} else {
	include_once ("./home/home.php");
}

include_once ("./home/foodter.php");
?>
 