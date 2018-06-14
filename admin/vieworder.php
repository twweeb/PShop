<?php 
	$order_data = $order->AdminShowOrderData($_GET['id']);
	$order_list = $order->AdminShowOrderList($_GET['id']);
	$order_ship = $order->AdminShowOrderShip($_GET['id']);
	$ship_status = $order->ShowShipStatus($order_ship['ship_id']);
?>
<?= (isset($msg))? "<div class=\"col-md-12 message\">・".$msg."</div>" :''?>
<h2>訂單編號: <?=$_GET['id']?></h2>
<section class="order-detail-header__state-container">
<div class="stepper">
	<div class="stepper__step stepper__step--finish">
		<div class="stepper__step-icon stepper__step-icon--finish">
			<svg class="pshop-svg-icon icon-order-order" enable-background="new 0 0 32 32" viewBox="0 0 32 32" x="0" y="0">
				<g><path d="m5 3.4v23.7c0 .4.3.7.7.7.2 0 .3 0 .3-.2.5-.4 1-.5 1.7-.5.9 0 1.7.4 2.2 1.1.2.2.3.4.5.4s.3-.2.5-.4c.5-.7 1.4-1.1 2.2-1.1s1.7.4 2.2 1.1c.2.2.3.4.5.4s.3-.2.5-.4c.5-.7 1.4-1.1 2.2-1.1.9 0 1.7.4 2.2 1.1.2.2.3.4.5.4s.3-.2.5-.4c.5-.7 1.4-1.1 2.2-1.1.7 0 1.2.2 1.7.5.2.2.3.2.3.2.3 0 .7-.4.7-.7v-23.7z" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"></path>
				<g><line fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" x1="10" x2="22" y1="11.5" y2="11.5"></line><line fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" x1="10" x2="22" y1="18.5" y2="18.5"></line></g></g>
			</svg>
		</div>
	<div class="stepper__step-text">訂單已成立</div>
	<div class="stepper__step-date"><?=$order_data['order_date']?></div>
</div>
<div class="stepper__step<?=($order_data['paid']) ? " stepper__step-icon--finish":""?>">
	<div class="stepper__step-icon<?=($order_data['paid']) ? " stepper__step-icon--finish":""?>">
		<svg class="pshop-svg-icon icon-order-paid" enable-background="new 0 0 32 32" viewBox="0 0 32 32" x="0" y="0">
			<g><path clip-rule="evenodd" d="m24 22h-21c-.5 0-1-.5-1-1v-15c0-.6.5-1 1-1h21c .5 0 1 .4 1 1v15c0 .5-.5 1-1 1z" fill="none" fill-rule="evenodd" stroke-miterlimit="10" stroke-width="3"></path><path clip-rule="evenodd" d="m24.8 10h4.2c.5 0 1 .4 1 1v15c0 .5-.5 1-1 1h-21c-.6 0-1-.4-1-1v-4" fill="none" fill-rule="evenodd" stroke-miterlimit="10" stroke-width="3"></path><path d="m12.9 17.2c-.7-.1-1.5-.4-2.1-.9l.8-1.2c.6.5 1.1.7 1.7.7.7 0 1-.3 1-.8 0-1.2-3.2-1.2-3.2-3.4 0-1.2.7-2 1.8-2.2v-1.3h1.2v1.2c.8.1 1.3.5 1.8 1l-.9 1c-.4-.4-.8-.6-1.3-.6-.6 0-.9.2-.9.8 0 1.1 3.2 1 3.2 3.3 0 1.2-.6 2-1.9 2.3v1.2h-1.2z" stroke="none"></path></g>
		</svg>
	</div>
	<div class="stepper__step-text"><?=($order_data['paid']) ? "訂單已付款":"訂單待付款"?> ($<?=$order_data['final_price']?>)</div>
	<div class="stepper__step-date"><?=$order_data['payment_date']?></div>
</div>
<?php if(!empty($order_data['payment_date'])){?>
<div class="stepper__step<?=(!empty($order_data['ship_date'])) ? " stepper__step-icon--finish":""?>">
	<div class="stepper__step-icon<?=(!empty($order_data['ship_date'])) ? " stepper__step-icon--finish":""?>">
		<svg class="pshop-svg-icon icon-order-shipping" enable-background="new 0 0 32 32" viewBox="0 0 32 32" x="0" y="0">
			<g><line fill="none" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3" x1="18.1" x2="9.6" y1="20.5" y2="20.5"></line><circle cx="7.5" cy="23.5" fill="none" r="4" stroke-miterlimit="10" stroke-width="3"></circle><circle cx="20.5" cy="23.5" fill="none" r="4" stroke-miterlimit="10" stroke-width="3"></circle><line fill="none" stroke-miterlimit="10" stroke-width="3" x1="19.7" x2="30" y1="15.5" y2="15.5"></line><polyline fill="none" points="4.6 20.5 1.5 20.5 1.5 4.5 20.5 4.5 20.5 18.4" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"></polyline><polyline fill="none" points="20.5 9 29.5 9 30.5 22 24.7 22" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"></polyline></g>
		</svg>
	</div>
	<div class="stepper__step-text"><?=(!empty($order_data['ship_date'])) ? "訂單已出貨":"訂單待出貨" ?></div>
	<div class="stepper__step-date"><?=$order_data['ship_date']?></div>
</div>
<?php }if(!empty($order_data['ship_date'])){?>
<div class="stepper__step<?=(!empty($order_data['finished_date'])) ? " stepper__step-icon--finish":""?>">
	<div class="stepper__step-icon<?=(!empty($order_data['finished_date'])) ? " stepper__step-icon--finish":""?>">
		<svg class="pshop-svg-icon icon-order-received" enable-background="new 0 0 32 32" viewBox="0 0 32 32" x="0" y="0">
			<g><polygon fill="none" points="2 28 2 19.2 10.6 19.2 11.7 21.5 19.8 21.5 20.9 19.2 30 19.1 30 28" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"></polygon><polyline fill="none" points="21 8 27 8 30 19.1" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"></polyline><polyline fill="none" points="2 19.2 5 8 11 8" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"></polyline><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3" x1="16" x2="16" y1="4" y2="14"></line><path d="m20.1 13.4-3.6 3.6c-.3.3-.7.3-.9 0l-3.6-3.6c-.4-.4-.1-1.1.5-1.1h7.2c.5 0 .8.7.4 1.1z" stroke="none"></path></g>
		</svg>
	</div>
	<div class="stepper__step-text"><?=(!empty($order_data['finished_date'])) ? "完成訂單":"待完成訂單"?></div>
	<div class="stepper__step-date"><?=$order_data['finished_date']?></div>
</div>
<?php }if(!empty($order_data['finished_date'])){?>
<div class="stepper__step<?=(!empty($order_data['all_finished_date'])) ? " stepper__step-icon--finish":""?>">
	<div class="stepper__step-icon<?=(!empty($order_data['all_finished_date'])) ? " stepper__step-icon--finish":""?>">
		<svg class="pshop-svg-icon icon-order-rating" enable-background="new 0 0 32 32" viewBox="0 0 32 32" x="0" y="0">
			<polygon fill="none" points="16 3.2 20.2 11.9 29.5 13 22.2 19 24.3 28.8 16 23.8 7.7 28.8 9.8 19 2.5 13 11.8 11.9" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"></polygon>
		</svg>
	</div>
	<div class="stepper__step-text"><?=(!empty($order_data['all_finished_date'])) ? "訂單已完成":"待賣家結單"?></div>
	<div class="stepper__step-date"><?=$order_data['all_finished_date']?></div>
</div>
<?php }?>
<div class="stepper__line">
	<div class="stepper__line-background" style="background: rgb(224, 224, 224) none repeat scroll 0% 0%;"></div>
	<div class="stepper__line-foreground" style="width: calc(100% - 140px); background: rgb(45, 194, 88) none repeat scroll 0% 0%;"></div>
</div>
</div>
</section>
<section class="order-detail-page__delivery__container-wrapper">
	<div class="pshop-border-delivery"></div>
	<div class="order-detail-page__delivery__container">
		<div class="order-detail-page__delivery__header">
			<div class="order-detail-page__delivery__header__title">寄貨資訊</div>
			<div class="order-detail-page__delivery__header__tracking-info"><?=$order_ship['freight']?> | 寄件編號. <?=$order_ship['ship_id']?></div>
		</div>
		<div class="order-detail-page__delivery__content">
			<div class="order-detail-page__delivery__shipping-address__container">
				<div class="order-detail-page__delivery__shipping-address">
					<div class="order-detail-page__delivery__shipping-address__shipping-name"><?=$order_ship['customer_name']?></div>
					<div class="order-detail-page__delivery__shipping-address__detail"><?=$order_ship['customer_email']?></div>
					<div class="order-detail-page__delivery__shipping-address__detail"><?=$order_ship['customer_phone']?><br><?=$order_ship['customer_address']?></div>
				</div>
			</div>
			<div class="order-detail-page__delivery__logistic-info">
			<?php
				$i = 0;
				$j = $ship_status->rowCount()-1;
				while($result=$ship_status->fetch()){ 
			?>
				<div class="order-detail-page__delivery__logistic-info__item-wrapper">
					<div class="order-detail-page__delivery__logistic-info__bullet-connector<?=($i==$j)? " order-detail-page__delivery__logistic-info__bullet-connector--last": "" ?>"></div>
					<div class="order-detail-page__delivery__logistic-info__item">
						<div class="order-detail-page__delivery__logistic-info__item__bullet<?=(!$i)?" order-detail-page__delivery__logistic-info__item__bullet--highlighted":"" ?>"></div>
						<div class="order-detail-page__delivery__logistic-info__item__time<?=(!$i)?" order-detail-page__delivery__logistic-info__item__time--highlighted":"" ?>"><?=$result['timestamp']?></div>
						<div class="order-detail-page__delivery__logistic-info__item__description<?=(!$i)?" order-detail-page__delivery__logistic-info__item__description--highlighted":"" ?>"><?=$result['current_status']?></div>
					</div>
				</div>
			<?php $i++;} ?>
			</div>
		</div>
	</div>
	<div class="pshop-border-delivery"></div>
</section>
<section>
	<table class='view-order-table view-order-hoverable'>
		<tr class='view-order-title'>
			<th>商品名稱<th>訂購數量<th>商品單價<th>價格合計
		<colgroup>
			<col class="cg1"><col class="cg2"><col class="cg3"><col class="cg4">
		</colgroup>
		<tbody>
		<?php if(isset($order_list)){
				$TotalPrice = 0;
				while($result=$order_list->fetch()){
					$comm_now = new Commodity($result['commodity_id']);
					echo "<tr id=".$comm_now->comdity_id.">";
					echo "<td class=\"commdity_name\">".$comm_now->comdity_name."</td>";
					echo "<td class=\"commdity_amount\">".$result['amount']."</td>";
					echo "<td class=\"commdity_price\">".$comm_now->comdity_price."</td>";
					$TotalPrice += $result['amount']*$comm_now->comdity_price;
					echo "<td class=\"commdity_item_sum\">".$result['amount']*$comm_now->comdity_price."</td>";
					echo "</tr>";
				}
				if($TotalPrice){
					echo "<tr class=\"total-price\"><td><td><td>總計<td><span>".$TotalPrice."</span>";
					echo "<tr class=\"freight-price\"><td><td><td>運費<td><span>".$order_data['freight_price']."</span>";
					echo "<tr class=\"coupon\"><td><td><td>折扣<td>";if(!empty($order_data['coupon']))echo "-".$order_data['coupon_price']; else echo"0";
					echo "<tr class=\"total-price\"><td><td><td><span style=\"color:#FF0000;\">付款金額</span><td><span style=\"color:#FF0000;\">".$order_data['final_price']."</span>";
				}}?>
		</tbody>
	</table>
</section><div class="checkout"><a href="payment.php?id=<?=$order_data['order_id']?>" class="button">金流/物流管理</a></div>