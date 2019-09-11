<?php
require 'config.php';

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Schubec\PHPHelpers\Request as Request;
use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;

$smarty = new Smarty();
try {
	$recordid = Request::getRequiredParameter('recordid');
	$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);
	$record = $fmdb->layout('www')->getRecord($recordid);

	$smarty_fuer_email = new Smarty();
	$smarty_fuer_email->assign('record', $record);

	// Setup SMTP transport using LOGIN authentication
	$transport = new SmtpTransport();
	$options = new SmtpOptions([ 
			'name' => 'localhost.localdomain',
			'host' => 'smtp.schubec-hosting.com',
			'connection_class' => 'login',
			'connection_config' => [ 
					'username' => 'reporting@schubec-hosting.com',
					'password' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
			]
	]);
	$transport->setOptions($options);

	$message = new Message();
	$message->setBody($smarty_fuer_email->fetch('email_body.tpl'));
	$message->setFrom('test@schubec.com', 'Einige Sender');
	$message->addTo('recipient@schubec.com', 'Einige Empfaenger');
	$message->setSubject('Das ist ein Email von PHP!');
	$transport->send($message);

	$smarty->display('emailversand.html');
} catch ( Exception $e ) {
	$smarty->assign('exception', $e);
	$smarty->display('fehler.html');
}

