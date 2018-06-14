<?php
session_start();
header('Content-Type: application/json');

$aResult = array();

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($_SESSION['user_id']) ) { $aResult['error'] = 1; $aResult['result'] = '請先登入！'; }

if( !isset($aResult['error']) ) {
	require_once dirname(__FILE__).'/../../database/db.php';
    switch($_POST['functionname']) {
        case 'cancelitem':
           	include('../../class/order.php');
           	$order = new Order();
           	$aResult = $order->Cancel($_POST['arguments']);
           break;
        
        case 'restoreitem':
           	include('../../class/order.php');
           	$order = new Order();
           	$aResult = $order->Restore($_POST['arguments']);
           break;

        case 'setdiscount':
           	include('../../class/order.php');
           	$order = new Order();
           	$aResult = $order->SetDiscount($_POST['orderid'],$_POST['price']);
           break;

        case 'setpaid':
           	include('../../class/order.php');
           	$order = new Order();
           	$aResult = $order->SetPaid($_POST['orderid']);
           break;
           
        case 'setship':
           	include('../../class/order.php');
           	$order = new Order();
           	$aResult = $order->SetShip($_POST['orderid'],$_POST['shipid']);
           break;
           
        case 'setfinished':
           	include('../../class/order.php');
           	$order = new Order();
           	$aResult = $order->SetFinished($_POST['orderid'],$_POST['shipid']);
           break;
           
        case 'setallfinished':
           	include('../../class/order.php');
           	$order = new Order();
           	$aResult = $order->SetAllFinished($_POST['orderid']);
           break;
           
        case 'productdropoff':
           	include('../../class/commodity.php');
           	$order = new Commodity();
           	$aResult = $order->DropOff($_POST['commodity_id']);
           break;
           
        case 'productonshelf':
           	include('../../class/commodity.php');
           	$order = new Commodity();
           	$aResult = $order->OnShelf($_POST['commodity_id']);
           break;
           
        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
           break;
    }

}

echo json_encode($aResult);
?>