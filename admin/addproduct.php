<?php 
include('header.php');
include('../class/category.php');
$cat = new Cat();
if(isset($_POST['submit'])){
		if(!empty($_FILES["product_photo"]["name"])) {
				include '../functions/upload.php';
				//echo $uploadOk;//$uploadOk;
				$product_photo = $file_name;
		}
		else $product_photo ='';

		$comm = new Commodity();
		$insert_id = $comm->add_comdity($_POST['product_name'],$_POST['product_price'],$_POST['product_amount'],$product_photo,$_POST['product_category']);
		header('Location: edit.php?p='.$insert_id);
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
					<tr><td class="item">商品名稱<td><input name="product_name" type="text" size="40" required/>
					<tr><td class="item">商品價格<td><input name="product_price" type="text" size="40" required/>
					<tr><td class="item">商品庫存<td><input name="product_amount" type="text" size="40" required/>
					<tr><td class="item">商品分類<td>
					
						<div id="taxonomy-category" class="categorydiv">
							<div id="category-all" class="tabs-panel">
							<ul id="categorychecklist" class="categorychecklist form-no-clear">

<?php $get_showall_cat = $cat->ShowAllCat();
		foreach($get_showall_cat->fetchAll() as $cat_item)
			echo "<li id=\"cat-".$cat_item['term_id']."\"><label class=\"selectit\"><input value=\"".$cat_item['term_id']."\" name=\"product_category[]\" id=\"catgory-".$cat_item['term_id']."\" type=\"radio\" required>"."&nbsp&nbsp&nbsp".$cat_item['name']."</label></li>";		
?>
</ul>
							</div>
						</div>
					<!--<tr><td class="item">產品敘述<td><textarea name="product_desc" width="40%" rows="10"></textarea>-->
					<tr><td class="item">商品照片<td><input name="product_photo" id="product_photo" aria-invalid="false" type="file" required/> 
</select>
					</tbody>
				</table>
				<div class="submit"><input name="submit" id="submit" class="button" value="新增商品" type="submit"></div>
			</form>
			</section>
		</div>
	</div>
</div>
</div>
<?php include('footer.php');?>