<?php include('../head/openSession.php');
require('../pdo/cnxPDO.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <title>AnyGenes - Adding Genes </title>
        <meta name="description" content="AnyGenes markets high quality qPCR arrays for signaling pathways. You can also send us your samples to be processed in our platform as a low-cost effective service, or personalize your own signaling pathways of specific biomarkers" />
        <meta name="subject" content="AnyGenes markets high quality qPCR arrays for signaling pathways. You can also send us your samples to be processed in our platform as a low-cost effective service, or personalize your own signaling pathways of specific biomarkers" />
        <meta name="googlebot" content="index,follow"/>
        <meta name="robots" content="index,follow"/>
        <meta name="Author" CONTENT="Anygenes team">
        <link rel='shortcut icon' href='images/icone.ico' type='image/x-icon'>
        <meta name="keywords" content="qPCR arrays , signArrays anygenes, high throughput , signaling pathways , biomarkers , cancer , drugs screening , in vitro , statistics, real-time, transcriptome" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" media="all" href="../css2/layout_setup.css" />
        <link rel="stylesheet" type="text/css" media="all" href="../css2/layout_text.css" />
        <link rel="stylesheet" type="text/css" media="all" href="../css2/menu.css"/>

        <script type='text/javascript' src="../ajax/ajax.js"></script>
        <script type='text/javascript' src='../jqueryui/jquery-ui.min.js'></script>
        <script type='text/javascript' src='../jqueryui/dynamic.js'></script>
            <!--style="background-image: url('images/bgimage4.jpg');background-size: 100%;background-repeat:none;" -->
    </head>
    <body>
        <!-- Main Page Container -->
        <div class="page-container" >
            <!-- Header-->
            <div class="header">
                <?php include('../head/loginHead.php');?>
                <div class="header-bottom">
                    <div id="menu">
                        <ul id="nav">
                            <li class="top"><a href="../index.php" class="top_link"><span>HOME</span></a></li>
                            <li class="top"><a href="../catalogue.php" id="contacts" class="top_link"><span>CATALOG</span></a></li>
                            <li class="top"><a href="../molecular_diagnosis.php" id="shop" class="top_link"><span>MOLECULAR DIAGNOSIS</span></a></li>
                            <li class="top"><a href="../service.php" id="services" class="top_link"><span>SERVICES</span></a></li>
                            <li class="top"><a href="../shoppingcart.php" id="privacy" class="top_link"><span>SHOPPING CART</span></a></li>
                            <li class="top"><a href="../about.php" id="about" class="top_link"><span>ABOUT US</span></a></li>
                            <li class="top"><a href="../contact.php" id="contact" class="top_link"><span>CONTACT</span></a></li>
                            <li class="top"><a href="../faqenglish.php" id="contact" class="top_link"><span>FaQ</span></a></li>
                        </ul>
                    </div>
                    <!-- Breadcrumbs -->
                    <div class="header-breadcrumbs">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                        </ul>
                                        </div>   
                   <!-- Main -->
    <div class="main">
    <?php include('../menu/menu.php');?>
    <!-- End Main-->
    <!-- Main Content -->
<div class="main-content">
    <h1 class="pagetitle" style="margin:0 2.4em 0.4em 0;font-size:190%;">Add Gene Data</h1>
<!-- -->
<?php 
///////////////////////////////////////////
//si l'user clique sur le boutton Add du formulaire
date_default_timezone_set('Asia/Kolkata');

include 'PHPExcel/IOFactory.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //récupération des champs du formulaire
        $nomFichier=$_FILES['fichierCSV']['name'];
        $srcFichier=$_FILES['fichierCSV']['tmp_name'];
        $res=move_uploaded_file($srcFichier,"Files/files/".$nomFichier);
        $pathFile = 'Files/files/'.$nomFichier;
        //echo $nomFichier." ---- ".$srcFichier." -- res move ".$res;

//  Read your Excel workbook
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
        
        //  Loop through each row of the worksheet in turn
        for ($row = 2; $row <= $highestRow; $row++) {
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            //echoing every cell in the selected row for simplicity. You can save the data in database too.
            //foreach($rowData[0] as $k=>$CellValue){
                $nomGene = $rowData[0][0];
                $refSeq = $rowData[0][1];
                $symbolGene = $rowData[0][2];
                $locationChromo = $rowData[0][3];
                $subPathway = $rowData[0][4];
                $pathwayGeneNew = $rowData[0][5];

                //echo $nomGene."<br/>";
            }//fin foreach
            echo '<br/><br/>';
        }
//888888888888888888888888888888888888888888888888888888888888888888888888

$row = 1;

if (($handle = fopen($pathFile, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if($row > 1)
        {
//=====================================================================
            $num = count($data);
            $row++;
                $nomGene = trim($data[0]) ;
                $refSeq = trim($data[1]) ;
                $symbolGene = trim($data[2]); 
                $locationChromo = trim($data[3]);
                $subPathway = trim($data[4]);
                $pathwayGeneNew = trim($data[5]);
                echo $nomGene."<br/>";

                    $stmt = $conn->prepare("SELECT * FROM gene WHERE symbol_gene=:symbolGene");
                    $stmt->bindValue(':symbolGene', $symbolGene, PDO::PARAM_STR);
                    $stmt->execute();
                    $geneResult = $stmt->fetchAll();
                    echo "RowCount  =  ".$stmt->rowCount();
                    //exit();
                        //Si le symbol existe deja c'est à dire que le gene est deja associé au qque path
                        if( $stmt->rowCount()==1 )
                        {
                            foreach ($geneResult as $geneRes ) {
                                $idGeneExistant = $geneRes['id_gene'];
                                $pathwayGeneExistant = $geneRes['pathways_gene'];
                                //echo "--- ".$idGeneExistant."---".$pathwayGeneExistant."<br/>";
                            }//fin foreach

                            //si le pathway associé au nouveau gene est different du pathway deja existant
                            //c'est à dire que le gène sera associé au nouveau pathway
                            if( !strpos($pathwayGeneExistant,$pathwayGeneNew) )
                            {
                                $concatPathways = $pathwayGeneExistant.",".$pathwayGeneNew;
                                $conn->exec("UPDATE gene SET pathways_gene='$concatPathways' WHERE id_gene = $idGeneExistant");
                                //selectionner l'id du pathwayNew qu'on vient d'Updater 

                                $stmt2 = $conn->prepare("SELECT * FROM pathways WHERE nom=:nom");
                                $stmt2->bindValue(':nom', $pathwayGeneNew, PDO::PARAM_STR);
                                $stmt2->execute();
                                $pathwaysResult = $stmt2->fetchAll();
                                if($stmt2->rowCount()==1){
                                foreach ($pathwaysResult as $res) {
                                    $idNewPathway = $res['id_pathway'];
                                    }//fin foreach
                                    }//fin if
                            //insert les donnes dans le tableau intermediaires
                            $stmt3 = $conn->prepare("INSERT INTO intertable (id_gene,id_pathway) VALUES($idGeneExistant,$idNewPathway)");
                            $stmt3->execute();

                            }//fin if pathway n'existe pas
                        }
                        //si le symbole du gene n'existe pas on doit l'insérer
                        else
                        {
                            $sqlInsertGene='INSERT INTO `gene` (`id_gene`, `nom_gene`, `refseq`, `symbol_gene`, `location_chromosomic`, `sub_pathway`, `pathways_gene`) VALUES (NULL, "'.$nomGene.'","'.$refSeq.'","'.$symbolGene.'","'.$locationChromo.'","'.$subPathway.'","'.$pathwayGeneNew.'")';

                                if( $conn->exec($sqlInsertGene))
                                {
                                  $lastIdGene = $conn->lastInsertId();
                                  $stmt2 = $conn->prepare("SELECT * FROM pathways WHERE nom=:nom");
                                  $stmt2->bindValue(':nom', $pathwayGeneNew, PDO::PARAM_STR);
                                  $stmt2->execute();
                                  $pathwaysResult = $stmt2->fetchAll();
                                   if(count( $pathwaysResult )==1){
                                     foreach ($pathwaysResult as $res) {
                                        $idNewPathway = $res['id_pathway'];
                                        }//fin foreach
                                        }//fin if
                                  $stmt3 = $conn->prepare("INSERT INTO intertable (id_gene,id_pathway) VALUES($lastIdGene,$idNewPathway)");
                                  $stmt3->execute();
                                } 
                        }//fin else
                        
//=====================================================================  
        }//fin if 1st line
      else{
        $row ++;
      }
//echo "<br/>";
    }//fin while

    fclose($handle);
    echo '<div id="sendDivSuccess" style="display:block;border-radius:40px;background-color:rgb(191,211,241);width:40%;height:50px;font-size:13pt ;font-weight:bold;color:#750E99;margin:auto;padding-top:5px;text-align: center">$nomFichier : Gene Data imported successfully !</div>';

}//fin if
else//erreur d'ouverture du fichier
{
echo '<div  style="display:block;border-radius:40px;background-color:red;width:30;height:30px;font-size:11pt ;font-weight:bold;color:black;margin:auto;padding-top:5px;text-align: center">$nomFichier : error opening file !</div>
    <meta http-equiv="Refresh" content="0;URL=formAddGene.php">
';

}
}//fin if isset

////////////////////////////////////////////


?>
<div class="divGeneForm">

<form  id="formProduct" method="POST" action="formAddGene.php" enctype="multipart/form-data">
<table align="center" cellpadding = "10">
<tr>
<td>CSV Data Gene File</td>
<td><input type="file" accept=".xlsx" name="fichierCSV" maxlength="50" required/>
</td>
</tr>
<tr>
<td colspan="2" align="center">
 <img id='loadingAddProduct' style='width:35px;height:35px;display:none;' src='../images/loading.gif'></img>
 <input type="submit" class="SubmitGene buttonSubmit" value="Import Data Gene">
<input type="reset"  value="Reset">
</td>
</tr>
</table>
</form>
<!--
<form  id="formGene" method="POST" action="formAddGene.php" >

<table align="center" cellpadding = "10">
 


<tr>
<td>Gene Name</td>
<td><input type="text" name="nomGene" id="nomGene" maxlength="50" pattern="[a-zA-Z0-9 _'()-]+" placeholder="Gene Name" required/>
</td>
</tr>
 

<tr>
<td>Gene RefSeq</td>
<td><input type="text" name="refSeq" id="refSeq" maxlength="30" pattern="[a-zA-Z0-9 _'()-.]+" placeholder="exemple:NM_001122.2" required/>
</td>
</tr>


<tr>
<td>Gene Symbol </td>
<td><input type="text" name="symbolGene" id="symbolGene" maxlength="30" pattern="[a-zA-Z0-9]+" placeholder="Gene Symbol" required/>
</td>
</tr>

<tr>
<td>Chromosomic Location </td>
<td><input type="text" name="locationChromo" id="locationChromo" maxlength="30"  placeholder="Chromosomic Location" required/>
</td>
</tr>


<tr>
<td>Sub-Pathway </td>
<td><input type="text" name="subPathway" id="subPathway" maxlength="30"  placeholder="Sub-Pathway" required/>
</td>
</tr>


<tr>
<td>Pathway(s)</td>
 
<td>
    <a href="#" name="pickPath" class="pickPath" >pick up pathways</a>
    <div class="checkboxPathways" style="display:block;height:80px;overflow-y:scroll;"></div>
</td>
</tr>
 
<tr>
<td colspan="2" align="center">
 <img id='loadingAddProduct' style='width:35px;height:35px;display:none;' src='images/loading.gif'></img>
 <input type="submit" class="SubmitGene buttonSubmit" value="Submit Gene">
<input type="reset"  value="Reset">
</td>
</tr>
</table>
</form>
-->
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.pickPath').click( function() {
        //$(".hiddenType").remove();
        //$('#formDeleteProduct2').prepend('<input type=hidden class="hiddenType" name="typePath" value="'+disease+'" />');
        //$(".checkboxPathways").css('display','block');
        //$(this).ajaxStart(function(){$('.loadingProductDisease').css("display","block");});
        $.ajax({
             url: "getPathways.php",
             data: {
             },
             type: 'GET',
                success: function(data){
                $(".checkboxPathways").css('display','block');
                $(".checkboxPathways").html(data);
                },
                error: function(){}
               });
  });

});
</script>

</div><!-- end main content -->

    <!-- FOOTER -->
<div>
    <div class="footer">
        <h5><p><font color="white" >AnyGenes SARL<sup></sup> &nbsp; Hopital TENON - 4 rue de la Chine
                                    75970 
                                    Paris Cedex 20
                                    France&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Copyright &copy; ?php echo date("Y");?></font></p></h5>
                                    </div>
                                   </div>
</div> 
                                                                                

                                                                                </div></div>
                                                                                </body> 
                                                                                </html>
