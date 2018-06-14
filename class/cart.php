<?php
class Cart
{
	private	$customer_id="";
	public $count="",$order_id="",$coupon="";
	//set username of a cart
    function __construct($id)
	{    
		$this->customer_id = $id;
		global $dbh;
		$sql = "SELECT SUM(Amount) AS count FROM cart where customer_id=? and confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id,0]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		if(!empty($result['count']))
			$this->count = $result['count'];
		else $this->count = 0;
		
		$sql = "SELECT order_id,coupon FROM `order` WHERE customer_id=? and confirm_status=0";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$this->order_id = $result['order_id'];
		$this->coupon = $result['coupon'];
    }
	
	//Add new item to the cart
	function AddItem($CommodityID,$Amount,$Price)
	{
		global $dbh;
		if (!class_exists('Commodity')) {
    		require_once(dirname(__FILE__).'/commodity.php');
		}
		$sql = "SELECT order_id,coupon FROM `order` WHERE customer_id=? and confirm_status=0";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id]);
		if($sth->rowCount()){
			$result=$sth->fetch();
			$order_id = $result['order_id'];
			$coupon = $result['coupon'];
		}
		else{
			$sql = "INSERT INTO `order` (customer_id,confirm_status,coupon_price) VALUES (?,?,?)";
			$sth = $dbh->prepare($sql);
			$sth->execute([$this->customer_id,0,0]);
			$order_id = $dbh->lastInsertId();
		}
		
		$sql = "SELECT Amount FROM cart WHERE customer_id=? and commodity_id=? and order_id =?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id, $CommodityID,$order_id]);
		$ok = "done";
		if($sth->rowCount()){//Already in Cart
			$result=$sth->fetch();
			$Amount += $result['Amount'];
			$ok = $this->ChangeAmount($CommodityID, $Amount,$order_id);
		}
		else
		{
		$Goods = new Commodity($CommodityID);
		$TotalAmount =  $Goods->comdity_amount;
		if($Amount>$TotalAmount){
			$ok = "商品數量大於現有庫存量！已將所有庫存加入購物車！";
			$sql = "INSERT INTO cart (customer_id,commodity_id, amount, price, order_id, confirm_status) VALUES (?,?,?,?,?,?)";
			$sth = $dbh->prepare($sql);
			$sth->execute([$this->customer_id, $CommodityID, $TotalAmount,$Price,$order_id,0]);
		}
		else{
			$sql = "INSERT INTO cart (customer_id, commodity_id, amount, price, order_id, confirm_status) VALUES (?,?,?,?,?,?)";
			$sth = $dbh->prepare($sql);
			$sth->execute([$this->customer_id, $CommodityID, $Amount, $Price, $order_id,0]);
		}
		}
		if(!empty($coupon)){
			$this->CartUseCouponUpdate();
		}
			return $ok;
    }
	
	//Delete one item exists in the cart
	function DeleteOneItem($CommodityID)
	{
		global $dbh;
		$sql = "DELETE FROM cart WHERE customer_id=? and commodity_id=? and confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id,$CommodityID,0]);
		$sql = "SELECT commodity_id FROM cart WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->order_id]);
		if($sth->rowCount()==0){
			$this->ResetCoupon();
			$this->coupon="";
		}
		if(!empty($this->coupon)){
			return $this->CartUseCouponUpdate()['total_price'];
		}
		return 0;
	}
	
	//Delete all items exist in the cart
	function DeleteAllItem()
	{
		global $dbh;
		$sql = "DELETE FROM cart WHERE customer_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id]);
	}
	
	//Change amount of an item in the cart
	function ChangeAmount($CommodityID,$Amount,$order_id)
	{
		global $dbh;
		if (!class_exists('Commodity')) {
    		require_once(dirname(__FILE__).'/commodity.php');
		}
		$Goods = new Commodity($CommodityID);
		$TotalAmount =  $Goods->comdity_amount;
		//判斷輸入數量
		if($Amount<=0)
			return "商品數量不得小於1！請重新輸入！";
		
		else if($Amount>$TotalAmount) //輸入數量>商品最大庫存量
		{
			$sql = "UPDATE cart SET amount=? WHERE customer_id=? and commodity_id=? and order_id=?";
			$sth = $dbh->prepare($sql);
			$sth->execute([$TotalAmount,$this->customer_id,$CommodityID,$order_id]);
			return "商品數量大於現有庫存量！已將購物車內數量改為最大值！";
		}
		else //成功更改
		{
			$sql = "UPDATE cart SET amount=? WHERE customer_id=? and commodity_id=? and order_id=?";
			$sth = $dbh->prepare($sql);
			$sth->execute([$Amount,$this->customer_id,$CommodityID,$order_id]);
			return "done";
		}
		
	}
	//修改商品價格(賣家做商品價格更改)
	function ChangePrice($CommodityID,$Price)
	{
		global $dbh;
		$sql = "UPDATE cart SET price=? WHERE commodity_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$Price,$CommodityID]);
	}
	//送出訂單
	function ConfirmOrder($order_id,$payment_method,$freight)
	{
		global $dbh;
		
		$sql = "SELECT SUM(amount*price) AS total_price FROM cart where customer_id=? and order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id,$order_id]);
		$cart = $sth->fetch();
		
		if($freight=="mailing") $freight_price = 80;
		else $freight_price = 60;

		
		$sql = "SELECT ifnull(coupon,0) as coupon,coupon_price from `order` WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$order = $sth->fetch(PDO::FETCH_ASSOC);
		if(!empty($order['coupon'])){
			if (!class_exists('Coupon')) {
    			require_once(dirname(__FILE__).'/coupon.php');
			}
			$coupon = new Coupon();
			if($coupon->CheckAvailable($order['coupon'])){
				if($coupon->type=="free_ship") $freight_price = 0;
				$sql = "UPDATE coupons SET uses_total=uses_total+1 WHERE code=?";
				$sth = $dbh->prepare($sql);
				$sth->execute([$coupon->code]);
				
				$sql = "INSERT INTO coupon_used (coupon_id,order_id,befor_final_price,after_final_price,discount) VALUES(?,?,?,?,?)";
				$sth = $dbh->prepare($sql);
				$sth->execute([$coupon->id,$order_id,$freight_price+$cart['total_price'],$freight_price+$cart['total_price']-$order['coupon_price'],$order['coupon_price']]);
			}
			else{
				$this->ResetCoupon();
				$msg = "優惠代碼已無效，請重新確認！";
				return;
			}
		}
		$sql = "UPDATE cart SET confirm_status=? WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([1,$order_id]);
		
		$sql = "UPDATE `order` SET confirm_status=?,paid=?,payment_method=?,freight=?,freight_price=?,order_date=CURRENT_TIMESTAMP,total_price=?,final_price=?-coupon_price WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([1,0,$payment_method,$freight,$freight_price,$freight_price+$cart['total_price'],$freight_price+$cart['total_price'],$order_id]);
	}
	
	//查看購物車
    function ShowGoods()
	{
		global $dbh;
		$sql = "SELECT * from cart where customer_id=? and confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id,0]);
		//輸出格式調整
		$TotalPrice = 0;
		if (!class_exists('Commodity')) {
    		require_once(dirname(__FILE__).'/commodity.php');
		}
		return $sth;
    }
	
	//使用折價碼，回傳可以折扣的金額
	function CartUseCoupon($CouponCode,$order)
	{
		global $dbh;
		if (!class_exists('Coupon')) {
    		require_once(dirname(__FILE__).'/coupon.php');
		}
		$coupon = new Coupon();
		if($coupon->CheckAvailable($CouponCode)){
			if($coupon->type=="free_all" || $coupon->type=="free_all_but_ship"){
				$discount = 0;
			}
			else{
				$discount = 0.01*(100 - $coupon->discount);
			}
			
			$sql = "SELECT SUM(amount*price) AS total_price FROM cart where order_id=?";
			$sth = $dbh->prepare($sql);
			$sth->execute([$order->order_id]);
			$result=$sth->fetch();
			
			$discount = $result['total_price'] - $result['total_price']*$discount;
			$order->coupon_price = (int)($discount);
			$order->coupon = $CouponCode;
			
			$sql = "UPDATE `order` SET coupon=?,coupon_price=? WHERE order_id = ?";
			$sth = $dbh->prepare($sql);
			$sth->execute([$CouponCode,$discount,$order->order_id]);
			$result['total_price'] = $discount;
		}
		else{
			$result = -1;
		}
		return $result;
	}
	function ResetCoupon(){
		global $dbh;
		$sql = "UPDATE `order` SET coupon = NULL,coupon_price=0 WHERE order_id =?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->order_id]);
	}
	function CartUseCouponUpdate(){
		if (!class_exists('Order')) {
    		require_once(dirname(__FILE__).'/order.php');
		}
		$order = new Order($this->customer_id);
		return $this->CartUseCoupon($this->coupon,$order);
	}
	function __destruct()
	{
		$this->customer_id = "";
	}
	
}

function additem($id,$amount,$price){
	if(isset($_SESSION['user_id'])){
			$user_cart = new Cart($_SESSION['user_id']);
			return $user_cart->AddItem($id,$amount,$price);
	}
}

function deleteitem($id){
	if(isset($_SESSION['user_id'])){
		$curcart = new Cart($_SESSION['user_id']);
		return $curcart->DeleteOneItem($id);
	}
}

?>