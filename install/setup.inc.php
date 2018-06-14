<?php
include('../database/db.php');
include('../functions/functions.php');
global $required_php_version, $required_mysql_version;

$php_version    = phpversion();
$mysql_version  = get_mysql_ver();
$php_compat     = version_compare( $php_version, $required_php_version, '>=' );
$mysql_compat   = version_compare( $mysql_version, $required_mysql_version, '>=' );

if ( !$mysql_compat && !$php_compat ) {
	$compat = sprintf('無法安裝 PShop ，由於 PShop 需要 PHP 版本 %1$s 或更高，以及 MySQL 版本 %2$s 或更高。 目前的環境為 PHP 版本 %3$s 和 MySQL 版本 %4$s 。' , $required_php_version, $required_mysql_version, $php_version, $mysql_version );
} elseif ( !$php_compat ) {
	$compat = sprintf('無法安裝 PShop ，由於 PShop 需要 PHP 版本 %1$s 或更高。 目前的環境為 PHP 版本 %2$s 。' , $required_php_version, $php_version );
} elseif ( !$mysql_compat ) {
	$compat = sprintf('無法安裝 PShop ，由於 PShop 需要 MySQL 版本 %1$s 或更高。 目前的環境為 MySQL 版本 %3$s 。' , $required_mysql_version, $mysql_version );
}

if ( !$mysql_compat || !$php_compat ) {
	die( '<h1>' .'環境需求不足' . '</h1><p>' . $compat . '</p></div></div></body></html>' );
}

$step = $_GET['step'];
function pshop_install( $weblog_title, $user_name, $admin_email, $admin_password){
	if(isset($failcreateconnect)) {
		echo "Error!";
	}
	global $dbh;
	// Temporary variable, used to store current query
	$templine = '';
	// Read in entire file
	$lines = file('pshop.sql');
	// Loop through each line
	foreach ($lines as $line)
	{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
		    continue;
		
		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{
		    // Perform the query
		    $sth = $dbh->prepare($templine);
		    $sth->execute();
		    // Reset temp variable to empty
		    $templine = '';
			if (!$sth) {
			    echo "\nPDO::errorInfo():\n";
			    print_r($dbh->errorInfo());
			}
		}
	}
	global $dbh;
    $admin_password = crypt($admin_password, 'userPassword20180424');
	$sql = "LOCK TABLES `userinfo` WRITE; INSERT INTO `userinfo` (`account`, `account_password`,`email`,`authority`) VALUES ('$user_name', '$admin_password', '$admin_email', 'admin');UNLOCK TABLES;";
	$sth = $dbh->prepare($sql);
	$sth->execute();
	if (!$sth) {
	    echo "\nPDO::errorInfo():\n";
	    print_r($dbh->errorInfo());
	}
	
	$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	$url .= $_SERVER['SERVER_NAME'];
	$url .= $_SERVER['REQUEST_URI'];
	$url = dirname(dirname($url));

    $sql = "LOCK TABLES `options` WRITE; INSERT INTO `options` (`option_name`, `option_value`,`autoload`) VALUES
	('siteurl', ?,'yes'),('sitename', ?,'yes'),('sitedescription', ?,'yes'),('users_can_register', '1','yes'),('admin_email', ?,'no'),('results_per_page', 15,'yes');UNLOCK TABLES;";
	$sth = $dbh->prepare($sql);
	$sth->execute([$url, $weblog_title,"PShop購物車！", $admin_email]);
}
function display_setup_form( $error = null ) {
	$weblog_title = isset( $_POST['weblog_title'] ) ? trim( stripslashes_deep( $_POST['weblog_title'] ) ) : '';
	$user_name = isset($_POST['user_name']) ? trim( stripslashes_deep( $_POST['user_name'] ) ) : '';
	$admin_email  = isset( $_POST['admin_email']  ) ? trim( stripslashes_deep( $_POST['admin_email'] ) ) : '';
?>
<h1>哈囉</h1>
<?php
	if ( ! is_null( $error ) ) {
?>
<p class="message"><?php echo $error; ?></p>
<?php } ?>
<p>歡迎來到 PShop購物車 安裝過程的最後一步，設定基本網站資訊！只要簡單填寫以下資訊，你就能夠開始使用 PShop 購物車。</p>

<h2>需要資訊</h2>
<p>請提供下列資訊。別擔心，你可以在稍後更動他們。</p>

<form id="setup" method="post" action="install.php?step=4" novalidate="novalidate">
	<table class="form-table">
		<tr>
			<th scope="row"><label for="weblog_title">網站標題</label></th>
			<td><input name="weblog_title" type="text" id="weblog_title" size="25" value="" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="user_login">使用者名稱</label></th>
			<td>
			<input name="user_name" type="text" id="user_login" size="25" value="" />
				<p>用戶名稱只能包含數字、英文字母、空白、底線、連字符、半型句點和@符號。</p>
						</td>
		</tr>
				<tr class="form-field form-required user-pass1-wrap">
			<th scope="row">
				<label for="pass1">
					密碼				</label>
			</th>
			<td>
				<div class="">
										<input type="password" name="admin_password" id="pass1" class="regular-text" autocomplete="off" data-reveal="1" data-pw="YY*$NEG0*!sqbFTtDe" aria-describedby="pass-strength-result" />
					<button type="button" class="button wp-hide-pw hide-if-no-js" data-start-masked="0" data-toggle="0" aria-label="隱藏密碼">
						<span class="dashicons dashicons-hidden"></span>
						<span class="text">隱藏</span>
					</button>
					<div id="pass-strength-result" aria-live="polite"></div>
				</div>
				<p><span class="description important hide-if-no-js">
				<strong>重要：</strong>
								你未來將使用此密碼來登入。請將它保存在安全的地方。</span></p>
			</td>
		</tr>
		<tr class="form-field form-required user-pass2-wrap hide-if-js">
			<th scope="row">
				<label for="pass2">重複輸入密碼					<span class="description">(必)</span>
				</label>
			</th>
			<td>
				<input name="admin_password2" type="password" id="pass2" autocomplete="off" />
			</td>
		</tr>
		<tr class="pw-weak">
			<th scope="row">確認密碼</th>
			<td>
				<label>
					<input type="checkbox" name="pw_weak" class="pw-checkbox" />
					確定使用強度弱的密碼				</label>
			</td>
		</tr>
				<tr>
			<th scope="row"><label for="admin_email">你的電子郵件</label></th>
			<td><input name="admin_email" type="email" id="admin_email" size="25" value="" />
			<p>繼續下去之前請再度確認你的電子郵件位址。</p></td>
		</tr>
	</table>
	<p class="step"><input type="submit" name="submit" id="submit" class="button button-large" value="安裝 PShop"  /></p>
</form>
<?php	}
if($step==3) display_setup_form();
else if($step == 4){
		// Fill in the data we gathered
		$weblog_title = isset( $_POST['weblog_title'] ) ? trim( stripslashes_deep( $_POST['weblog_title'] ) ) : '';
		$user_name = isset($_POST['user_name']) ? trim( stripslashes_deep( $_POST['user_name'] ) ) : '';
		$admin_password = isset($_POST['admin_password']) ? stripslashes_deep( $_POST['admin_password'] ) : '';
		$admin_password_check = isset($_POST['admin_password2']) ? stripslashes_deep( $_POST['admin_password2'] ) : '';
		$admin_email  = isset( $_POST['admin_email'] ) ?trim( stripslashes_deep( $_POST['admin_email'] ) ) : '';

		// Check email address.
		$error = false;
		if ( empty( $user_name ) ) {
			// TODO: poka-yoke
			display_setup_form( "請輸入有效的使用者名稱。" );
			$error = true;
		} elseif ( $user_name != sanitize_user( $user_name, true ) ) {
			display_setup_form( "使用者名稱中含有非法字元。" );
			$error = true;
		} elseif ( $admin_password != $admin_password_check ) {
			// TODO: poka-yoke
			display_setup_form( "兩次密碼輸入不一致，請重新輸入。" );
			$error = true;
		} elseif ( empty( $admin_email ) ) {
			// TODO: poka-yoke
			display_setup_form("您必須提供管理者Email。" );
			$error = true;
		} elseif ( ! is_email( $admin_email ) ) {
			// TODO: poka-yoke
			display_setup_form( "抱歉，您提供的管理者Email是無效的。Email 形式須為 <code>username@example.com</code> 。" );
			$error = true;
		}

		if ( $error === false ) {
			$result = pshop_install( $weblog_title, $user_name, $admin_email, stripslashes_deep( $admin_password ));
?>
<h1>恭喜</h1>

<p>PShop 購物車已成功安裝</p>
<table class="form-table install-success">
	<tr>
		<th>使用者名稱</th>
		<td><?php echo sanitize_user( $user_name, true ); ?></td>
	</tr>
	<tr>
		<th>密碼</th>
		<td>您選擇的密碼</td>
	</tr>
</table>

<p class="step"><a href="../login.php" class="button button-large">馬上登入</a></p>
<?php }
} ?>
<script type="text/javascript">var t = document.getElementById('weblog_title'); if (t){ t.focus(); }</script>
<script type='text/javascript' src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
<script type='text/javascript' src='https://code.jquery.com/jquery-migrate-1.4.1.min.js'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var _zxcvbnSettings = {"src":".\/js/zxcvbn.min.js"};
/* ]]> */
</script>
<script type='text/javascript' src='./js/zxcvbn-async.min.js'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var pwsL10n = {"unknown":"\u5bc6\u78bc\u5f37\u5ea6\u672a\u77e5","short":"\u975e\u5e38\u5f31","bad":"\u5f31","good":"\u4e2d","strong":"\u5f37","mismatch":"\u4e0d\u7b26\u5408"};
/* ]]> */
</script>
<script type='text/javascript' src='./js/password-strength-meter.min.js'></script>
<script type='text/javascript' src='./js/underscore.min.js'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var _wpUtilSettings = {"ajax":{"url":"\/wp-admin\/admin-ajax.php"}};
/* ]]> */
</script>
<script type='text/javascript' src='./js/wp-util.min.js'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var userProfileL10n = {"warn":"\u4f60\u7684\u65b0\u5bc6\u78bc\u5c1a\u672a\u5132\u5b58\u3002","warnWeak":"\u78ba\u5b9a\u4f7f\u7528\u5f37\u5ea6\u5f31\u7684\u5bc6\u78bc","show":"\u986f\u793a","hide":"\u96b1\u85cf","cancel":"\u53d6\u6d88","ariaShow":"\u986f\u793a\u5bc6\u78bc","ariaHide":"\u96b1\u85cf\u5bc6\u78bc"};
/* ]]> */
</script>
<script type='text/javascript' src='./js/user-profile.min.js'></script>
<script type="text/javascript">
jQuery( function( $ ) {
	$( '.hide-if-no-js' ).removeClass( 'hide-if-no-js' );
} );
</script>