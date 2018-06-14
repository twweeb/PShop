<?php include('header.php');
include_once('./class/user.php');
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    // The htmlspecialchars() function converts special characters to HTML entities.
    return $data;
}
	//沒有登入，回首頁
	if(!isset($user))
	{
		header("Location:index.php");  
	}
	if (isset($_POST['submit']))
    {
		if(isset($_POST['newpswd1'])&&isset($_POST['newpswd2'])&&isset($_POST['pswd'])){
			$newpswd1 = test_input($_POST['newpswd1']);
			$newpswd2 = test_input($_POST['newpswd2']);
			$pswd = test_input($_POST['pswd']);
			if(!empty($newpswd1)&&!empty($newpswd2)&&!empty($pswd)){
				//原始密碼錯誤
				if($user->check_pswd($pswd)==false){
					echo"<div class='alert alert-danger alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Error!</strong>原密碼輸入錯誤，修改密碼失敗！
					</div>";
				}
				else{
					if($newpswd1==$newpswd2){
						$user->change_password($newpswd1);
						echo"<div class='alert alert-success alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Success!</strong> 修改密碼成功！
					</div>";
					}
					else{
						echo"<div class='alert alert-danger alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Error!</strong>新密碼不一致，修改密碼失敗！
					</div>";
					}
				}
			}
			else{
				echo"<div class='alert alert-danger alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Error!</strong>密碼不得空白，修改密碼失敗！
					</div>";
			}
		}
	}
?>
<div id="pshop" class="container">
	<div class="row account">
<center><h1><?=(!empty($user->get_user_name())) ? $user->get_user_name() : "您";?>的個人資料</h1></center>
<center><table id="accountinfo">
<form action="changepswd.php" method="post">
<tr><td><strong>請輸入原密碼</strong></td><td>&nbsp;&nbsp;<input type="password" name="pswd"></td></tr>
<tr><td><strong>請輸入新密碼</strong></td><td>&nbsp;&nbsp;<input type="password" name="newpswd1"></td></tr>
<tr><td><strong>確認新密碼</strong></td><td>&nbsp;&nbsp;<input type="password" name="newpswd2"></td></tr>
</table></center>
<div class="hyper-btn"><input type="submit" value="確認修改" class="btn" name="submit">&nbsp;&nbsp;<a href="modifyaccount.php" class="btn">返回</a></div>
</form> 
</div></div>
<?php include('footer.php'); ?>