<?php
require 'config.php';


use Schubec\PHPHelpers\Request as Request;
use Schubec\PHPHelpers\Paginator as Paginator;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;



$itemsPerPage = 10;
$offset = Request::getParameter('offset', 0);

$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);
//$fmdb->setDebug(true);
//$fmdb->startCommunication();

$conditions = [];

$condition1 = array('Nachricht'=>'Test','Email'=>'schubec');
$condition2 = array('Absender'=>'MICHAEL','omit'=>'true');

$conditions[] = $condition1;
$conditions[] = $condition2;

$sort = [];
$sort[] = array('Absender', 'ascend');
$sort[] = array('DatumUndUhrzeit', 'descend');


$result = $fmdb->layout('www')->query($conditions, $sort, $offset, $itemsPerPage);

// var_dump($result->getFieldnames());

$paginator = new Paginator($offset, $result->getFoundCount() , $itemsPerPage);


//$fmdb->endCommunication();

$smarty = new Smarty();
$smarty->assign('result', $result);
$smarty->assign('paginator', $paginator);

$smarty->display('liste.html');
