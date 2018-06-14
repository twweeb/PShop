<?php 
include('header.php');
$order = new Order();?>

<div id="pshop" class="container">
	<div class="row myorder">
<?php
if(isset($_GET['id']))
	include "vieworder.php";
else
	include "showorder.php";
?>
	</div>
</div>
<?php include('footer.php');?>