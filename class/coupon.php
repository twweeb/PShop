<?php
class Coupon
{
	public $id, $eng_name, $cht_name, $code, $type, $discount, $shipping, $date_start, $date_end, $uses_total, $uses_limit, $available, $date_added;
	function __construct()
	{
	    $a = func_get_args();
	    $i = func_num_args();
	    if (method_exists($this,$f='__construct'.$i)) {
	        call_user_func_array(array($this,$f),$a);
	    }
	} 
	function __construct1($id)
	{
		global $dbh;
		$sql="SELECT * FROM coupons WHERE coupon_id = ?";
		$stmt=$dbh->prepare($sql);
		$stmt->execute([$id]);
		if($stmt->rowCount()){
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			$this->id = $result['coupon_id'];
			$this->eng_name = $result['eng_name'];
			$this->cht_name = $result['cht_name'];
			$this->code = $result['code'];
			$this->type = $result['type'];
			$this->discount = $result['discount'];
			$this->shipping = $result['shipping'];
			$this->date_start = $result['date_start'];
			$this->date_end = $result['date_end'];
			$this->uses_total = $result['uses_total'];
			$this->uses_limit = $result['uses_limit'];
			$this->available = $result['available'];
			$this->date_added = $result['date_added'];
		}
		else $this->id = -1;
	}
	
	function add_coupon($eng_name, $cht_name, $code, $type, $discount, $shipping, $date_start, $date_end, $uses_limit)
		{
			global $dbh;
			$sql="INSERT INTO coupons (eng_name,cht_name,code,type,discount,shipping,date_start,date_end,uses_limit) 
				VALUES(?,?,?,?,?,?,?,?,?)";
			$stmt=$dbh->prepare($sql);
			$stmt->execute([$eng_name, $cht_name, $code, $type, $discount, $shipping, $date_start, $date_end, $uses_limit]);
			$id = $dbh->lastInsertId();
			
			return $id;
		}
	
	function update_coupon($id, $eng_name, $cht_name, $date_start, $date_end, $uses_limit,$available)
	{
		global $dbh;
		$sql="UPDATE coupons SET eng_name = ?,cht_name = ?,date_start = ?,date_end = ?,uses_limit = ?,available=? WHERE coupon_id = $id";
		$stmt=$dbh->prepare($sql);
		$stmt->execute([$eng_name, $cht_name, $date_start, $date_end, $uses_limit,$available]);
	}
	
	function CountAvailable()
	{
		global $dbh;
		$sql="SELECT * FROM coupons WHERE available = ?";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([1]);
		return $stmt->rowCount();
	}
	function CountTotalDiscount()
	{
		global $dbh;
		$sql="SELECT ifnull(SUM(discount), 0) as discount FROM coupon_used WHERE YEAR(used_date) = YEAR(CURRENT_DATE) AND MONTH(used_date) = MONTH(CURRENT_DATE)";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		return $result['discount'];
	}
	function CouponUsedRatio()
	{
		global $dbh;
		$a = $b = 0;
		$sql = "SELECT order_id FROM `order` WHERE confirm_status>=? and YEAR(all_finished_date) = YEAR(CURRENT_DATE) AND MONTH(all_finished_date) = MONTH(CURRENT_DATE)";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([5]);
		$a = $stmt->rowCount();
		
		$sql = "SELECT coupon_id FROM coupon_used WHERE order_id = ?";
		$stmt2 = $dbh->prepare($sql);
		while($result=$stmt->fetch()){ 
			$stmt2->execute([$result['order_id']]);
			if($stmt2->rowCount()) $b++;
		}
		
		if($a==0) return 0;
		else return number_format ( $b/$a , 4)*100;
	}
	function ShowAllCoupon()
	{
		global $dbh;
		$sql = "SELECT * FROM coupons WHERE available = ?";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([1]);
		return $stmt;
	}
	function ShowAllNonAvailable()
	{
		global $dbh;
		$sql="SELECT * FROM coupons WHERE available = 0 or date_end <= CURRENT_DATE or uses_limit - uses_total <= 0";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([1]);
		return $stmt;
	}
	function CheckAvailable($code){
		global $dbh;
		$sql = "SELECT * from coupons WHERE code=? and date_start <= CURRENT_DATE and (date_end >= CURRENT_DATE or date_end IS NULL) and (uses_limit = -1 or (uses_limit - uses_total > 0)) and (available > 0)";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([$code]);
		if($stmt->rowCount()==1) {
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			$this->id = $result['coupon_id'];
			$this->code = $result['code'];
			$this->type = $result['type'];
			$this->discount = $result['discount'];
			$this->shipping = $result['shipping'];
			return true;
		}
		else return false;
		
	}
		
}
?>