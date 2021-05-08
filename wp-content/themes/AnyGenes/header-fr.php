<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='shortcut icon' href='<?php echo get_template_directory_uri(); ?>/favicone.ico' type='image/x-icon'>
    <?php wp_head(); ?>
    <style type="text/css">
        .home {
            font-size: 15px;
            font-weight: bold;
        }


        .dropdown-menu {
            background-color: #AA6F95;
            color: white;
        }

        .dropdown-menu>li>a {
            color: white;
        }

        .dropdown:hover>.dropdown-menu {
            display: block;
        }

        li.menu-item>a.nav-link {
            padding-left: 10px;
            margin-left: 10px;
            color: white !important;
            font-size: 15px;
            font-weight: bold;
        }

        ul>li.menu-item>a.nav-link {
            font-size: 15px;
        }

        @media only screen and (max-width: 768px) {
            .dropdown-menu {
                color: red;
                position: absolute;
                padding-left: 10px;
                display: block;

            }

            .nav-link {
                padding-left: 20px;
                margin-left: 20px;
            }

        }
    </style>
</head>

<body>

    <?php
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    if (has_custom_logo()) {
        echo '<div class="text-center"><img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '"></div>';
    } else {
        echo '<h1>' . get_bloginfo('name') . '</h1>';
    }
    ?>

    <script type="text/javascript">
        jQuery(function($) {
            if ($(window).width() > 769) {
                $('.navbar .dropdown').hover(function() {
                    $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();

                }, function() {
                    $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();

                });

                $('.navbar .dropdown > a').click(function() {
                    location.href = this.href;

                });

            }
        });
    </script>

    <nav class="navbar navbar-expand-md navbar-light bg-anygenes navbar navbar-dark" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php

            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $link = "https";
            else
                $link = "http";

            // Here append the common URL characters. 
            $link .= "://";

            // Append the host(domain name, ip) to the URL. 
            $link .= $_SERVER['HTTP_HOST'] . "/anygenes";


            ?>
            <a class="navbar-brand home" href="<?php echo  $link; ?>/index.php/fr">ACCUEIL</a>
            <?php
            wp_nav_menu(array(
                'theme_location'    => 'secondary',
                'depth'             => 0,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
                'echo'              => true,
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker(),

            ));


            ?>


            <div style="margin-right: 12px;">
                <ul class="nav navbar-nav">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children dropdown menu-item-1691 nav-item">
                        <a class="nav-link">
                            <span class="flag-icon-fr flag-icon"></span>
                            FR</a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="choix1" value="fr"><a class="dropdown-item"><span class="flag-icon-fr flag-icon" style="margin-right: 10px; margin-left: -10px;"></span>FR</a></li>
                            <li class="choix1" value="en"><a class="dropdown-item"><span class="flag-icon-gb flag-icon" style="margin-right: 10px; margin-left: -10px;"></span>EN</a></li>
                        </ul>
                    </li>
                </ul>
            </div>


        </div>
    </nav>


    <script type="text/javascript">
        $(document).on('click', '.choix1', function() {
            const selection = $(this).attr('value');
            const cheminComplet = document.location.href;
            const NomDuFichier = cheminComplet.substring(cheminComplet.lastIndexOf("/") + 1);

            $.ajax({
                url: `http://localhost/anygenes/service-globale/verifierLang.php`,
                data: {
                    selection,
                    cheminComplet
                },
                type: 'POST',
                success: function(data) {
                    window.location.href = data;
                },
                error: function() {}
            });

        });
    </script>