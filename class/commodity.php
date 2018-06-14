<?php
class Commodity
{
	public $comdity_id,$comdity_name,$comdity_sold,$comdity_amount,$comdity_price,$comdity_photo,$total_pages;
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
		//echo('__construct with 1 param called: '.$a1.PHP_EOL); 
		global $dbh;
		$sql="SELECT * FROM commodity WHERE id = ?";
		$stmt=$dbh->prepare($sql);
		$stmt->execute([$id]);
		if($stmt->rowCount()){
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			$this->comdity_id = $id;
			$this->comdity_name = $result['name'];
			$this->comdity_sold = $result['sold'];
			$this->comdity_amount = $result['amount'];
			$this->comdity_price = $result['price'];
			$this->comdity_photo = $result['photoName'];
		}
		else $this->comdity_id = -1;
	}
	
	function add_comdity($commodity_name,$price,$amount,$filename,$category)//新增商品
		{
			global $dbh;
			$sql="INSERT INTO commodity (name,price,amount,sold,date,opinion,opNum,photoName,deleted) 
				VALUES('$commodity_name',$price,$amount,0,CURDATE(),0,0,'$filename',0)";
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			$id = $dbh->lastInsertId();
			
			$insert_term_sql="INSERT INTO term_relationships (object_id,term_id) VALUES('$id',?)";
			$update_count_sql = "UPDATE terms SET count = count + 1 WHERE term_id = ?";

			$update = $dbh->prepare($update_count_sql);
			$insert=$dbh->prepare($insert_term_sql);
			$insert->execute([$category[0]]);
			$update->execute([$category[0]]);
			
			return $id;  //回傳此商品的id
		}
		
		function delete_comdity($id)//刪掉
		{
			global $dbh;
			$sql="UPDATE  commodity SET deleted = 1 WHERE id = $id";
			$dbh->exec($sql); // use exec() because no results are returned
		}
		
		function update_comdity($id,$name,$price,$amount,$sold,$filename,$new_category)
		{
			global $dbh;
			$sql="UPDATE commodity SET name=?,price=?,amount=?,sold=?,photoName=? WHERE id=?";
			$this->comdity_name = $name;
			$this->comdity_sold = $sold;
			$this->comdity_amount = $amount;
			$this->comdity_price = $price;
			$this->comdity_photo = $filename;
			$stmt=$dbh->prepare($sql);
			$stmt->execute([$name,$price,$amount,$sold,$filename,$id]);

			$old_category = $this->get_category($id);
			if($new_category == $old_category) return;//商品種類未修改		
				
			$decrease_count = "UPDATE terms SET count = count-1 WHERE term_id = ?";
			$increase_count = "UPDATE terms SET count = count + 1 WHERE term_id = ?";
			$change_category = "UPDATE term_relationships SET term_id = ? WHERE object_id = ?";
			$sth = $dbh->prepare($decrease_count);
			$sth->execute([$old_category]);
			$sth = $dbh->prepare($increase_count);
			$sth->execute([$new_category]);
			$sth = $dbh->prepare($change_category);
			$sth->execute([$new_category,$id]);
		}
		function update_opinion($id,$nopinion)//星數評價，最多5星
		{
			global $dbh;
			$sql="SELECT * FROM commodity WHERE id = $id";
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			$opNumber=$result["opNum"];
			$opinion=($nopinion+$opNumber*$result["opinion"])/($opNumber+1);
			$sql="UPDATE commodity SET opNum =$opNumber+1,opinion=$opinion WHERE id =$id";
			$stml=$dbh->prepare($sql);
			$stml->execute();
		}
		
		function search($keyword)
		{
			global $dbh;
			$sql="SELECT * FROM commodity WHERE name Like '%$keyword%' ORDER BY sold";
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			return $result;//要傳回甚麼再改
		}
		/////////////////要資料///////////////////
		function is_exist($id)
		{
			global $dbh;
			//$sql="SELECT COUNT(*) FROM commodity WHERE id=$id "
			$sql="SELECT * FROM commodity WHERE id = $id LIMIT 1";
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);;
			if($result != NULL)return true;
			else return false;//??????
		}
		function amount($id)//庫存
		{
			global $dbh;
			$sql="SELECT * FROM commodity WHERE id = $id LIMIT 1";
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);;
			if($result==NULL)return 0;
			else return $result['amount'];
		}
		function price($id)//價格
		{
			global $dbh;
			$sql="SELECT * FROM commodity WHERE id = $id LIMIT 1";
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);;
			if($result==NULL)return 0;
			else return $result['price'];
		}
	//顯示所有商品
	function showall_commodity($results_per_page,$page_now,$keyword){
		global $dbh;
		$start_from = ($page_now - 1)*$results_per_page;
		if($keyword == 'unset'){
			$com_sql = "SELECT id, name, price, amount, sold, date, photoName FROM commodity WHERE deleted=0 ORDER BY id DESC LIMIT $start_from, $results_per_page";
			$total_num_sql = "SELECT COUNT(id) AS total FROM commodity WHERE deleted=0"; 
		}
		else{
			$com_sql = "SELECT id, name, price, amount, sold, date, photoName FROM commodity WHERE deleted=0 and name Like '%$keyword%' ORDER BY sold DESC LIMIT $start_from, $results_per_page";
			$total_num_sql = "SELECT COUNT(ID) AS total FROM commodity WHERE deleted=0 and name Like '%$keyword%'";
		}
		$stmt=$dbh->prepare($com_sql);
		$stmt->execute();
		
		$total_num = $dbh->prepare($total_num_sql);
		$total_num->execute();
		$total_num = $total_num->fetch(PDO::FETCH_ASSOC);
		$this->total_pages = ceil($total_num['total'] / $results_per_page);
		return $stmt;
	}
	//顯示所有下架商品
	function showall_dropoff_commodity($results_per_page,$page_now){
		global $dbh;
		$start_from = ($page_now - 1)*$results_per_page;
		$com_sql = "SELECT id, name, price, amount, sold, date, photoName FROM commodity WHERE deleted=1 ORDER BY id DESC LIMIT $start_from, $results_per_page";

		$stmt=$dbh->prepare($com_sql);
		$stmt->execute();
		return $stmt;
	}
	
	function count_all()//商品總數量
	{
		global $dbh;
		$sql="select id FROM commodity";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();
	}
	function count_soldout()//商品總數量
	{
		global $dbh;
		$sql="select id FROM commodity where amount=0";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();
	}
	function this_month_total_revenue()
	{
		global $dbh;
		$sql = "SELECT ifnull(SUM(final_price),0) AS total FROM `order` WHERE YEAR(all_finished_date) = YEAR(CURRENT_DATE) AND MONTH(all_finished_date) = MONTH(CURRENT_DATE)";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result['total'];
	}
	function this_month_total_sold()
	{
		global $dbh;
		$sql = "SELECT order_id FROM `order` WHERE YEAR(all_finished_date) = YEAR(CURRENT_DATE) AND MONTH(all_finished_date) = MONTH(CURRENT_DATE)";

		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		
		$sql = "SELECT SUM(amount) AS total_sold FROM cart WHERE order_id = ?";
		$total_sold = 0;
		while($result=$stmt->fetch()){ 
		
			$sth = $dbh->prepare($sql);
			$sth->execute([$result['order_id']]);
			$tmp = $sth->fetch(PDO::FETCH_ASSOC);
			$total_sold += $tmp['total_sold'];
		}
		return $total_sold;
	}
	function DropOff($id)
	{
		global $dbh;
		$sql = "UPDATE commodity SET deleted=? WHERE id=?";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([1,$id]);
	}
	function OnShelf($id)
	{
		global $dbh;
		$sql = "UPDATE commodity SET deleted=? WHERE id=?";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([0,$id]);
	}
	function get_category($object_id)
	{
		global $dbh;
		$sql="SELECT term_id FROM term_relationships WHERE object_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$object_id]);
		$result=$sth->fetch();
		return $result['term_id'];
    }
	function get_category_name($object_id)
	{
		global $dbh;
		$sql="SELECT name FROM terms WHERE term_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->get_category($object_id)]);
		$result=$sth->fetch();
		return $result['name'];
    }
    private 
    function TotalPage($total_num_sql)
    {
		global $dbh;
    	
    }
}
?>