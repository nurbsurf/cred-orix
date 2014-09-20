<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Orix
 */

/*
Template name: Management
*/

get_header(); ?>

	<div class="hero short" style="background-image: url(<?php echo get_template_directory_uri() . '/fpo/hero-careers.jpg' ?>) "></div>

	<div id="content" class="site-content">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<section class='centered'>
			<h1>Our Firm</h1>
			
		</section>

		<?php 
		$qstring = $_REQUEST['filter'];
		if(!empty($qstring)) {
			$appendFilter = "/?filter=" . $qstring;
			$filter = 'firm-'.$_REQUEST['filter'];
			query_posts(array( 'post_type' => 'firm', 'post_status'=>'publish', 'posts_per_page' => -1, 'orderby'=> 'menu_order', 'order' => 'ASC', "firmcategory"=>$filter)); 
		} else {
			query_posts(array( 'post_type' => 'firm', 'post_status'=>'publish', 'posts_per_page' => -1, 'orderby'=> 'menu_order', 'order' => 'ASC')); 
		}
		?>
		<article class="full col-xs-12 col-md-12">
		<div class='holder-bullets row'>
		<?php while (have_posts()) : the_post(); ?>
			<?php

			#$excerpt = get_the_excerpt();
			$excerpt = get_post_meta($post->ID, 'headline', true);
			
			if( get_post_meta($post->ID, 'link', true) ) {
				$bulletCta = BulletCTA::create([
					"icomoon"=> "icon-".get_post_meta($post->ID, 'icon', true),
					"headline"=>get_the_title(),
					"excerpt"=> string_limit_words($excerpt,25),
					"link"=> get_post_meta($post->ID, 'link', true)
				]);

			} else {
				$bulletCta = BulletCTA::create([
					"icomoon"=> "icon-".get_post_meta($post->ID, 'icon', true),
					"headline"=>get_the_title(),
					"excerpt"=> string_limit_words($excerpt,25),
					"link"=> $post->post_name
				]);
			};
			?>
			
		<?php endwhile; ?>
		</div>
		</article>
		<?php #get_template_part( 'content', 'sidebar-firm' ); ?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>