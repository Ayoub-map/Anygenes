
<?php
if (isset($_POST['idGene']) &&  isset($_POST['nomGene']) && isset($_POST['symbolGene']) && isset($_POST['espece'])) {
    $espece = $_POST['espece'];
    $idGene = $_POST['idGene'];
    $nomGene = $_POST['nomGene'];
    $symbolGene = trim($_POST['symbolGene']);
    require_once('./wp-config.php');
    global $wpdb;



    $query = 'SELECT p.nom as nom, p.disease as disease, s.nom as subpathwaynom From pathways p, intertable i, gene g,subpathway s where i.id_subpathway = s.id_subpathway AND p.id_pathway =i.id_pathway AND g.id_gene = i.id_gene AND symbol_gene like "' . $symbolGene . '" ORDER BY  p.nom';

    $geneResult = $wpdb->get_results($query);

    $symbolGeneTrue = substr($symbolGene, 0, (strlen($symbolGene) - 2));

    if ($espece == 'Human') {
        echo "<br><p style=color:#000;> More information About <strong style=color:red;><a href=http://www.anygenes.com/restSearch.php?query=$symbolGeneTrue&saveForm=Search target=_blank>$symbolGeneTrue</a> </strong><br/>
        <p>";
    }
    $pathwaysOfGene  = array();
    $subPAthwaysOfgene = array();

    for ($i = 0; $i < sizeof($geneResult); $i++) {
        $value = $geneResult[$i];
        $maladie = $value->disease;
        switch ($maladie) {
            case 'Signaling Pathways':
                $disease = 'signaling_pathways';
                $result = $wpdb->get_results("SELECT * FROM signaling_pathways s  where  s.nom=\"$value->nom\"");
                for ($j = 0; $j < sizeof($result); $j++) {
                    $value1 = $result[$j];
                    $id_product = $value1->id_signpath;
                    $description = $value1->description;
                }
                $nomProduct = str_replace(" ", "%20", $value->nom);
                $nomProduct = str_replace("&", "%26", $value->nom);

                $lien = 'http://localhost/anygenes/home/detail-signaling-pathways?typePath=Signaling%20Pathways&idProduit=' . $id_product . '&nomProduit=' . $nomProduct . '&descProduit=' . $description . '';


                break;
            case 'Neurodegenerative Diseases Pathways':

                $disease = 'neurodegenerative_diseases_pathways';
                $result = $wpdb->get_results('SELECT * FROM neurodegenerative_diseases_pathways s  where  s.nom="'.$value->nom.'"');

                for ($j = 0; $j < sizeof($result); $j++) {
                    $value1 = $result[$j];
                    $id_product = $value1->id_neuro;
                    $description = $value1->description;
                }
                $nomProduct = str_replace(" ", "%20", $value->nom);
                $nomProduct = str_replace("&", "%26", $value->nom);

                $lien = 'http://localhost/anygenes/home/detail-signaling-pathways?typePath=Neurodegenerative%20Diseases%20Pathways&idProduit=' . $id_product . '&nomProduit=' . $nomProduct . '&descProduit=' . $description . '';
                break;
            case 'Autoimmune Diseases Pathways':
                $disease = "autoimmune_diseases_pathways";
                $result = $wpdb->get_results('SELECT * FROM autoimmune_diseases_pathways s  where  s.nom=\"$value->nom\"');
                for ($j = 0; $j < sizeof($result); $j++) {
                    $value1 = $result[$j];
                    $id_product = $value1->id_auto;
                    $description = $value1->description;
                }
                $nomProduct = str_replace(" ", "%20", $value->nom);
                $nomProduct = str_replace("&", "%26", $value->nom);

                $lien = 'http://localhost/anygenes/home/detail-signaling-pathways?typePath=Autoimmune%20Diseases%20Pathways&idProduit=' . $id_product . '&nomProduit=' . $nomProduct . '&descProduit=' . $description . '';
                break;
            case 'Mental Disorders Pathways':
                $disease = "mental_disorders_pathways";
                $result = $wpdb->get_results('SELECT * FROM mental_disorders_pathways s  where  s.nom=\"$value->nom\"');
                for ($j = 0; $j < sizeof($result); $j++) {
                    $value1 = $result[$j];
                    $id_product = $value1->id_mental;
                    $description = $value1->description;
                }
                $nomProduct = str_replace(" ", "%20", $value->nom);
                $nomProduct = str_replace("&", "%26", $value->nom);

                $lien = 'http://localhost/anygenes/home/detail-signaling-pathways?typePath=Mental%20Disorders%20Pathways&idProduit=' . $id_product . '&nomProduit=' . $nomProduct . '&descProduit=' . $description . '';
                break;
            case 'Cancer Diseases':
                $disease = "cancer_diseases";
                $result = $wpdb->get_results('SELECT * FROM cancer_diseases s  where  s.nom=\"$value->nom\"');
                for ($j = 0; $j < sizeof($result); $j++) {
                    $value1 = $result[$j];
                    $id_product = $value1->id_patho;
                    $description = $value1->description;
                }
                $nomProduct = str_replace(" ", "%20", $value->nom);
                $nomProduct = str_replace("&", "%26", $value->nom);

                $lien = 'http://localhost/anygenes/home/detail-signaling-pathways?typePath=Cancer%20Diseases&idProduit=' . $id_product . '&nomProduit=' . $nomProduct . '&descProduit=' . $description . '';
                break;
            case 'Other Pathology':
                $disease = "other_pathology";
                $result = $wpdb->get_results('SELECT * FROM other_pathology s  where  s.nom=\"$value->nom\"');
                for ($j = 0; $j < sizeof($result); $j++) {
                    $value1 = $result[$j];
                    $id_product = $value1->id_signpath;
                    $description = $value1->description;
                }
                $nomProduct = str_replace(" ", "%20", $value->nom);
                $nomProduct = str_replace("&", "%26", $value->nom);

                $lien = 'http://localhost/anygenes/home/detail-signaling-pathways?typePath=Other%20Pathology&idProduit=' . $id_product . '&nomProduit=' . $nomProduct . '&descProduit=' . $description . '';
                break;
            case 'Pharmacological Pathways':
                $disease = "pharmacological_pathways";
                $result = $wpdb->get_results('SELECT * FROM pharmacological_pathways s  where  s.nom=\"$value->nom\"');
                for ($j = 0; $j < sizeof($result); $j++) {
                    $value1 = $result[$j];
                    $id_product = $value1->id_signpath;
                    $description = $value1->description;
                }
                $nomProduct = str_replace(" ", "%20", $value->nom);
                $nomProduct = str_replace("&", "%26", $value->nom);

                $lien = 'http://localhost/anygenes/home/detail-signaling-pathways?typePath=Pharmacological%20Pathways&idProduit=' . $id_product . '&nomProduit=' . $nomProduct . '&descProduit=' . $description . '';
                break;
            default:

                // header('Location: catalogue.php');
                exit();
                break;
        }
        $pathwaysOfGene[$i] = "<td style=\"border:1px solid gray;padding:5px;\"><a href=\"" . $lien . "\" target=_blank>" . $value->nom . "</a></td>";
        $subPAthwaysOfgene[$i] = "<td style=\"border:1px solid gray;padding:5px;\">" . $value->subpathwaynom . "</td>";
    }
    // echo $value;

    echo "<table style=\"border:1px solid gray;padding:5px;\" class=\"table-striped\">
    <tr>
    <th style=\"border:1px solid gray;padding:5px;\">Gene Name</th>
    <th style=\"border:1px solid gray;padding:5px;\">Gene Symbol </th>
    <th style=\"border:1px solid gray;padding:5px;\">Pathways </th>
    <th style=\"border:1px solid gray;padding:5px;\">Sub Pathways </th>
    </tr>";
    echo "<tr>
    <td style=\"border:1px solid gray;padding:5px;\" rowspan=" . count($geneResult) . ">
    " . $nomGene . "  </td>" . "
    <td style=\"border:1px solid gray;padding:5px;\" rowspan=
    " . count($geneResult) . ">" . $symbolGeneTrue . "  
    </td>" . $pathwaysOfGene[0] . "" . $subPAthwaysOfgene[0] . " </tr>";
    for ($j = 1; $j < $i; $j++) {
        echo "<tr>" . $pathwaysOfGene[$j] . "" . $subPAthwaysOfgene[$j] . "</tr>";
    }
    echo "</table>";
}

?>