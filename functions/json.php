<?php
session_start();
header('Content-Type: application/json');

$aResult = array();

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

if( !isset($_SESSION['user_id']) ) { $aResult['error'] = 1; $aResult['result'] = '請先登入！'; }

if( !isset($aResult['error']) ) {
	require_once dirname(__FILE__).'/../database/db.php';
    switch($_POST['functionname']) {
        case 'deleteitem':
           	include('../class/cart.php');
            $aResult['result'] = deleteitem(floatval($_POST['arguments']));
           break;
        
        case 'additem':
           	include('../class/cart.php');
            if( !is_array($_POST['arguments']) || (count($_POST['arguments']) != 3) ) {
                $aResult['error'] = 'Error in arguments!';
            }
            else{
                $aResult['result'] = additem(floatval($_POST['arguments'][0]),floatval($_POST['arguments'][1]),floatval($_POST['arguments'][2]));
                if($aResult['result']!="done") $aResult['error'] = 1;
            }
            break;

        case 'cancelitem':
           	include('../class/order.php');
           	$order = new Order();
           	$order->Cancel($_POST['arguments']);
           break;
        
        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
           break;
    }

}

echo json_encode($aResult);
?>