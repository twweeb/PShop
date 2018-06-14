		<div class="cd-customization">
		<div class="col-md-6 hidden-sm hidden-xs">
			<section>
				<div id="silder">
					<div class="detail-img">
						<img src="./img/product_img/<?=$product->comdity_photo;?>" alt="" class="img-responsive">
					</div>
				</div>
			</section>
		</div>
			<div class="col-md-6">
				<section class="commodity-info">
					<h1><?=$product->comdity_name;?><input type="hidden" name="id" class="commodity-id" value="<?=$product->comdity_id;?>" /></h1>
					<!--<hr>產品內容<hr>-->
					已售：<?=$product->comdity_sold;?>｜庫存：<?=$product->comdity_amount;?>
					<p><span class="product_view_price">TWD $<?=$product->comdity_price;?></span><input class="commodity-price" type="hidden" name="price" value="<?=$product->comdity_price;?>" /></p>
					<?php if($product->comdity_amount){ ?>
					<div class="pshop-input-quantity">
						數量：<input type="number" class="commodity-amount" value="1" placeholder="1~<?=$product->comdity_amount;?>" name="amount" step="1" min="1" max="<?=$product->comdity_amount;?>" required><span class="validity"></span>
					</div>
					<button class="add-to-cart">
						<em>加到購物車</em>
						<svg x="0px" y="0px" width="25px" height="32px" viewBox="0 0 25 32">
							<path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"/>
						</svg>
					</button>
					<?php } else {?>
						<div class="empty">已無庫存！</div>
					<?php }?>
				</section>
			</div>
		</div>