<?php
	if (isset($_POST['selection'])) {
		//echo "index.php";
		 //header('Location: http://www.anygenes.com/index.php');
		//on va ajouter la langue 
				$userChoise = $_POST['selection'];
				$requestURL = $_POST['CheminComplet'];
				$pathFr = explode("anygenes.com",$requestURL)[1];
				
				$fileName = $_POST['NomDuFichier'];
				if (strpos($fileName, "#")) {
					$fileName=explode("#", $fileName)[0];
				}
				if (strpos($fileName, "?") || (strpos($fileName, "?") && strpos($fileName, "#"))  ) {
					$fileName=explode("?", $fileName)[0];
				}

				switch ($userChoise) {
					case 'en':
					if (strpos($requestURL,"/fr")) {
						switch ($fileName) {
								case 'voies-signalisation.php':
								$requestURL =str_replace($fileName,'signaling-pathways.php', $requestURL);
									break;
								case 'ressources.php':
								$requestURL =str_replace($fileName,'resources.php', $requestURL);
									break;
								case 'produits.php':
								$requestURL =str_replace($fileName,'products.php', $requestURL);
									break;
								case 'analyses-materiel-biologique.php':
								$requestURL =str_replace($fileName,'single-cell-profiling.php', $requestURL);
									break;
								case 'analyse-microbiote.php':
								$requestURL =str_replace($fileName,'microbiota-assays.php', $requestURL);
									break;

								case 'primers-valides-prets-emploi.php':
								$requestURL =str_replace($fileName,'validated-primer-sets.php', $requestURL);
									break;
										
								case 'master-mixe-qpcr.php':
								$requestURL =str_replace($fileName,'qpcr-master-mixes.php', $requestURL);
									break;
										
								case 'services-biomarqueurs.php':
								$requestURL =str_replace($fileName,'biomarker-services.php', $requestURL);
									break;
									
								case 'developpement-molecules-in-vitro.php':
								$requestURL =str_replace($fileName,'in-vitro-drug-development.php', $requestURL);
									break;
								case 'etudes-histoculture.php':
								$requestURL =str_replace($fileName,'histoculture-drug-response-assays.php', $requestURL);
									break;
								case 'identification-validation-biomarqueurs.php':
								$requestURL =str_replace($fileName,'biomarker-identification-validation.php', $requestURL);
									break;
								case 'etudes-methylation.php':
								$requestURL =str_replace($fileName,'methylation-studies.php', $requestURL);
									break;
								case 'analyses-donnees-haut-debit.php':
								$requestURL =str_replace($fileName,'high-Throughput-data-analysis.php', $requestURL);
									break;
									
								case 'technologie-pyrosequencage.php':
								$requestURL =str_replace($fileName,'pyrosequencing-technology.php', $requestURL);
									break;
								case 'epigenetique.php':
								$requestURL =str_replace($fileName,'epigenetic.php', $requestURL);
									break;
									case 'reverse-transcription-start.php':
								$requestURL =str_replace($fileName,'StaRT-reverse-transcription-kits.php', $requestURL);
									break;
								case 'diagnostic-moleculaire.php':
								$requestURL =str_replace($fileName,'molecular-diagnosis.php', $requestURL);
									break;
								case 'infos-anygenes.php':
								$requestURL =str_replace($fileName,'about-anygenes.php', $requestURL);
									break;
								case 'distributeurs.php':
								$requestURL =str_replace($fileName,'distributors.php', $requestURL);
									break;
								case 'Kits-qPCR-LncRNA.php':
								$requestURL =str_replace($fileName,'LncRNA-qPCR-assays.php', $requestURL);
									break;
									case 'kits-LncRNA.php':
								$requestURL =str_replace($fileName,'LncRNA-assays.php', $requestURL);
										break;
								default:
									# code...
									break;
							}

						$requestURLNew = str_replace("/fr","", $requestURL);
						$requestURLNew = str_replace("accueil/produits/","home/products/", $requestURLNew);
						$requestURLNew = str_replace("accueil/ressources/","home/resources/", $requestURLNew);
						$requestURLNew = str_replace("accueil/aide/","home/help/", $requestURLNew);
						$requestURLNew = str_replace("accueil/blog/","home/blog/", $requestURLNew);
						$requestURLNew = str_replace("accueil/infos/","home/about/", $requestURLNew);
						$requestURLNew = str_replace("accueil/services-biomarqueurs/","home/biomarker-services/", $requestURLNew);
						$requestURLNew = str_replace("analyses-materiel-biologique/","single-cell-profiling/", $requestURLNew);
						$requestURLNew = str_replace("master-mixe-qpcr/","qpcr-master-mixes/", $requestURLNew);
						$requestURLNew = str_replace("etudes-methylation/","methylation-studies/", $requestURLNew);

						$requestURLNew = str_replace("accueil/diagnostic-moleculaire/","home/molecular-diagnosis/", $requestURLNew);


						echo $requestURLNew;}
						else{
							echo $requestURL;
						}
						break;
					case 'fr':
						if (strpos($requestURL,"/fr")) {

							echo $requestURL;
						}else{
							switch ($fileName) {
								case 'signaling-pathways.php':
								$pathFr =str_replace($fileName,'voies-signalisation.php', $pathFr);
									break;
									case 'resources.php':
								$pathFr =str_replace($fileName,'ressources.php', $pathFr);
									break;
								case 'products.php':
								$pathFr =str_replace($fileName,'produits.php', $pathFr);
									break;
								case 'single-cell-profiling.php':
								$pathFr =str_replace($fileName,'analyses-materiel-biologique.php', $pathFr);
									break;
								case 'microbiota-assays.php':
								$pathFr =str_replace($fileName,'analyse-microbiote.php', $pathFr);
									break;
								case 'validated-primer-sets.php':
								$pathFr =str_replace($fileName,'primers-valides-prets-emploi.php', $pathFr);
									break;
								case 'qpcr-master-mixes.php':
								$pathFr =str_replace($fileName,'master-mixe-qpcr.php', $pathFr);
									break;
								case 'biomarker-services.php':
								$pathFr =str_replace($fileName,'services-biomarqueurs.php', $pathFr);
									break;
								case 'in-vitro-drug-development.php':
								$pathFr =str_replace($fileName,'developpement-molecules-in-vitro.php', $pathFr);
									break;
								case 'histoculture-drug-response-assays.php':
								$pathFr =str_replace($fileName,'etudes-histoculture.php', $pathFr);
									break;
								case 'biomarker-identification-validation.php':
								$pathFr =str_replace($fileName,'identification-validation-biomarqueurs.php', $pathFr);
									break;
								case 'methylation-studies.php':
								$pathFr =str_replace($fileName,'etudes-methylation.php', $pathFr);
									break;
								case 'high-Throughput-data-analysis.php':
								$pathFr =str_replace($fileName,'analyses-donnees-haut-debit.php', $pathFr);
									break;
								case 'pyrosequencing-technology.php':
								$pathFr =str_replace($fileName,'technologie-pyrosequencage.php', $pathFr);
									break;
								case 'epigenetic.php':
								$pathFr =str_replace($fileName,'epigenetique.php', $pathFr);
									break;
								case 'StaRT-reverse-transcription-kits.php':
								$pathFr =str_replace($fileName,'reverse-transcription-start.php', $pathFr);
									break;  

								case 'molecular-diagnosis.php':
								$pathFr =str_replace($fileName,'diagnostic-moleculaire.php', $pathFr);
									break;
								case 'about-anygenes.php':
								$pathFr =str_replace($fileName,'infos-anygenes.php', $pathFr);
									break;
								case 'distributors.php':
								$pathFr =str_replace($fileName,'distributeurs.php', $pathFr);
									break;
								case 'LncRNA-qPCR-assays.php':
								$pathFr =str_replace($fileName,'Kits-qPCR-LncRNA.php', $pathFr);
									break;
									case 'LncRNA-assays.php':
								$pathFr =str_replace($fileName,'kits-LncRNA.php', $pathFr);
								break;

								/*case 'signaling-pathways.php':
								$pathFr =str_replace($fileName,'voies-de-signalisation.php', $pathFr);
									break;*/
								
								default:
									# code...
									break;
							}

							$pathFr = str_replace("home/products/","accueil/produits/", $pathFr);
						$pathFr = str_replace("home/resources/","accueil/ressources/", $pathFr);
						$pathFr = str_replace("home/about/","accueil/infos/", $pathFr);
						$pathFr = str_replace("home/help/","accueil/aide/", $pathFr);
						$pathFr = str_replace("home/biomarker-services/","accueil/services-biomarqueurs/", $pathFr);
						$pathFr = str_replace("home/blog/","accueil/blog/", $pathFr);
						$pathFr = str_replace("single-cell-profiling/","analyses-materiel-biologique/", $pathFr);
						$pathFr = str_replace("qpcr-master-mixes/","master-mixe-qpcr/", $pathFr);
						$pathFr = str_replace("methylation-studies/","etudes-methylation/", $pathFr);

						$pathFr = str_replace("home/molecular-diagnosis/","accueil/diagnostic-moleculaire/", $pathFr);



							echo "http://www.anygenes.com/fr".$pathFr;
						}
						
					break;
					
					default:
						# code...
						break;
				}
				
	}
?>