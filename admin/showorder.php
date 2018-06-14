<div id="pshop" class="container">
	<div class="row">
        <div class="container-fluid">
            <!-- Start Page Content -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-money-bill-alt f-s-40 color-primary"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2 class="waiting-pay"><?=$order->CountWaitingPay() ?></h2>
                                <p class="m-b-0">待付款訂單</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-archive f-s-40 color-warning"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2 class="waiting-ship"><?=$order->CountWaitingShip() ?></h2>
                                <p class="m-b-0">待出貨訂單</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-percent f-s-40 color-success"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2 class="finished"><?=$order->CountFinish() ?></h2>
                                <p class="m-b-0">本月已完成訂單數</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<section class="col-md-12">
			<div class="submit changetable">
       			<span class="right"><a href="<?=(isset($_GET['trash'])&&($_GET['trash']==1))? "order.php" : "?trash=1" ?>" class="orderpage button"><?=(isset($_GET['trash'])&&($_GET['trash']==1))? "全部訂單" : "取消的訂單" ?></a></span>
       		</div>
			<table class='view-order-table view-order-hoverable'>
				<tr class='view-order-title'>
					<th><th>訂單編號<th>買家<th>訂單日期<th>訂單總金額<th>付款狀態<th>訂單狀態<th>運送方式<th>檢視<th><?=(isset($_GET['trash'])&&($_GET['trash']==1))?"復原":"取消"?>
				<colgroup>
					<col class="cg1"><col class="cg2"><col class="cg3"><col class="cg4"><col class="cg5"><col class="cg6"><col class="cg7"><col class="cg8"><col class="cg9"><col class="cg10">
				</colgroup>
				<tbody>
<?php if(isset($_GET['trash'])&&($_GET['trash']==1))
			$showall_order = $order->ShowAllTrashOrder(); 
		else 
			$showall_order = $order->ShowAllOrder(); 
			if($showall_order->rowCount()){
			foreach($showall_order->fetchAll() as $ord) {
			$order_user = new user($ord['customer_id']);?>
					<tr id="<?=$ord['order_id'] ?>">
					<td class="order-<?=$ord['order_id'] ?>"><span><input type="checkbox" name="del[]" value="<?=$ord['order_id'] ?>" /></span>
					<td class="order_id"><span><?=$ord['order_id'] ?></span>
					<td class="order_customer"><span><?=$ord['customer_name']?></span>
					<td class="order_date"><span><?=$ord['order_date'] ?></span>
					<td class="order_totalprice"><span><?=$ord['total_price'] ?></span>
					<td class="order_paid"><span><?= ($ord['paid'])? "已付款" : "待付款" ?></span>
					<td class="order_status"><span><?= ($ord['confirm_status'])? "已確認" : "待確認" ?></span>
					<td class="order_ship_method"><span><?=$ord['freight'] ?></span>
					<td><span><a href="?id=<?=$ord['order_id'] ?>" class="order-item__view">檢視</button></span>
					<td><span><button class="<?=(isset($_GET['trash'])&&($_GET['trash']==1))?"order-item__restore":"order-item__cancel"?>"><?=(isset($_GET['trash'])&&($_GET['trash']==1))?"復原":"取消"?></button></span>
<?php }}
else echo"<tr><td><td>-<td>-<td>-<td>-<td>-<td>-<td>-<td>-<td>-"; ?>
				</tbody>
			</table>
		</section>
	</div>
</div>