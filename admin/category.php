<?php 
include('header.php');
	include('../class/category.php');
	$cat = new Cat();
	if(isset($_POST['submit'])){
		if(!empty($_POST['tag-name']) && !empty($_POST['slug']))
			$cat->AddCat($_POST['tag-name'],$_POST['slug']);
		else
			$msg = "請填入必填欄位！";
	}
	if(isset($_POST['apply'])){
		if($_POST['action']=='delete'){
			foreach ($_POST['delete_tags'] as $term_id){
				$cat->DeleteCat($term_id);
			}
		}
	}
	
?>
<div id="pshop" class="container">
	<div class="row">
		<?= (isset($msg))? "<div class=\"col-md-12 message\">・".$msg."</div>" :''?>
		<section class="col-md-12">
<div class="wrap nosubsub">
<h1>商品分類</h1>

<div id="ajax-response"></div>

<form class="search-form pshop-clearfix" method="get">

<p class="search-box">
	<label class="screen-reader-text" for="tag-search-input">搜尋分類:</label>
	<input id="tag-search-input" name="keyword" value="" type="search">
	<input id="search-submit" class="button" value="搜尋分類" type="submit"></p>

</form>

<div id="col-container" class="pshop-clearfix">

<div id="col-left">
<div class="col-wrap">
<div class="form-wrap">
<h2>新增分類</h2>
<form id="addtag" method="post" action="category.php" class="validate">
<input name="action" value="add-tag" type="hidden">
<input name="screen" value="edit-category" type="hidden">
<input name="taxonomy" value="category" type="hidden">
<input name="post_type" value="post" type="hidden">
<div class="form-field form-required term-name-wrap">
	<label for="tag-name">名稱</label>
	<input name="tag-name" id="tag-name" value="" size="40" aria-required="true" type="text" required>
	<p>標籤出現在網站上時所用的名稱。</p>
</div>
<div class="form-field term-slug-wrap">
	<label for="tag-slug">代稱</label>
	<input name="slug" id="tag-slug" value="" size="40" type="text" required>
	<p>「代稱（slug）」是用在網址列上的名字。通常使用小寫英文字母、數字以及連字號（hyphen -）。</p>
</div>
<p class="submit"><input name="submit" id="submit" class="button button-primary" value="新增分類" type="submit"></p></form></div>

</div>
</div><!-- /col-left -->

<div id="col-right">
<div class="col-wrap">
<form id="posts-filter" method="post">
<input name="taxonomy" value="category" type="hidden">
<input name="post_type" value="post" type="hidden">

<div class="tablenav top">
				<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">選擇批次管理</label><select name="action" id="bulk-action-selector-top">
<option value="-1">批次管理</option>
	<option value="delete">刪除</option>
</select>
<input id="doaction" class="button action" value="套用" name="apply" type="submit">
		</div>
		<h2 class="screen-reader-text">分類列表導覽</h2><div class="tablenav-pages"><span class="displaying-num"><?php echo$cat->CountCat();?> 個項目</span></div>
		<br class="clear">
	</div>
<h2 class="screen-reader-text">分類列表</h2>
<table class="pshop-list-table widefat fixed striped tags">
	<thead>
	<tr>
		<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">選取全部</label><input id="check_list_all" type="checkbox"></td>
		<th scope="col" id="name" class="manage-column column-name column-primary sortable desc"><span>名稱</span></th>
		<th scope="col" id="slug" class="manage-column column-slug sortable desc"><span>代稱</span></th>
		<th scope="col" id="posts" class="manage-column column-posts num sortable desc"><span>總數</span></th>
	</tr>
	</thead>

	<tbody id="the-list" data-pshop-lists="list:tag">
<?php if(isset($_GET['keyword'])) $get_showall_cat = $cat->SearchCat($_GET['keyword']);
		else $get_showall_cat = $cat->ShowAllCat(); 
		$i = 0;
		foreach($get_showall_cat->fetchAll() as $cat_item){
?>
			<tr id="tag-<?=$cat_item['term_id']?>">
				<th scope="row" class="check-column"><?=($i++)?"<label class=\"screen-reader-text\" for=\"cb-select-".$cat_item['term_id']."\">選擇 ".$cat_item['name']."</label><input name=\"delete_tags[]\" value=\"".$cat_item['term_id']."\" id=\"cb-select-".$cat_item['term_id']."\" type=\"checkbox\">":""?></th>
				<td class="name column-name has-row-actions column-primary" data-colname="名稱"><strong><?=$cat_item['name']?></strong><br>
				<div class="hidden" id="inline_<?=$cat_item['term_id']?>">
					<div class="name"><?=$cat_item['name']?></div>
					<div class="slug"><?=$cat_item['slug']?></div>
				</div>
				<div class="row-actions">
					<span class="edit">編輯 | </span><span class="inline hide-if-no-js">快速編輯 | </span><span class="view">查看</span>
				</div>
				</td>
				<td class="slug column-slug" data-colname="代稱"><?=$cat_item['slug']?></td>
				<td class="posts column-posts" data-colname="總數"><?=$cat_item['count']?></td>
			</tr>
<?php }?>
		</tbody>
</table>
		<br class="clear">
</form>

<div class="form-wrap edit-term-notes">
<p>
	<strong>注意：</strong><br>刪除一個分類無法刪除該分類中的商品。然而，分配至已刪除分類的文章會指定為分類 <strong>未分類</strong>。</p>
</div>

</div>
</div><!-- /col-right -->

</div><!-- /col-container -->
</div>	
		</section>
	</div>
</div>
<script language="JavaScript">
$("#check_list_all").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
</script>
<?php include('footer.php');?>