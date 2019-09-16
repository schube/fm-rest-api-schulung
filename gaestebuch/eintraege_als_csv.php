<?php
require 'config.php';

use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);
$result = $fmdb->layout('www')->query(null, null, 0, 10);

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="downloaded.csv"');
$smarty = new Smarty();
$smarty->assign('records', $result);
$smarty->display('export_csv.tpl');
