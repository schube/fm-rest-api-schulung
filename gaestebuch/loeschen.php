<?php
require 'config.php';

use Schubec\PHPHelpers\Session as Session;
use Schubec\PHPHelpers\Request as Request;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

if (Session::getRequiredValue('angemeldet') === true) {

	$smarty = new Smarty();
	try {
		$recordid = Request::getRequiredParameter('recordid');

		$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);
		$fmdb->layout('www')->delete($recordid);
		$smarty->display('geloescht.html');
	} catch ( Exception $e ) {
		$smarty->assign('exception', $e);
		$smarty->display('fehler.html');
	}
} else {
	header("Location: ./login.php");
}
