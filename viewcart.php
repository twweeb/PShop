<?php include('header.php');
if(isset($cart)){
	if(isset($_POST['coupon'])&&isset($order)){
		if(isset($order->coupon)) $msg = "無效的操作";
		else{
			$data = $cart->CartUseCoupon($_POST['coupon'],$order);
			if($data==-1)
				$msg = "優惠無法使用！";
			else{
				$msg = "已套用優惠！如有運費優惠將在下單後，自動套用！";
			}
		}
	}
	if(isset($_POST['submit'])){
		if(!empty($_POST['name'])&&!empty($_POST['phone'])&&!empty($_POST['email'])&&
			!empty($_POST['address'])&&!empty($_POST['payment_method'])&&!empty($_POST['freight'])){
				if(!isset($order)) $msg = "操作無效";
				else if($order->CheckOrderAmount($order->order_id)){
					$order->UpdateCommodityAmount($order->order_id);
					$cart->ConfirmOrder($order->order_id,$_POST['payment_method'],$_POST['freight']);
					$order->ShipCustomerData($_POST['freight'],$user->id,$_POST['name'],$_POST['phone'],$_POST['email'],$_POST['address'],$_POST['payment_method']);
					$msg = "訂單已送出，請至『我的訂單』查看您的訂單！";
					$count = 0;
				}
				else $msg = "清單中已有售完的項目，請重新確認！";
			}
		else{
			$msg = "資料填寫不完整！";
		}
	}
}
?>
<div id="pshop" class="container">
	<div class="row">
		<?= (isset($msg))? "<div class=\"col-md-12 message\">・".$msg."</div>" :''?>
<h2>購物車內容</h2>
<table class='view-cart-table'>
<tr class='view-cart-title'>
	<th>商品名稱<th>訂購數量<th>商品單價<th>價格合計<th>操作
	<colgroup>
		<col class="cg1"><col class="cg2"><col class="cg3"><col class="cg4"><col class="cg5">
	</colgroup>
	<tbody>
		<?php if(isset($cart)){
				$commodity = $cart->ShowGoods();
				$TotalPrice = 0;
				if($commodity->rowCount()){
					while($result=$commodity->fetch()){
						$comm_now = new Commodity($result['commodity_id']);
						echo "<tr id=".$comm_now->comdity_id.">";
						echo "<td class=\"commdity_name\">".$comm_now->comdity_name."</td>";
						echo "<td class=\"commdity_amount\">".$result['amount']."</td>";
						echo "<td class=\"commdity_price\">".$comm_now->comdity_price."</td>";
						$TotalPrice += $result['amount']*$comm_now->comdity_price;
						echo "<td class=\"commdity_item_sum\">".$result['amount']*$comm_now->comdity_price."</td>";
						echo "<td><button class=\"cart-item__delete\">刪除</button></td>";
						echo "</tr>";
					}
				}
				else{
					echo "<tr class=\"empty-cart\"><td>-<td>-<td>-<td>-<td>-</table>";
				}
	if(!empty($order->coupon_price)) $final = $TotalPrice - $order->coupon_price;
	else $final = $TotalPrice;
				if($TotalPrice){
					echo "<tr class=\"total-price\"><td><td><td>原始總金額<td><span>".$TotalPrice."</span><td>";
					if(!empty($order->coupon)){
						echo "<tr class=\"coupon disabled\" disabled=\"disabled\"><td><td><td>折扣代碼<td><input type=\"text\"  name=\"coupon\" size=\"40\" value=\"".$order->coupon."\" disabled=\"disabled\" required/><td><button class=\"btn use-coupon\" disabled=\"disabled\">已使用</button>";
					}
					else
					echo "
<form method=\"POST\" action=\"\"><tr class=\"coupon\"><td><td><td>優惠代碼<td><input type=\"text\" name=\"coupon\" size=\"40\"/ placeholder=\"e.g. SUMMERSPECIAL10OFF\" required><td><button class=\"btn use-coupon\">使用</button></form>";
					echo "<tr class=\"final-price\"><td><td><td>總金額（折扣後）<td><span>".$final."</span><td>";
?>
</table>
</form>
<h2>購買人資料</h2>
<form method="post" action="viewcart.php">
<table class='cart-userinfo'>
<colgroup>
<col class="cg6"><col class="cg7">
</colgroup>
<tbody>
<tr><td>姓名<td><input type="text" name="name" value="<?=$user->name;?>" required/>
<tr><td>電話<td><input type="text" name="phone" value="<?=$user->get_phone_number();?>" required/>
<tr><td>Email<td><input type="text" name="email" value="<?=$user->get_email();?>" required/>
<tr><td>地址<td><input type="text" name="address" value="<?=$user->get_user_address();?>" required/>
<tr><td>付款方式
<td><label class="radio_label"><input name="payment_method" value="transfer" checked="checked" type="radio" required>轉帳匯款 </label><label class="radio_label"><input name="payment_method" value="visa" type="radio" required>信用卡</label><label class="radio_label"><input name="payment_method" value="pickup" type="radio" required>超商取貨付款</label></td>
<tr><td>取貨方式
<td><label class="radio_label"><input name="freight" value="mailing" checked="checked" type="radio" required>郵寄($80)</label><label class="radio_label"><input name="freight" value="711" type="radio" required>7-11取貨($60)</label></td>
</tbody>
</table>
<div class="submit checkout"><input name="submit" id="submit" class="button" value="結帳！" type="submit"></div>
</form>
<?php }}
			else{
?>
			<tr class=\"empty-cart\"><td>-<td>-<td>-<td>-<td>-
			</table>
			<script>alert("由於您尚未登入，系統不會暫存您放入購物車的商品！");</script>
		<?php }
		?>
	</div>
</div>
<?php include('footer.php');?>