<?php
require 'config.php';

use Schubec\PHPHelpers\Request as Request;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

$recordid = Request::getRequiredParameter('recordid');

$fmdb = new FMDataAPI ( FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST );
$record = $fmdb->layout ( 'www' )->getRecord ( $recordid );


$data = [ ];
$data ['Absender'] = $record->field('Absender');
$data ['Betreff'] = $record->field('Betreff');
$data ['Nachricht'] = $record->field('Nachricht');
$data ['Email'] = $record->field('Email');


$smarty = new Smarty ();
$smarty->assign ( 'recordId', $record->getRecordId() );
$smarty->assign ( 'modId', $record->getModId() );
$smarty->assign ( 'data', $data );
$smarty->assign ( 'fehlermeldungen', null );
$smarty->display ( 'aenderungsformular.html' );
	