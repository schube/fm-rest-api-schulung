<?php
require 'config.php';

use Schubec\PHPHelpers\Request as Request;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

$smarty = new Smarty();


$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);

try {
	$data = [ ];
	$data ['Absender'] = Request::getParameter('Absender');
	$data ['Betreff'] = Request::getParameter('Betreff');
	$data ['Nachricht'] = Request::getParameter('Nachricht');
	$data ['Email'] = Request::getParameter('Email');
	$recordId = Request::getRequiredParameter('recordId');
	$modId = Request::getRequiredParameter('modId');
	
	$fehlermeldungen = [];
	if(!$data ['Absender']) {
		$fehlermeldungen[] ='Bitte füllen Sie das Feld ABSENDER aus.';
	} 
	
	if(!$data ['Betreff']) {
		$fehlermeldungen[] ='Bitte füllen Sie das Feld BETREFF aus.';
	}
	
	if(strlen($data ['Nachricht'] )<5 ) {
		$fehlermeldungen[] ='Bitte geben Sie eine Nachricht an, die länger als 5 Zeichen ist.';
	}
	if (!empty($fehlermeldungen)) {
		$smarty->assign('fehlermeldungen',$fehlermeldungen);
		$smarty->assign('data', $data);
		$smarty->display('aenderungsformular.html');
		return;
	}
	
	$fmdb->layout('www')->update($recordId, $data, $modId);
	$smarty->display('geaendert.html');
} catch ( Exception $e ) {
	$smarty->assign('exception', $e);
	$smarty->display('fehler.html');
}


