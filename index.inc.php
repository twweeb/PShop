		<article id="content" class="col-md-12">
			<div class="row">
<?php $show = new Commodity();
		$get_showall_commodity = $show->showall_commodity($option->results_per_page,$page_now,$keyword); 
		if($get_showall_commodity->rowCount()){
		foreach($get_showall_commodity->fetchAll() as $com) {?>
				<section class="col-md-4">
					<div class="product_item">
						<div class="product_img">
							<a href="?p=<?=$com['id'] ?>" class="product_link" title="<?=$com['name'] ?>"><img class="img-responsive" src="./img/product_img/thumb/timthumb.php?src=<?=$option->siteurl?>/img/product_img/<?=$com['photoName'] ?>&h=250&w=300&zc=1&q=100&a=t" /></a>
						</div>
						<div class="product_description">
							<h2 class="h2"><a href="?p=<?=$com['id'] ?>" title="<?=$com['name'] ?>" class="product_link"><?=$com['name'] ?></a></h2>
							<span class="price">TWD$ <?=$com['price'] ?></span>
						</div>
					<div class="product_view"><a href="?p=<?=$com['id'] ?>" class="product_btn" title="瀏覽《<?=$com['name'] ?>》">瀏覽</a></div>
					</div>
				</section>
<?php 
		}
			echo "<div class=\"col-md-12 page-btn\"><nav id=\"page-navigate\">"; 
				PageNav($show->total_pages, $page_now);
			echo "</nav></div>";
		}
		else{
			echo "no data!";
		}
		
?>
			</div>
		</article>