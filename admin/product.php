<?php 
include('header.php');
include('../class/category.php');
$product = new commodity();
$cat = new Cat();
?>
<div id="pshop" class="container">
	<div class="row">
        <div class="container-fluid">
            <!-- Start Page Content -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-table f-s-40 color-primary"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2><?=$product->count_all() ?></h2>
                                <p class="m-b-0">商品總數量</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-archive f-s-40 color-warning"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2><?=$cat->CountCat();?></h2>
                                <p class="m-b-0">總商品類別</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-box-open f-s-40 color-success"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2><?=$product->count_soldout() ?></h2>
                                <p class="m-b-0">已無庫存</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<section class="col-md-12">
			<div class="submit changetable">
       			<span class="right"><a href="<?=(isset($_GET['off'])&&($_GET['off']==1))? "product.php" : "?off=1" ?>" class="productpage button"><?=(isset($_GET['off'])&&($_GET['off']==1))? "上架中商品" : "已下架的商品" ?></a></span>
       		</div>
			<table class='view-commodity-table view-commodity-hoverable'>
				<tr class='view-commodity-title'>
					<th><th>商品<th><th>類別<th>單價<th>庫存<th>已賣數量<th>編輯<th><?=(isset($_GET['off'])&&($_GET['off']==1))?"上架":"下架"?>
				<colgroup>
					<col class="cg1"><col class="cg2"><col class="cg3"><col class="cg4"><col class="cg5"><col class="cg6"><col class="cg7"><col class="cg8"><col class="cg9">
				</colgroup>
				<tbody>
<?php if(isset($_GET['off'])&&($_GET['off']==1))
			$get_showall_commodity = $product->showall_dropoff_commodity(100,1); 
		else 
			$get_showall_commodity = $product->showall_commodity(100,1,"unset");
			if($get_showall_commodity->rowCount()){
			foreach($get_showall_commodity->fetchAll() as $com) {?>
					<tr id="<?=$com['id'] ?>">
					<td class="commodity-<?=$com['id'] ?>"><span><input type="checkbox" name="del[]" value="<?=$com['id'] ?>" /></span>
					<td class="commdity_thumb"><img src="../img/product_img/thumb/timthumb.php?src=<?=$option->siteurl?>/img/product_img/<?=$com['photoName'] ?>&h=40&w=40&zc=1&q=100&a=t" />
					<td class="commdity_name"><span><a href="../?p=<?=$com['id'] ?>" title="<?=$com['name'] ?>"><?=$com['name'] ?></a></span>
					<td class="commdity_cat"><span><?=$product->get_category_name($com['id']) ?></span>
					<td class="commdity_price"><span><?=$com['price'] ?></span>
					<td class="commdity_amount"><span><?=$com['amount'] ?></span>
					<td class="commdity_sold"><span><?=$com['sold'] ?></span>
					<td><span><a href="edit.php?p=<?=$com['id'] ?>" class="cart-item__edit">編輯</a></span>
					<td><span><button class="<?=(isset($_GET['off'])&&($_GET['off']==1))?"product-item__shelf":"product-item__drop"?>"><?=(isset($_GET['off'])&&($_GET['off']==1))?"上架":"下架"?></button></span>
<?php }}
else echo"<tr><td><td>-<td><td>-<td>-<td>-<td>-<td>-<td>-"; ?>
				</tbody>
			</table>
		</section>
	</div>
</div>
<?php include('footer.php');?>