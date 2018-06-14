<?php 
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
	require_once dirname(__FILE__).'/database/db.php';
	include('./class/option.php');
	$option = new Option();
	require_once dirname(__FILE__).'/database/db.php';
	if(isset($_SESSION['user_id'])){
		include (dirname(__FILE__).'/class/user.php');
		include (dirname(__FILE__).'/class/cart.php');
		$user = new user($_SESSION['user_id']);
		$cart = new Cart($_SESSION['user_id']);
		$count = $cart->count;
	}
	else $count = 0;
?><!DOCTYPE html>
<html dir="ltr" lang="zh-tw">
<head>
	<title><?=$option->sitename?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css" media="screen" />
	<link href='https://fonts.googleapis.com/css?family=Anton|Passion+One|PT+Sans+Caption' rel='stylesheet' type='text/css'>
	<link rel="Shortcut Icon" type="image/x-icon" href="" />
	<link rel="image_src" href="" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
					<li><a href="" >會員資料</a></li>
					<?php if($user->authority == "admin"){ ?><li><a href="userinfo.php" style="color:#FF0000;">會員管理</a></li>
					<li><a href="addproduct.php" >新增商品</a></li>
					<?php }} ?>
				</ul>
			</div>
		</nav>
		<div class="container-wrapper header-with-search-wrapper">
			<div class="container header-with-search">
				<h1 class="title"><a href="./" class="logo"><?=$option->sitename?></a></h1>
					<div class="header-with-search__search-section">
						<div class="pshop-searchbar">
							<div class="search">
								<form method="get" action="" autocomplete="off">
									<input name="keyword" class="searchbox" value="" maxlength="128" placeholder="搜尋商品" autocomplete="off">
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
<div id="pshop" class="container">
	<div class="row">
        <!-- Error Page -->
            <div class="error">
                <div class="container-floud">
                    <div class="col-xs-12 ground-color text-center">
                        <div class="container-error-404">
                            <div class="clip"><div class="shadow"><span class="digit thirdDigit"></span></div></div>
                            <div class="clip"><div class="shadow"><span class="digit secondDigit"></span></div></div>
                            <div class="clip"><div class="shadow"><span class="digit firstDigit"></span></div></div>
                            <div class="msg">OH!<span class="triangle"></span></div>
                        </div>
                        <h2 class="h1">抱歉! 找不到您要求的頁面</h2>
                    </div>
                </div>
            </div>
        <!-- Error Page -->
	</div>
</div>
</div><!--#wrap-->
<footer id="footer">
	<div class="container">PShop購物車</div>
</footer>
	<script>
 	function randomNum()
        {
            "use strict";
            return Math.floor(Math.random() * 9)+1;
        }
        var loop1,loop2,loop3,time=30, i=0, number, selector3 = document.querySelector('.thirdDigit'), selector2 = document.querySelector('.secondDigit'),
            selector1 = document.querySelector('.firstDigit');
        loop3 = setInterval(function()
        {
          "use strict";
            if(i > 40)
            {
                clearInterval(loop3);
                selector3.textContent = 4;
            }else
            {
                selector3.textContent = randomNum();
                i++;
            }
        }, time);
        loop2 = setInterval(function()
        {
          "use strict";
            if(i > 80)
            {
                clearInterval(loop2);
                selector2.textContent = 0;
            }else
            {
                selector2.textContent = randomNum();
                i++;
            }
        }, time);
        loop1 = setInterval(function()
        {
          "use strict";
            if(i > 100)
            {
                clearInterval(loop1);
                selector1.textContent = 4;
            }else
            {
                selector1.textContent = randomNum();
                i++;
            }
        }, time);
	</script>
</body>
</html>