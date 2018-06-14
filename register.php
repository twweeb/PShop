<?php include('header.php');
	if(!$option->reg) {
		echo "<div class='alert alert-dismissible fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<center><h2>目前並未開放註冊新使用者！</center>
					</div></div></div>";
		include('footer.php');
		die();
	}
    // define variables and set to empty values
    $account = $password1 = $password2 = $name = $phone_number = $email = $address = "";
    $nameErr = $emailErr = $passwordErr = $accountErr = $addressErr =  $phone_numberErr = "";
    $authority = 'user'; // 從註冊頁面註冊的用戶均預設為一般使用者。
    $info_is_correct = FALSE;
    $correctness = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["account"]))
        {
            $accountErr = "* account is required<br>";
        }
        else
        {
            $account = test_input($_POST["account"]);
            if (account_is_unique($account))
                $correctness[0] = TRUE;
            else
                $accountErr = "* 帳號名稱已存在<br>";
        }
        if (empty($_POST["password1"]))
            $passwordErr = "* password is required<br>";
        else
        {
            $password1 = test_input($_POST["password1"]);
            $correctness[1] = TRUE;
        }
        if (empty($_POST["password2"]))
            $passwordErr = "* password is required<br>";
        else
        {
            $password2 = test_input($_POST["password2"]);
            if (!empty($_POST["password1"]))
            {
                if ($password1 != $password2)
                    $passwordErr = "* 密碼不一致<br>";
                else
                    $correctness[2] = TRUE;
            }
        }
        if (empty($_POST["name"]))
            $nameErr = "* name is required<br>";
        else
        {
            $name = test_input($_POST["name"]);
            $correctness[3] = TRUE;
        }
        if (empty($_POST["phone_number"]))
            $phone_numberErr = "* phone number is required<br>";
        else
        {
            $phone_number = test_input($_POST["phone_number"]);
            $correctness[4] = TRUE;
        }
        if (empty($_POST["email"]))
            $emailErr = "* e-mail is required<br>";
        else
        {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                $emailErr = "Invalid email format"; 
            else
                $correctness[5] = TRUE;
        }
        if (empty($_POST["address"]))
            $addressErr = "* address is required<br>";
        else
        {
            $address = test_input($_POST["address"]);
            $correctness[6] = TRUE;
        }

        for ($i = 0; $i <= 6; $i++)
        {
            if ($correctness[$i] == FALSE)
            {
                $info_is_correct = FALSE;
                break;
            }
            else
                $info_is_correct = TRUE;
        } 

        // 所有資料已正確輸入，因此將該新建使用者的資料加入table(UserInfo)
        if ($info_is_correct == TRUE)
        {
            // 連接到資料庫(POD)
            try
            {
                $hashed_password = crypt($password2, 'userPassword20180424');
                $sql = "INSERT INTO UserInfo (account, account_password, userName, phone_number, user_address, email, authority)
                        VALUES ('$account',  '$hashed_password', '$name', '$phone_number', '$address', '$email', '$authority')";
                // use exec() because no results are returned
                $dbh->exec($sql);
                echo '<br><font color="purple" size="4"><center>已成功加入會員！</center></font>';
            }
            catch (PODException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
            $dbh = null;
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        // The htmlspecialchars() function converts special characters to HTML entities.
        return $data;
    }

    function test_password($password1, $password2)
    {
        if ($password1 != $password2)
        {
            echo "密碼不一致，請重新輸入。<br>";
            return false;
        }
        if (strlen($password1) < 6)
        {
            echo "密碼長度最少為6，請輸入新的密碼。<br>";
            return false;
        }
        return true;
    }

    function account_is_unique($new_account_name)
    {
        global $dbh;
        
        // 比對新的帳號名稱是否已經存在資料庫裏
        $sql = "SELECT * FROM userinfo WHERE username LIKE ?";
        $results = $dbh->prepare($sql);
        $results->execute([$new_account_name]);
        if ($results->rowCount())
            return false;
        else
            return true;
    }
?>
<div id="pshop" class="container">
	<div class="row">
    <form method="post" action="">
    <font color="red" size="6"><center>Create account</center></font>
    <br>
    <center>帳號</center><center><input type="text" name="account" value="<?php echo $account;?>"></center>
    <center><span class="error"><?php echo $accountErr;?></span></center><br>
    <center>密碼</center><center><input type="password" name="password1"></center>
    <center><span class="error"><?php echo $passwordErr;?></span></center><br>
    <center>確認密碼</center><center><input type="password" name="password2"></center>
    <center><span class="error"><?php echo $passwordErr;?></span></center><br>
    <center>姓名</center><center><input type="text" name="name" value="<?php echo $name;?>"></center>
    <center><span class="error"><?php echo $nameErr;?></span></center><br>
    <center>手機</center><center><input type="text" name="phone_number" value="<?php echo $phone_number;?>"></center>
    <center><span class="error"><?php echo $phone_numberErr;?></span></center><br>
    <center>地址</center><center><input type="text" name="address" value="<?php echo $address;?>"></center>
    <center><span class="error"><?php echo $addressErr;?></span></center><br>
    <center>E-mail</center><center><input type="text" name="email" value="<?php echo $email;?>"></center>
    <center><span class="error"><?php echo $emailErr;?></span></center><br>
    <center><input type="submit" value="Create your PShop account"></center><br>
    </form>
</div></div>
<?php 
    include('footer.php');
?>
