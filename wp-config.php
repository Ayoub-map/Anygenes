<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

 define('URL','http://localhost/anygenes');
//  define('URL','http://www.anygenes.com');

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'db740565030' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ',T)FL+aCi:(f;e;Myj*d&rhT?s=Qtwj:FkWxHdq!cdEw(a~GGri]^lR8N`%TRvm=' );
define( 'SECURE_AUTH_KEY',  'Og#}=K`S=n$b+N.XPyL_La#Kod*3A$Iq/,;/Uc=wVjtLp]?yKh<Wpv_DZ4*j1uK|' );
define( 'LOGGED_IN_KEY',    '6ybs?mPDiO-~j.`BrcIbeAfQ(C0LLpX,9{!,N>`N@Nz;{/AGVu<Egh.mt@.S2:~x' );
define( 'NONCE_KEY',        '<!v.&u*!<H>|)GyU*{:NrRI!#>ItE!hISDHPuG2UkVN}KCCk;/Iy;iY)^$f;H* U' );
define( 'AUTH_SALT',        ';Ua_xv:26Ryv`]S:`pWO.)z<.+MI@1>fP5X0>RcWlj5F]1YzOuKmJ&/Edp:;jObp' );
define( 'SECURE_AUTH_SALT', '@,IH2o~a %:SPdZqC|amcy5P#9^D3L}](dYLwjo6 V-&L&XWKrbPHHcS?N@[pl({' );
define( 'LOGGED_IN_SALT',   ',y2$kB#!fxU{#Cv#Uoh4`F<cx74V ,my7BNgnZZ:NODaX%WYrCKQdGoT<nCEyl/~' );
define( 'NONCE_SALT',       'e)tIaJP2[zjjY]BQGGr3adj$s{6AV7_={7xZ%*+t!Ud5!oKIDa`Ut>NInjh!MR6-' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'T_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
