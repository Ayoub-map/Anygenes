<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.3.1/css/flag-icon.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/magnific-popup.css">

    <link rel='shortcut icon' href='<?php echo get_template_directory_uri(); ?>/favicone.ico' type='image/x-icon'>

    <?php session_start();
    wp_head(); ?>
    <style type="text/css">
        /* li>ul>li>ul .dropdown-menu>li>a {
            position: relative;
            float: right;
            color: red !important;
        } */


        li>ul>li>ul {
            position: sticky;
            margin-left: 100%;
            margin-top: -40px;
            left: 100%;
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

        .popup-triggerr {
            display: block;
            margin: 0 auto;
            padding: 20px;
            max-width: 260px;
            background: #4EBD79;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            line-height: 24px;
            cursor: pointer;
        }

        .popup {
            display: none;
            position: absolute;
            top: 250px;
            left: 50%;
            width: 700px;
            margin-left: -350px;
            padding: 50px 30px;
            background: #fff;
            color: #333;
            font-size: 19px;
            line-height: 30px;
            border: 10px solid #aa6f95;
            z-index: 9999;
        }

        .popup-mobile {
            position: relative;
            top: 0;
            left: 0;
            margin: 30px 0 0;
            width: 100%;
        }

        .popup-btn-close {
            position: absolute;
            top: 8px;
            right: 14px;
            color: #00000;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
        }

        .fa {
            padding: 10px;
            font-size: 20px;
            width: 25px;
            text-align: center;
            text-decoration: none;
            margin: 0;
            padding: 2px;
            border-radius: 50%;
        }

        .fa:hover {
            opacity: 0.7;
        }

        .fa-facebook {
            background: #3B5998;
            color: white;
        }

        .fa-twitter {
            background: #55ACEE;
            color: white;
        }

        .fa-sign-in {
            background: green;
            color: white;
        }

        .fa-sign-out {
            background: #e4e4e4;
            color: #ff1000;
        }

        .fa-linkedin {
            background: #007bb5;
            color: white;
        }

        .white-popup img {
            width: 80px;
            height: 80px;
            margin-top: -80px;
            text-align: center;
            background-color: #e6e6fa;
            border-radius: 90px;
        }

        .hinge {
            animation-duration: 1s;
            animation-name: hinge;
        }

        .buttonLogin {
            background-color: #92278f;
            /* Green */
            border: none;
            color: white;
            padding: 8px 8px;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;

            cursor: pointer;
        }

        .buttonLogin:hover,
        .buttonLogin:focus {
            background-color: #b334af;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 15px;
        }

        .home {
            font-size: 15px;
            font-weight: bold;
        }

        .list-inline {
            margin-bottom: -21px !important;
        }

        /*-------------------------------*/
        @import "compass/css3";
    </style>
</head>

<body>

    <div class="col-1-3 links" style="margin-left: 80%;  margin-top: 0%;margin-bottom:-5px;position: relative;">
        <ul id="inline-popup" class="list-inline top-social wrap-top">
            <li style="margin-top: 3px;">
                <iframe src="https://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.anygenes.com&width=1000&layout=button&action=like&size=small&show_faces=true&share=true&height=20&appId" width="120" height="20" style="border:none;overflow:hidden;" data-adapt-container-width="true" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media" data-show-facepile="false"></iframe>
            </li>
            <li><a class="masterTooltip" title="Facebook" href="https://www.facebook.com/AnyGenes-1067086253429722/" target="_new"><i class="fa fa-facebook"></i></a>
            </li>
            <li><a class="masterTooltip" title="LinkedIn" href="https://www.linkedin.com/company/anygenes/" target="_new"><i class="fa fa-linkedin"></i></a></li>
            <li><a class="masterTooltip" title="Twitter" href="https://twitter.com/anygenes" target="_new"><i class="fa fa-twitter"></i></a></li>
            <li class="login"><a data-target=<?php if (!isset($_SESSION['login'])) {
                                                    echo '"#login-popup"';
                                                } else {
                                                    echo '"#logout-popup"';
                                                } ?> type="button" data-toggle="modal" title="Log in" onclick="clearPopUp()"><i class="fa fa-sign-in"></i></a></li>
            <!--<li class="logout" style="display:none;"><a href="logout.php" class="masterTooltip hinge" title="Log out"><i class="fa fa-sign-out" ></i></a></li>-->
        </ul>
    </div>
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade mt-6" id="logout-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #aa6f95; margin-top: 30%;">
                <center>
                    <div style="width: 80px; height: 80px; border-radius:50%;background-color:#e6e6fa; margin-top:-38px">
                        <img width="80" height="80" src="<?php echo URL;?>/image/user.png" alt="user">
                    </div>
                </center>
                <div class="text-center text-white">
                    <div>
                        <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="text-white">
                        <span> If you want to log out click in LogOut </span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" class="logout" onclick="logout()" style="background-color: #92278f;">Logout</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade mt-6" id="login-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #aa6f95; margin-top: 30%;">
                <center>
                    <div style="width: 80px; height: 80px; border-radius:50%;background-color:#e6e6fa; margin-top:-38px">
                        <img width="80" height="80" src="<?php echo URL;?>/image/user.png" alt="user">
                    </div>
                </center>
                <div class="text-center text-white">
                    <div>
                        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                    </div>
                </div>
                <div class="modal-body">
                    <label for="Email" class="text-white"> Email</label>
                    <input type="mail" id="login" name="login" id="Email" placeholder="Enter Email" class="form-control form-control-sm">

                    <label for="Password" class="text-white pt-3"> Password</label>
                    <input type="password" id="pwd" name="pwd" placeholder="Enter Password" id="Password" class="form-control form-control-sm">
                </div>
                <input type="hidden" id="ANGXP" name="ANGXP" class="rounded" value="OWY4NmQwODE4ODRjN2Q2NTlhMmZlYWEwYzU1YWQwMTVhM2Jm" />
                <span class="error" style="color: red;"></span>
                <span class="valid" style="color: green;"></span>
                <div id="message">

                </div>

                <div class="modal-footer">
                    <a href="<?php echo URL;?>/accueil/register" target="_new" style="padding-right: 200px;">Create account</a>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary btn-sm" style="background-color: #92278f;" onclick="login()">Login</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_SESSION['login'])) {
        ChangeIcon("fa fa-sign-in");

    ?>

        <div class="col-1-3 links" style="margin-right: 60%; margin-bottom:-10px;position: sticky;border-radius: 10px; background-color: #eddeeb; color: purple; max-width: 100px; margin-left:40px;">
            <ul class="list-inline top-social wrap-top">
                <a href="#test-popupProfile" class="hinge" title="<?php echo $_SESSION['nom']; ?>"><span><i class="fa fa-user" aria-hidden="true"></i><?php echo $_SESSION['prenom'] ?></span></a>
            </ul>
        </div>
    <?php
    } else {
        ChangeIcon("fa-sign-out");
    }
    ?>

    <!-- Popup itself -->
    <div id="test-popupProfile" class="white-popup mfp-with-anim mfp-hide">
        <div style="display:block;border-color:steelblue;border:1px;border-radius:5px;width:60%;background-color:#AA6F95 ;margin-left:20%;margin-top:10px;">
            <div>
                <span>hi <?php echo $_SESSION['prenom']; ?></span>
                <a style="color:#000;font-size:11pt;font:FontAwesome" href="<?php echo URL;?>/index.php"> continue visiting your profile </a>

            </div>
        </div>
    </div>

    <!-- Popup itself -->
    <div id="login-popup" class="white-popup mfp-with-anim mfp-hide">
        <center>
            <img src="<?php echo URL;?>/image/user.png" alt="user">
        </center>
        <div class="login" style="border-color:steelblue;border:1px;border-radius:5px;background-color:#AA6F95 ;">
            <form action="<?php echo URL;?>/login.php" method="POST">
                <div class="form-group">
                    <center>
                        <p style="color:#000;font-size:14pt;font-weight:bold; ">Login</p>
                    </center>
                    <span style="color:#fff;font-size:12pt;font-weight:bold; ">Email</span>
                    <div style="display:flex;">
                        <input id="email" placeholder="Enter Email" name="login" type="text" class="form-control" style=" background-color: #eaeafb;" required>
                    </div>
                    <br>
                    <span style="color:#fff;font-size:12pt;font-weight:bold;">Password</span>
                    <div style="display:flex;">
                        <input id="password" name="pwd" type="password" class="form-control" placeholder="Enter Password" style=" background-color: #eaeafb;" required>
                    </div>
                    <!-- <input type="hidden" name="vider" class="rounded" value="vider" /> -->
                </div>
                <center>
                    <input id="register" name="register" class="buttonLogin " type="submit" value="Login"><br />
                </center>
                <a href="<?php echo URL;?>/register.php" class="createAccount">Create account</a><br />
                <a href="#" class="createAccount">Forget password</a>
            </form>
        </div>

        <div class="register" style="display:none;border-color:steelblue;border:1px;border-radius:5px;width:60%;background-color:#AA6F95 ;margin-left:20%;margin-top:20px;">
            <div>
                <form name="frmReset" id="frmReset" method="post" action="sendResetPassword.php">
                    <span style="font-weight: bold;">Reset Password</span><br>
                    <div class="field-group">
                        <span style="font-weight: bold; font-size: 20px;">you forgot your password?</span><br /><br />
                        <p>Please enter your email address that you have used during registration:</p>
                        <div><label for="emailReset">Email</label></div>
                        <div><input type="text" name="emailReset" id="emailReset" placeholder="enter your e-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" class="input-field form-control" title="Enter your e-mail adress and we will send you a link to reset your password" required></div>
                    </div>


                    <div class="field-group">
                        <div><input type="submit" name="reset" id="reset" value="Reset password" class="btn btn-default"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Popup itself -->
    <div id="test-popupLogout" class="white-popup mfp-with-anim mfp-hide">
        <div style="display:block;border-color:steelblue;border:1px;border-radius:5px;width:60%;background-color:#AA6F95 ;margin-left:20%;margin-top:20px;">
            <div>
                <a class="wantToLogout" style="color:#fff;font-size:13pt;" href="#">do you want to Log Out ?</a>
                <div class="continueLogOut" style="display:none;">
                    <a style="color:#fff;font-size:11pt;" href="<?php echo URL;?>/logout.php">Continue Log out</a>
                </div>
            </div>
        </div>
    </div>


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

            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $link = "https";
            } else {
                $link = "http";
            }

            // Here append the common URL characters. 
            $link .= "://";

            // Append the host(domain name, ip) to the URL. 
            $link .= $_SERVER['HTTP_HOST'] . "/anygenes";
            ?>

            <a class="navbar-brand home" href="<?php echo  $link; ?>/index.php">HOME</a>
            <?php
            wp_nav_menu(array(
                'theme_location'    => 'primary',
                'depth'             => 0,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
                'echo'              => true,
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav active',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker()
            ));

            ?>

            <div style="margin-right: 12px;">
                <ul class="nav navbar-nav">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children dropdown menu-item-1691 nav-item">
                        <a class="nav-link">
                            <span class="flag-icon-gb flag-icon" style="padding-right: 10px;"></span><span> EN</span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="choix1" value="en"><a class="dropdown-item"><span class="flag-icon-gb flag-icon" style="margin-right: 10px; margin-left: -10px;"></span>EN</a></li>
                            <li class="choix1" value="fr"><a class="dropdown-item"><span class="flag-icon-fr flag-icon" style="margin-right: 10px; margin-left: -10px;"></span>FR</a></li>
                        </ul>
                    </li>
                </ul>
            </div>


        </div>
    </nav>

    <?php
    function ChangeIcon($from)
    {
        if ($from == 'fa fa-sign-in') {
            echo "<script type=text/javascript> 
                    $(document).ready(function(){
                    $('.login a i').removeClass('fa fa-sign-in');
                    $('.login a').removeClass('hinge');
                    $('.login a').attr('href','#test-popupLogout');
                    $('.login a i').addClass('fa fa-sign-out');
                    $('.login a').attr('title','Log out');
                    });
                    </script>";
        } else {
            echo "<script type=text/javascript> 
                    $(document).ready(function(){
                    $('.login a i').removeClass('fa fa-sign-out');
                    $('.login a i').addClass('fa fa-sign-in');
                    $('.login a').attr('title','Log in');
                    });
                    </script>";
        }
    }


    ?>

    <script type="text/javascript">
        $("#login").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#submit").click();
            }
        });

        $("#pwd").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#submit").click();
            }
        });



        function clearPopUp() {
            var element = document.getElementById("message");
            element.innerHTML = '';
        }

        function login() {
            const uniqid = document.getElementById('ANGXP').value;
            const login = document.getElementById('login').value;
            const pwd = document.getElementById('pwd').value;
            $.ajax({
                url: `<?php echo URL;?>/login.php`,
                type: 'POST',
                data: {
                    uniqid,
                    login,
                    pwd
                },
                success: function(data) {

                    var element = document.getElementById("message");
                    element.innerHTML = data;
                },
                error: function() {}
            });
        }

        function logout() {
            const uniqid = document.getElementById('ANGXP').value;
            $.ajax({
                url: `<?php echo URL;?>/logout.php`,
                type: 'POST',
                data: {
                    uniqid
                },
                success: function(data) {
                    window.location.href = data;
                },
                error: function() {}
            });
        }

        // $(document).on('click', '.logout', function() {

        // })

        $(document).on('click', '.choix1', function() {
            const selection = $(this).attr('value');
            const cheminComplet = document.location.href;
            const NomDuFichier = cheminComplet.substring(cheminComplet.lastIndexOf("/") + 1);
            let data = {
                selection,
                CheminComplet: cheminComplet,
                NomDuFichier
            };
            data = JSON.stringify(data);

            $.ajax({
                url: `<?php echo URL;?>/service-globale/verifierLang.php`,
                type: 'POST',
                data: {
                    selection,
                    cheminComplet
                },
                success: function(data) {
                    window.location.href = data;
                },
                error: function() {}
            });

        });
    </script>