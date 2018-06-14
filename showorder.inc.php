<?= (isset($msg))? "<div class=\"col-md-12 message\">・".$msg."</div>" :''?>
		<section class="">
			<h2>待付款</h2>
			<table class='view-order-table view-order-hoverable'>
				<tr class='view-order-title'>
					<th><th>訂單編號<th>訂單日期<th>訂單總金額<th>付款狀態<th>訂單狀態<th>運送方式<th>查看<th>取消
				<colgroup>
					<col class="cg1"><col class="cg2"><col class="cg3"><col class="cg4"><col class="cg5"><col class="cg6"><col class="cg7"><col class="cg8"><col class="cg9">
				</colgroup>
				<tbody>
<?php $showall_order = $order->ShowAllOrderUnpaid($user->id); 
			if($showall_order->rowCount()){
			foreach($showall_order->fetchAll() as $ord) {?>
					<tr id="<?=$ord['order_id'] ?>">
					<td class="order-<?=$ord['order_id'] ?>"><span><input type="checkbox" name="del[]" value="<?=$ord['order_id'] ?>" /></span>
					<td class="order_id"><span><?=$ord['order_id'] ?></span>
					<td class="order_date"><span><?=$ord['order_date'] ?></span>
					<td class="order_total_price"><span><?=$ord['final_price'] ?></span>
					<td class="order_paid"><span><?= ($ord['paid'])? "已付款" : "待付款" ?></span>
					<td class="order_status"><span><?= ($ord['confirm_status'])? "已確認" : "待確認" ?></span>
					<td class="order_ship_method"><span><?=$ord['freight'] ?></span>
					<td><span><a href="?id=<?=$ord['order_id'] ?>" class="order-item__view">查看</a></span>
					<td><span><button class="order-item__cancel">取消</button></span>
<?php }} else echo "<tr><td><td>-<td>-<td>-<td>-<td>-<td>-<td>-<td>-" ?>
				</tbody>
			</table>
		</section>
		<section class="">
			<h2>待收貨</h2>
			<table class='view-order-table view-order-hoverable order-shipping'>
				<tr class='view-order-title'>
					<th>訂單編號<th>訂單日期<th>訂單總金額<th>付款狀態<th>訂單狀態<th>運送方式<th>查看
				<colgroup>
					<col class="cg11"><col class="cg3"><col class="cg4"><col class="cg5"><col class="cg6"><col class="cg7"><col class="cg10">
				</colgroup>
				<tbody>
<?php $showall_order = $order->ShowAllOrderUnrecieve($user->id); 
			if($showall_order->rowCount()){
			foreach($showall_order->fetchAll() as $ord) {?>
					<tr id="<?=$ord['order_id'] ?>">
					<td class="order_id"><span><?=$ord['order_id'] ?></span>
					<td class="order_date"><span><?=$ord['order_date'] ?></span>
					<td class="order_total_price"><span><?=$ord['final_price'] ?></span>
					<td class="order_paid"><span><?= ($ord['paid'])? "已付款" : "待付款" ?></span>
					<td class="order_status"><span><?= ($ord['confirm_status'])? "已確認" : "待確認" ?></span>
					<td class="order_ship_method"><span><?=$ord['freight'] ?></span>
					<td><span><a href="?id=<?=$ord['order_id'] ?>" class="order-item__view">查看</a></span>
<?php }} else echo "<tr><td>-<td>-<td>-<td>-<td>-<td>-<td>-" ?>
				</tbody>
			</table>
		</section>
		<section class="">
			<h2>已完成</h2>
			<table class='view-order-table view-order-hoverable order-finished'>
				<tr class='view-order-title'>
					<th>訂單編號<th>訂單日期<th>訂單總金額<th>付款狀態<th>訂單狀態<th>運送方式<th>查看
				<colgroup>
					<col class="cg11"><col class="cg3"><col class="cg4"><col class="cg5"><col class="cg6"><col class="cg7"><col class="cg10">
				</colgroup>
				<tbody>
<?php $showall_order = $order->ShowAllOrderFinished($user->id); 
			if($showall_order->rowCount()){
			foreach($showall_order->fetchAll() as $ord) {?>
					<tr id="<?=$ord['order_id'] ?>">
					<td class="order_id"><span><?=$ord['order_id'] ?></span>
					<td class="order_date"><span><?=$ord['order_date'] ?></span>
					<td class="order_total_price"><span><?=$ord['final_price'] ?></span>
					<td class="order_paid"><span><?= ($ord['paid'])? "已付款" : "待付款" ?></span>
					<td class="order_status"><span><?= ($ord['confirm_status'])? "已確認" : "待確認" ?></span>
					<td class="order_ship_method"><span><?=$ord['freight'] ?></span>
					<td><span><a href="?id=<?=$ord['order_id'] ?>" class="order-item__view">查看</a></span>
<?php }} else echo "<tr><td>-<td>-<td>-<td>-<td>-<td>-<td>-" ?>
				</tbody>
			</table>
		</section>