<?php
require 'config.php';

use Schubec\PHPHelpers\Request as Request;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

$recordid = Request::getRequiredParameter('recordid');

$fmdb = new FMDataAPI ( FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST );
$record = $fmdb->layout ( 'www' )->getRecord ( $recordid );

$smarty = new Smarty ();
foreach($record->getFieldnames() as $fieldname) {
	$smarty->assign($fieldname, $record->field($fieldname));
}

$smarty->assign ( 'recordId', $record->getRecordId() );
$smarty->assign ( 'modId', $record->getModId() );
$smarty->assign ( 'fehlermeldungen', array() );
$smarty->display ( 'aenderungsformular.html' );
	