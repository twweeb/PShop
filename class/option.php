<?php
class Option
{
    public $sitename="",$siteurl="",$sitedescription="",$results_per_page="",$reg="";
    function __construct()
    {
		global $dbh;
        $sql = "SELECT option_name,option_value FROM options WHERE autoload='yes'";
        $sth = $dbh->prepare($sql);
        $sth->execute();
		while($result=$sth->fetch()){
			$this->switchcase($result['option_name'],$result['option_value']);
		}
    }
    function switchcase($option_name,$option_value){
    	switch($option_name){
    		case 'sitename':
    			$this->sitename = $option_value;
    			break;
    		case 'siteurl':
    			$this->siteurl = $option_value;
    			break;
    		case 'sitedescription':
    			$this->sitedescription = $option_value;
    			break;
    		case 'results_per_page':
    			$this->results_per_page = $option_value;
    			break;
    		case 'users_can_register':
    			$this->reg = $option_value;
    			break;
    		default:
    			break;
    	}
    }

    function update_site_setting($url,$name,$desc,$reg,$email,$res_per_page){
		global $dbh;
    	$sql = "UPDATE options
    SET option_value = (case when option_name = 'siteurl' then ?
                         	 when option_name = 'sitename' then ?
                         	 when option_name = 'sitedescription' then ?
                         	 when option_name = 'users_can_register' then ?
                         	 when option_name = 'admin_email' then ?
                         	 when option_name = 'results_per_page' then ? end)
    WHERE option_name in ('siteurl', 'sitename', 'sitedescription' , 'users_can_register', 'admin_email', 'results_per_page')";
        $sth = $dbh->prepare($sql);
        $sth->execute([$url,$name,$desc,$reg,$email,$res_per_page]);
    }
    
    function get_option($option_name){
		global $dbh;
    	$sql = "SELECT option_value FROM options WHERE option_name=?";
        $sth = $dbh->prepare($sql);
        $sth->execute([$option_name]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result['option_value'];
    }
}
?>