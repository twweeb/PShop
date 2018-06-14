<?php
	/*
		請將以下字串，替換成您的資料庫資料，在將檔名變更為 db.php
		__DB_USERNAME__	: 請填寫資料庫帳號
		__DB_PASSWORD__	: 請填寫資料庫密碼
		__DB_HOST__		: 請填寫資料庫主機位置(通常是 localhost )
		__DB_NAME__		: 請填寫資料庫名稱
	*/
	$dsn = array('user'=>'__DB_USERNAME__','pass'=>'__DB_PASSWORD__');
    $dbh = new PDO("mysql:host=__DB_HOST__;dbname=__DB_NAME__",$dsn['user'],$dsn['pass'],array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(PDOException $ex){
	$failcreateconnect = 2;
}
?>