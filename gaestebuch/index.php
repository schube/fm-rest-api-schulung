<?php
require 'config.php';


use Schubec\PHPHelpers\Request as Request;
use Schubec\PHPHelpers\Paginator as Paginator;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;



$itemsPerPage = 2;
$offset = Request::getParameter('offset', 0);

$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);
//$fmdb->setDebug(true);
//$fmdb->startCommunication();
$sort = [];
$sort[] = array('DatumUndUhrzeit', 'descend');

$result = $fmdb->layout('www')->query(null, $sort, $offset, $itemsPerPage);

// var_dump($result->getFieldnames());

$paginator = new Paginator($offset, $result->getFoundCount() , $itemsPerPage);


//$fmdb->endCommunication();

$smarty = new Smarty();
$smarty->assign('result', $result);
$smarty->assign('paginator', $paginator);

$smarty->display('liste.html');
