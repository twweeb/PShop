<?php 
$page = "myorder";
include('header.php');
if(!isset($user)) header('Location: 404.php');
if (!class_exists('Order')) {
	require_once('./class/order.php');
	$order = new Order($user->id);
}
?>
<div id="pshop" class="container">
	<div class="row myorder">
<?php 
	if(isset($_GET['id']))
		include_once('vieworder.inc.php');
	else
		include_once('showorder.inc.php');
?>
	</div>
</div>
<?php include('footer.php');?>