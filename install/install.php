<?php 
if(isset($_POST['connect_db'])){
	try{
		$dbh = new PDO("mysql:host=".$_POST['dbhost'].";dbname=".$_POST['dbname'],$_POST['uname'],$_POST['pwd'],array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(PDOException $ex){
		$failcreateconnect = 1;
	}
	if(!isset($failcreateconnect)){
		$db = fopen("../database/db.php", "w");
		if ( !$db ) {
			$failcreateconnect = 2;
		}
		else{
			file_put_contents("../database/db.php", "");
			$dsn = "array('user'=>'".$_POST['uname']."', 'pass'=>'".$_POST['pwd']."');\n";
			$host = $_POST['dbhost'];
			$dbname = $_POST['dbname'];
			$script = "<?php\n".'$dsn='.print_r($dsn, true)."try{\n\t".'$dbh = new PDO("mysql:host='.$host.';dbname='.$dbname.'",$dsn[\'user\'],$dsn[\'pass\'],array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));'."\n}\n".'catch(PDOException $ex){'."\n\t".'$failcreateconnect = 2;'."\n}\n?>";
			fwrite($db, $script);
			fclose($db);
			header('Location: install.php?step=2');
		}
	}
}
?><!DOCTYPE html>
<html dir="ltr" lang="zh-tw">
<head>
	<title>PShop - 安裝</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Pacifico:400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
</head>
<body class="pshop-core-ui shadow">
  <div class="wrapper">
	  <div class="main">
	<p id="logo"><span>PShop購物車</span></p>
<?php if(!isset($failcreateconnect)){
if(!isset($_GET['step'])){?>
<h1 class="screen-reader-text">開始之前</h1>
<p>歡迎使用 PShop購物車。開始以前，我們需要一些關於資料庫的設定資訊。進行前請確認你已知道下列項目。</p>
<ol>
	<li>資料庫使用者帳號</li>
	<li>資料庫密碼</li>
	<li>資料庫名稱</li>
	<li>資料庫主機位址</li>
</ol>
<p>我們會使用這些資訊來建立一個 <code>db.php</code> 檔案(位於資料夾/database/內)。	<strong>如果因為某些原因而導致自動建立檔案無法運作，別擔心。你需要做的是把資料庫資訊填入設定檔。你也可以簡單地在文字編輯器開啟 <code>/database/db-sample.php</code>，填寫你的資訊，並將其儲存至 <code>/database/db.php</code>。</strong></p>
<p>絕大部分狀況下，這些資訊將由你的網站管理員提供。若是你沒有這些資訊，繼續下去之前你必須先聯絡他們。若你都準備好了&hellip;</p>

<p class="step"><a href="install.php?step=1" class="button button-large">衝吧！</a></p>
<?php }else if($_GET['step'] == 1){?>
	<form method="POST" action="">
		<section>
	<p>請於下方輸入你的資料庫連線細節。若你不確定這些細節，請聯絡你的主機管理員。</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">資料庫名稱</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value="" /></td>
			<td>你想讓 PShop 使用的資料庫名稱。</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">使用者名稱</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value="" /></td>
			<td>你的資料庫使用者名稱。</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">密碼</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value="password" autocomplete="off" /></td>
			<td>你的資料庫密碼。</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">資料庫主機位址</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			<td>如果 <code>localhost</code> 無法運作，你應該可以從遠端取得這個資訊。</td>
		</tr>
	</table>
		<input type="hidden" name="language" value="zh_TW" />
	<p class="step"><input name="connect_db" type="submit" value="送出" class="button button-large" /></p>
		</section>
		</form>
<?php }else if($_GET['step'] == 2){
include('../database/db.php');
if(isset($failcreateconnect)) {echo "Error!";
exit;
}
?>
		<section><h1 class="screen-reader-text">資料庫連線成功</h1>
<p>做的好！你完成安裝過程中重要的一步。PShop 現在已經可以連結到你的資料庫。如果你準備好了，那麼就&hellip;</p>
<p class="step"><a href="install.php?step=3" class="button button-large">執行安裝</a></p>
		</section>
<?php }else if($_GET['step'] == 3 || $_GET['step'] == 4){
include('setup.inc.php');
}
}
else if($failcreateconnect == 1){?>
<p><h1>建立資料庫連線時發生錯誤</h1>
<p>這代表若不是您 <code>/database/db.php</code> 檔案中的使用者名稱及密碼資訊不正常，就是我們無法連線至資料庫主機 <code><?=$_POST['dbhost']?></code>。 這可能是所連線的資料庫主機已關閉。</p>
<ul>
<li>請確認你輸入了正確使用者名稱及密碼？</li>
<li>請確認你輸入的主機名稱正確無誤？</li>
<li>請確認資料庫伺服器正常運作中？</li>
</ul>
<p>假如您不了解這些訊息代表什麼意思，請連絡您的主機管理員。</p>
<p class="step"><a href="install.php?step=1" onclick="javascript:history.go(-1);return false;" class="button button-large">再試一次</a></p>
<?php 
}
else if($failcreateconnect == 2){?>
<p><h1>無法建立系統設定檔</h1>
<p>系統無法自行建立設定檔<code>/database/db.php</code> 別擔心。你可以將<code>/database/</code> 資料夾權限設定為<code>777</code> ，然後再試一次。</p>
<p>或是您可以手動修改，你需要做的是把資料庫資訊填入設定檔。你也可以簡單地在文字編輯器開啟 <code>/database/db-sample.php</code>，填寫你的資訊，並將其儲存至 <code>/database/db.php</code>。</strong>
<p class="step"><a href="install.php?step=1" onclick="javascript:history.go(-1);return false;" class="button button-large">再試一次</a> <a href="install.php?step=2" class="button button-large">自行設定完成</a></p>

<?php
}?>
	</div><!--/main-->
  </div><!--/wrapper-->
</body>
</html>