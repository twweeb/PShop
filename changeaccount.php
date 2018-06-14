<?php include('header.php');
include_once('./class/user.php');?>
<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    // The htmlspecialchars() function converts special characters to HTML entities.
    return $data;
}
	if(!isset($user))
		header("Location:index.php");
	if (isset($_POST['submit']))
    {
		if(isset($_POST['newname'])&&isset($_POST['newemail'])&&isset($_POST['newaddress'])&&isset($_POST['newphonenumber'])){
			$newname = test_input($_POST['newname']);
			$newemail = test_input($_POST['newemail']);
			$newaddress = test_input($_POST['newaddress']);
			$newphonenumber = test_input($_POST['newphonenumber']);
			if(!empty($newname)&&!empty($newemail)&&!empty($newaddress)&&!empty($newphonenumber)){
				$user->change_name($newname);
				$user->change_email($newemail);
				$user->change_address($newaddress);
				$user->change_phone_number($newphonenumber);
				echo"<div class='alert alert-success alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>資料修改成功！</strong> 
					</div>";
			}
			else{
					echo"<div class='alert alert-warning alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>欄位不得空白，請再試一次</strong>
					</div>";
			}
		}
	}
?>
<div id="pshop" class="container">
	<div class="row account">
<center><h1><?=(!empty($user->get_user_name())) ? $user->get_user_name() : "您";?>的個人資料</h1></center>
<center><table id="accountinfo">
<form action="changeaccount.php" method="post">
<tr><td><strong>姓名</strong></td><td>&nbsp;&nbsp;<?php echo $user->get_user_name();?></td></tr>
<tr><td><strong>新姓名</strong></td><td>&nbsp;&nbsp;<input type="text" name="newname" value="<?php echo $user->get_user_name();?>"></td></tr>
<tr><td><strong>地址</strong></td><td>&nbsp;&nbsp;<?php echo $user->get_user_address();?></td></tr>
<tr><td><strong>新地址</strong></td><td>&nbsp;&nbsp;<input type="text" name="newaddress" value="<?php echo $user->get_user_address();?>"></td></tr>
<tr><td><strong>電話</strong></td><td>&nbsp;&nbsp;<?php echo $user->get_phone_number();?></td></tr>
<tr><td><strong>新電話</strong></td><td>&nbsp;&nbsp;<input type="text" name="newphonenumber" value="<?php echo $user->get_phone_number();?>"></td></tr>
<tr><td><strong>E-mail</strong></td><td>&nbsp;&nbsp;<?php echo $user->get_email();?></td></tr>
<tr><td><strong>新E-mail</strong></td><td>&nbsp;&nbsp;<input type="text" name="newemail" value="<?php echo $user->get_email();?>"></td></tr>
</table></center>
<div class="hyper-btn"><input type="submit" value="確認修改" class="btn" name="submit">&nbsp;&nbsp;<a href="modifyaccount.php" class="btn">返回</a></div>
</form>
</div></div>
<?php include('footer.php'); ?>