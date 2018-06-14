<?php
include('header.php');
include_once('./class/user.php');
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    // The htmlspecialchars() function converts special characters to HTML entities.
    return $data;
}
if (isset($_POST['submit']))
{
	$account = test_input($_POST['account']);
	if(isset($account)&&!empty($account))
	{
		if(reset_mail_pswd($account)==true){
		echo"<div class='alert alert-success alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>新密碼已成功寄出！</strong>登入後請盡速修改您的密碼，謝謝！ 
					</div>";
		}
	}
	else{
		echo"<div class='alert alert-warning alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>此帳號不存在！</strong>
					</div>";
	}
}
?>
<div id="pshop" class="container">
	<div class="row account">
<center><h1>忘記密碼</h1></center><br/>
<form action="forgetpswd.php" method="post">
<center>請輸入您的帳戶&nbsp;&nbsp;<input type="text" name="account">
<div class="hyper-btn"><input type="submit" value="確認" class="btn" name="submit"></center></div>
</form>
</div></div>
<?php include('footer.php');?>
<?php
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function reset_mail_pswd($account)
{
	global $dbh,$option;
    $sql = "SELECT id, username FROM userinfo WHERE account = '$account'";
    $sth = $dbh->prepare($sql);
    $sth->execute();
	$result = $sth->fetch(PDO::FETCH_ASSOC);
	if(empty($result['id'])) {echo"<div class='alert alert-warning alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>此帳號不存在！</strong>
					</div>";return false;}
	$user = new user($result['id']);
	$newpswd = randomPassword();
	$user->change_password($newpswd);
	mail($user->get_email(),$option->sitename,"親愛的".$result['username']."您好："."\n"."    這是您的新密碼".$newpswd."，登入後請盡速修改您的密碼，謝謝！\n\n請勿直接回覆此信件。\n\n\n-\n".$option->sitename." 敬上","from:noreply");
	return true;
}
?>
