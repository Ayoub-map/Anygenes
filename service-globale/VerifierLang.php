<?php
function getAllChemins(){
return  array(
	array('en' =>'http://localhost/anygenes/' , 'fr' =>'http://localhost/anygenes/fr'),
	array('en' =>'http://localhost/anygenes/home/products' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits'),
	array('en' =>'http://localhost/anygenes/home/biomarker-services' , 'fr' =>'http://localhost/anygenes/fr/accueil/services-biomarqueurs'),
	array('en' =>'http://localhost/anygenes/home/molecular-diagnosis' , 'fr' =>'http://localhost/anygenes/fr/accueil/diagnostic-moleculaire'),
	array('en' =>'http://localhost/anygenes/home/resources' , 'fr' =>'http://localhost/anygenes/fr/accueil/ressources'),
	array('en' =>'http://localhost/anygenes/home/blog' , 'fr' =>'http://localhost/anygenes/fr/accueil/blog'),
	array('en' =>'http://localhost/anygenes/home/products/signaling-pathways' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/voies-signalisation'),
	array('en' =>'http://localhost/anygenes/home/products/lncrna-qpcr-assay' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/kits-qpcr-lncrna'),
	array('en' =>'http://localhost/anygenes/home/products/qpcr-master-mixes' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/master-mixe-qpcr'),
	array('en' =>'http://localhost/anygenes/home/products/qpcr-master-mixes/qpcr-mix-sybr-green' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/master-mixe-qpcr/qpcr-mix-sybr-green'),
	array('en' =>'http://localhost/anygenes/home/products/qpcr-master-mixes/qpcr-mix-probe' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/master-mixe-qpcr/qpcr-mix-probe'),
	array('en' =>'http://localhost/anygenes/home/products/validated-primer-sets' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/primers-valides-prets-emploi'),
	array('en' =>'http://localhost/anygenes/home/products/single-cell-profiling' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/analyses-materiel-biologique'),
	array('en' =>'http://localhost/anygenes/home/products/single-cell-profiling/pre-amplification' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/analyses-materiel-biologique/kits-de-preamplification'),
	array('en' =>'http://localhost/anygenes/home/products/single-cell-profiling/direct-lysis' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/analyses-materiel-biologique/kits-de-lyse-directe-dilysis'),
	array('en' =>'http://localhost/anygenes/home/products/start-reverse-transcritpion-kits' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/reverse-transcription-start'),
	array('en' =>'http://localhost/anygenes/home/products/microbiota-assays' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/analyse-microbiote'),
	array('en' =>'http://localhost/anygenes/home/products/mycoplasma-detection-assays-mycodiag' , 'fr' =>'http://localhost/anygenes/fr/accueil/produits/mycoplasma-detection-assays-mycodiag'),
	array('en' => 'http://localhost/anygenes/home/biomarker-services/in-vitro-drug-development', 'fr' => 'http://localhost/anygenes/fr/accueil/services-biomarqueurs/developpement-molecules-in-vitro'),
	array('en' => 'http://localhost/anygenes/home/biomarker-services/histoculture-drug-response-assays', 'fr' => 'http://localhost/anygenes/fr/accueil/services-biomarqueurs/etudes-histoculture'),
	array('en' => 'http://localhost/anygenes/home/biomarker-services/biomarkers-identification-validation', 'fr' => 'http://localhost/anygenes/fr/accueil/services-biomarqueurs/identification-validation-biomarqueurs'),
	array('en' => 'http://localhost/anygenes/home/biomarker-services/methylation-studies', 'fr' => 'http://localhost/anygenes/fr/accueil/services-biomarqueurs/etudes-methylation'),
	array('en' => 'http://localhost/anygenes/home/biomarker-services/hight-throughput-data-analysis', 'fr' => 'http://localhost/anygenes/fr/accueil/services-biomarqueurs/analyses-donnees-haut-debit'),
	array('en' => 'http://localhost/anygenes/home/biomarker-services/methylation-studies/epigenetic', 'fr' => 'http://localhost/anygenes/fr/accueil/produits/analyse-microbiote'),
	array('en' => 'http://localhost/anygenes/home/biomarker-services/methylation-studies/pyrosequencing-technology', 'fr' => 'http://localhost/anygenes/fr/accueil/services-biomarqueurs/etudes-methylation/technologie-pyrosequencage'),
	array('en' => 'http://localhost/anygenes/home/help/contact', 'fr' => 'http://localhost/anygenes/fr/accueil/aide/contact'),
	array('en' => 'http://localhost/anygenes/home/help/faq', 'fr' => 'http://localhost/anygenes/fr/accueil/aide/faq'),
	array('en' => 'http://localhost/anygenes/home/about/about-anygenes', 'fr' => 'http://localhost/anygenes/fr/accueil/infos/infos-anygenes'),
	array('en' => 'http://localhost/anygenes/home/about/distributors', 'fr' => 'http://localhost/anygenes/fr/accueil/infos/distributeurs'),
	array('en' => 'http://localhost/anygenes/home/resources/data-analysis-tools', 'fr' => 'http://localhost/anygenes/fr/accueil/ressources/outils-analyse'),
	array('en' => 'http://localhost/anygenes/home/resources/operating-protocols', 'fr' => 'http://localhost/anygenes/fr/accueil/ressources/protocoles-operatoires'),
);
}

	if (isset($_POST['selection'])) {
	$CHEMINS = getAllChemins();
	$selection = $_POST['selection'];
	$cheminComplet = $_POST['cheminComplet'];
	$opose = 'fr';
	if($selection == 'fr'){
		$opose = 'en';
	}
	$ok = true;
	foreach ($CHEMINS as $chemin) {
		if($chemin[$opose] == $cheminComplet){
			echo $chemin[$selection];
			$ok = false;
			return;
		}
	}
	if($ok){
	echo $cheminComplet;
		return;

	}
	}
