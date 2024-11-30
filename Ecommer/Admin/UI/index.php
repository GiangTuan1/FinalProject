<?php
session_start();
include_once ("../../config.php");
include_once ("./home/head.php");
?>
 

 <?php
if (isset ($_GET['page'])) {
	$page = $_GET['page'];
	if ($page == "category") {
		include_once ("./category.php");
	} elseif ($page == "banner") {
		include_once ("./banner.php");
	} elseif ($page == "order") {
		include_once ("./order.php");
	} elseif ($page == "size") {
		include_once ("./size.php");
	} elseif ($page == "role") {
		include_once ("./role.php");
	} elseif ($page == "account") {
		include_once ("./account.php");
	} elseif ($page == "product") {
		include_once ("product.php");
	} elseif ($page == "contact") {
		include_once ("contact.php");
	} 
} else {
	include_once ("./home/home.php");
}

include_once ("./home/foodter.php");
?>
 