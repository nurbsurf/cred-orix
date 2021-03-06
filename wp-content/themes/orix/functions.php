<?php
/**
 * Orix functions and definitions
 *
 * @package Orix
 */
#flush_rewrite_rules();
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'orix_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function orix_setup() {

		/*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Orix, use a find and replace
     * to change 'orix' to the name of your theme in all the template files
     */
		load_theme_textdomain( 'orix', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'orix' ),
		) );

		/*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
     * Enable support for Post Formats.
     * See http://codex.wordpress.org/Post_Formats
     */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'quote', 'link'
		) );

		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'orix_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
endif; // orix_setup
add_action( 'after_setup_theme', 'orix_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function orix_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'orix' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'orix_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function orix_scripts() {
	wp_enqueue_style( 'orix-style', get_stylesheet_uri() . '?ver=1.3' );

	wp_enqueue_script( 'jQuery', get_template_directory_uri() . '/js/jquery-1.11.1.min.js', array(), '20120206', true );
	wp_enqueue_script( 'twitterBootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '20120206', true );
	wp_enqueue_script( 'orix-navigation', get_template_directory_uri() . '/js/navigation.js', array('jQuery'), '20120206', true );
	wp_enqueue_script( 'parallax', get_template_directory_uri() . '/js/jquery.parallax-1.1.3.js', array('jQuery'), '20140721', true );
	wp_enqueue_script( 'printjs', get_template_directory_uri() . '/js/html2canvas.min.js', array('jQuery'), '20141023', true );



	wp_enqueue_script( 'orix-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array('jQuery'), '20130115', true );
	wp_enqueue_script( 'match-height', get_template_directory_uri() . '/js/jquery.matchHeight.js', array('jQuery'), '20130115', true );

	wp_enqueue_script( 'orix-app', get_template_directory_uri() . '/js/orix.js', array('match-height'), '20140715', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'orix_scripts' );



/**
 *	Limit the character count on excerpts
 */
function string_limit_words($string, $word_limit, $elips = true) {

	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
		array_pop($words);
	if($elips) {
		$showElips = "...";
	}
	return implode(' ', $words) . $showElips;
}

/**
 *	Style login screen
 */
function custom_login_css() {
	echo '<link rel="stylesheet" media="screen" type="text/css" href="'.get_stylesheet_directory_uri().'/style.css" >';
}
//add_action('login_head', 'custom_login_css');

show_admin_bar( false );

function sort_array_by_property( $array, $property ){
    $cur = 1;
    $stack[1]['l'] = 0;
    $stack[1]['r'] = count($array)-1;

    do
    {
        $l = $stack[$cur]['l'];
        $r = $stack[$cur]['r'];
        $cur--;

        do
        {
            $i = $l;
            $j = $r;
            $tmp = $array[(int)( ($l+$r)/2 )];

            // split the array in to parts
            // first: objects with "smaller" property $property
            // second: objects with "bigger" property $property
            do
            {
                while( $array[$i]->{$property} < $tmp->{$property} ) $i++;
                while( $tmp->{$property} < $array[$j]->{$property} ) $j--;

                // Swap elements of two parts if necesary
                if( $i <= $j)
                {
                    $w = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $w;

                    $i++;
                    $j--;
                }

            } while ( $i <= $j );

            if( $i < $r ) {
                $cur++;
                $stack[$cur]['l'] = $i;
                $stack[$cur]['r'] = $r;
            }
            $r = $j;

        } while ( $l < $r );

    } while ( $cur != 0 );

    return $array;

}


/**
 * Remove menu items in admin
 */
function remove_menus(){

	$current_user = wp_get_current_user();

	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);

	if ($user_role == 'administrator') {

	} elseif ($user_role == 'editor') {

	} elseif ($user_role == 'author') {

	} elseif ($user_role == 'contributor' || $user_role == 'revisor') {

		remove_menu_page( 'index.php' );                  //Dashboard
		remove_menu_page( 'edit.php' );                   //Posts
		remove_menu_page( 'upload.php' );                 //Media
		remove_menu_page( 'edit.php?post_type=page' );    //Pages
		remove_menu_page( 'edit-comments.php' );          //Comments
		remove_menu_page( 'themes.php' );                 //Appearance
		remove_menu_page( 'plugins.php' );                //Plugins
		remove_menu_page( 'users.php' );                  //Users
		remove_menu_page( 'tools.php' );                  //Tools
		remove_menu_page( 'options-general.php' );        //Settings
		remove_menu_page( 'edit.php?post_type=capitalsolution' );
		remove_menu_page( 'edit.php?post_type=career' );
		remove_menu_page( 'edit.php?post_type=homepagecta' );
		//remove_menu_page( 'edit.php?post_type=management' );
		remove_menu_page( 'edit.php?post_type=offices' );
		remove_menu_page( 'edit.php?post_type=firm' );
		remove_menu_page( 'admin.php?page=wpcf7' );

		//remove_menu_page( 'edit.php?post_type=provensuccess' );

	} elseif ($user_role == 'subscriber') {

	} else {

	};

}
add_action( 'admin_menu', 'remove_menus' );

/**
 *	Multiple featured images for post
 */
if (class_exists('MultiPostThumbnails')) {
	new MultiPostThumbnails(array(
		'label' => 'Secondary Image',
		'id' => 'secondary-image',
		'post_type' => 'capitalsolution'
	));

	new MultiPostThumbnails(array(
		'label' => 'Secondary Image',
		'id' => 'secondary-image',
		'post_type' => 'page'
	));

	new MultiPostThumbnails(array(
		'label' => 'Secondary Image',
		'id' => 'secondary-image',
		'post_type' => 'career'
	));

	new MultiPostThumbnails(array(
		'label' => 'Secondary Image',
		'id' => 'secondary-image',
		'post_type' => 'firm'
	));
}

/**
 * Get only the url of the thumbnail
 */
function get_the_post_thumbnail_src($img) {
	return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}

/**
 * Add css to admin panel
 */
function custom_colors() {
	echo '<style type="text/css">
			   #wpcontent{ margin-left:220px; };
				 #adminmenuwrap, #adminmenu{ width:200px; }
			 </style>';
};
add_action('wp_head', 'custom_colors');

/**
 * Managemnts link shortcode
 */
function management_func( $atts ) {
	$link= $atts['link'];
	$name = $atts['name'];

	return array("name"=>$name, "link"=>$link);
}
add_shortcode( 'management', 'management_func' );


function my_custom_post_type_archive_where($where,$args){
	$post_type  = isset($args['post_type'])  ? $args['post_type']  : 'post';
	$where = "WHERE post_type = '$post_type' AND post_status = 'publish'";
	return $where;
}
add_filter( 'getarchives_where','my_custom_post_type_archive_where',10,2);


/**
 * Allow vcard upload
 **/
add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {
	// add your extension to the array
	$existing_mimes['vcf'] = 'text/x-vcard';
	return $existing_mimes;
}

/**
 *
 */
function getHero($thumb) {
	//<div class="hero short" style="background-image: url(<?php #echo $secondThumb; #) "></div>
	echo '<img style="margin-bottom:40px; "src="'.$thumb.'">';
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

add_filter( 'wp_mail_from', 'my_mail_from' );
function my_mail_from( $email )
{
	return "bodie.dev@gmail.com";
}


add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
function my_mail_from_name( $name )
{
	return "ORIX";
}

function myplugin_save_post () {
	global $post;

	if ((!defined ("DOING_AUTOSAVE") || !DOING_AUTOSAVE) /*&& get_post_type ($post) == "my_post_type"*/) { // Post type can also be page, post, etc

		$to = "bodie.dev@gmail.com";
		$subject = "Orix post updated";
		$headers = "From: bodie.dev@gmail.com\r\n";
		$headers .= "Reply-To: bodie.dev@gmail.com\r\n";
		$headers .= "CC:\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = '<html><body><table>';
		$message .= '<tr> <td> Notification: ORIX.com was updated. </td> </tr>
			         <tr> <td> Title: '.$post->post_title.' </td></tr>
			         <tr> <td> <a href="'.$post->guid.'">Preview post</a> </td></tr>
			         <tr> <td> <a href="'.get_admin_url().'post.php?post='.$post->ID.'&action=edit">Edit post</a> </td></tr>
			        ';
		$message .= '</table></body></html>';
		$message .= $post;

		wp_mail($to, $subject, $message, $headers);
	}
}

//add_action ("save_post", "myplugin_save_post");


add_action('admin_init', 'contact_form_email');
function contact_form_email() {
	add_settings_field('contact_form_email', 'Contact Form Email', 'contact_form_email_callback_function', 'general', $section = 'default');
	register_setting('general','contact_form_email');
}
function contact_form_email_callback_function() {
	settings_fields( 'general' );
	echo '<input type="text" class="regular-text code" value="'.get_option('contact_form_email').'" id="siteContact Form Email" name="contact_form_email">';
}
