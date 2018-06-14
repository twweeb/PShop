<?php include('header.php');
    $account = $password = "";
    if(isset($_GET['logout'])&&$_GET['logout'] == 1){
    	if(isset($user)){
    		logout();
    	}
    }
?>
<div id="pshop" class="container">
	<div class="row">
<font color="red" size="6"><center>Sign in</center></font>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><br><br>
    <center>帳號</center><center><input type="text" name="account" value="<?php echo $account;?>"></center><br>
    <center>密碼</center><center><input type="password" name="password"></center><br>
    <center><input type="submit" value="登入"></center><br>
	<center><a href="forgetpswd.php">忘記密碼？</a></center>
</form>

<?PHP
    if (isset($_POST['account']) && isset($_POST['password']))
    {
        $account = $_POST['account'];
        $password = $_POST['password'];

        if (!empty($account) && !empty($password))
        {
            $sql = "SELECT id, username, account_password FROM userinfo WHERE account = '$account'";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);

            if ($sth->rowCount()==1)
            {
                $hashed_password = $result['account_password'];
                
                if ($hashed_password == crypt($password, 'userPassword20180424'))
                {
                    $_SESSION['user_id'] = $result['id'];
                    echo '<font color="blue" size="2"><center>Password verified!</center></font><br><br>';
                    header('Location: index.php');
                }
                else
                    echo '<font color="blue" size="2"><center>密碼錯誤!</center></font><br><br>';
            }
            else
                echo '<font color="green" size="2"><center>* 帳號不存在</center></font><br><br>';
            
            $dbh = null;
        }
        else
        {
            echo '<font color="green" size="2"><center>* 請填入帳號和密碼</center></font><br><br>';
        }
    }
    echo "</div></div>";
    include('footer.php');
?>