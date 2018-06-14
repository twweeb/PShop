<?php include('header.php');
if(!isset($user)){
	header("Location: 404.php");  
}
?>
<div id="pshop" class="container">
	<div class="row account">
<center><h1><?=(!empty($user->get_user_name())) ? $user->get_user_name() : "您";?>的個人資料</h1></center>
<center><table id="accountinfo">
  <tr><td>用戶名稱</td><td>&nbsp;&nbsp;<?php echo $user->get_user_name();?></td></tr>
  <tr><td>地址</td><td>&nbsp;&nbsp;<?php echo $user->get_user_address();?></td></tr>
  <tr><td>電話</td><td>&nbsp;&nbsp;<?php echo $user->get_phone_number();?></td></tr>
  <tr><td>E-mail</td><td>&nbsp;&nbsp;<?php echo $user->get_email();?></td></tr>
</table></center>
<div class="hyper-btn"><a href="changeaccount.php" class="btn">修改個人資料</a>
<a href="changepswd.php" class="btn">修改密碼</a></dvi>
</div></div>
<?php
include('footer.php'); ?>