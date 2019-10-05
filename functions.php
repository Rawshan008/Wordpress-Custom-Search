<?php
/**
 * skilltalk functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package skilltalk
 */

if ( ! function_exists( 'skilltalk_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function skilltalk_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on skilltalk, use a find and replace
		 * to change 'skilltalk' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'skilltalk', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'skilltalk' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'skilltalk_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'skilltalk_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function skilltalk_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'skilltalk_content_width', 640 );
}
add_action( 'after_setup_theme', 'skilltalk_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function skilltalk_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'skilltalk' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'skilltalk' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'skilltalk_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function skilltalk_scripts() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'skilltalk-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'jquery.sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array('jquery'), '1.0.0', true );
	
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'skilltalk_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/**
 * Register Custom Post Type People
 */
function create_people_cpt() {

	$labels = array(
		'name' => _x( 'People', 'Post Type General Name', 'skilltalk' ),
		'singular_name' => _x( 'People', 'Post Type Singular Name', 'skilltalk' ),
		'menu_name' => _x( 'People', 'Admin Menu text', 'skilltalk' ),
		'name_admin_bar' => _x( 'People', 'Add New on Toolbar', 'skilltalk' ),
		'archives' => __( 'People Archives', 'skilltalk' ),
		'attributes' => __( 'People Attributes', 'skilltalk' ),
		'parent_item_colon' => __( 'Parent People:', 'skilltalk' ),
		'all_items' => __( 'All Peoples', 'skilltalk' ),
		'add_new_item' => __( 'Add New People', 'skilltalk' ),
		'add_new' => __( 'Add New', 'skilltalk' ),
		'new_item' => __( 'New People', 'skilltalk' ),
		'edit_item' => __( 'Edit People', 'skilltalk' ),
		'update_item' => __( 'Update People', 'skilltalk' ),
		'view_item' => __( 'View People', 'skilltalk' ),
		'view_items' => __( 'View Peoples', 'skilltalk' ),
		'search_items' => __( 'Search People', 'skilltalk' ),
		'not_found' => __( 'Not found', 'skilltalk' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'skilltalk' ),
		'featured_image' => __( 'Featured Image', 'skilltalk' ),
		'set_featured_image' => __( 'Set featured image', 'skilltalk' ),
		'remove_featured_image' => __( 'Remove featured image', 'skilltalk' ),
		'use_featured_image' => __( 'Use as featured image', 'skilltalk' ),
		'insert_into_item' => __( 'Insert into People', 'skilltalk' ),
		'uploaded_to_this_item' => __( 'Uploaded to this People', 'skilltalk' ),
		'items_list' => __( 'Peoples list', 'skilltalk' ),
		'items_list_navigation' => __( 'Peoples list navigation', 'skilltalk' ),
		'filter_items_list' => __( 'Filter Peoples list', 'skilltalk' ),
	);
	$args = array(
		'label' => __( 'People', 'skilltalk' ),
		'description' => __( '', 'skilltalk' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-share-alt',
		'supports' => array('title'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => false,
		'hierarchical' => true,
		'exclude_from_search' => true,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'people', $args );

}
add_action( 'init', 'create_people_cpt', 0 );

/**
 * Texomoni of People
 */
function create_peoplecategory_tax() {

	$labels = array(
		'name'              => _x( 'People Category', 'taxonomy general name', 'skilltalk' ),
		'singular_name'     => _x( 'People Category', 'taxonomy singular name', 'skilltalk' ),
		'search_items'      => __( 'Search People Category', 'skilltalk' ),
		'all_items'         => __( 'All People Category', 'skilltalk' ),
		'parent_item'       => __( 'Parent People Category', 'skilltalk' ),
		'parent_item_colon' => __( 'Parent People Category:', 'skilltalk' ),
		'edit_item'         => __( 'Edit People Category', 'skilltalk' ),
		'update_item'       => __( 'Update People Category', 'skilltalk' ),
		'add_new_item'      => __( 'Add New People Category', 'skilltalk' ),
		'new_item_name'     => __( 'New People Category Name', 'skilltalk' ),
		'menu_name'         => __( 'People Category', 'skilltalk' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( '', 'skilltalk' ),
		'hierarchical' => true,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => false,
		'show_in_quick_edit' => true,
		'show_admin_column' => false,
		'show_in_rest' => true,
		'query_var' => true,
		'show_admin_column' => true,
		
	);
	register_taxonomy( 'categories', array('people'), $args );


	$labels = array(
		'name'              => _x( 'Practice Areas', 'taxonomy general name', 'skilltalk' ),
		'singular_name'     => _x( 'Practice Areas', 'taxonomy singular name', 'skilltalk' ),
		'search_items'      => __( 'Search Practice Areas', 'skilltalk' ),
		'all_items'         => __( 'All Practice Areas', 'skilltalk' ),
		'parent_item'       => __( 'Parent Practice Areas', 'skilltalk' ),
		'parent_item_colon' => __( 'Parent Practice Areas:', 'skilltalk' ),
		'edit_item'         => __( 'Edit Practice Areas', 'skilltalk' ),
		'update_item'       => __( 'Update Practice Areas', 'skilltalk' ),
		'add_new_item'      => __( 'Add New Practice Areas', 'skilltalk' ),
		'new_item_name'     => __( 'New Practice Areas Name', 'skilltalk' ),
		'menu_name'         => __( 'Practice Areas', 'skilltalk' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( '', 'skilltalk' ),
		'hierarchical' => true,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => false,
		'show_in_quick_edit' => true,
		'show_admin_column' => false,
		'show_in_rest' => true,
		'query_var' => true,
		'show_admin_column' => true,
		
	);
	register_taxonomy( 'practiceareas', array('people'), $args );

}
add_action( 'init', 'create_peoplecategory_tax' );



function my_acf_google_map_api( $api ){
	$api['key'] = 'AIzaSyAE50WVxvpGNW2ruXPMpUh7cDEGnXLVSh8';
	return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');


/**
 * Shortcode for form
 */
// function my_people_shortcode($atts){
//     extract( shortcode_atts( array(
//         'count' => -1,
// 	), $atts) );
	
     
	
// 	if($_GET['a_category']){
// 		$category_get = $_GET['a_category'];
// 	}else{
// 		$category_get = '';
// 	}

// 	if($_GET['a_name']){
// 		$title_get = $_GET['a_name'];
// 	}else{
// 		$title_get = '';
// 	}

// 	$tax_query = array('relation'=> 'AND');	
// 	if(!empty($category_get)){
// 		$tax_query[] = array(
// 			'taxonomy' => 'peoplecategory',
// 			'fields' => 'id',
// 			'terms' => $category_get
// 		);
// 	} 

// 	$q = new WP_Query(
//         array(
//             'posts_per_page' => $count, 
// 			'post_type' => 'people',
// 			's' => $title_get,
// 			'tax_query' => $tax_query, 
//         )
// 	);

// 	$list = '';
// 	$list .= '<form action="" class="site-search-form">
// 		<div class="search-element">
// 			<input type="text" name="a_name" value="'.$title_get.'" placeholder="Type Title">
// 		</div>';

// 		$taxonomy_name = 'peoplecategory';
// 		$elements = get_terms( $taxonomy_name, array('hide_empty' => false) );
// 		$cpt_cat_array = array();
	
// 		if ( !empty($elements) ) {
// 			$list .= '<div class="search-element"><select name="a_category" ><option>All Category</option>';
// 			foreach ( $elements as $element ) {
// 				$info = get_term($element, $taxonomy_name);
// 				$cpt_cat_array[ $info->term_id ] = $info->name;
// 				if($category_get == $info->term_id){
// 					$select_markup = 'selected=selected';
// 				}else{
// 					$select_markup = '';
// 				}
// 				$list .='<option '.$select_markup.' value="'.$info->term_id.'">'.$info->name.'</option>';
// 			}
// 			$list .= '</select></div>';
// 		}
// 		$list .='
// 		<div class="search-element">
// 			<input type="submit" name="a_submit" value="Search">
// 		</div>
// 	</form>';
//     $list .= '<div class="custom-post-list">';
//     while($q->have_posts()) : $q->the_post();
//         $idd = get_the_ID();
//         $custom_field = get_post_meta($idd, 'custom_field', true);
//         $post_content = get_the_excerpt();
//         $list .= '
//         <div class="single-people-item">
//             <h2><a href="'.get_permalink().'">' .do_shortcode( get_the_title() ). '</a></h2>
//         </div>
//         ';        
//     endwhile;  
     
     
//     $list.= '</div>';
//     wp_reset_query();
//     return $list;
// }
// add_shortcode('search_people', 'my_people_shortcode');



// add_action( 'wp_ajax_my_ajax_action', 'my_ajax_action' );
// add_action( 'wp_ajax_nopriv_my_ajax_action', 'my_ajax_action' );

// function my_ajax_action(){
	
// 	$q = new WP_Query(
//         array(
//             'posts_per_page' => -1, 
// 			'post_type' => 'people',
// 			'tax_query' => array(
// 				array(
// 					'taxonomy' => 'peoplecategory',
// 					'fields' => 'id',
// 					'terms' => $val
// 				)
// 			) 
//         )
// 	);

// 	$html = '<ul>';
// 		while($q->have_posts()): 
// 			$q->the_post();
// 			$html .= '<li>'.get_the_title().'</li>';
// 		endwhile; wp_reset_query();
// 	$html .= '<ul>';
// 	echo $html;
	
// 	die();
// }

// function my_shortcode(){
// 	$list = '';

	
// 	$list .= '
// 		<button class="click-me">Click Me</button>
// 		<form action="" method="post">
// 			<select name="" id="select-anyone">
// 				<option value="1">One</option>
// 				<option value="3">Two</option>
// 				<option value="4">Three</option>
// 			</select>
// 		</form>
// 		<ul id="info"></ul>
// 		<script>
// 			jQuery(document).ready(function($) {
// 				$(".click-me").on("click", function(){
// 					$.ajax({
// 						url: "'.admin_url('admin-ajax.php').'",
// 						type: "POST",
// 						data: {
// 							action: "my_ajax_action"
// 						},
// 						success: function(html){
// 							$("#info").append(html);
// 						}
// 					})
// 				});
// 				$("#select-anyone").on("change", function(){
// 					var val = this.options[this.selectedIndex].value;
// 					meth = this.form.method;
// 					var params = {};
// 					params[this.name] = val;
// 					$.ajax({
// 						url: "'.admin_url('admin-ajax.php').'",
// 						type: "POST",
// 						data: {
// 							action: "my_ajax_action"
// 						},
// 						success: function(html){
// 							$("#info").append(html);
// 						}
// 					})
// 				})
// 			});
// 		</script
// 		';
// 	return $list;
// }
// add_shortcode('btn_text', 'my_shortcode');

// function wpdocs_register_my_custom_menu_page() {
//     add_menu_page(
//         'Classic Theme Option',
//         'Classic',
//         'manage_options',
//         'ibrahim-classic',
//         'classic_theme_create_page',
//         get_template_directory_uri()."/wp-includes/images/arrow-pointer-blue-2x.png",
//         110
//     );
// }
// add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );


// function classic_theme_create_page(){
// 	echo "This is Title";
// }




function _search_(){
	wp_enqueue_script( 'search-js', get_template_directory_uri() . '/js/search.js', array('jquery'), '1.0.0', true );
	wp_localize_script('search-js','search_url', admin_url('admin-ajax.php'));
}


function my_search_form(){
	_search_();
	$list ='';
	if(!empty($_GET['a_name'])){
		$a_name = $_GET['a_name'];
	}else{
		$a_name = '';
	}

	if(!empty($_GET['categories'])){
		$s_categories = $_GET['categories'];
	}else{
		$s_categories = '';
	}

	if(!empty($_GET['practiceareas'])){
		$s_practiceareas = $_GET['practiceareas'];
	}else{
		$s_practiceareas = '';
	}
	$list .='
		<form action="" id="search-form" class="search-form">
			<div class="search-element">
				<input value="'.$a_name.'" id="a_name" type="text" name="a_name" placeholder="Type Name">
			</div>';
			$categories = get_terms('categories');
			if(!empty($categories) && !is_wp_error($categories)){
				$list .=' <div class="search-element"> <select id="categories" name="categories">
						<option value="">All Categories</option>';
					foreach($categories as $category){
						if($s_categories == $category->term_id){
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}
						$list .='<option '.$selected.' value="'.$category->term_id.'">'.$category->name.'</option>';
					}
				
				$list .= '</select></div>';
			}
			
			$practiceareas = get_terms('practiceareas');
			if(!empty($practiceareas) && !is_wp_error($practiceareas)){
				$list .=' <div class="search-element"> <select id="practiceareas" name="practiceareas">
						<option value="">All PracticAareas</option>';
					
					foreach($practiceareas as $practicearea){
						if($s_practiceareas == $practicearea->term_id){
							$selected = 'selected="selected"';
						}else{
							$selected = '';
						}
						$list .='<option '.$selected.' value="'.$practicearea->term_id.'">'.$practicearea->name.'</option>';
					}
				
				$list .= '</select></div>';
			}
			
			$list .='
			<div class="search-element">
				<button type="submti">Search</button>
			</div>
		</form>
	';

	$list .= '<div id="ourresult"></div>';

	

	return $list;

	echo $decoded = json_decode($_GET['response'],true);

}
add_shortcode('my_search_form','my_search_form');


add_action( 'wp_ajax_snowreports_shortcode', 'snowreports_shortcode' );
add_action( 'wp_ajax_nopriv_snowreports_shortcode', 'snowreports_shortcode' );



function snowreports_shortcode($atts){
	// header("Content-Type: application/josn");
	
    extract( shortcode_atts( array(
        'count' => -1,
	), $atts) );
	
	$list = '';
	
	if(!empty($_GET['a_name'])){
		$a_name = $_GET['a_name'];
	}else{
		$a_name = '';
	}

	if(!empty($_GET['categories'])){
		$s_categories = $_GET['categories'];
	}else{
		$s_categories = '';
	}

	if(!empty($_GET['practiceareas'])){
		$s_practiceareas = $_GET['practiceareas'];
	}else{
		$s_practiceareas = '';
	}

	$tax_query = array('relation' => 'OR');

	if(!empty($s_categories)){
		$tax_query[] = array(
			'taxonomy' => 'categories',
			'fields' => 'id',
			'terms' => $s_categories,
		);
	}

	if(!empty($s_practiceareas)){
		$tax_query[] = array(
			'taxonomy' => 'practiceareas',
			'fields' => 'id',
			'terms' => $s_practiceareas,
		);
	}
	
	$q = new WP_Query(
        array(
			'posts_per_page' => $count,
			'post_type' => 'people',
			's' => $a_name,
			'tax_query' => $tax_query,
        )
	);
    $result ='';
    $list .= '<div class="custom-post-list">';
    while($q->have_posts()) : $q->the_post();
        $list .= '
        <div class="single-post-item">';

			$result .= '
				<div class="single-people">
					<a href="'.get_the_permalink().'"><h2>'.get_the_title().'</h2></a>
				</div>
			';

        $list .= '</div>
        ';        
    endwhile;  
     
     wp_reset_query();
    $list.= '</div>';
   
	
	echo $result;

	die();
}
add_shortcode('people_search', 'snowreports_shortcode');



