<?php
// require_once('./wp-config.php');

/**
 * Plugin Name: Rest Api AnyGenes
 * Description: How to extent WP RSET api from your custom plugin.
 * Version: 1.0.0
 * Author: upnrunn
 * Author URI: http://www.anygenes.com
 * License: GPL2+
 *
 * @package Rest_Api_AnyGenes
 */


function add_news($request)
{
	$data = $request->get_params();
	global $wpdb;

	if (isset($data['newsTitle']) && isset($data['newsDescription'])) {
		$newsTitle = trim($data['newsTitle']);
		$newsTitle = str_replace("'", "\'", $newsTitle);
		$newsDescription = trim($data['newsDescription']);
		$newsDescription = str_replace("'", "\'", $newsDescription);
		$lang = trim($data['langue']);
		$admin = 'Anygenes Biomarkers';
		$dateInsertion = date_create()->format('Y-m-d H:i');

		$sqlNews = "INSERT INTO `news` (`id`,`title`,`admin`,`dateInsertion`,`newsDescription`,`langue`) VALUES ('','$newsTitle','$admin','$dateInsertion','$newsDescription','$lang')";
		$results = $wpdb->query($sqlNews);

		if ($results == 1) {
			return $newsTitle . ' added Succesfully';
		} else {
			return 'Error happens ! try again';
		}
	}
}

function  updateNews($request)
{
	$data = $request->get_params();
	global $wpdb;
	$newsToUpdate = $data['newsToUpdate'];
	$idNew = $data['idNew'];
	$description = $data['description'];
	$query = $wpdb->prepare("UPDATE news set title=%s,newsDescription =%s  WHERE id=%d", $newsToUpdate, $description, $idNew);
	$result = $wpdb->query($query);

	if ($result == 1) {
		return 'OK';
	} else {
		return 'KO';
	}
}

function deleteNews($request)
{
	$data = $request->get_params();
	global $wpdb;
	$newsToDelete = $data['newsToDelete'];
	$idNew = $data['idNew'];

	$query = $wpdb->prepare("DELETE  FROM news WHERE title=%s and id=%d", $newsToDelete, $idNew);
	$result = $wpdb->query($query);
	if ($result == 1) {
		return 'OK';
	} else {
		return 'KO';
	}
}

function importProduct($request)
{
	global $wpdb;
	$data = $request->get_params();
	if ($_POST['nomProduit'] != " " && $_POST['codeProduit'] != " ") {

		$pathwayName = $data['pathway'];
		$nomFichier = $_FILES['fichierProduit']['name'];
		$typeFichier = $_FILES['fichierProduit']['type'];
		if ($typeFichier != 'application/pdf') {
			$message =  'Error while uploading file (PDF Only) !!';
			$json = '{"status":404, "message": "' . $message . '" }';
			return json_decode($json, true);
		}

		$sizeFichier = $_FILES['fichierProduit']['size'];
		if ($sizeFichier > 2491820) {
			$message = 'Error File Size > 4M0 !!';
			return json_decode('{"status":404, "message":"' . $message . '"}', true);
		}
		$srcFichier = $_FILES['fichierProduit']['tmp_name'];
		$nomProduit = trim($data['nomProduit']);
		if ($pathwayName == 'undefined' || $pathwayName == '') {
			$pathwayName = $nomProduit;
		}

		$oldNomProduit = $nomProduit;
		if (!preg_match("/^(.)*$/", $nomProduit)) {
			$message =  'Error Product Name !!';
			return json_decode('{"status":404, "message":"' . $message . '"}', true);
		}

		$codeProduit = trim($data['codeProduit']);
		if (!preg_match("/^(.)*$/", $codeProduit)) {
			$message = 'Error Product Code !!';
			return json_decode('{"status":404, "message":"' . $message . '"}', true);
		}

		$typePlaque = $data['typePlaque'];
		$typePlaque = intval(str_replace("_", "", $typePlaque));

		$nbrPlaque = $data['nbrPlaque'];
		$nbrPlaque = intval(str_replace("_", "", $nbrPlaque));

		$maladie = $data['maladie'];
		if ($maladie == "-1") {
			$message = 'Enter a Disease for your product';
			return json_decode('{"status":404, "message":"' . $message . '"}', true);
		}

		$espece = $data['espece'];

		$description = $data['description'];

		$nouveau_nomSE = str_replace(" ", "-", $nomProduit);
		//eliminer les espaces du nom du fichier
		$nouveau_codeSE = str_replace(" ", "", $codeProduit);
		$nouveau_nomSE = $nouveau_nomSE . "-" . $nouveau_codeSE;
		$ext = substr(strrchr($_FILES['fichierProduit']['name'], '.'), 1);

		if ($espece != "Mouse" && $espece != "Rat") {
			// si le fichier n'existe pas déjà dans le dossier Human
			if (!file_exists("Files/Human/" . $nouveau_nomSE . "." . $ext)) {
				$res = move_uploaded_file($srcFichier, "Files/Human/" . $nouveau_nomSE . "." . $ext);
			} //fin if existe
			else {
				$message = 'File Already Exists ! Try Another Product Name!';
				return json_decode('{"status":404, "message":"' . $message . '"}', true);
			}
		} //fin if pour Human
		elseif ($espece != "Mouse" && $espece != "Human") {
			// si le fichier n'existe pas déjà dans le dossier Rat
			if (!file_exists("Files/Rat/" . $nouveau_nomSE . "." . $ext)) {
				$res = move_uploaded_file($srcFichier, "Files/Rat/" . $nouveau_nomSE . "." . $ext);
			} //fin if existe
			else {
				$message = 'File Already Exists ! Try Another Product Name';
				return json_decode('{"status":404, "message":"' . $message . '"}', true);
			}
		} //fin if pour Rat
		else {  // si le fichier n'exit pas deja dans le dossier mousse 
			if (!file_exists("Files/Mouse/" . $nouveau_nomSE . "." . $ext)) {
				$res = move_uploaded_file($srcFichier, "Files/Mouse/" . $nouveau_nomSE . "." . $ext);
			} else {
				$message = 'File Already Exists ! Try Another Product Name';
				return json_decode('{"status":404, "message":"' . $message . '"}', true);
			}
		}
	} else {
		$message =  'Error Product Name and Product Code !!';
		return json_decode('{"status":404, "message":"' . $message . '"}', true);
	}

	$nomProduit = str_replace("'", "''", $nomProduit);
	$pathwayName = str_replace("'", "''", $pathwayName);

	switch ($maladie) {
		case 'signaling pathways':
			$query = $wpdb->prepare("SELECT * FROM signaling_pathways WHERE nom=%s", $pathwayName);
			$resultExist = $wpdb->get_results($query);
			if (count($resultExist) == 1) { //si le nom dejà existe dans les Diseases
				//récupérer l'id du produit existant pour une cohérence de jointure avec l'id de la table plaque 
				foreach ($resultExist as $data) {
					$idExiste = intval($data->id_signpath);
				} //fin foreach
				$lastId = $idExiste;
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);

				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée : <br>Pathway Name :" . $pathwayName . "  <br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				break;
			} else {
				$sql = "INSERT INTO signaling_pathways (id_signpath,nom,description,designation) VALUES(NULL,'$pathwayName','$description','designation');";
				$wpdb->query($sql);
				$lastId = $wpdb->insert_id;
				//$idEspece=($espece[0]=='H')?1:2;$idEspece = intval($idEspece);
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);
				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				//echo "typePlaque = ".$typePlaque."<br>"."nbrPlaque = ".$nbrPlaque."<br>"."lastId = ".$lastId."<br>";
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée :<br>Pathway Name :" . $pathwayName . "<br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				//insertion dans le tableau Pathways
				$sqlExistPathway = $wpdb->prepare("SELECT * FROM pathways WHERE nom=%s and disease=%s", $pathwayName, $maladie);
				$resultExistPathway = $wpdb->get_results($sqlExistPathway);
				if (count($resultExistPathway) == 0) //si le pathway n'esite pas
				{
					$sqlPathways = "INSERT INTO pathways (id_pathway,nom,disease) VALUES(NULL,'$pathwayName','Signaling Pathways');";
					$wpdb->query($sqlPathways);

					break;
				} else {
					break;
				}
			}

		case 'neurodegenerative diseases pathways':

			$query = $wpdb->prepare("SELECT * FROM neurodegenerative_diseases_pathways WHERE nom=%s", $pathwayName);
			$resultExist = $wpdb->get_results($query);
			if (count($resultExist) == 1) { //si le nom dejà existe dans les Diseases
				//récupérer l'id du produit existant pour une cohérence de jointure avec l'id de la table plaque 
				foreach ($resultExist as $data) {
					$idExiste = intval($data->id_neuro);
				} //fin foreach
				$lastId = $idExiste;
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);

				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée : <br>Pathway Name :" . $pathwayName . "  <br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				break;
			} else {
				$sql = "INSERT INTO neurodegenerative_diseases_pathways (id_neuro,nom,description,designation) VALUES(NULL,'$pathwayName','$description','designation');";
				$wpdb->query($sql);
				$lastId = $wpdb->insert_id;
				//$idEspece=($espece[0]=='H')?1:2;$idEspece = intval($idEspece);
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);
				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				//echo "typePlaque = ".$typePlaque."<br>"."nbrPlaque = ".$nbrPlaque."<br>"."lastId = ".$lastId."<br>";
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée :<br>Pathway Name :" . $pathwayName . "<br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				//insertion dans le tableau Pathways
				$sqlExistPathway = $wpdb->prepare("SELECT * FROM pathways WHERE nom=%s and disease=%s", $pathwayName, $maladie);
				$resultExistPathway = $wpdb->get_results($sqlExistPathway);
				if (count($resultExistPathway) == 0) //si le pathway n'esite pas
				{
					$sqlPathways = "INSERT INTO pathways (id_pathway,nom,disease) VALUES(NULL,'$pathwayName','Signaling Pathways');";
					$wpdb->query($sqlPathways);
					break;
				} else {
					break;
				}
			}

		case 'autoimmune diseases pathways':

			$query = $wpdb->prepare("SELECT * FROM autoimmune_diseases_pathways WHERE nom=%s", $pathwayName);
			$resultExist = $wpdb->get_results($query);
			if (count($resultExist) == 1) { //si le nom dejà existe dans les Diseases
				//récupérer l'id du produit existant pour une cohérence de jointure avec l'id de la table plaque 
				foreach ($resultExist as $data) {
					$idExiste = intval($data->id_auto);
				} //fin foreach
				$lastId = $idExiste;
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);

				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée : <br>Pathway Name :" . $pathwayName . "  <br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				break;
			} else {
				$sql = "INSERT INTO autoimmune_diseases_pathways (id_auto,nom,description,designation) VALUES(NULL,'$pathwayName','$description','designation');";
				$wpdb->query($sql);
				$lastId = $wpdb->insert_id;
				//$idEspece=($espece[0]=='H')?1:2;$idEspece = intval($idEspece);
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);
				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				//echo "typePlaque = ".$typePlaque."<br>"."nbrPlaque = ".$nbrPlaque."<br>"."lastId = ".$lastId."<br>";
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée :<br>Pathway Name :" . $pathwayName . "<br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				//insertion dans le tableau Pathways
				$sqlExistPathway = $wpdb->prepare("SELECT * FROM pathways WHERE nom=%s and disease=%s", $pathwayName, $maladie);
				$resultExistPathway = $wpdb->get_results($sqlExistPathway);
				if (count($resultExistPathway) == 0) //si le pathway n'esite pas
				{
					$sqlPathways = "INSERT INTO pathways (id_pathway,nom,disease) VALUES(NULL,'$pathwayName','Signaling Pathways');";
					$wpdb->query($sqlPathways);
					break;
				} else {
					break;
				}
			}


		case 'mental disorders pathways':

			$query = $wpdb->prepare("SELECT * FROM mental_disorders_pathways WHERE nom=%s", $pathwayName);
			$resultExist = $wpdb->get_results($query);
			if (count($resultExist) == 1) { //si le nom dejà existe dans les Diseases
				//récupérer l'id du produit existant pour une cohérence de jointure avec l'id de la table plaque 
				foreach ($resultExist as $data) {
					$idExiste = intval($data->id_mental);
				} //fin foreach
				$lastId = $idExiste;
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);

				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée : <br>Pathway Name :" . $pathwayName . "  <br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				break;
			} else {
				$sql = "INSERT INTO mental_disorders_pathways (id_mental,nom,description,designation) VALUES(NULL,'$pathwayName','$description','designation');";
				$wpdb->query($sql);
				$lastId = $wpdb->insert_id;
				//$idEspece=($espece[0]=='H')?1:2;$idEspece = intval($idEspece);
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);
				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				//echo "typePlaque = ".$typePlaque."<br>"."nbrPlaque = ".$nbrPlaque."<br>"."lastId = ".$lastId."<br>";
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée :<br>Pathway Name :" . $pathwayName . "<br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				//insertion dans le tableau Pathways
				$sqlExistPathway = $wpdb->prepare("SELECT * FROM pathways WHERE nom=%s and disease=%s", $pathwayName, $maladie);
				$resultExistPathway = $wpdb->get_results($sqlExistPathway);
				if (count($resultExistPathway) == 0) //si le pathway n'esite pas
				{
					$sqlPathways = "INSERT INTO pathways (id_pathway,nom,disease) VALUES(NULL,'$pathwayName','Signaling Pathways');";
					$wpdb->query($sqlPathways);
					break;
				} else {
					break;
				}
			}
		case 'cancer diseases':

			$query = $wpdb->prepare("SELECT * FROM cancer_diseases WHERE nom=%s", $pathwayName);
			$resultExist = $wpdb->get_results($query);
			if (count($resultExist) == 1) { //si le nom dejà existe dans les Diseases
				//récupérer l'id du produit existant pour une cohérence de jointure avec l'id de la table plaque 
				foreach ($resultExist as $data) {
					$idExiste = intval($data->id_cancer);
				} //fin foreach
				$lastId = $idExiste;
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);

				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée : <br>Pathway Name :" . $pathwayName . "  <br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				break;
			} else {
				$sql = "INSERT INTO cancer_diseases (id_cancer,nom,description,designation) VALUES(NULL,'$pathwayName','$description','designation');";
				$wpdb->query($sql);
				$lastId = $wpdb->insert_id;
				//$idEspece=($espece[0]=='H')?1:2;$idEspece = intval($idEspece);
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);
				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				//echo "typePlaque = ".$typePlaque."<br>"."nbrPlaque = ".$nbrPlaque."<br>"."lastId = ".$lastId."<br>";
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée :<br>Pathway Name :" . $pathwayName . "<br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				//insertion dans le tableau Pathways
				$sqlExistPathway = $wpdb->prepare("SELECT * FROM pathways WHERE nom=%s and disease=%s", $pathwayName, $maladie);
				$resultExistPathway = $wpdb->get_results($sqlExistPathway);
				if (count($resultExistPathway) == 0) //si le pathway n'esite pas
				{
					$sqlPathways = "INSERT INTO pathways (id_pathway,nom,disease) VALUES(NULL,'$pathwayName','Signaling Pathways');";
					$wpdb->query($sqlPathways);
					break;
				} else {
					break;
				}
			}

		case 'other pathology':


			$query = $wpdb->prepare("SELECT * FROM other_pathology WHERE nom=%s", $pathwayName);
			$resultExist = $wpdb->get_results($query);
			if (count($resultExist) == 1) { //si le nom dejà existe dans les Diseases
				//récupérer l'id du produit existant pour une cohérence de jointure avec l'id de la table plaque 
				foreach ($resultExist as $data) {
					$idExiste = intval($data->id_patho);
				} //fin foreach
				$lastId = $idExiste;
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);

				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée : <br>Pathway Name :" . $pathwayName . "  <br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				break;
			} else {
				$sql = "INSERT INTO other_pathology (id_patho,nom,description,designation) VALUES(NULL,'$pathwayName','$description','designation');";
				$wpdb->query($sql);
				$lastId = $wpdb->insert_id;
				//$idEspece=($espece[0]=='H')?1:2;$idEspece = intval($idEspece);
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);
				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				//echo "typePlaque = ".$typePlaque."<br>"."nbrPlaque = ".$nbrPlaque."<br>"."lastId = ".$lastId."<br>";
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée :<br>Pathway Name :" . $pathwayName . "<br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				//insertion dans le tableau Pathways
				$sqlExistPathway = $wpdb->prepare("SELECT * FROM pathways WHERE nom=%s and disease=%s", $pathwayName, $maladie);
				$resultExistPathway = $wpdb->get_results($sqlExistPathway);
				if (count($resultExistPathway) == 0) //si le pathway n'esite pas
				{
					$sqlPathways = "INSERT INTO pathways (id_pathway,nom,disease) VALUES(NULL,'$pathwayName','Signaling Pathways');";
					$wpdb->query($sqlPathways);
					break;
				} else {
					break;
				}
			}


		case 'pharmacological pathways':
			$query = $wpdb->prepare("SELECT * FROM pharmacological_pathways WHERE nom=%s", $pathwayName);
			$resultExist = $wpdb->get_results($query);
			if (count($resultExist) == 1) { //si le nom dejà existe dans les Diseases
				//récupérer l'id du produit existant pour une cohérence de jointure avec l'id de la table plaque 
				foreach ($resultExist as $data) {
					$idExiste = intval($data->id_pharmaco);
				} //fin foreach
				$lastId = $idExiste;
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);

				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée : <br>Pathway Name :" . $pathwayName . "  <br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				break;
			} else {
				$sql = "INSERT INTO pharmacological_pathways (id_pharmaco,nom,description,designation) VALUES(NULL,'$pathwayName','$description','designation');";
				$wpdb->query($sql);
				$lastId = $wpdb->insert_id;
				//$idEspece=($espece[0]=='H')?1:2;$idEspece = intval($idEspece);
				$sqlIdEspece = $wpdb->prepare("SELECT * FROM espece where nom=%s", $espece);
				$resultIdEspece = $wpdb->get_results($sqlIdEspece);
				foreach ($resultIdEspece as $resultId) {
					$idEspece = $resultId->id_espece;
					$idEspece = intval($idEspece);
				}
				//echo "typePlaque = ".$typePlaque."<br>"."nbrPlaque = ".$nbrPlaque."<br>"."lastId = ".$lastId."<br>";
				$sqlplaque = "INSERT INTO plaque (id_plaque,nom,code_plaque,type_plaque,nbr_plaque,id_signpath,id_neuro,id_auto,id_mental,id_cancer,id_patho,id_pharmaco,id_realtime,id_espece) 
                                     VALUES(NULL,'$nomProduit','$codeProduit',$typePlaque,$nbrPlaque,$lastId,0,0,0,0,0,0,0,$idEspece);";
				$wpdb->query($sqlplaque);
				$res = "Produit Ajoutée :<br>Pathway Name :" . $pathwayName . "<br />Product Name:" . $nomProduit . "<br>Product Code :" . $codeProduit . "<br/>Disease :" . $maladie . "<br/>Plaque Type:" . $typePlaque . "<br/>Number of Plate :" . $nbrPlaque . "<br/>Espece :" . $espece;
				//insertion dans le tableau Pathways
				$sqlExistPathway = $wpdb->prepare("SELECT * FROM pathways WHERE nom=%s and disease=%s", $pathwayName, $maladie);
				$resultExistPathway = $wpdb->get_results($sqlExistPathway);
				if (count($resultExistPathway) == 0) //si le pathway n'esite pas
				{
					$sqlPathways = "INSERT INTO pathways (id_pathway,nom,disease) VALUES(NULL,'$pathwayName','Signaling Pathways');";
					$wpdb->query($sqlPathways);
					break;
				} else {
					break;
				}
			}


		default:
			header('Location: index.php');
			exit();
			break;
	} // fin switich 

	$tableCascade = str_replace(" ", "_", $maladie);
	$sqlNumber = "SELECT * FROM $tableCascade";
	$stmt = $wpdb->prepare($sqlNumber);
	$numberOfCascades = $wpdb->get_results($stmt);
	$numberOfCascade = count($numberOfCascades) - 1;
	$res1 = '';
	$res1 .= "
                <section class=\"content-box\">
                  <div class=\"zerogrid\">
                    <div class=\"row \">
                        <table style =\"
                                font-size:15pt;
                                border-radius: 10px;
                                border-width:1px;
                                border: medium solid #b293d8;
                                width: 50%;margin:auto;
                                margin-left:2%;\">
                                <tr text-align:center;><td colspan=\"2\" float=middle; bgcolor=red; style=\"border-radius:1px;\" >Product Added Successfully ! <span class=\"NEW\" style=\"color:red;padding-right:0;background-color:#fff\">NEW !!</span></td></tr>
                            <tr>
                            <td class=tdtd style=\"background-color:rgb(179, 148, 214);font-weight:bold; border-radius:1px;\">Product Name</td>
                            <td class=\"tdtd\" style=\"background-color:#5190D3;border-radius:1px;\">" . $oldNomProduit . "</td>
                            </tr>
                            <tr>
                            <td class=tdtd style=\"background-color:rgb(179, 148, 214);font-weight:bold;border-radius:1px;\">Product Code</td>
                            <td class=\"tdtd\" style=\"background-color:#5190D3;border-radius:1px;\">" . $codeProduit . "</td>
                            </tr >
                            <tr>
                            <td class=tdtd style=\"background-color:rgb(179, 148, 214);font-weight:bold;border-radius:1px;\">Cascade</td>
                            <td class=\"tdtd\" style=\"background-color:#5190D3;border-radius:1px;\">" . $maladie . " <span  style=\"color:red;background-color:#fff;border-radius:5px;\">(Total :" . $numberOfCascade . ") </span></td>
                            </tr>
                             <tr>
                            <td class=tdtd style=\"background-color:rgb(179, 148, 214);font-weight:bold;border-radius:1px;\">Plate type</td>
                            <td class=\"tdtd\" style=\"background-color:#5190D3;border-radius:1px;\">" . $typePlaque . " </td>
                            </tr>
                             <tr>
                            <td class=tdtd style=\"background-color:rgb(179, 148, 214);font-weight:bold;border-radius:1px;\">number of plate</td>
                            <td class=\"tdtd\" style=\"background-color:#5190D3;border-radius:1px;\">" . $nbrPlaque . "</td>
                            </tr>
                            <tr>
                            <td class=tdtd style=\"background-color:rgb(179, 148, 214);font-weight:bold;border-radius:1px;\">Species</td>
                            <td class=\"tdtd\" style=\"background-color:#5190D3;border-radius:1px;\">" . $espece . "<img src=\"http://localhost/anygenes/image/" . $espece . ".png\" alt=\"Species qPCR arrays\"/></td>
                            </tr>

                             </table>
							 ";


	$res1 .= "
	                         <table style =\"
	                            font-size:15pt;
	                            border-radius: 1px;
	                            border-width:1px;
	                            border: medium solid #b293d8;
	                            width: 50%;margin:auto;
	                            margin-left:2%;
	                            margin-bottom:20px;
	                            margin-top:5px;
	                            \">
	                        <tr>
	                             <td class=tdview colspan=\"2\" float=middle; \";>
	                             <a href= \"http://www.anygenes.com/home/add-product-file\" >Add Another Product</a>
	                             </td>
	                            <td class=tdview colspan=\"2\" float=middle; \";><a href=http://www.anygenes.com/home/products/signaling-pathways#main-content> View Catalogue</a></td>
	                        </tr>
	                         </table>
	                         </div>
	                         </div>
	                         </section>
							 ";
	$resultatFinale = new StdClass();
	$resultatFinale->status = 200;
	$resultatFinale->message = $res1;
	return $resultatFinale;
}


function getPathwaysDiseases($request)
{
	global $wpdb;
	$data = $request->get_params();
	$maladie = $data['maladie'];
	$table = str_replace(" ", "_", $maladie);
	$sql = "SELECT * FROM $table ORDER BY nom";
	$pathways = $wpdb->get_results($sql);
	$result = '<p><strong> Products :</strong></p>';
	$i = 1;
	foreach ($pathways as $pathway) {
		if ($pathway->nom != '') {
			$result .= '
                        <input type="radio" id=' . $i . ' name="pathway" value="' . $pathway->nom . '" idPathway= ' . $pathway->id_pathway . ' required/>
                        <label for=' . $i . '>' . $pathway->nom . '</label><br/>';
		}
		$i++;
	} //fin for

	return $result;
}

function getAllSpecies()
{
	global $wpdb;
	$sql = "SELECT * FROM espece";
	$speciesResults = $wpdb->get_results($sql);
	$result = '';
	foreach ($speciesResults as $species) {
		$result .= '<input name="espece" id="' . $species->id_espece . '" type="radio" value="' . $species->nom . '" required>
			<label for="' . $species->id_espece . '">' . $species->nom . ' </label><br/>';
	}
	return $result;
}
function productsFromPlate()
{
	global $wpdb;
	if (isset($_POST['plateName'])) {
		if ($_POST['plateName'] != "-1") {

			$plateName = $_POST['plateName'];
			$sql = 'SELECT code_plaque FROM plaque  WHERE nom="' . $plateName . '"';
			$result = $wpdb->get_results($sql);

			$resultF = '                  
                <select class="col-md-4 form-control-sm form-control" name="productsFromPlateCodes" id="productsFromPlateCodes" onchange="verifierFichier(this)" required>
                <option value="-1">Choose code plaque</option>';


			foreach ($result as $productCodes) {
				$resultF .= '<option value="' . $productCodes->code_plaque . '">' . $productCodes->code_plaque . '</option>';
			}
			$resultF .= '</select>';
			return $resultF;
		} //fin if disease!=1
		else {
			echo '<h5 style="color:red;font-size:10pt;" class="pProduct">-1 Error : please choose a product name to display plate codes.</h5>';
		}
	}
}

function productPlatesName()
{
	global $wpdb;

	if (isset($_POST['product']) && isset($_POST['diseases'])) {
		if ($_POST['product'] != " " && $_POST['diseases'] != " ") {

			$productFromPlate = $_POST['product'];
			$disease  = $_POST['diseases'];
			$table = strtolower(str_replace(" ", "_", $disease));

			$requete2 = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' ";
			$result = $wpdb->get_results($requete2, ARRAY_A);
			$id_table = $result[0]['COLUMN_NAME'];

			$prepared_statement = $wpdb->prepare("SELECT * FROM $table WHERE nom='$productFromPlate'");
			$id = $wpdb->get_col($prepared_statement)[0];

			$sql = "SELECT DISTINCT nom FROM plaque  WHERE $id_table=$id  ORDER BY nom";
			$result = $wpdb->get_results($sql);
			$resultF = '                  
					<select class="col-md-6 form-control form-control-sm" name="productsFromPlate" id="productsFromPlate1" onchange="test(this)" required>
					<option value="-1">Choose product</option>';


			foreach ($result as $product) {
				$resultF .= '<option value="' . $product->nom . '">' . $product->nom . '</option>';
			}
			$resultF .= '</select>';

			return $resultF;
		} //fin if disease!=1
		else {
			echo '<h5 style="color:red;font-size:10pt;" class="pProduct">please choose a product plate</h5>';
		}
	}
}

function getProduct()
{
	global $wpdb;
	if (isset($_POST['disease'])) {
		if ($_POST['disease'] != "-1") {

			$typePath = $_POST['disease'];

			switch ($typePath) {
				case 'Signaling Pathways':
					$sql = 'SELECT * FROM signaling_pathways WHERE id_signpath != 0 ORDER BY nom ';
					break;
				case 'Neurodegenerative diseases pathways':
					$sql = 'SELECT * FROM neurodegenerative_diseases_pathways WHERE id_neuro !=0 ORDER BY nom';
					break;
				case 'Autoimmune diseases pathways':
					$sql = 'SELECT * FROM autoimmune_diseases_pathways WHERE id_auto !=0 ORDER BY nom';
					break;
				case 'Mental disorders pathways':
					$sql = 'SELECT * FROM mental_disorders_pathways WHERE id_mental ORDER BY nom';
					break;
				case 'Cancer diseases':
					$sql = 'SELECT * FROM cancer_diseases WHERE id_cancer !=0 ORDER BY nom';
					break;
				case 'Other pathology':
					$sql = 'SELECT * FROM other_pathology WHERE id_patho != 0 ORDER BY nom';
					break;
				case 'Pharmacological Pathways':
					$sql = 'SELECT * FROM pharmacological_pathways WHERE id_pharmaco !=0 ORDER BY nom';
					break;
				default:
					break;
			} //fin switch
			$result = $wpdb->get_results($sql);

			$resultFinale = '<span style="color:#000">All <strong>' . $_POST['disease'] . '</strong> Products :</span><br/>';
			$i = 1;
			foreach ($result as $products) {

				$resultFinale .= '<span onclick="pProduct(`' .  $products->nom . '`)" class="fa fa-times test" title="' . $products->nom . '" style="color:red; cursor:pointer;" aria-hidden="true"></span><span style="color:red;">' . $i . '</span>
                        <a style="color:#000;font-size:10pt;" href="#" class="pProduct" title="' . $products->nom . '">' . $products->nom . '</a><br/>';
				$i++;
			}
			return $resultFinale;
		} //fin if disease!=1
		else {
			return '<h5 style="color:red;font-size:10pt;" class="pProduct">please choose a disease</h5>';
		}
	}
}

function getAllNews($request)
{
	$data = $request->get_params();
	global $wpdb;
	$langue = $data['langue'];

	$sqlNews = "SELECT * FROM news WHERE langue='" . $langue . "' ORDER BY id DESC";
	$results = $wpdb->get_results($sqlNews);
	$listOfNews = "All News available:<br/>";
	$i = 1;

	$style = $data['type'] == 'delete' ? 'fa-times' : 'fa-exchange';
	$color = $data['type'] == 'delete' ? 'red' : 'yellow';

	foreach ($results as $news) {
		$listOfNews .= '<i style="cursor:pointer; color:' . $color . ';" class="fa ' . $style . ' pNews pr-2" id="' . $news->id . '" title="' . $news->title . '" data="' . $news->newsDescription . '" style="color:red;" aria-hidden="true"></i>' . $i . '
						<a style="color:#fff;font-size:10pt;"  href="#">' . $news->title . '</a><br/>';
		$i++;
	}

	return $listOfNews;
}


function verifierFichier($request)
{

	$result = '';

	if (isset($_POST['nomPlaque']) && isset($_POST['codePlaque'])) {
		if ($_POST['nomPlaque'] != "-1" && $_POST['codePlaque'] != "-1") {
			$nomPlaque = str_replace(" ", "-", $_POST['nomPlaque']);
			$codePlaque = str_replace(" ", "", $_POST['codePlaque']);
			$espece = "";
			$fileName = "";
			switch ($codePlaque[strlen($codePlaque) - 2]) {
				case 'H':
					$espece = 'Human';
					$fileName = "Files/Human/" . $nomPlaque . "-" . $codePlaque . ".pdf";
					break;
				case 'M':
					$espece = 'Mouse';
					$fileName = "Files/Mouse/" . $nomPlaque . "-" . $codePlaque . ".pdf";
					break;
				case 'R':
					$espece = 'Rat';
					$fileName = "Files/Rat/" . $nomPlaque . "-" . $codePlaque . ".pdf";
					break;
				default:
					header('Location : index.php');
					break;
			}

			$fileName = "Files/" . $espece . "/" . $nomPlaque . "-" . $codePlaque . ".pdf";
			if (file_exists($fileName)) {
				$result .= "file exist";
				$result .= '<script type="text/javascript">
					$(document).ready(function() {
						const fileToDelete = "' . $fileName . '";
						
						const nbrInput = $(".finalProductNameToDelete > input").length;
						$(".hiddenFileName").not(":first").remove();
						$(".finalProductNameToDelete").append(\'<input class="hiddenFileName" type="hidden" name="fileToDelete" value="' . $fileName . '" />\');
				
					});
				</script>';
				return $result;
			} else {
				$result .= "affichage du fichier " . $codePlaque[strlen($codePlaque) - 2];
				$result .= "file do not exist";
				return $result;
			}
		} //fin if disease!=1
		else {
			$result .= '<h5 style="color:red;font-size:10pt;" class="pProduct">-1 Error : please choose a product plate code</h5>';
			return $result;
		}
	}
}

function updatePathwaysProducts()
{
	global $wpdb;
	$pathway = $_POST['pathway'];
	$code_plaque = $_POST['codePlaque'];

	$query = $wpdb->prepare("SELECT * FROM  plaque where nom=%s AND code_plaque =%s", $pathway, $code_plaque);
	$result = $wpdb->get_results($query);
	$table = '<br><br><br><div><table align="center" class="table table-bordered table-striped"  style="width:50%" >
                          <thead>
                            <tr>  
                              <th style="padding:15px;">nom</th>
                              <th style="padding:15px;">code plaque</th>
                              <th style="padding:15px;">type plaque</th>
                              <th style="padding:15px;">nombre plaque</th>
                              <th style="padding:15px;">Action</th>
                            </tr>
                          </thead>
                          <tbody>';
	foreach ($result as  $value) {
		$table .= "<tr id=\"1\"><td style=\"padding:15px;\" data-target=\"nom\">" . $value->nom . "</td>";
		$table .= "<td style=\"padding:15px;\" data-target=\"code_plaque\">" . $value->code_plaque . "</td>";
		$table .= "<td style=\"padding:15px; display:none;\" data-target=\"code_plaque1\">" . $value->code_plaque . "</td>";
		$table .= "<td style=\"padding:15px;\" data-target=\"type_plaque\">" . $value->type_plaque . "</td>";
		$table .= "<td style=\"padding:15px;display:none;\" data-target=\"type_plaque1\">" . $value->type_plaque . "</td>";
		$table .= "<td style=\"padding:15px;\" data-target=\"nbr_plaque\">" . $value->nbr_plaque . "</td>";
		$table .= "<td style=\"padding:15px;display:none;\" data-target=\"nbr_plaque1\">" . $value->nbr_plaque . "</td>";
		$table .= "<td style=\"padding:15px;\" ><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal\" data-role=\"update\">update</a></td></tr>";
	}
	$table .= "</tbody></table></div><br><br><br>";

	return $table;
}

function updateProductFinale()
{
	global $wpdb;
	if (
		isset($_POST['code_plaque1']) && isset($_POST['nbr_plaque1'])
		&& isset($_POST['type_plaque1']) && isset($_POST['code_plaque'])
		&& isset($_POST['nom']) && isset($_POST['nbr_plaque'])
		&& isset($_POST['type_plaque'])
	) {
		if (!empty($_FILES['newFile']['name'])) {
			//les informations origine
			$resultatAffichage = "";
			$codePlaqueOrigine = $_POST['code_plaque1'];
			$nbrPlaqueOrigine  = $_POST['nbr_plaque1'];
			$typePlaqueOrigine = $_POST['type_plaque1'];
			$symboleEspece = $codePlaqueOrigine[strlen($codePlaqueOrigine) - 2];
			$productName = $_POST['nom'];
			$srcFichier = $_FILES['newFile']['tmp_name'];

			// le fichier à supprimer 
			$pdfFile = str_replace(" ", "-", $productName . '-' . $codePlaqueOrigine . ".pdf");

			$espece = "";
			switch ($symboleEspece) {
				case 'H':
					$espece = "Human";
					$id_espece = 1;
					break;
				case 'M':
					$espece = "Mouse";
					$id_espece = 2;

					break;

				case 'R':
					$espece = "Rat";
					$id_espece = 3;

					break;

				default:
					# code...
					break;
			}
			$pathFileToDelete = "Files/" . $espece . "/" . $pdfFile;
			//tester l'existance du fichier PDF:
			if (file_exists($pathFileToDelete)) {


				//On va copier le nouveau fichier dans le dossier de l'espece choisie
				//ici on va faire attention on peut par exemple changer le code plaque de XXXH1 
				//vers le code plaque XXXM1 alors on va extraire l'espece choisi de la nouvelle donne choisie par 
				//l'urilisateur 
				// les nouvelles données
				$codePlaque = $_POST['code_plaque'];
				$nbrPlaque  = intval($_POST['nbr_plaque']);
				$typePlaque = intval($_POST['type_plaque']);

				$symboleEspeceNew = $codePlaque[strlen($codePlaque) - 2];

				$especeNew = "";
				switch ($symboleEspeceNew) {
					case 'H':
						$especeNew = "Human";
						$id_especeNew = 1;
						break;
					case 'M':
						$especeNew = "Mouse";
						$id_especeNew = 2;
						break;

					case 'R':
						$especeNew = "Rat";
						$id_especeNew = 3;
						break;

					default:
						# code...
						break;
				}
				//nouvelle nom du fichier :
				$pdfFileNew = str_replace(" ", "-", $productName . '-' . $codePlaque . ".pdf");

				//on va verifier est ce que le produit est deja existe dans notre stock 
				if (!file_exists("Files/" . $especeNew . "/" . $pdfFileNew)) {

					//on va coper le fichier dans le dossier delete
					copy($pathFileToDelete, "Files/fileDeleted/" . $espece . "/" . $pdfFile);
					// on va supprimer le fichier 
					unlink($pathFileToDelete);
					$resultatAffichage .= "<h6 style=color:red>File Deleted " . $pathFileToDelete . "</h6><br>";

					// on transmettre le fichier source dans le chemin de l'espece choisi avec la nouvelle donnée
					move_uploaded_file($srcFichier, "Files/" . $especeNew . "/" . $pdfFileNew);
					$resultatAffichage .= "<h6 style=color:green;>New File added " . "Files/" . $especeNew . "/" . $pdfFileNew . "</h6>";

					//on va tester est ce que la ligne existe dans la base de donnée 

					$sql = $wpdb->prepare(
						'SELECT * FROM plaque WHERE nom=%s 
					AND code_plaque=%d AND type_plaque=%d 
					AND nbr_plaque=%d AND id_espece=%d',
						$productName,
						$codePlaqueOrigine,
						$typePlaqueOrigine,
						$nbrPlaqueOrigine,
						$id_espece
					);

					$result = $wpdb->get_results($sql);
					if (count($result) >= 1) {
						$resultatAffichage .= "<h6  style=color:green> oui  le produit existe dans la base de donnée </h6><br>";
						//maintenant on va faire update pour le prosuit 
						$sql1 = $wpdb->prepare(
							"UPDATE plaque SET code_plaque = %s,
						 type_plaque = %d , nbr_plaque = %d,
						 id_espece = %d WHERE nom = %s AND
						  code_plaque = %d AND nbr_plaque = %d AND
						   type_plaque = %d AND id_espece = %d",
							$codePlaque,
							$typePlaque,
							$nbrPlaque,
							$id_especeNew,
							$productName,
							$codePlaqueOrigine,
							$nbrPlaqueOrigine,
							$typePlaqueOrigine,
							$id_espece
						);
						$wpdb->query($sql1);
					} else {
						// echo "<script type=text/javascript> alert('Error the product exist');</script>";
						$resultatAffichage .= "<h6 style=color:red> Error the product existe </h6>";
					}
				} else {
					$resultatAffichage .= "<script type=text/javascript> alert('Error the product exist');</script>";
					$resultatAffichage .= "<h6 style=color:red> Error the product existe </h6>";
				}
			} else {
				$resultatAffichage .= "<h6 style=color:red>the file not existe Refresh this page  !!!! " . $pathFileToDelete . "</h6>";
			}

			return $resultatAffichage . "</div>";
		} else {
			return "<script type=text/javascript> alert('Choose the file PDF'); </script>";
		}
	}



	$resultatAffichage = "";
	$codePlaqueOrigine = $_POST['code_plaque1'];
	$nbrPlaqueOrigine  = $_POST['nbr_plaque1'];
	$typePlaqueOrigine = $_POST['type_plaque1'];

	$symboleEspece = $codePlaqueOrigine[strlen($codePlaqueOrigine) - 2];

	$productName = $_POST['nom'];
	//le fichier source 
	$srcFichier = $_FILES['newFile']['tmp_name'];


	// le fichier à supprimer 
	$pdfFile = str_replace(" ", "-", $productName . '-' . $codePlaqueOrigine . ".pdf");

	$espece = "";

	return $codePlaqueOrigine;
}

function deleteProducte()
{
	global $wpdb;
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pathway']) && isset($_POST['productsFromPlateCodes'])) {
		$pathway = $_POST['productsFromPlate1'];
		$codePlaque = $_POST['productsFromPlateCodes'];
		$nbrPlaque = intval($_POST['nbrPlaque']);
		$fileToDelete = $_POST['fileToDelete'];
		$fileName = explode("/", $_POST['fileToDelete'])[2];
		$symboleEspece = $codePlaque[strlen($codePlaque) - 2];
		$espece = "";
		$id_espece = 0;
		switch ($symboleEspece) {
			case 'H':
				$espece = "Human";
				$id_espece = 1;
				break;
			case 'M':
				$espece = "Mouse";
				$id_espece = 2;

				break;

			case 'R':
				$espece = "Rat";
				$id_espece = 3;

				break;

			default:
				# code...
				break;
		}
		$stmt = $wpdb->prepare("SELECT * FROM plaque WHERE nom='$pathway' AND code_plaque='$codePlaque' 
		AND nbr_plaque=$nbrPlaque AND id_espece=$id_espece");
		$result = $wpdb->get_results($stmt);
		if (count($result) >= 1) {

			//on va suprimer la ligne du  produit dans la base de donnée la table plaque
			$sql = $wpdb->prepare("DELETE FROM plaque WHERE nom='$pathway' AND code_plaque='$codePlaque' 
			AND nbr_plaque=$nbrPlaque AND id_espece=$id_espece");
			$wpdb->query($sql);
			copy($fileToDelete, "Files/fileDeleted/" . $espece . "/" . $fileName);
			unlink($fileToDelete);
			return "<h6 style=color:green>The file deleted " . $fileToDelete . "</h6><br>";
		} else {
			return "<h6 style=color:red> The File error !!! </h6>";
		}
	} else {
		return '<p style="color:red;"> Select all feild </p>';
	}
}

function deletePathway()
{
	global $wpdb;
	$table = strtolower(str_replace(" ", "_", $_POST['maladie']));
	$disease = $_POST['maladie'];
	$pathway = $_POST['pathway'];

	$requete2 = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' ";
	$result = $wpdb->get_results($requete2, ARRAY_A);
	$id_table = $result[0]['COLUMN_NAME'];


	$prepared_statement = $wpdb->prepare("SELECT * FROM $table WHERE nom='$pathway'");
	$id = $wpdb->get_col($prepared_statement)[0];

	$stmt2 = $wpdb->prepare("SELECT * FROM pathways WHERE nom='$pathway'");
	$id_pathway = $wpdb->get_col($stmt2)[0];
	//supprimer les fichiers PDF de tout les especes.

	$codeplaque = "SELECT *  FROM plaque WHERE  $id_table='$id'";
	$stmt = $wpdb->prepare($codeplaque);
	$result = $wpdb->get_results($stmt);
	$message = '';
	foreach ($result as $value) {
		$codePlaque = $value->code_plaque;
		$nomPlaque = $value->nom;
		$especeChoisie = substr($codePlaque, -2, -1);
		if ($especeChoisie == 'H') {
			$nomFichier = str_replace(" ", "-", $nomPlaque . "-" . $codePlaque . ".pdf");
			$nomFichier = str_replace("\'", "'", $nomFichier);
			$fileToDelete1 = "Files/Human/" . $nomFichier;

			copy($fileToDelete1, "Files/fileDeleted/Human/" . $nomFichier);
			unlink($fileToDelete1);
			$message .= "<h7 style='color:red;'> le PDF est supprimé " . $nomFichier . "</h7><br>";
		} elseif ($especeChoisie == 'M') {
			$nomFichier = str_replace(" ", "-", $nomPlaque . "-" . $codePlaque . ".pdf");
			$nomFichier = str_replace("\'", "'", $nomFichier);
			$fileToDelete1 = "Files/Mouse/" . $nomFichier;

			copy($fileToDelete1, "Files/fileDeleted/Mouse/" . $nomFichier);
			unlink($fileToDelete1);
			$message . "<h7 style='color:red;'> le PDF est supprimé " . $nomFichier . "</h7><br>";
		} else {
			$nomFichier = str_replace(" ", "-", $nomPlaque . "-" . $codePlaque . ".pdf");
			$nomFichier = str_replace("\'", "'", $nomFichier);
			$fileToDelete1 = "Files/Rat/" . $nomFichier;

			copy($fileToDelete1, "Files/fileDeleted/Rat/" . $nomFichier);
			unlink($fileToDelete1);
			$message . "<h7 style='color:red;'> le PDF est supprimé " . $nomFichier . "</h7><br>";
		}
	}

	$wpdb->query("DELETE FROM plaque WHERE $id_table='$id' "); // nom='$pathway' 
	$wpdb->query("DELETE  FROM $table WHERE $id_table='$id' ");
	$wpdb->query("DELETE  FROM intertable WHERE id_pathway='$id_pathway' ");
	$wpdb->query("DELETE  FROM pathways WHERE id_pathway='$id_pathway' ");

	$message .=  "<div style=\"color:green;margin-bottom:10px;margin:auto;width:auto;background-color:rgb(225,225,225);border-radius:10px;\">" . $nomPlaque . " deleted successfully</div>";

	return $message;
}

function getPathways()
{
	global $wpdb;
	$sql = 'SELECT * FROM pathways ORDER BY nom';
	$pathways = $wpdb->get_results($sql);
	$returnResult = '<p><strong> Products :</strong></p>';
	foreach ($pathways as $pathway) {
		$returnResult .= '
        <input type="radio" id=' . $pathway->id_pathway . ' name="pathway" value="' . $pathway->nom . '" idPathway= ' . $pathway->id_pathway . ' required/>
        <label for=' . $pathway->id_pathway . '>' . $pathway->nom . '</label><br/>';
	} //fin for
	return $returnResult;
}

function importGene()
{
	global $wpdb;
	//si l'user clique sur le boutton Add du formulaire
	date_default_timezone_set('Asia/Kolkata');
	include 'excel/PHPExcel/IOFactory.php';
	if (
		isset($_POST['pathway']) && isset($_FILES['fichierCSV'])
		&& isset($_POST['espece'])
	) {
		$espece = trim($_POST['espece']);
		$nomFichier = $_FILES['fichierCSV']['name'];
		$srcFichier = $_FILES['fichierCSV']['tmp_name'];
		$pathway = trim($_POST['pathway']);
		// extraire le nom de  l'espece  pour générer le fichier exacte.
		switch ($espece) {
			case 'Human':
				$pathFile = 'Files/humanGene/' . $nomFichier;
				break;
			case 'Mouse':
				$pathFile = 'Files/mouseGene/' . $nomFichier;
				break;
			case 'Rat':
				$pathFile = 'Files/ratGene/' . $nomFichier;
				break;
			default:
				# code...
				break;
		}
		// ajouter le fichier source dans la nouvelle path
		$res = move_uploaded_file($srcFichier, $pathFile);
		$tableFiche = explode(".", $nomFichier);

		$nameFile = $tableFiche[0];
		try {
			$inputFileType = PHPExcel_IOFactory::identify($pathFile);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($pathFile);
		} catch (Exception $e) {
			return 'Error loading file "' . pathinfo($pathFile, PATHINFO_BASENAME)
				. '": ' . $e->getMessage();
		}
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		//extraire l'id du pathway 
		$stmt = $wpdb->prepare("SELECT * FROM pathways WHERE nom='$pathway'");
		$geneResult = $wpdb->get_results($stmt);

		foreach ($geneResult as  $value) {
			$id_pathway = $value->id_pathway;
		}
		if ($pathway == $nameFile) {
			for ($row = 2; $row <= $highestRow; $row++) {
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				//echoing every cell in the selected row for simplicity. You can save the data in database too.
				$nomGene = trim($rowData[0][0]);
				$refSeq = str_replace(" ", "", trim(strtoupper($rowData[0][1])));

				// on va ajouter au symbole gene le symbole des espece choisie par l'utilisateur (H,L,R)
				switch ($espece) {
					case 'Human':
						$symbolGene = trim(str_replace(" ", "", strtoupper($rowData[0][2] . '_H')));
						break;
					case 'Mouse':
						$symbolGene = trim(str_replace(" ", "", $rowData[0][2] . '_M'));
						break;
					case 'Rat':
						$symbolGene = trim(str_replace(" ", "", $rowData[0][2] . '_R'));
						break;
					default:
						header('Location: index.php');
						exit();
						break;
				}
				$locationChromo = trim($rowData[0][3]);
				$subPathway = trim($rowData[0][4]);

				$stmt = $wpdb->prepare("SELECT * FROM gene WHERE symbol_gene='$symbolGene'");
				$geneResult = $wpdb->get_results($stmt);
				$resultatFianl = '';
				// details :  
				if (count($geneResult) == 1) {
					// si le symbole gene est existe dans la table Gene : ne pas inserer dans la table Gene 

					foreach ($geneResult as  $value) {
						$id_geneNew = $value->id_gene;
					}
					$stmt6 = $wpdb->prepare('SELECT * FROM intertable I JOIN gene G  ON (I.id_gene=G.id_gene) WHERE 
					  id_pathway=%d AND I.id_gene=%d AND symbol_gene=%s  ', $id_pathway, $id_geneNew, $symbolGene);
					$geneResult = $wpdb->get_results($stmt6);


					if (count($geneResult) == 1) {
						$resultatFianl .= "<h6 style=color:red;> /!\ le symbole gene deja existe attention : " . $symbolGene . " /!\ </h6><br>";
					}

					$stmt3 = $wpdb->prepare('SELECT * FROM subPathway WHERE nom=%s', $subPathway);

					$resuet3 = $wpdb->get_results($stmt3);
					$resultatFianl .= "<h6 style=color:green>voila le nom " . $subPathway . "</h6><br>";
					// on va tirer id_gene de cette colonne;
					foreach ($geneResult as  $value) {
						$id_geneNew = $value->id_gene;
					}


					// tester est ce que le sub pathway existe dans la table subpathway
					if (count($resuet3) == 1) {
						// si le subpathway existe dans la table subpathway
						foreach ($resuet3 as  $value) {
							$id_subpathway = $value->id_subpathway;
						}
						// on va continuer 
						// on va verifier est ce que id_pathway est deja dans la table intertable.
						$stmt4 = $wpdb->prepare('SELECT * FROM intertable WHERE id_pathway=%d AND
						 id_gene=%d AND id_subpathway=%d', $id_pathway, $id_geneNew, $id_subpathway);
						$resuet4 = $wpdb->get_results($stmt4);
						if (count($resuet4) == 1) {
							// si le pathway existe avec id_gene et id_subpathway OK !!
							// continuer 
							$resultatFianl .= "<h6 style=color:red>le pathway  existe deja on va pas l'ajouter Merci " . $pathway . " id_gene " . $id_geneNew . " subpathway " . $subPathway . "</h6><br>";
						} else {
							//echo "affichage : Ayouuuuuuuuuuuuuuubb : ".$id_subpathway."<br>";
							$sqlInsertIntertable = $wpdb->prepare('INSERT  INTO `intertable` (`id`,`id_gene`,`id_pathway`,`id_subpathway`) 
								VALUE (NULL,"' . $id_geneNew . '","' . $id_pathway . '","' . $id_subpathway . '");');
							$wpdb->query($sqlInsertIntertable);
						}
					} else {
						// si le subpathway n'existe pas dans la table subpathway
						$sqlInsertSubPath = $wpdb->prepare('INSERT  INTO `subpathway` (`id_subpathway`,`nom`) VALUE (NULL,"' . $subPathway . '");');
						$wpdb->query($sqlInsertSubPath);
						$id_subpathway = $wpdb->insert_id;

						$sqlInsertIntertable = $wpdb->prepare('INSERT  INTO `intertable` (`id`,`id_gene`,`id_pathway`,`id_subpathway`) 
							VALUE (NULL,"' . $id_geneNew . '","' . $id_pathway . '","' . $id_subpathway . '");');
						$wpdb->query($sqlInsertIntertable);
					}
				} else {

					// si le symbole gene n'est pas existe dans la table Gene : onva inserer dans la table Gene + subpath + intertable

					$sqlInsertGene = 'INSERT INTO `gene` (`id_gene`, `nom_gene`, `refseq`, `symbol_gene`,
					 `location_chromosomic`) VALUES
					  (NULL, "' . $nomGene . '","' . $refSeq . '","' . $symbolGene . '","' . $locationChromo . '");';
					$wpdb->query($sqlInsertGene);
					$id_geneNew = $wpdb->insert_id;

					$stmt3 = $wpdb->prepare('SELECT * FROM subPathway WHERE nom=%s', $subPathway);
					$resuet = $wpdb->get_results($stmt3);

					if (count($resuet) == 1) {
						// si le subpathway existe dans la table subpathway

						foreach ($resuet as  $value) {
							$id_subpathway = $value->id_subpathway;
						}

						$sqlInsertIntertable = 'INSERT  INTO `intertable` (`id`,`id_gene`,`id_pathway`,`id_subpathway`) VALUE (NULL,"' . $id_geneNew . '","' . $id_pathway . '","' . $id_subpathway . '");';
						$wpdb->query($sqlInsertIntertable);
					} else {
						//si le subpathway  n'existe pas dans la table subpathway
						$sqlInsertSubPath = 'INSERT  INTO `subpathway` (`id_subpathway`,`nom`) VALUE (NULL,"' . $subPathway . '");';
						$wpdb->query($sqlInsertSubPath);
						$id_subpathway = $wpdb->insert_id;

						$sqlInsertIntertable = 'INSERT  INTO `intertable` (`id`,`id_gene`,`id_pathway`,`id_subpathway`) VALUE (NULL,"' . $id_geneNew . '","' . $id_pathway . '","' . $id_subpathway . '");';
						$wpdb->query($sqlInsertIntertable);
					}
				}
			} // fin for
		} else {
			$res = "<center><h6 style=color:red > the file chosen is incorrect !!!!<br>";
			$res .=  "try again </h6></center>";
			return $res;
		}

		return $resultatFianl;
	} else {
		return '<p style="color:red;"> Erreur Interne</p>';
	}
}


function  getEcosystem()
{
	global $wpdb;
	if ($_POST['delete']) {
		$result = '<script type="text/javascript"> 
$(document).ready(function(){
  $(".pNews").click(function(){
  var newsClicked = $(this).attr("ecosystem");
  $(".ecosystemToDelete").val(newsClicked);
	});
});
</script>';
		$sql = "SELECT * FROM ecosystems";
		$stmt = $wpdb->prepare($sql);
		$result1 = $wpdb->get_results($stmt);
		$result .= "All Ecosystems available:<br/>";
		$i = 1;
		foreach ($result1 as $eco) {
			$result .= '<i onclick="setDeleted(\'' . $eco->ecosystem.'\')" class="fa fa-times pNews" ecosystem="' . $eco->ecosystem . '" style="color:red;" aria-hidden="true"></i>' . $i . '
						<a style="color:#fff;font-size:10pt;" href="#">' . $eco->ecosystem . '</a><br/>';
			$i++;
		}


		return $result;
	} else {
		$sql = "SELECT * FROM ecosystems ";
		$stmt = $wpdb->prepare($sql);
		$ecosystemResults = $wpdb->get_results($stmt);
		$result = '';
		foreach ($ecosystemResults as $ecosystem) {
			$result .= '<input style="margin:5px"; name="ecosystem" id="' . $ecosystem->id . '" type="radio" value="' . $ecosystem->ecosystem . '" required>';
			$result .= '<label for="' . $ecosystem->id . '">' . $ecosystem->ecosystem . '</label>';
		}
		return $result;
	}
}

function importMicrobiota()
{
	date_default_timezone_set('Asia/Kolkata');
	include 'excel/PHPExcel/IOFactory.php';
	global $wpdb;

	$nomFichier = trim($_FILES['fichier']['name']);
	$srcFichier = trim($_FILES['fichier']['tmp_name']);
	$res = move_uploaded_file($srcFichier, "Files/microbiota/" . $nomFichier);
	$pathFile = 'Files/microbiota/' . $nomFichier;

	$ecosystemChoosed = trim($_POST['ecosystem']);
	$organism = trim($_POST['organism']);
	switch ($organism) {
		case 'Human':
			$id_espece = 1;
			break;
		case 'Mouse':
			$id_espece = 2;
			break;
		case 'Rat':
			$id_espece = 3;
			break;

		default:
			# code...
			break;
	}

	try {
		$inputFileType = PHPExcel_IOFactory::identify($pathFile);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($pathFile);
	} catch (Exception $e) {
		die('Error loading file "' . pathinfo($pathFile, PATHINFO_BASENAME)
			. '": ' . $e->getMessage());
	}

	//  Get worksheet dimensions
	$sheet = $objPHPExcel->getSheet(0);
	$highestRow = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();
	$result = '';
	$result .= '<p id="loadingAddGene" style="align:center;color:green;">' . ($highestRow - 1) . ' New lines inserted.<br/>';

	for ($row = 2; $row <= $highestRow; $row++) {
		//  Read a row of data into an array
		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
		//echoing every cell in the selected row for simplicity. You can save the data in database too.
		$phylum = trim($rowData[0][0]);
		$class = trim($rowData[0][1]);
		$ordre = trim($rowData[0][2]);
		$family = trim($rowData[0][3]);
		$genus = trim($rowData[0][4]);
		$species = trim($rowData[0][5]);
		$strain_genome = trim($rowData[0][6]);
		//$ecosystemChoosed = trim($rowData[0][7];);

		//echo $phylum." -- ".$class."<br/>";
		//+++++++++++++++++++++++++++++++++++++++++++++++++++
		$stmt = $wpdb->prepare("SELECT * FROM ecosystems WHERE ecosystem=%s", $ecosystemChoosed);
		$ecosystemResult = $wpdb->get_results($stmt);

		if (count($ecosystemResult) == 1) {
			foreach ($ecosystemResult as $ecosys) {
				$id_ecosystem = $ecosys->id;
			}
		} else {
			// header('Location: importMicrobiota.php');
		}
		$sqlMicrobiota = 'INSERT INTO microbiota (`id`, `phylum`, `class`, `ordre`, `family`, `genus`, `species`, `strain_genome`, `id_ecosystem`,`id_espece`) VALUES(NULL,"' . $phylum . '","' . $class . '","' . $ordre . '","' . $family . '","' . $genus . '","' . $species . '","' . $strain_genome . '","' . $id_ecosystem . '","' . $id_espece . '")';
		$wpdb->query($sqlMicrobiota);
	} //fin foreach*/
	$result .= '<img id="loadingAddGene" style="width:35px;height:35px;display:block;"" src="image/loading.gif" alt="loading"></img>';
	$result .= '
<script type="text/javascript">
$(document).ready(function(){
        //$(".hiddenType").remove();
        $("#loadingAddGene").delay(500).fadeIn(1000);
        $("#loadingAddGene").delay(2000).fadeOut(500);
});
</script>
';

	return $result;
}

function addEcosystem()
{
	global $wpdb;
	$newEcosystem = trim($_POST['newEcosystem']);
	$ecosystemDescription = trim($_POST['ecosystemDescription']);

	$sqlEcosystem = "INSERT INTO `ecosystems` (`id`,`ecosystem`,`description`) VALUES ('','$newEcosystem','$ecosystemDescription')";
	$stmtEcosystem = $wpdb->prepare($sqlEcosystem);
	if ($wpdb->query($stmtEcosystem) == 1) {
		return $newEcosystem . ' added Succesfully';
	} else {
		return 'Error happens ! try again';
	}
}

function delEcosystem(){
	global $wpdb;
	$ecosystemToDelete = $_POST['ecosystemToDelete'];

	$sql = "SELECT * FROM ecosystems where ecosystem= '$ecosystemToDelete'";
	$stmt = $wpdb->prepare($sql);
	$result = $wpdb->get_results($stmt);
	if (count($result) == 1 || count($result) >= 1) {

		$stmtDeleteNews = $wpdb->prepare("DELETE  FROM ecosystems WHERE ecosystem=%s", $ecosystemToDelete);
		$wpdb->query($stmtDeleteNews);
		return  'yes';
	} else {
		return  'no';
	}


}


add_action('rest_api_init', function () {

	register_rest_route('ws', 'addNews/', [
		'methods' => 'POST',
		'callback' => 'add_news'
	]);

	register_rest_route('ws', 'deleteNews/', [
		'methods' => 'POST',
		'callback' => 'deleteNews'
	]);

	register_rest_route('ws', 'updateNews/', [
		'methods' => 'POST',
		'callback' => 'updateNews'
	]);

	register_rest_route('ws', 'getAllNews/', [
		'methods' => 'POST',
		'callback' => 'getAllNews'
	]);

	register_rest_route('ws', 'products/importProduct/', [
		'methods' => 'POST',
		'callback' => 'importProduct'
	]);

	register_rest_route('ws/products', 'getPathwaysDiseases/', [
		'methods' => 'POST',
		'callback' => 'getPathwaysDiseases'
	]);

	register_rest_route('ws/products', 'getAllSpecies/', [
		'methods' => 'GET',
		'callback' => 'getAllSpecies'
	]);

	register_rest_route('ws/products', 'getProduct/', [
		'methods' => 'POST',
		'callback' => 'getProduct'
	]);

	register_rest_route('ws/products', 'productPlatesName/', [
		'methods' => 'POST',
		'callback' => 'productPlatesName'
	]);

	register_rest_route('ws/products', 'productsFromPlate/', [
		'methods' => 'POST',
		'callback' => 'productsFromPlate'
	]);

	register_rest_route('ws/products', 'verifierFichier/', [
		'methods' => 'POST',
		'callback' => 'verifierFichier'
	]);

	register_rest_route('ws/products', 'updatePathwaysProducts/', [
		'methods' => 'POST',
		'callback' => 'updatePathwaysProducts'
	]);
	register_rest_route('ws/products', 'updateProductFinale/', [
		'methods' => 'POST',
		'callback' => 'updateProductFinale'
	]);

	register_rest_route('ws/products', 'deleteProducte/', [
		'methods' => 'POST',
		'callback' => 'deleteProducte'
	]);

	register_rest_route('ws/products', 'deletePathway/', [
		'methods' => 'POST',
		'callback' => 'deletePathway'
	]);

	register_rest_route('ws/products', 'getPathways/', [
		'methods' => 'POST',
		'callback' => 'getPathways'
	]);

	register_rest_route('ws/products', 'importGene/', [
		'methods' => 'POST',
		'callback' => 'importGene'
	]);
	register_rest_route('ws/products', 'getEcosystem/', [
		'methods' => 'POST',
		'callback' => 'getEcosystem'
	]);
	register_rest_route('ws/products', 'importMicrobiota/', [
		'methods' => 'POST',
		'callback' => 'importMicrobiota'
	]);
	register_rest_route('ws/products', 'addEcosystem/', [
		'methods' => 'POST',
		'callback' => 'addEcosystem'
	]);
	register_rest_route('ws/products', 'delEcosystem/', [
		'methods' => 'POST',
		'callback' => 'delEcosystem'
	]);


	register_rest_route('ws/verifierLang2', 'posts/(?P<slug>[a-zA-Z0-9]+)', [
		'methods' => WP_REST_SERVER::CREATABLE,
		'callback' => 'wl_post'
	]);
});
