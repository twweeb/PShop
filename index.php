<?php include('header.php');
include('./functions/functions.php');
if(isset($_GET['keyword'])){
	if(ctype_space($_GET['keyword']))
		$keyword = "unset";
	else $keyword = $_GET['keyword'];
}
else $keyword = "unset";
if(isset($_GET['page'])) $page_now = $_GET['page'];  else $page_now = 1;
?>
<div id="pshop" class="container">
	<div class="row">
<?php if(!isset($_GET['p'])) //If Home Page
		include('index.inc.php');
	  else { //if Product view
			include('productview.inc.php');
		 }
		?>
	</div>
</div>
<?php include('footer.php'); ?>