<link rel='shortcut icon' href='http://localhost/anygenes/favicone.ico' type='image/x-icon'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<meta charset="utf-8">
<?php

$uriApp = 'http://www.anygenes.com/';
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $uriApp = 'http://localhost/anygenes/';
}

//include('head/openSession.php');
if (isset($_POST['retour']) || (isset($_POST['typePath']))) {
    require_once('./wp-config.php');
    global $wpdb;

    if (isset($_POST['retour'])) {
    } else //requete AsynchronousJS demandant les détails sur un tel produit de tel maladie
    {
        $typePath = $_POST['typePath']; //type du produit
        $idProduit = $_POST['idProduit']; //son id dans la base de données
        $nomProduit = $_POST['nomProduit']; //le nom du produit
        $descProduit = $_POST['descProduit']; //une petite description si elle existe.
    } //fin else 
?>



    <!--<section class="content-box boxstyle-3 box-4">
    <div class="row">
      <div class="col-1-1">
        <div class="wrap-col">
            <div class="box-item">-->


    <section class="text-justify container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-sm-8 offset-sm-2  col-xs-12  modal-content-anime" style="border: 0.5px solid #cccccc;">

                    <h1 class="pagetitle" style="margin-left:2%;font-size:15pt; padding-top: 20px;">
                        <?php echo $nomProduit; ?>
                    </h1>

                    <?php
                    if ($descProduit != '')
                        echo '<p style="font-size:12pt;">
                            ' . $descProduit . '
                            </p>';
                    ?>

                    <?php
                    function traduction($mot)
                    {
                        switch ($mot) {
                            case 'Human':
                                return '<em>Homo sapiens</em> (human)';
                                break;
                            case 'Mouse':
                                return  '<em>Mus musculus</em> (mouse)';
                                break;
                            case 'Rat':
                                return  '<em>Rattus norvegicus</em> (rat)';
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                    $reqespece = $wpdb->get_results("SELECT * FROM espece");
                    // iterate over Human and Mouse Espece
                    foreach ($reqespece as $dataespece) {
                        $idespece = $dataespece->id_espece;
                        $nomespece = $dataespece->nom;
                        $designationespece = $dataespece->designation;
                    ?>


                        <br />
                        <h5 style="margin-bottom:5px; ">
                            <u style="font-size:20px; ">
                                <b>Species : <?php echo traduction($nomespece); ?></b>
                            </u>
                        </h5>

                        <p style="width:30px;height:30px;margin-bottom:5px;">
                            <img style="width:30px;height:30px;" src="<?php echo $uriApp; ?>image/<?php echo $nomespece . ".png"; ?>" />
                        </p>
                        <!-- Display Results in the Table -->

                        <table class="table-bordered table text-center table-striped" style="">
                            <tr>
                                <th> <?php echo $typePath; ?> </th>
                                <th>Product ref</th>
                                <th>Informations </th>
                            </tr>

                            <?php
                            // make a switch over different typePaths received from an AJAX Request
                            switch ($typePath) {
                                case 'Signaling Pathways':
                                    $sqlplaque = 'SELECT * FROM plaque where id_signpath=' . $idProduit . '  and id_espece=' . $idespece . ' ORDER BY code_plaque ';
                                    break;
                                case 'Neurodegenerative diseases pathways':
                                    $sqlplaque = 'SELECT * FROM plaque where id_neuro=' . $idProduit . '  and id_espece=' . $idespece . ' ORDER BY code_plaque ';
                                    break;
                                case 'Autoimmune diseases pathways':
                                    $sqlplaque = 'SELECT * FROM plaque where id_auto=' . $idProduit . '  and id_espece=' . $idespece . ' ORDER BY code_plaque ';
                                    break;
                                case 'Mental disorders pathways':
                                    $sqlplaque = 'SELECT * FROM plaque where id_mental=' . $idProduit . '  and id_espece=' . $idespece . ' ORDER BY code_plaque ';
                                    break;
                                case 'Cancer diseases':
                                    $sqlplaque = 'SELECT * FROM plaque where id_cancer=' . $idProduit . '  and id_espece=' . $idespece . ' ORDER BY code_plaque ';
                                    break;
                                case 'Other pathology':
                                    $sqlplaque = 'SELECT * FROM plaque where id_patho=' . $idProduit . '  and id_espece=' . $idespece . ' ORDER BY code_plaque ';
                                    break;
                                case 'Pharmacological Pathways':
                                    $sqlplaque = 'SELECT * FROM plaque where id_pharmaco=' . $idProduit . '  and id_espece=' . $idespece . ' ORDER BY code_plaque ';
                                    break;
                                case 'Real-time PCR Reagents':
                                    $sqlplaque = 'SELECT * FROM plaque where id_realtime=' . $idProduit . '  and id_espece=' . $idespece . ' ORDER BY code_plaque ';
                                    break;
                                default:
                                    //header('Location: catalogue.php');
                                    //exit();
                                    break;
                            } //fin switch

                            // $stmt2 = $conn->prepare($sqlplaque);
                            // $stmt2->execute();
                            // $resultPlaque = $stmt2->fetchAll();
                            $resultPlaque = $wpdb->get_results($sqlplaque);
                            if (count($resultPlaque) == 0) {
                                $nomProduit = trim($nomProduit);
                                if ($nomProduit == "Human Leukocyte Antigen" || $nomProduit == "Oncogenes") {
                                    $nomProduit = ' *******';
                                }

                            ?>

                                <tr>
                                    <td>
                                        <p style="color:black;font-size:11pt; margin:0px;">
                                            <?php echo $nomProduit; ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p style="color:black; margin:0px;">
                                            <span> *******</span>
                                        </p>
                                    </td>
                                    <td style="margin:0px;">
                                        <p style="color:black;font-size:11pt; margin-bottom: 0rem;">
                                            List In progress
                                            <a href="<?php echo $uriApp; ?>home/help/contact.php#contact_us" target="_blank">
                                                <i class="fa fa-cog fa-spin" style="font-size:18px"></i>
                                            </a>
                                            <br>
                                        </p>
                                    </td>
                                </tr>

                                <?php
                            } //end if

                            //iterate over different plaque
                            foreach ($resultPlaque as $dataplaque) {
                                $idplaque = $dataplaque->id_plaque;
                                $nomplaque = $dataplaque->nom;
                                $codeplaque = $dataplaque->code_plaque;
                                $typeplaque = $dataplaque->type_plaque;
                                $nbrplaque = $dataplaque->nbr_plaque;

                                // if plaque is of type 94
                                if ($typeplaque == 96) {

                                ?>
                                    <tr style="height:40px;">
                                        <td style="font-size:11pt; margin:0px;">
                                            <?php echo $nomplaque; ?>
                                        </td>
                                        <td style="font-size:11pt;  margin:0px;">
                                            <?php echo $codeplaque; ?>
                                        </td>
                                        <td style="font-size:11pt;  margin:0px;">
                                            <?php

                                            /*$NomSignPathSansEspace = $nomplaque;
                                                        $longueur = strlen($NomSignPathSansEspace); 
                                                        $nouveau_nom = '';
                                                        $nouveau_nom = str_replace(" ","",$NomSignPathSansEspace);*/
                                            $nomFilePDF = $nomplaque . "-" . $codeplaque;
                                            $nomFile = str_replace(" ", "-", $nomFilePDF);
                                            $filename = "Files/$nomespece/$nomFile.pdf";
                                            //echo $nouveau_nom."".$codeplaque.".pdf";
                                            //echo "fichier *".$filename."*";

                                            if (file_exists(($filename))) {
                                                echo "<a href=\"$uriApp$filename\" target=\"_blank\" ><p style=\"  margin-bottom: 0px; font-size:11pt; \">List infos <i class=\"fa fa-file-pdf-o masterTooltip\" title=\"Show list info\" style=\"font-size:18px;color:#ff0000;\"></i></p></a>";
                                            } else {
                                                echo " <p style=\"color:black;font-stype:bold;font-size:11pt; margin-bottom: 0px; margin-bottom: 0rem;\">List In progress...<a href=\"$uriApphome/help/contact.php#contact_us\" target=\"_blank\"><i class=\"fa fa-cog fa-spin\" style=\"font-size:18px\"></i></a></p>";
                                            }
                                            ?>

                                        </td>

                                <?php
                                } //fin if 96                                                
                            }
                                ?>
                                    </tr>
                        </table>

                    <?php
                    }
                    echo '<br/>';
                    ?>
                    <style type="text/css">
                        .table td,
                        .table th {
                            padding: 5px;
                        }
                    </style>
                </div>
            </div><!-- End Main-Content-->
        </div>
    </section>

<?php

    //mysql_close();
    $conn = null;
} //fin

else {
    header('Location: products/');
    //exit();

}
?>