<?php
require 'config.php';

$data = [ ];
$data ['Absender'] = '';
$data ['Betreff'] = '';
$data ['Nachricht'] = '';
$data ['Email'] = '';

$smarty = new Smarty ();
$smarty->assign('data', $data);
$smarty->assign('fehlermeldungen', null);
$smarty->display ( 'eingabeformular.html' );
