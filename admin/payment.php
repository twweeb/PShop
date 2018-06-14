<?php 
include('header.php');
$order = new Order();?>

<div id="pshop" class="container">
	<div class="row myorder">
<?php 
	$order_data = $order->AdminShowOrderData($_GET['id']);
	$order_ship = $order->AdminShowOrderShip($_GET['id']);
	$ship_status = $order->ShowShipStatus($order_ship['ship_id']);
?>
<?= (isset($msg))? "<div class=\"col-md-12 message\">・".$msg."</div>" :''?>
<h2>訂單金流/物流資訊</h2>
<section class="payment_sec">
<table class="payment view-payment-table view-payment-hoverable">
<colgroup>
	<col class="cg1"><col class="cg2">
</colgroup>
<tbody>
<tr><td><label for="order_id">訂單編號<br />Order ID</label><td><span id="order_id"><?=$order_data['order_id']?></span>
<tr><td><label for="customer_account">客戶帳號<br />Customer Account</label><td><span id="username"><?php $thisuser = new user($order_data['customer_id']); echo $thisuser->account;?></span>
<tr><td><label for="email">取貨人電子郵件<br />Customer Email</label><td><span id="email"><?=$order_ship['customer_email']?></span>
<tr><td><label for="name">取貨人姓名<br />Customer Name</label><td><span id="name"><?=$order_ship['customer_name']?></span>
<tr><td><label for="address">運送地址<br />Address</label><td><span id="address"><?=$order_ship['customer_address']?></span>
<tr><td><label for="total_price">訂單總金額<br />Total Price</label><td><span id="total_price"><?=$order_data['total_price']?></span>
<tr><td><label for="freight">運送方式(運費)<br />Freight</label><td><span id="fright"><?=$order_data['freight']?>($<?=$order_data['freight_price']?>)</span>
<tr><td><label for="coupon">折扣<br />Discount</label><td><span id="coupon">
<?php if(!empty($order_data['coupon']))
	echo $order_data['coupon_price'];
	else if(!$order_data['paid'])
		echo "<input type=\"text\" name=\"coupon_price\" value=\"0\" /><span class=\"button setdiscount update\">折扣金額</span>";
	else echo "0";
?></span>
<tr><td><label for="final_price">需付款金額<br />Final Price</label><td><span id="final_price"><?=$order_data['final_price']?></span>
<tr><td><label for="payment_status">付款狀態<br />Payment Status</label><td><span id="payment_status"><?=($order_data['paid']) ? $order_data['payment_method']."(已付款)":"未付款<span class=\"button setpaid update\">設定成已付款</span>";?></span>
<tr><td><label for="payment_date">付款日期<br />Payment Date</label><td><span id="payment_date"><?=(!empty($order_data['payment_date'])) ? $order_data['payment_date']:"-";?></span>
<tr><td><label for="ship_stauts">運送狀態<br />Shipping Status</label><td><span id="ship_status"><?=($order_ship['ship_status']) ? "已出貨(寄送編號: <span id=\"ship_id\">".$order_data['ship_id']."</span>)":"未出貨(寄送編號: <span id=\"ship_id\">".$order_data['ship_id']."</span>)<span class=\"button setship update\">設定成已出貨</span>";?></span>
<tr><td><label for="ship_date">運送日期<br />Shipping Date</label><td><span id="ship_date"><?=(!empty($order_data['ship_date'])) ? $order_data['ship_date']:"-";?></span>
</tbody>
</table>
</section>
<?php if($order_data['confirm_status']==3){ ?>
<div class="checkout"><span class="button setfinished update">完成訂單</span></span></div>
<?php }
else if($order_data['confirm_status']==4){ ?>
<div class="checkout"><span class="button setallfinished update">訂單已完成</span></span></div>
<?php }?>
	</div>
</div>
<?php include('footer.php');?>