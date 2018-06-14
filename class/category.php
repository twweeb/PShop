<?php
class Cat
{
	public $cat_id="",$cat_name="",$cat_slug="",$cat_count=0;

	//set username of a cart
	function __construct()
	{
	    $a = func_get_args();
	    $i = func_num_args();
	    if (method_exists($this,$f='__construct'.$i)) {
	        call_user_func_array(array($this,$f),$a);
	    }
	} 
    function __construct1($cat_id)
	{
		global $dbh;
		$this->cat_id = $cat_id;
		$sql = "SELECT name,slug,count FROM terms WHERE term_id=? and taxonomy=category";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->cat_id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$this->cat_name = $result['name'];
		$this->cat_slug = $result['slug'];
		$this->cat_count = $result['count'];
    }
    function AddCat($name,$slug)
	{
		global $dbh;
		$sql="INSERT INTO terms (name,slug,taxonomy) VALUES(?,?,?)";
		$sth = $dbh->prepare($sql);
		$sth->execute([$name,$slug,"category"]);
    }
    function ShowAllCat()
	{
		global $dbh;
		$sql="SELECT * FROM terms WHERE taxonomy='category'";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		return $sth;
    }
    
    function SearchCat($keyword)
	{
		global $dbh;
		$sql="SELECT * FROM terms WHERE taxonomy='category' and (name like '%$keyword%' or slug like '%$keyword%');";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		return $sth;
    }
    
    function CheckCat($object_id,$term_id)
	{
		global $dbh;
		$sql="SELECT object_id FROM term_relationships WHERE object_id=? and term_id=?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$object_id,$term_id]);
		return $sth->rowCount();
    }
    
    function CountCat()
	{
		global $dbh;
		$sql="SELECT term_id FROM terms WHERE taxonomy = 'category'";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		return $sth->rowCount();;
    }
    function DeleteCat($term_id)
	{
		global $dbh;
		$sql="UPDATE term_relationships SET term_id=1 WHERE term_id = ?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$term_id]);
		$sql="UPDATE terms INNER JOIN(SELECT count FROM terms WHERE term_id = ?) as delterm SET terms.count=terms.count+delterm.count WHERE term_id = 1";
		$sth = $dbh->prepare($sql);
		$sth->execute([$term_id]);
		$sql="DELETE FROM terms WHERE term_id = ?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$term_id]);
    }


	function __destruct()
	{
		$this->customer_id="";
		$this->order_id="";
	}
	
}
?>