<?php 
	session_start();
	require_once dirname(__FILE__).'/../database/db.php';
	include('../class/option.php');
	$option = new Option();
	if(isset($_SESSION['user_id'])){
		include('../class/user.php');
		$user = new user($_SESSION['user_id']);
	}
	if(!isset($user)){
		http_response_code(404);
		header('Location: ../404.php'); // provide your own HTML for the error page
		die();
	}
	if($user->authority!="admin"){
		http_response_code(404);
		header('Location: ../404.php'); // provide your own HTML for the error page
		die();
	}
	include('../class/commodity.php');
	include('../class/cart.php');
	include('../class/order.php');
	$pagename = basename(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
	if(isset($page) && ($page == "addproduct")) $pagename = "addproduct";
?><!DOCTYPE html>
<html dir="ltr" lang="zh-tw">
<head>
	<title><?=$option->sitename?> - 後台</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css" media="screen" />
	<?=($pagename == "addproduct"||$pagename == 'category'||$pagename == 'coupon'||$pagename == 'setting')?"<link rel=\"stylesheet\" href=\"./css/".$pagename.".css\" type=\"text/css\" media=\"screen\" />":""; ?>
	<?=($pagename == 'order'||$pagename == 'payment')? "<link rel=\"stylesheet\" href=\"./css/order.css\" type=\"text/css\" media=\"screen\" />" : ""?>
	<link rel="Shortcut Icon" type="image/x-icon" href="" />
	<link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Pacifico:400' rel='stylesheet' type='text/css'>
    <link href="css/helper.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<?=($pagename == 'index') ? "<script src=\"js/chart/fusioncharts.js\"></script>\n<script src=\"js/chart/themes/fusioncharts.theme.fint.js\"></script>":"" ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" crossorigin="anonymous"></script>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
</head>
<body>
<div id="wrap">
<header id="header">
		<nav id="nav">
			<div class="nav_container">
				<ul class="nav_title">
					<li><h1 class="title"><a href="../" class="logo"><?=$option->sitename?></a></h1></li>
				</ul>
				<ul class="nav_menu">
					<li><a href="./" class="dashboard<?=($pagename == 'index') ? " current" : "" ?>">總覽</a></li>
					<li><a href="product.php" class="product-manage<?=($pagename == 'product') ? " current" : "" ?>">商品管理</a></li>
					<li><a href="addproduct.php" class="product-add<?=($pagename == 'addproduct') ? " current" : "" ?>">新增商品</a></li>
					<li><a href="category.php" class="product-cat<?=($pagename == 'category') ? " current" : "" ?>">商品分類</a></li>
					<li><a href="order.php" class="order-manage<?=($pagename == 'order') ? " current" : "" ?>">訂單管理</a></li>
					<li><a href="coupon.php" class="coupon<?=($pagename == 'coupon') ? " current" : "" ?>">優惠管理</a></li>
					<li><a href="userinfo.php" class="user-manage<?=($pagename == 'userinfo') ? " current" : "" ?>">會員管理</a></li>
					<li><a href="setting.php" class="website-setting<?=($pagename == 'setting') ? " current" : "" ?>">網站設定</a></li>
					<li style="float:right;"><a href="../login.php?logout=1">登出</a></li>
				</ul>
			</div>
		</nav>
		<div class="container-wrapper header-with-search-wrapper">
			<div class="container header-with-search">
				
			</div>
		</div>
</header>