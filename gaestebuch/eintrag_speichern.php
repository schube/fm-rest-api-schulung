<?php
require 'config.php';

use Schubec\PHPHelpers\Request as Request;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

$data = [ ];

$fehlermeldungen = [ ];
if (! Request::hasParameter('Absender')) {
	$fehlermeldungen [] = 'Bitte füllen Sie das Feld ABSENDER aus.';
} else {
	$data ['Absender'] = Request::getParameter('Absender');
}
if (! Request::hasParameter('Betreff')) {
	$fehlermeldungen [] = 'Bitte füllen Sie das Feld BETREFF aus.';
} else {
	$data ['Betreff'] = Request::getParameter('Betreff');
}
if (strlen(Request::getParameter('Nachricht', '')) < 5) {
	$fehlermeldungen [] = 'Bitte geben Sie eine Nachricht an, die länger als 5 Zeichen ist.';
} else {
	$data ['Nachricht'] = Request::getParameter('Nachricht');
}
$data ['Email'] = Request::getParameter('Email');

$smarty = new Smarty();
if (empty($fehlermeldungen)) {
	$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);

	$fmdb->layout('www')->create($data);
	$smarty->display('angelegt.html');
} else {
	$smarty->assign('fehlermeldungen', $fehlermeldungen);
	foreach ( $data as $key => $value ) {
		$smarty->assign($key, $value);
	}
	$smarty->display('eingabeformular.html');
}

	
	
	