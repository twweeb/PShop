<?php 
include('header.php');
if(isset($_POST['submit'])){
	if(!empty($_POST['sitename'])&&!empty($_POST['siteurl'])&&!empty($_POST['admin_email'])&&!empty($_POST['results_per_page'])){
		if(isset($_POST['users_can_register']))$option->reg = 1;
		else $option->reg = 0;
		$option->update_site_setting($_POST['siteurl'],$_POST['sitename'],$_POST['sitedescription'],$option->reg,$_POST['admin_email'],$_POST['results_per_page']);
		$option = new Option();
	}
}
?>
<div id="pshop" class="container">
	<div class="row coupon">
<div id="pshop" class="container">
	<div class="row">
		<div class="col-md-12 hidden-sm hidden-xs">
	<h2>一般設定</h2>
			<section>
			<form method="post" action="" enctype="multipart/form-data">
				<table class="edit_option">
					<colgroup>
						<col class="cg1"><col class="cg2">
					</colgroup>
					<tbody>
					<tr class="form-group"><td class="item">網站名稱<td>

<div class="row">  
  <div class="col-xs-12 col-sm-10">
    <div class="controls">
      <input class="form-control" horizontal-label-span="2" placeholder="皮蝦購物" value="<?=$option->sitename;?>" name="sitename" type="text" required>
    </div>
  </div>
</div>
					<tr class="form-group"><td class="item">網站描述<td>

<div class="row">  
  <div class="col-xs-12 col-sm-10">
    <div class="controls">
      <input class="form-control" horizontal-label-span="2" placeholder="此網站利用皮蝦購物 PShop 建置！" value="<?=$option->sitedescription?>" name="sitedescription" type="text">
      <p class="description" id="tagline-description">請用簡單幾字描述此網站。</p>
    </div>
  </div>
</div>
					<tr class="form-group"><td class="item">網站網址<td>

<div class="row">  
  <div class="col-xs-12 col-sm-10">
    <div class="controls">
      <input class="form-control" horizontal-label-span="2" placeholder="<?=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";?>" value="<?=$option->siteurl;?>"  name="siteurl" type="text" required>
    </div>
  </div>
</div>
					<tr class="form-group"><td class="item">電子郵件地址<td>

<div class="row">  
  <div class="col-xs-12 col-sm-10">
    <div class="controls">
      <input class="form-control" horizontal-label-span="2" placeholder="example@gmail.com" value="<?=$option->get_option('admin_email')?>"  name="admin_email" type="email" required>
      <p class="description" id="tagline-description">此Email用於管理用途。</p>
    </div>
  </div>
</div>
					<tr class="form-group"><td class="item">新使用者<td>

<div class="row">  
  <div class="col-xs-12 col-sm-10">
    <div class="controls">
      <label type="checkbox-inline"><input class="" horizontal-label-span="2"  value="1" type="checkbox" name="users_can_register" <?=($option->reg)? "checked":""?>> 開放註冊</label>
    </div>
  </div>
</div>
					<tr class="form-group"><td class="item">網頁顯示最多<td>

<div class="row">  
  <div class="col-xs-12 col-sm-10">
    <div class="controls">
	<div class="row">  
        <div class="col-sm-4">
        	<div class="input-group benefit-input" style="width:100%;">
        	    <input step="1" min="1" class="form-control" placeholder="e.g. 15" name="results_per_page" type="number" value="<?=$option->results_per_page;?>" required>
        	    <div class="input-group-addon">筆商品</div>
        	</div>
        </div>
    </div>
    </div>
  </div>
</div>
					</tbody>
				</table>
				<div class="submit"><input name="submit" id="submit" class="button" value="更新設定" type="submit"></div>
			</form>
			</section>
		</div>
	</div>
</div>
	</div>
</div>
<?php include('footer.php');?>