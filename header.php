<?php 
	if(!file_exists("./database/db.php")) header("Location: ./install/install.php");
	session_start();
	require_once dirname(__FILE__).'/database/db.php';
	include('./class/option.php');
	$option = new Option();
	include('./class/commodity.php');
	if(isset($_SESSION['user_id'])){
		include('./class/cart.php');
		include('./class/user.php');
		$user = new user($_SESSION['user_id']);
		$cart = new Cart($_SESSION['user_id']);
		$count = $cart->count;
		if($count){
			include('./class/order.php');
			$order = new Order($_SESSION['user_id']);
		}
	}
	else $count = 0;
?><!DOCTYPE html>
<html dir="ltr" lang="zh-tw">
<head>
	<title><?=$option->sitename?></title>
	<meta name="description" content="<?=$option->sitedescription?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css" media="screen" />
	<?=(isset($page))? "<link rel=\"stylesheet\" href=\"./css/".$page.".css\" type=\"text/css\" media=\"screen\" />" : ""?>
	<link rel="Shortcut Icon" type="image/x-icon" href="" />
	<link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Pacifico:400' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" crossorigin="anonymous"></script>
<?php if(isset($_GET['p'])){ 
	$product = new Commodity($_GET['p']);
	if($product->comdity_id==-1){
		header('Location: 404.php'); // provide your own HTML for the error page
		die();
	}
?>
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
	<script>$(function() { $('#addcart').ajaxForm(function() {}); });</script>
<?php } ?>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
</head>
<body>
<div id="wrap">
<header id="header">
		<nav id="nav">
			<div class="nav_container">
				<ul class="nav_menu_left">
					<li><a href="" >聯絡我們</a></li>
					<li><a href="" >Facebook</a></li>
				</ul>
				<ul class="nav_menu_right">
					<?php if(!isset($_SESSION['user_id'])) { 
					?>
					<li><a href="register.php" >註冊</a></li>
					<li><a href="login.php" >登入</a></li>
					<?php } else { ?>
					<li>hi' <?=$user->name ?> <a href="login.php?logout=1" >登出</a></li>
					<li><a href="modifyaccount.php" >會員資料</a></li>
					<li><a href="myorder.php" >我的訂單</a></li>
					<?php if($user->authority == "admin"){ ?><li><a href="./admin/" style="color:#FF0000;">管理後台</a></li><?php }} ?>
				</ul>
			</div>
		</nav>
		<div class="container-wrapper header-with-search-wrapper">
			<div class="container header-with-search">
				<h1 class="title"><a href="./" class="logo"><?=$option->sitename?></a></h1>
					<div class="header-with-search__search-section">
						<div class="pshop-searchbar">
							<div class="search">
								<form method="get" action="./" autocomplete="off">
									<input name="keyword" class="searchbox" value="<?=(isset($_GET['keyword'])? $_GET['keyword']:"")?>" maxlength="128" placeholder="搜尋商品" autocomplete="off">
									<input type="submit" value="Search">
								</form>
							</div>
						<!--<button class="pshop-button-solid pshop-button-solid-primary "></button>-->
						<!--<div class="hot-words"><div class="hot-words__list">...</div></div>-->
					</div>
				</div>
				<div class="header-with-search__cart-wrapper">
					<div class="pshop-drawer "> 
						<div class="cart-drawer-container">
							<div class="cart-drawer">
								<a href="viewcart.php" title="查看購物車"><div class="cart-btn cd-cart <?php echo ($count) ? 'items-added' : '';?>"><span><?=$count ?></span></div></a>
							</div>
						</div>
						<div class="cart-drawer_view-cart-btn-wrapper">
						<div class="navbar_spacer"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
</header>