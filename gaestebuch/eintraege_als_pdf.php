<?php
require 'config.php';

use INTERMediator\FileMakerServer\RESTAPI\FMDataAPI as FMDataAPI;
use setasign\Fpdi\Tcpdf\Fpdi as Fpdi;

$fmdb = new FMDataAPI(FM_DATABASE, FM_USER, FM_PASSWORD, FM_HOST);
$result = $fmdb->layout('www')->query(null, null, 0, 10);

// initiate FPDI
$pdf = new Fpdi();

// get the page count
$pageCount = $pdf->setSourceFile('Vorlage.pdf');
// iterate through all pages
for($pageNo = 1; $pageNo <= $pageCount; $pageNo ++) {
	// import a page
	$templateId = $pdf->importPage($pageNo);

	$pdf->SetFont('Helvetica');

	foreach ( $result as $record ) {
		$pdf->AddPage();
		// use the imported page and adjust the page size
		$pdf->useTemplate($templateId, [ 
				'adjustPageSize' => true
		]);

		$pdf->SetXY(62, 135);
		$pdf->Write(8, $record->field('Absender'));
	}
}

// Output the new PDFF
$pdf->Output();      

