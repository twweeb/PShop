<?php 
$page = "addproduct";
include('header.php');
if(isset($_GET['p'])){
	$comm = new Commodity($_GET['p']);
	include('../class/category.php');
	$cat = new Cat();
	if(isset($_POST['submit'])){
		if(!empty($_FILES["product_photo"]["name"])) {
				include '../functions/upload.php';
				//echo $uploadOk;//$uploadOk;
				$product_photo = $file_name;
		}
		else $product_photo = $comm->comdity_photo;
		$new_category = $_POST['product_category'][0];
		$comm->update_comdity($_GET['p'],$_POST['product_name'],$_POST['product_price'],$_POST['product_amount'],$_POST['product_sold'],$product_photo, $new_category);
		//$comm->update_comdity($_POST['product_name'],$_POST['product_price'],$_POST['product_amount'],$_POST['product_sold'],$product_photo);
	}
}
?>
<div id="pshop" class="container">
	<div class="row">
		<div class="col-md-12 hidden-sm hidden-xs">
			<section>
			<form method="post" action="" enctype="multipart/form-data">
				<table class="edit_page">
					<colgroup>
						<col class="cg1"><col class="cg2">
					</colgroup>
					<tbody>
					<tr><td class="item">商品名稱<td><input name="product_name" type="text" size="40" value="<?=$comm->comdity_name?>" />
					<tr><td class="item">商品價格<td><input name="product_price" type="text" size="40" value="<?=$comm->comdity_price?>" />
					<tr><td class="item">商品庫存<td><input name="product_amount" type="text" size="40" value="<?=$comm->comdity_amount?>" />
					<tr><td class="item">商品已售<td><input name="product_sold" type="text" size="40" value="<?=$comm->comdity_sold?>" />
					<tr><td class="item">商品分類<td>
					
						<div id="taxonomy-category" class="categorydiv">
							<div id="category-all" class="tabs-panel">
							<ul id="categorychecklist" class="categorychecklist form-no-clear">

<?php $get_showall_cat = $cat->ShowAllCat();
		foreach($get_showall_cat->fetchAll() as $cat_item){
			echo "<li id=\"cat-".$cat_item['term_id']."\"><label class=\"selectit\"><input value=\"".$cat_item['term_id']."\" name=\"product_category[]\" id=\"catgory-".$cat_item['term_id']."\" type=\"radio\" ";
			if($cat->CheckCat($_GET['p'],$cat_item['term_id']))echo "checked=\"checked\"";
			echo ">".$cat_item['name']."</label></li>";
		}
?>
</ul>
							</div>
						</div>
					<!--<tr><td class="item">產品敘述<td><textarea name="product_desc" width="40%" rows="10"></textarea>-->
					<tr><td class="item">商品照片<td><input name="product_photo" id="product_photo" aria-invalid="false" type="file" />
					<?php if(!empty($comm->comdity_photo)){?><img src="../img/product_img/<?=$comm->comdity_photo ?>" /><?php }?>
</select>
					</tbody>
				</table>
				<div class="submit"><input name="submit" id="submit" class="button" value="更新" type="submit"></div>
			</form>
			</section>
		</div>
	</div>
</div>
</div>
<?php include('footer.php');?>