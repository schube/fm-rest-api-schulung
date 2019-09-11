<?php
require 'config.php';

use Schubec\PHPHelpers\Request as Request;
use Schubec\PHPHelpers\Session as Session;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

$smarty = new Smarty();

if(!Request::hasParameter('benutzername') || !Request::hasParameter('passwort')) {

	$smarty->display('login_formular.html');

} else {
	$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);
	$condition=[];
	$condition['benutzername']='=='.Request::getRequiredParameter('benutzername');
	$condition['passwort']='=='.Request::getRequiredParameter('passwort');
	$record = $fmdb->layout('user')->query(array($condition));
	
	$spitzname = $record->field('Spitzname');
	
	
	Session::set('angemeldet', true);
	Session::set('benutzername', $spitzname);
	
	$smarty->assign('benutzername',$spitzname);
	$smarty->display('login_erfolgreich.html');

	
}