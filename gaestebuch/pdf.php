<?php
require 'config.php';

use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;
use setasign\Fpdi\Tcpdf\Fpdi as Fpdi;

$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);
$result = $fmdb->layout('www')->getRecord($_REQUEST['recordid'], null, ["script" => "PDF-generieren"]);
$pdf = $result->getContainerData('PDFContainer');
header('Content-type: application/pdf');
echo base64_decode($pdf);