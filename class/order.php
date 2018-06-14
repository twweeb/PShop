<?php
class Order
{
	public $order_id="",$coupon_price="",$coupon="";
	private $customer_id="";

	//set username of a cart
	function __construct()
	{
	    $a = func_get_args();
	    $i = func_num_args();
	    if (method_exists($this,$f='__construct'.$i)) {
	        call_user_func_array(array($this,$f),$a);
	    }
	} 
    function __construct1($user_id)
	{
		global $dbh;
		$this->customer_id = $user_id;
		$sql = "SELECT order_id,coupon,coupon_price FROM `order` WHERE customer_id=? and confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$user_id,0]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$this->order_id = $result['order_id'];
		$this->coupon_price = $result['coupon_price'];
		$this->coupon = $result['coupon'];
    }
    function ShipCustomerData($freight,$id,$name,$phone,$email,$address,$payment_method)
	{    
		global $dbh;
		$sql = "INSERT INTO ship (order_id,freight,customer_id,customer_name,customer_address,customer_phone,customer_email,ship_status)
				VALUES (?,?,?,?,?,?,?,?)";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->order_id,$freight,$id,$name,$address,$phone,$email,0]);
		
		$ship_id = $dbh->lastInsertId();
		$sql = "UPDATE `order` SET ship_id=? WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$ship_id,$this->order_id]);
		
		date_default_timezone_set("Asia/Taipei");
		$sql = "INSERT INTO ship_status (ship_id,timestamp,current_status) VALUES(?,?,?)";
		$sth = $dbh->prepare($sql);
		$sth->execute([$ship_id,date("Y-m-d H:i:s"),"訂單已成立"]);
    }
	
    function CountWaitingPay()
	{
		global $dbh;
		$sql = "SELECT order_id FROM `order` WHERE confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([1]);
		return $sth->rowCount();
    }
    
    function CountWaitingShip()
	{
		global $dbh;
		$sql = "SELECT order_id FROM `order` WHERE confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([2]);
		return $sth->rowCount();
    }
    function CountFinish()
	{
		global $dbh;
		$sql = "SELECT order_id FROM `order` WHERE confirm_status >= ?";
		$sth = $dbh->prepare($sql);
		$sth->execute([5]);
		return $sth->rowCount();
    }
    function ShowAllOrder()
	{
		global $dbh;
		$sql = "SELECT * FROM `order` LEFT JOIN ship ON `order`.order_id = ship.order_id WHERE confirm_status > 0 ORDER BY order_date DESC";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		return $sth;
    }
    function ShowAllTrashOrder()
	{
		global $dbh;
		$sql = "SELECT * FROM `order` LEFT JOIN ship ON `order`.order_id = ship.order_id WHERE confirm_status = -1";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		return $sth;
    }
    function ShowAllOrderUnpaid($id)
	{
		global $dbh;
		$sql = "SELECT * FROM `order` WHERE customer_id=? and confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$id,1]);
		return $sth;
    }
    function ShowAllOrderUnrecieve($id)
	{
		global $dbh;
		$sql = "SELECT * FROM `order` WHERE customer_id=? and confirm_status between ? and ?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$id,2,3]);
		return $sth;
    }
    function ShowAllOrderFinished($id)
	{
		global $dbh;
		$sql = "SELECT * FROM `order` WHERE customer_id=? and confirm_status>?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$id,4]);
		return $sth;
    }
    function ShowOrderData($order_id)
	{
		global $dbh;
		$sql = "SELECT * FROM `order` WHERE customer_id=? and order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id,$order_id]);
		return $sth->fetch(PDO::FETCH_ASSOC);
    }
    function ShowOrderList($order_id)
	{
		global $dbh;
		$sql = "SELECT * FROM cart WHERE customer_id=? and order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id,$order_id]);
		return $sth;
    }
    function ShowOrderShip($order_id)
	{
		global $dbh;
		$sql = "SELECT * FROM ship WHERE customer_id=? and order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->customer_id,$order_id]);
		return $sth->fetch(PDO::FETCH_ASSOC);
    }
    
    //For Admin
    function AdminShowAllOrderUnpaid($id)
	{
		global $dbh;
		$sql = "SELECT * FROM `order` WHERE confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([1]);
		return $sth;
    }
    function AdminShowAllOrderUnship($id)
	{
		global $dbh;
		$sql = "SELECT * FROM `order` WHERE confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([2]);
		return $sth;
    }
    function AdminShowAllOrderFinished($id)
	{
		global $dbh;
		$sql = "SELECT * FROM `order` WHERE confirm_status=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([5]);
		return $sth;
    }
    function AdminShowOrderData($order_id)
	{
		global $dbh;
		$sql = "SELECT * FROM `order` WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		return $sth->fetch(PDO::FETCH_ASSOC);
    }
    function AdminShowOrderList($order_id)
	{
		global $dbh;
		$sql = "SELECT * FROM cart WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		return $sth;
    }
    function AdminShowOrderShip($order_id)
	{
		global $dbh;
		$sql = "SELECT * FROM ship WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		return $sth->fetch(PDO::FETCH_ASSOC);
    }
    function ShowShipStatus($ship_id)
	{
		global $dbh;
		$sql = "SELECT * FROM ship_status WHERE ship_id=? ORDER BY timestamp DESC";
		$sth = $dbh->prepare($sql);
		$sth->execute([$ship_id]);
		return $sth;
    }
    function Cancel($order_id)
    {
    	global $dbh;
		$sql = "SELECT confirm_status FROM `order` WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		
		$sql = "UPDATE `order` SET confirm_status=?, previous_confirm_status=? WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([-1,$result['confirm_status'],$order_id]);
		
		$sql = "UPDATE cart SET confirm_status=? WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([-1,$order_id]);
		if($this->isUpdateCommodityAmount($order_id)){
			$this->RestoreCommodityAmount($order_id);
		}
		
		return "Done";
    }
    function Restore($order_id)
    {
    	global $dbh;
		$sql = "SELECT previous_confirm_status,confirm_status FROM `order` WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		
		$sql = "UPDATE `order` SET confirm_status=?, previous_confirm_status=? WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$result['previous_confirm_status'],$result['confirm_status'],$order_id]);
		
		$sql = "UPDATE cart SET confirm_status=? WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$result['previous_confirm_status'],$order_id]);
		return "Done";
    }
    function RestoreCommodityAmount($order_id)
    {
    	if($this->isUpdateCommodityAmount($order_id))
    	{
    	global $dbh;
			$sql = "UPDATE `order` SET inventory=0 WHERE order_id=?";
			$sth = $dbh->prepare($sql);
			$sth->execute([$order_id]);
			$sql = "SELECT commodity_id,amount FROM cart WHERE order_id=?";
			$sth = $dbh->prepare($sql);
			$sth->execute([$order_id]);
			$sql = "UPDATE commodity SET sold=sold-?,amount=amount+? WHERE id=?";
			
			while($result=$sth->fetch()){ 
				$sth2 = $dbh->prepare($sql);
				$sth2->execute([$result['amount'],$result['amount'],$result['commodity_id']]);
			}
		}
    }
    function SetDiscount($order_id,$price)
    {
    	if(!$this->isAble($order_id)) {
    		$error['error'] = "1";
    		$error['result'] = "操作無效";
    		return $error;
    	}
    	global $dbh;
		$sql = "SELECT paid,final_price FROM `order` WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		
		if($result['final_price']>=$price && $price >0 && !$result['paid']){
			$sql = "UPDATE `order` SET coupon=?, coupon_price=?,final_price=? WHERE order_id=?";
			$sth = $dbh->prepare($sql);
			$sth->execute(['ADMIN',$price,$result['final_price']-$price,$order_id]);
			return "Done";
		}
		else return "Error!";
    }
    function SetPaid($order_id)
    {
    	if(!$this->isAble($order_id)) {
    		$error['error'] = "1";
    		$error['result'] = "操作無效";
    		return $error;
    	}
    	global $dbh;
		$sql = "SELECT paid,ship_id FROM `order` WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		
		if(!$result['paid']){
			if(!$this->isUpdateCommodityAmount($order_id))
			{
				if($this->CheckOrderAmount($order_id))
					$this->UpdateCommodityAmount($order_id);
				else{
					$this->Cancel($order_id);
    				$error['error'] = 1;
    				$error['result'] = "庫存量不足！訂單已取消";
    				return $error;
				}
			}
					
			$sql = "UPDATE `order` SET paid=?, payment_date=CURRENT_TIMESTAMP,confirm_status=?,previous_confirm_status=confirm_status WHERE order_id=?";
			$sth = $dbh->prepare($sql);
			$sth->execute([1,2,$order_id]);
			
			$sql = "UPDATE cart SET confirm_status=? WHERE order_id=?";
			$sth = $dbh->prepare($sql);
			$sth->execute([2,$order_id]);
			
			$sql = "INSERT INTO ship_status (ship_id,timestamp,current_status) VALUES (?,CURRENT_TIMESTAMP,?)";
			$sth = $dbh->prepare($sql);
			$sth->execute([$result['ship_id'],"已將訂單細節通知賣家"]);
			return "Done";
		}
		else return "Error!";
    }
    function CheckOrderAmount($order_id){
    	global $dbh;
		$sql = "SELECT commodity_id,amount FROM cart WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$sql = "SELECT amount FROM commodity WHERE id=?";

		while($result=$sth->fetch()){ 
			$sth2 = $dbh->prepare($sql);
			$sth2->execute([$result['commodity_id']]);
			$tmp = $sth2->fetch(PDO::FETCH_ASSOC);
			if($tmp['amount']<$result['amount']) return 0;
		}
		return 1;
    }
    function UpdateCommodityAmount($order_id){
    	global $dbh;
		$sql = "UPDATE `order` SET inventory=1 WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$sql = "SELECT commodity_id,amount FROM cart WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$sql = "UPDATE commodity SET sold=sold+?,amount=amount-? WHERE id=?";

		while($result=$sth->fetch()){ 
			$sth2 = $dbh->prepare($sql);
			$sth2->execute([$result['amount'],$result['amount'],$result['commodity_id']]);
		}
    }
    function isUpdateCommodityAmount($order_id){
    	global $dbh;
		$sql = "SELECT inventory FROM `order` WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$tmp = $sth->fetch(PDO::FETCH_ASSOC);
		return $tmp['inventory'];
    }

    function isAble($order_id){
    	global $dbh;
		$sql = "SELECT confirm_status FROM `order` WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$order_id]);
		$tmp = $sth->fetch(PDO::FETCH_ASSOC);
		if($tmp['confirm_status']==-1) return false;
		else return true;
    }
    function SetShip($order_id,$ship_id){
    	if(!$this->isAble($order_id)) {
    		$error['error'] = 1;
    		$error['result']= "操作無效";
    		return $error;
    	}
    	global $dbh;
		if(!$this->isUpdateCommodityAmount($order_id))
		{
			if($this->CheckOrderAmount($order_id))
				$this->UpdateCommodityAmount($order_id);
			else{
				$this->Cancel($order_id);
    			$error['error']['code'] = 1;
    			$error['error']['msg'] = "庫存量不足！訂單已取消";
    			return $error;
			}
		}
		$sql = "UPDATE `order` SET confirm_status=?,ship_date=CURRENT_TIMESTAMP,previous_confirm_status=confirm_status WHERE order_id=? and ship_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([3,$order_id,$ship_id]);
		
		$sql = "UPDATE ship SET ship_status=? WHERE ship_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute(["商品已出貨",$ship_id]);
		
		$sql = "INSERT INTO ship_status (ship_id,timestamp,current_status) VALUES (?,CURRENT_TIMESTAMP,?)";
		$sth = $dbh->prepare($sql);
		$sth->execute([$ship_id,"商品已出貨"]);
		return "Done";
    }
    function SetFinished($order_id,$ship_id){
    	if(!$this->isAble($order_id)) {
    		$error['error'] = 1;
    		$error['result']= "操作無效";
    		return $error;
    	}
    	global $dbh;
		$sql = "UPDATE `order` SET confirm_status=?,finished_date=CURRENT_TIMESTAMP,previous_confirm_status=confirm_status WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([4,$order_id]);
		
		$sql = "INSERT INTO ship_status (ship_id,timestamp,current_status) VALUES (?,CURRENT_TIMESTAMP,?)";
		$sth = $dbh->prepare($sql);
		$sth->execute([$ship_id,"取件成功"]);
		return "Done";
    }
    function SetAllFinished($order_id){
    	if(!$this->isAble($order_id)) {
    		$error['error'] = 1;
    		$error['result']= "操作無效";
    		return $error;
    	}
    	global $dbh;
		date_default_timezone_set("Asia/Taipei");
		$sql = "UPDATE `order` SET confirm_status=?,all_finished_date=CURRENT_TIMESTAMP,previous_confirm_status=confirm_status WHERE order_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([5,$order_id]);
		return "Done";
    }
    
    function MonthlyRevenueJson(){
    	global $dbh;
    	$data['chart']['caption'] = "近六個月營業額";
    	//$dataSource['subCaption'] = "近六個月營業額";
    	$data['chart']['xAxisName'] = "月份";
    	$data['chart']['yAxisName'] = "營業額（新台幣）";
    	$data['chart']['theme'] = "fint";
	    
	    $sql = "SELECT MONTHNAME(CURRENT_DATE - INTERVAL ? MONTH) as label, ifnull(SUM(final_price), 0) as value FROM `order` WHERE YEAR(all_finished_date) = YEAR(CURRENT_DATE - INTERVAL ? MONTH) AND MONTH(all_finished_date) = MONTH(CURRENT_DATE - INTERVAL ? MONTH)";
		$sth = $dbh->prepare($sql);
    	for($i = 5; $i >= 0; $i--){
			$sth->execute([$i,$i,$i]);
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			$data['data'][] = $result;
    	}
        return json_encode($data);
    }
    
    function CommodityRankJson(){
    	global $dbh;
    	$data['chart']['caption'] = "銷售量前五名商品";
    	$data['chart']['xAxisName'] = "";
    	$data['chart']['yAxisName'] = "銷售數量";
    	$data['chart']['theme'] = "fint";
        $data['chart']['paletteColors']= "#0075c2";
        $data['chart']['bgColor'] = "#ffffff";
        $data['chart']['borderAlpha'] = "0";
        $data['chart']['canvasBorderAlpha'] = "0";
        $data['chart']['usePlotGradientColor'] = "0";
        $data['chart']['plotBorderAlpha'] = "10";
        $data['chart']['placevaluesInside'] = "1";
        $data['chart']['rotatevalues'] = "1";
        $data['chart']['valueFontColor'] = "#ffffff";
        $data['chart']['showXAxisLine'] = "1";
        $data['chart']['divLineDashed'] = "1";
        $data['chart']['showAlternateHGridColor'] = "0";
        $data['chart']['subcaptionFontBold'] = "0";
        $data['chart']['subcaptionFontSize'] = "14";
    	
		$sql = "SELECT name, ifnull(sold,0) as value FROM commodity ORDER BY sold DESC LIMIT 5";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		while($result=$sth->fetch()){ 
			$data['data'][] = ARRAY('label'=>$result['name'],'value'=>$result['value']);
		}
        return json_encode($data);
    }
    
	function __destruct()
	{
		$this->customer_id="";
		$this->order_id="";
	}
	
}
?>