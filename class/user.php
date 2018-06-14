<?php
class user
{
    public $id,$account,$name,$authority;

    function __construct($id)
    {
		global $dbh;
        $this->id = $id;
        $sql = "SELECT userName, authority, account FROM userinfo WHERE id = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$this->id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
        $this->authority = $result['authority'];
        $this->name = $result['userName'];
        $this->account = $result['account'];
    }
    
    function get_user_name()
    {
		global $dbh;
        $sql = "SELECT username FROM userinfo WHERE id = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$this->id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result['username'];
    }
    function get_user_address()
    {
		global $dbh;
        $sql = "SELECT user_address FROM userinfo WHERE id = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$this->id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result['user_address'];
    }
    
    function get_phone_number()
    {
		global $dbh;
        $sql = "SELECT phone_number FROM userinfo WHERE id = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$this->id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result['phone_number'];
    }
    
    function get_email()
    {
		global $dbh;
        $sql = "SELECT email FROM userinfo WHERE id = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$this->id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result['email'];
    }
    function get_total_user_count()
    {
		global $dbh;
		$sql="select id FROM userinfo";
		$sth = $dbh->prepare($sql);
		$sth->execute();
		return $sth->rowCount();
    }

    // 2018.5.19 Yuan
    function change_password($new_password)
    {
        global $dbh;
        $hashed_password = crypt($new_password, 'userPassword20180424');
		$sql= "UPDATE userinfo SET account_password ='$hashed_password' WHERE id = '$this->id'";
		$sth = $dbh->prepare($sql);
		$sth->execute();
    }

    // 2018.5.19 Yuan
    function change_authority()
    {
        if ($this->authority == 'user')
            $new_authority = 'admin';
        else
            $new_authority = 'user';
        global $dbh;
        $sql= "UPDATE userinfo SET authority ='$new_authority' WHERE id = '$this->id'";
        $sth = $dbh->prepare($sql);
        $sth->execute();
    }

    function change_name($new_name)
    {
        global $dbh;
        $sql= "UPDATE userinfo SET username ='$new_name' WHERE id = '$this->id'";
		$sth = $dbh->prepare($sql);
		$sth->execute();
    }
    // 2018.5.20 Yuan
    function change_email($new_email)
    {
        global $dbh;
        $sql= "UPDATE userinfo SET email ='$new_email' WHERE id = '$this->id'";
		$sth = $dbh->prepare($sql);
		$sth->execute();
    }

    // 2018.5.20 Yuan
    function change_address($new_address)
    {
        global $dbh;
        $sql= "UPDATE userinfo SET user_address ='$new_address' WHERE id = '$this->id'";
		$sth = $dbh->prepare($sql);
		$sth->execute();
    }

    // 2018.5.20 Yuan
    function change_phone_number($new_phone_number)
    {
        global $dbh;
        $sql= "UPDATE userinfo SET phone_number ='$new_phone_number' WHERE id = '$this->id'";
		$sth = $dbh->prepare($sql);
		$sth->execute();
    }
	//檢查原始密碼 
	function check_pswd($pswd)
	{
		global $dbh;
		$sql = "SELECT account_password FROM userinfo WHERE id = ?";
		$sth = $dbh->prepare($sql);
		$sth->execute([$this->id]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$hashed_password = $result["account_password"];
		if (hash_equals($hashed_password, crypt($pswd, $hashed_password)))
		{
			return true;
		}
		else
			return false;
	}
}

// 2018.5.12 Yuan
function is_login()
{
    return (isset($_SESSION['user_id']));
}

// 2018.5.12 Yuan
function logout()
{
    if(is_login())
    {
        unset($_SESSION['user_id']);
        header('Location: index.php'); // 登出後直接跳轉至首頁
    }
}


// for testing
/*
$id = 15;
// 帳號是user001
$user1 = new user($id);
echo $user1->get_authority();
*/

?>