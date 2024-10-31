<?php

/*
 * Plugin Name: RubSum
 * Plugin URI:  https://www.wordpress.org/plugins/rubsum
 * Description: This is very usefull plugin for you. You can use this for your multiple much needed functionality for your website Employees. Please note (Updates will come for better experience)
 * Version:     1.0.0
 * Author:      Mohammad Rubel Hossain
 * Author URI:  https://profiles.wordpress.org/rubelbdp/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: rubsum_info
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;


class Employee{

	public function __construct(){

		//required files

		if( file_exists( dirname(__FILE__) . '/metabox/init.php' ) ){
			require_once( dirname(__FILE__) . '/metabox/init.php');
		}

		if( file_exists( dirname(__FILE__) . '/metabox/metabox-config.php' ) ){
			require_once( dirname(__FILE__) . '/metabox/metabox-config.php');
		}

		add_action('init', array($this, 'rubsum_employee_slider_post') );

		add_action('wp_enqueue_scripts', array( $this, 'external_scripts_and_styles') );
	}

	public function external_scripts_and_styles(){

		// CSS Adding

		wp_enqueue_style('font-awesome-style',  PLUGINS_URL('css/fontawesome-all.min.css', __FILE__) );
		wp_enqueue_style('custom-style',  PLUGINS_URL('css/custom.css', __FILE__) );
		wp_enqueue_style('owl-carousel-css', PLUGINS_URL('css/owl.carousel.min.css', __FILE__));
		wp_enqueue_style('owl-custom-css', PLUGINS_URL('css/owl.custom.css', __FILE__));

		// scripts adding

		wp_enqueue_script('custom-plugin-js', PLUGINS_URL('js/custom.js', __FILE__), array('jquery'), '', false);
		wp_enqueue_script('fontawesome-plugin-js', PLUGINS_URL('js/fontawesome-all.min.js', __FILE__), array('jquery'), '', false);
		wp_enqueue_script('owl-carousel-script', PLUGINS_URL('js/owl.carousel.min.js', __FILE__), array('jquery'));
		wp_enqueue_script('owl-carousel-custom-script', PLUGINS_URL('js/owl.custom.js', __FILE__), array('jquery'));
	}

	public function rubsum_employee_slider_post() {
		$labels = array(
			'name'               => _x( 'Employees', 'Employee general name', 'rubsum_info' ),
			'singular_name'      => _x( 'Employee', 'Employee singular name', 'rubsum_info' ),
			'menu_name'          => _x( 'Employees', 'Employees admin menu', 'rubsum_info' ),
			'name_admin_bar'     => _x( 'Employee', 'add new on admin bar', 'rubsum_info' ),
			'add_new'            => _x( 'Add New Employee', 'book', 'rubsum_info' ),
			'add_new_item'       => __( 'Add New info', 'rubsum_info' ),
			'new_item'           => __( 'New Employee', 'rubsum_info' ),
			'edit_item'          => __( 'Edit info', 'rubsum_info' ),
			'view_item'          => __( 'View info', 'rubsum_info' ),
			'all_items'          => __( 'All Employees', 'rubsum_info' ),
			'search_items'       => __( 'Search Employees', 'rubsum_info' ),
			'parent_item_colon'  => __( 'Parent Employees:', 'rubsum_info' ),
			'not_found'          => __( 'No Employees info found.', 'rubsum_info' ),
			'not_found_in_trash' => __( 'No Employees info found in Trash.', 'rubsum_info' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'rubsum_info' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'employee' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'			 => 'dashicons-money',
			'supports'           => array( 'title', 'thumbnail')
		);

		register_post_type( 'rs_employees_info', $args );

		//taxonomy

		$label = array(
			'name'                       => _x( 'speciality', 'Speciality general name', 'textdomain' ),
			'singular_name'              => _x( 'speciality', 'Speciality singular name', 'textdomain' ),
			'search_items'               => __( 'Search speciality', 'textdomain' ),
			'popular_items'              => __( 'Popular speciality', 'textdomain' ),
			'all_items'                  => __( 'All speciality', 'textdomain' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit speciality', 'textdomain' ),
			'update_item'                => __( 'Update speciality', 'textdomain' ),
			'add_new_item'               => __( 'Add New speciality', 'textdomain' ),
			'new_item_name'              => __( 'New speciality Name', 'textdomain' ),
			'separate_items_with_commas' => __( 'Separate speciality with commas', 'textdomain' ),
			'add_or_remove_items'        => __( 'Add or remove speciality', 'textdomain' ),
			'choose_from_most_used'      => __( 'Choose from the most used speciality', 'textdomain' ),
			'not_found'                  => __( 'No speciality found.', 'textdomain' ),
			'menu_name'                  => __( 'speciality', 'textdomain' ),
		);

		$arguments = array(
			'hierarchical'          => true,
			'labels'                => $label,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'speciality' ),
		);

		register_taxonomy( 'employee-speciality', 'rs_employees_info', $arguments );
	}

	// Front end e anar jonno.

	public function employees_shortcode(){

		add_shortcode('employees-information', array($this, 'employee_information_output') );
	}

	public function employee_information_output(){
		ob_start(); 

		$prefix = '_prefix_';

		$employees_info = new WP_Query(array(
			'post_type'			=> 'rs_employees_info',
			'posts_per_page'	=> -1
		));

		?>

		<div class="rubsum-employees"> <!-- this class used for owl carousel -->
		<?php while($employees_info->have_posts()) : $employees_info->the_post();
		?>

			<div class="employees-info">
				<div class="info-left">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				</div>
				<div class="info-right">
					<div class="informations">
						<ul>
							<li><strong>Name: </strong><span><?php echo get_post_meta( get_the_id(), $prefix.'employees_name', true); ?></span></li>
							<li><strong>Speciality: </strong>
								<span>
									<?php $specialities = get_the_terms(get_the_id(), 'employee-speciality');

									foreach( $specialities as $speciality ) {
										echo $speciality->name;
									} ?>					
							 	</span>
							</li>
							<li><strong>Age: </strong><span><?php echo get_post_meta( get_the_id(), $prefix.'employees_age', true); ?></span></li>
							<li><strong>Degree/Education: </strong><span><?php echo get_post_meta( get_the_id(), $prefix.'employees_degree', true); ?></span></li>
							<li><strong>Chember/Job Responsibility: </strong><span><?php echo get_post_meta( get_the_id(), $prefix.'employees_chember', true); ?></span></li>
						</ul>
					</div>
					
				</div>
			</div>

		<?php endwhile; ?>

		</div>

		<?php return ob_get_clean(); 
	}
}

$employee = new Employee();

$employee->employees_shortcode();

