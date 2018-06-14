<?php 
include('header.php');
include('../class/coupon.php');
$coupon = new Coupon();
?>
<div id="pshop" class="container">
	<div class="row coupon">
<?php
if(isset($_POST['submit']))
{
	if(isset($_POST['promotion_title_en']) && isset($_POST['promotion_title_cht']) && isset($_POST['type'])  && isset($_POST['startOpened'])
	&& (isset($_POST['endOpened']) || isset($_POST['forever'])) && isset($_POST['coupon_code']) && (isset($_POST['max_use_count'])&&!empty($_POST['max_use_count']) || isset($_POST['infinity']))){
		if(isset($_POST['endOpened'])) $end = $_POST['endOpened'];
		else $end = null;
		if(isset($_POST['discount']) && ($_POST['discount']>=0 && $_POST['discount']<=100)) $discount = $_POST['discount'];
		else $discount = 0;
		if($_POST['type'] == "free") $discount = 100;
		if($_POST['type'] == "free" || $_POST['type'] == "free_ship") $shipping = 0;
		else $shipping = 1;
		if(isset($_POST['max_use_count'])) $uses_limit = $_POST['max_use_count'];
		else $uses_limit = -1;
		$coupon->add_coupon($_POST['promotion_title_en'], $_POST['promotion_title_cht'], $_POST['coupon_code'], $_POST['type'][0], $discount, $shipping, $_POST['startOpened'], $end, $uses_limit);
		header('Location: coupon.php');
	}
}
if(isset($_POST['update']))
{
	if(isset($_POST['coupon_id']) && isset($_POST['promotion_title_en']) && isset($_POST['promotion_title_cht']) && isset($_POST['startOpened']) 
	&& (isset($_POST['endOpened']) || isset($_POST['forever'])) && (isset($_POST['max_use_count'])&&!empty($_POST['max_use_count']) || isset($_POST['infinity']))){
		if(isset($_POST['endOpened'])) $end = $_POST['endOpened'];
		else $end = null;
		if(isset($_POST['max_use_count'])) $uses_limit = $_POST['max_use_count'];
		else $uses_limit = -1;
		if(isset($_POST['available'])) $available = 0;
		else $available = 1;
		$coupon->update_coupon($_POST['coupon_id'], $_POST['promotion_title_en'], $_POST['promotion_title_cht'], $_POST['startOpened'], $end, $uses_limit,$available);
		header('Location: coupon.php?id='.$_POST['coupon_id']);
	}
}

if(isset($_GET['id'])){
	$coupon = new Coupon($_GET['id']);
	if(!empty($coupon->id))
		include "viewcoupon.inc.php";
	else include "showcoupon.inc.php";
}
else if(isset($_GET['add']))
	include "addcoupon.inc.php";
else
	include "showcoupon.inc.php";
?>
	</div>
</div>
<?php include('footer.php');?>