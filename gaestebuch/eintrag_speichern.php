<?php
require 'config.php';

use Schubec\PHPHelpers\Request as Request;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

$data = [ ];
$data ['Absender'] = Request::getParameter('Absender');
$data ['Betreff'] = Request::getParameter('Betreff');
$data ['Nachricht'] = Request::getParameter('Nachricht');
$data ['Email'] = Request::getParameter('Email');

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



$smarty = new Smarty();
if (empty($fehlermeldungen)) {
	$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);

	$fmdb->layout('www')->create($data);
	$smarty->display('angelegt.html');
} else {
	$smarty->assign('fehlermeldungen', $fehlermeldungen);
	$smarty->assign('data', $data);
	$smarty->display('eingabeformular.html');
}

	
	
	