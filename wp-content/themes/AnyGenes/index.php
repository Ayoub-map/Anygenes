<?php
$url = $_SERVER['REQUEST_URI'];
if (strpos($url, '/fr')) {
    get_header('fr');
} else {
    get_header();
}

?>

<?php

include('util.php');
if (endsWith($url, '/fr')) {
    $frontPageBody = include('front-page-body.php');
    echo $frontPageBody;
} else {
?>
    <?php if (have_posts()) : ?>
        <div class="container-fluid">
            <div class="row">
                <?php while (have_posts()) : the_post(); ?>
                    <div class="col-sm-12 col-md-10 offset-md-1">
                        <div>
                            <?php
                            $id_parent = wp_get_post_parent_id($post);
                            if ($id_parent != 0) {
                                if (!strpos($url, '/fr')) {
                                    $ids_page = getCrumbsPage($post, 'en');
                                } else {

                                    $ids_page = getCrumbsPage($post, 'fr');
                                }

                            ?>

                                <div class="crumbs" style="margin-bottom:5px;">
                                    <ul>
                                        <?php
                                        foreach ($ids_page as $id) {
                                            $title = get_the_title($id);
                                            if ($title == 'Signaling Pathways') {
                                                $title = 'Signaling Pathways (SignArrays® System)';
                                            }
                                            if ($title == 'qpcr Mix Sybr Green') {
                                                $title = 'qPCR Master Mix SYBR®  Green';
                                            }
                                            if ($title == 'Pre Amplification') {
                                                $title = 'Preamplification kits (SpeAmp<sup>n</sup> reagents)';
                                            }
                                            if ($title == 'Direct Lysis') {
                                                $title = 'Direct Lysis to SignArrays®';
                                            }
                                            if ($title == 'Mycoplasma Detection Assays MycoDiag') {
                                                $title = '<i>Mycoplasma</i>  Detection Assays (MycoDiag)';
                                            }
                                            if ($title == 'Epigenetic') {
                                                $title = 'Epigenetic Regulation Signaling Pathways';
                                            }
                                            if ($title == 'Analyses matériel biologique') {
                                                $title = 'Analyses avec peu de matériel biologique';
                                            }
                                            if ($title == 'Kits de préamplification') {
                                                $title = 'Kits de préamplification (réactifs SpeAmp<sup>n</sup>)';
                                            }
                                            if ($title == 'Etudes Methylation') {
                                                $title = "Etudes de Methylation de l'ADN";
                                            }
                                            if ($title == 'epigenetique') {
                                                $title = 'Voies de signalisation de  régulation épigénétique';
                                            }
                                            if ($title == 'technologie pyrosequencage') {
                                                $title = "Etudes de méthylation de l'ADN par  la technologie de pyroséquençage";
                                            }
                                            if ($title == 'Faq' || $title == 'FAQ') {
                                                $title = 'Frequently Asked Questions';
                                            }
                                            if ($title == 'Distributors' || $title == 'Distributeurs') {
                                                $title = 'AnyGenes® '.strtolower ($title);
                                            }
                                        ?>
                                            <li><a href='<?php echo get_permalink($id); ?>'><?php echo $title ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>

                            <div class="card-body">
                                <!--h5 class="card-title crumbs"><?php the_title() ?></h5-->
                                <h6 class="card-subtitle mb-2 text-muted"><?php the_category() ?></h6>
                                <p class="card-text"> <?php the_content('Voir more') ?> </p>
                                <a href="<?php the_permalink() ?>" class="card-link"></a>
                                <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php else : ?>
        <h1> Pas d'articles </h1>
<?php endif;
} ?>

<?php get_footer(); ?>