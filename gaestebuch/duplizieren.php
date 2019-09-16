<?php
require 'config.php';

use Schubec\PHPHelpers\Session as Session;
use Schubec\PHPHelpers\Request as Request;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

if (Session::getValue('angemeldet') === true) {

	$smarty = new Smarty();
	try {
		$recordid = Request::getRequiredParameter('recordid');

		$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);
		// $fmdb->setDebug(true);
		// $script=array("script"=>"webscript");
		$fmdb->layout('www')->duplicate($recordid);
		$smarty->display('dupliziert.html');
	} catch ( Exception $e ) {
		$smarty->assign('exception', $e);
		$smarty->display('fehler.html');
	}
} else {
	header("Location: ./login.php");
}