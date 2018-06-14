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
                                <h2><?=$coupon->CountAvailable() ?></h2>
                                <p class="m-b-0">優惠代碼數量</p>
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
                                <h2><?=$coupon->CountTotalDiscount() ?></h2>
                                <p class="m-b-0">本月已優惠總金額</p>
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
                                <h2><?=$coupon->CouponUsedRatio() ?>%</h2>
                                <p class="m-b-0">本月訂單Coupon使用率</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<section class="col-md-12">
			<div class="submit changetable">
       			<span class="left"><a href="?add=1" class="button">新增代碼</a></span>
       			<span class="right"><a href="<?=(isset($_GET['nonavailable'])&&($_GET['nonavailable']==1))? "coupon.php" : "?nonavailable=1" ?>" class="productpage button"><?=(isset($_GET['nonavailable'])&&($_GET['nonavailable']==1))? "可使用的代碼" : "已停用（過期）的代碼" ?></a></span>
       		</div>
			<table class='view-coupon-table view-coupon-hoverable'>
				<tr class='view-coupon-title'>
					<th><th>優惠名稱<th>特殊優惠<th>使用期限<th>使用次數<th>代碼<th>編輯<th>使用紀錄
				<colgroup>
					<col class="cg1"><col class="cg2"><col class="cg3"><col class="cg4"><col class="cg5"><col class="cg6"><col class="cg7"><col class="cg8">
				</colgroup>
				<tbody>
<?php if(isset($_GET['nonavailable'])) $ShowAllCoupon = $coupon->ShowAllNonAvailable();
		else $ShowAllCoupon = $coupon->ShowAllCoupon(); 
			if($ShowAllCoupon->rowCount()){
			foreach($ShowAllCoupon->fetchAll() as $cup) {?>
					<tr id="<?=$cup['coupon_id'] ?>">
					<td class="coupon-<?=$cup['coupon_id'] ?>"><span><input type="checkbox" name="del[]" value="<?=$cup['coupon_id'] ?>" /></span>
					<td class="coupon-name"><span><?=$cup['cht_name'] ?></span>
					<td class="coupon-type"><span><?=$cup['type'] ?></span>
					<td class="coupon-time"><span><?=$cup['date_start'] ?> ~ <?=($cup['date_end']==null)? "永久":$cup['date_end'] ?></span>
					<td class="coupon-used"><span><?=$cup['uses_total'] ?> / <?=($cup['uses_limit']==-1)? "無限":$cup['uses_limit'] ?></span>
					<td class="coupon-code"><span><?=$cup['code'] ?></span>
					<td><span><a href="?id=<?=$cup['coupon_id'] ?>">編輯</a></span>
					<td><span>使用紀錄</span>
<?php }}
else echo"<tr><td><td>-<td>-<td>-<td>-<td>-<td>-<td>-"; ?>
				</tbody>
			</table>
		</section>