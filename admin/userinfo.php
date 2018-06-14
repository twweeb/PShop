<?php include('header.php');
if(isset($user) && $user->authority == "admin"){?>
<div id="pshop" class="container">
	<div class="row">
<br><h1>User Information</h1><br>

<form method="post" action="userinfo.php">
<?php

    require_once('../class/user.php');

    if (isset($_POST['sel']))
    {
        global $dbh;
        
        if ($_POST['submit'] == "刪除用戶") // 2018.5.20 Yuan
        {
            foreach($_POST['sel'] as $i)
            {     
                $sql = "DELETE FROM UserInfo WHERE id=$i";
                $sth = $dbh->prepare($sql);
                $sth->execute();
                echo '&nbsp&nbsp&nbsp&nbsp<font color="red" size="3">已刪除ID = </font>';
                echo $i;
                echo '<font color="red" size="3"> 的用戶</font><br><br>';
            }
        }
        if ($_POST['submit'] == "更改用戶權限") // 2018.5.20 Yuan
        {   
            foreach($_POST['sel'] as $i)
            {
                $user1 = new user($i);
                $user1->change_authority();
            }
        }
    }
?>
<table class='view-userinfo-table-all view-cart-hoverable'><tr class='view-cart-blue'>
  <tr><tr>
    <th> </th>
    <th>ID</th>
    <th>姓名</th>
    <th>帳號</th>
    <th>電話</th>
    <th>信箱</th>
    <th>地址</th>
    <th>權限</th>
  </tr>

<?php
    // Show all the contents
	global $dbh;
    $sql = "SELECT * FROM UserInfo";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    if ($sth->rowCount() > 0)
    {
        // output data of each row
        foreach ($dbh->query($sql) as $row)
        {
            echo '<tr>';
            $id = $row['id'];
            $account = $row['account'];
            $name = $row['userName'];
            $phone_number = $row['phone_number'];
            $email = $row['email'];
            $address = $row['user_address'];
            $authority = $row['authority'];
            $checkbox = '<input type="checkbox" name="sel[]" value="'.$row['id'].'">';

            if ($authority == 'admin') // 2018.5.20 Yuan
            {
                $authority = '<font color="red">admin</font>';
            }
            
            echo '<td>' . $checkbox . '</td>';
            echo '<td>' . $id . '</td>';
            echo '<td>' . $name . '</td>';
            echo '<td>' . $account . '</td>';
            echo '<td>' . $phone_number . '</td>';
            echo '<td>' . $email . '</td>';
            echo '<td>' . $address . '</td>';
            echo '<td>' . $authority . '</td>';
            echo '</tr>';
        }
    }
    $dbh = null;
?>
</table>
	<div class="submit deletebtn">
        <input name="submit" id="submit" class="button" value="刪除用戶" type="submit">
        &nbsp&nbsp&nbsp&nbsp
        <input name="submit" id="submit" class="button" value="更改用戶權限" type="submit">
    </div>
</form>
</div></div>
<?php }
else {
	echo "<script>alert(\"You have no permission to view the page!\");</script>";
}
include('footer.php'); ?>