<?php

if(isset($_REQUEST['exportCarnotzet'])) {
	
	include_once('../../../../../wp-load.php' );
	define('STATS_DIR', plugin_dir_path(__FILE__));
	require_once STATS_DIR.'libraries/PHPExcel/PHPExcel.php';

	$carnotzets = getFeuilles();

	// création des objets de base et initialisation des informations d'entête
    $classeur = new PHPExcel;
    //$classeur->getProperties()->setCreator("Annie Gagnon");
    $classeur->setActiveSheetIndex(0);
    $carnotzet = $classeur->getActiveSheet();
 
    // ajout des données dans la feuille de calcul
    $carnotzet->setTitle('export');
    $carnotzet->setCellValueByColumnAndRow(0, 1, "NIP");
    $carnotzet->setCellValueByColumnAndRow(1, 1, "Nom");
    $carnotzet->setCellValueByColumnAndRow(2, 1, "Prénom");
    $carnotzet->setCellValueByColumnAndRow(3, 1, "Code cours");
    $carnotzet->setCellValueByColumnAndRow(4, 1, "Date début");
    $carnotzet->setCellValueByColumnAndRow(5, 1, "Heures");
    $carnotzet->setCellValueByColumnAndRow(6, 1, "Description");
    $carnotzet->setCellValueByColumnAndRow(7, 1, "Lieu convocation");
    $carnotzet->setCellValueByColumnAndRow(8, 1, "Activité");
    $carnotzet->setCellValueByColumnAndRow(9, 1, "Interv");
    $carnotzet->setCellValueByColumnAndRow(10, 1, "Absence");
    $carnotzet->setCellValueByColumnAndRow(11, 1, "Cours ECA");
    $carnotzet->setCellValueByColumnAndRow(12, 1, "Payé");
    $carnotzet->setCellValueByColumnAndRow(13, 1, "DPS");
    $carnotzet->setCellValueByColumnAndRow(14, 1, "OI");

	foreach($carnotzets as $c => $f) {
		$ecadisData = get_user_meta($f->user_id, 'ecadisData', true);

		$OI = ($ecadisData['org_cmp1'] == 'DAPY') ? "OI Serine" : "OI Gland";
		$DPS = ($ecadisData['incorp_cr'] == 'T') ? 1 : 0;
		$numrow = $c + 2;
    	$carnotzet->setCellValueByColumnAndRow(0, $numrow, $f->nickname);
    	$carnotzet->setCellValueByColumnAndRow(1, $numrow, $f->last_Name);
    	$carnotzet->setCellValueByColumnAndRow(2, $numrow, $f->first_Name);
    	$carnotzet->setCellValueByColumnAndRow(3, $numrow, $f->codecour);
    	$carnotzet->setCellValueByColumnAndRow(4, $numrow, $f->date_deb);
    	$carnotzet->setCellValueByColumnAndRow(5, $numrow, $f->heures);
    	$carnotzet->setCellValueByColumnAndRow(6, $numrow, $f->libelle);
    	$carnotzet->setCellValueByColumnAndRow(7, $numrow, $f->lieu_conv);
    	$carnotzet->setCellValueByColumnAndRow(8, $numrow, $f->activite);
    	$carnotzet->setCellValueByColumnAndRow(9, $numrow, $f->interv);
		$carnotzet->setCellValueByColumnAndRow(10, $numrow, $f->absence_P);
		$carnotzet->setCellValueByColumnAndRow(11, $numrow, $f->cour_eca);
		$carnotzet->setCellValueByColumnAndRow(12, $numrow, $f->paye_pc);
		$carnotzet->setCellValueByColumnAndRow(13, $numrow, $DPS);
		$carnotzet->setCellValueByColumnAndRow(14, $numrow, $OI);
		
	}
   
	// envoi du fichier au navigateur
	$filename = "carnotzets";
	$filename .= "_".date("Ymd-His").".xlsx";
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	$writer = PHPExcel_IOFactory::createWriter($classeur, 'Excel2007'); 
    $writer->save('php://output');

}

?>
