<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Orix
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "//www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<html>

<?php

	//require get_template_directory() . '/modules/Article.php';
	// include all modules
	foreach (glob(get_template_directory() . '/modules/*.php') as $file) {
	  require_once $file;
	};
?>


<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<!-- <link rel="profile" href="//gmpg.org/xfn/11"> -->
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="/favicon.ico" />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" id="orix-style-css" href="/wp-content/themes/orix/style.css?v2.1" type="text/css" media="all">
<link rel="stylesheet" id="orix-print-css" href="/wp-content/themes/orix/print.css" type="text/css" media="print">


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site page">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'orix' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<?php get_template_part( 'content', 'breaking-news' ); ?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>

			<button class="menu-toggle"><i class="fa fa-bars"></i></button>
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' , 'show_home'=>false ) ); ?>

			<?php $mobileMenu = array(
				  'menu'            => 'main-menu',
				  'menu_class'      => 'menu nav-menu mobile-menu',
				  'menu_id'         => 'menu-main-menu',
				  'echo'            => true,
				  'depth'           => 2,
				  'walker'          => '');
				wp_nav_menu( $mobileMenu );
			?>
			
		</nav><!-- #site-navigation -->	

	</header><!-- #masthead -->


