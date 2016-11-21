<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Orix
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
<!-- <link rel="profile" href="http://gmpg.org/xfn/11"> -->
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="/favicon.ico" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>



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
				  'theme_location'  => 'mobile',
				  'menu'            => '',
				  'container'       => '',
				  'container_class' => false,
				  'container_id'    => '',
				  'menu_class'      => 'menu nav-menu mobile-menu',
				  'menu_id'         => 'menu-main-menu',
				  'echo'            => true,
				  'fallback_cb'     => 'wp_page_menu',
				  'before'          => '',
				  'after'           => '',
				  'link_before'     => '',
				  'link_after'      => '',
				  'depth'           => 0,
				  'walker'          => '');
				wp_nav_menu( $mobileMenu );
			?>
				
			<ul id="menu-main-menu" class="menu nav-menu mobile-menu">
			    <li id="menu-item-4747" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4747"><a href="/about/">Our Firm</a></li>
			    <li id="menu-item-4750" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4750"><a href="/capital-solution/real-estate/">Real Estate</a></li>
			    <li id="menu-item-4774" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4774"><a href="/capital-solution/municipal-finance/">Municipal Finance</a></li>
			    <li id="menu-item-4752" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4752"><a href="/capital-solution/asset-management/">Asset Management</a></li>
			    <li id="menu-item-4753" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4753"><a href="/capital-solution/energy/">Energy</a></li>
			    <li id="menu-item-4754" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4754"><a href="/capital-solution/healthcare/">Healthcare</a></li>
			    
			    <li id="menu-item-4756" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4756"><a href="/capital-solution/corporate-development-and-strategic-opportunities/">Corporate Development and Strategic Opportunities</a></li>
			    <li id="menu-item-4757" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4757"><a href="/proven-success/">Proven Success</a></li>
			    <li id="menu-item-4758" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4758"><a href="/news">News</a></li>
			    <li id="menu-item-4759" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4759"><a href="/career/working-at-orix/">Careers</a></li>
			    <li id="menu-item-4760" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4760"><a href="/community">Community</a></li>
			    <li id="menu-item-4761" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4761"><a href="/offices">Contact</a></li>
			</ul>
			
		</nav><!-- #site-navigation -->	

	</header><!-- #masthead -->


