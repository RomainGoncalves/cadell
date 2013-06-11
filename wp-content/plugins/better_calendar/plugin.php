<?php
/*
Plugin Name: Better Calendar
Plugin URI: http://www.gotthefevermedia.com.au
Description: A better Worpress calendar for simple people
Version: 1.0
Author: Got The Fever Media
Author URI: http://www.gotthefevermedia.com.au
Author Email: gotthefevermedia@gmail.com
License:

  Copyright 2013 GNU General Public License (gotthefevermedia@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

include_once dirname( __FILE__ ) . '/includes/custom-post-types.php';

// TODO: rename this class to a proper name for your plugin
class BetterCalendar {
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		
		// Load plugin text domain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );
	
		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( $this, 'uninstall' ) );
		
	    /*
	     * TODO:
	     * Define the custom functionality for your plugin. The first parameter of the
	     * add_action/add_filter calls are the hooks into which your code should fire.
	     *
	     * The second parameter is the function name located within this class. See the stubs
	     * later in the file.
	     *
	     * For more information: 
	     * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
	     */

		//Adds Custom Post Type featured image for the edit screen
		add_image_size('featured_preview', 200, 250, true);

	    add_action( 'after_setup_theme', array( $this, 'custom_post_type' ) );
	    add_filter( 'TODO', array( $this, 'filter_method_name' ) );

		add_filter('manage_event_posts_columns', array($this, 'columns_head') );  
		add_action('manage_event_posts_custom_column', array($this, 'columns_content'), 1, 2);

	} // end constructor
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {
		// TODO:	Define activation functionality here
	} // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
		// TODO:	Define deactivation functionality here		
	} // end deactivate
	
	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function uninstall( $network_wide ) {
		// TODO:	Define uninstall functionality here		
	} // end uninstall

	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {
	
		// TODO: replace "better_calendar-locale" with a unique value for your plugin
		$domain = 'better_calendar';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	} // end plugin_textdomain

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
	
		wp_enqueue_style( 'better_calendar-admin-styles', plugins_url( 'better_calendar/css/admin.css' ) );
		wp_enqueue_style( 'better_calendar-admin-jqueryui-styles', plugins_url( 'better_calendar/css/vendors/ui-darkness/jquery-ui-1.10.1.custom.min.css' ) );
	
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
	
		wp_enqueue_script( 'better_calendar-admin-script', plugins_url( 'better_calendar/js/admin.js' ) );
		wp_enqueue_script('jquery-ui-datepicker', '', $deps = array('jquery'), '', $in_footer = false) ;
	
	} // end register_admin_scripts
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		wp_enqueue_style( 'better_calendar-plugin-styles', plugins_url( 'better_calendar/css/display.css' ) );
		//wp_enqueue_style( 'better_calendar-admin-jqueryui-styles', plugins_url( 'better_calendar/css/vendors/ui-darkness/jquery-ui-1.10.1.custom.min.css' ) );
		wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Sintony:400,700', 'better_calendar-admin-jqueryui-styles');
		wp_enqueue_style( 'better_calendar-custom-calendar', plugins_url( 'better_calendar/css/calendar.css' ), 'better_calendar-admin-jqueryui-styles' );
	
	} // end register_plugin_styles
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {
	
		//wp_enqueue_script('backbone', $src = false, $deps = array('underscore'), $ver = false, $in_footer = false) ; //TODO
		wp_enqueue_script( 'better_calendar-plugin-script', plugins_url( 'better_calendar/js/display.js' ), array('jquery') );
		wp_enqueue_script('jquery-ui-datepicker', '', $deps = array('jquery'), '', $in_footer = false) ;
	
	} // end register_plugin_scripts
	
	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/
	
	/**/
	function custom_post_type() {
    	
    	//Let's call and create the custom post type
    	$event = new Custom_Post_Type( 'Event', array( 'show_in_menu' => true, 'menu_position' => 25, 'has_archive' => true, 'taxonomies' => array('events')), array('menu_name' => 'Calendar') );
    	$event->add_meta_box(
    		'Event Details',
    		array(
    			'Start Date'	=>	'text',
    			'Starts at'		=>	'text',
    			'End Date'		=>	'text',
    			'Ends at'		=>	'text',
    			'Where'			=>	'text',
    			'Website'		=>	'text',
    			'RSVP'			=>	'checkbox',
    			'Entry Fee'		=>	'text'
    		),
    		'side'
    	) ;

	} // end custom_post_type
	
	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *		  WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *		  Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 */
	function filter_method_name() {
	    // TODO:	Define your filter method here
	} // end filter_method_name

	// GET FEATURED IMAGE  
	function get_featured_image($post_ID) {  
	    $post_thumbnail_id = get_post_thumbnail_id($post_ID);  
	    if ($post_thumbnail_id) {  
	        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');  
	        return $post_thumbnail_img[0];  
	    }  
	}

	// ADD NEW COLUMN  
	function columns_head($defaults) {  
	    $defaults['featured_image'] = 'Featured Image';  
	    return $defaults;  
	}  
	  
	// SHOW THE FEATURED IMAGE  
	function columns_content($column_name, $post_ID) {  
	    if ($column_name == 'featured_image') {  
	        $post_featured_image = $this->get_featured_image($post_ID);  
	        if ($post_featured_image) {  
	            echo '<img src="' . $post_featured_image . '" />';  
	        }  
	    }  
	}

	//Shortcode function
	function better_calendar_shortcode(){//For now displays calendar, TODO -> Add Backbone

		// $today = date("j/m/Y");

		$args = array(
			'post_type'	=> 'event',
			/*'meta_query' => array(
				array(
					'key' => 'event_details_start_date',
					'value' => $today,
					'type' => 'date',
					'compare' => '>='
				)
			)TO DO AT A LATER TIME*/
			) ;

		//Get all events
		$events = new WP_Query($args) ;

		$output = '<div id="better_calendar"></div>' ;
		$output .= '<div id="better_calendar_events">' ;

		//Loop through events
		foreach ($events->posts as $key => $event) {

			$meta = get_post_meta($event->ID) ;
			
			$output .= '<div class="event '.str_replace('/', '-', $meta['event_details_start_date'][0]).'">' ;

			//replace slash by dash as european time is supposed to be with dashes...
			$date_start = str_replace('/', '-', $meta['event_details_start_date'][0]) ;

			$date_formatted_start = date('D j-h-Y', strtotime($date_start)) ;

			$output .= '<h2>'.$event->post_title.'</h2><div class="event_date"><span class="event_date_start" data-date="'.$meta['event_details_start_date'][0].'">'.$date_formatted_start.'</span>' ;

			//Check if there's an end date
			if($meta['event_details_end_date'][0]){

				$date_end = str_replace('/', '-', $meta['event_details_end_date'][0]) ;
				$date_formatted_end = date('D j-h-Y', strtotime($date_end)) ;

				$output .= ' - <span class="event_date_end">'.$date_formatted_end.'</span>' ;

			}

			if($meta['event_details_website'][0]){

				$output .= '<span class="event_where">@ <a href="http://'.$meta['event_details_website'][0].'" title="See the title">'.$meta['event_details_where'][0].'</a></span></div>' ;

			}
			else{
				$output .= '<span class="event_where">@ '.$meta['event_details_where'][0].'</span></div>' ;
			}
			

			if(has_post_thumbnail($event->ID)){

				$output .= get_the_post_thumbnail($event->ID, $size = 'featured_preview', $attr = '') ;

			}

			$output .= '<p class="event_description">'.$event->post_content.'</p>' ;

			if( $meta['event_details_starts_at'][0] || $meta['event_details_ends_at'][0] || $meta['event_details_entry_fee'][0] || $meta['event_details_rsvp'][0]){
			
				$output .= '<table class="event_details">
				<thead>' ;

			}

			if($meta['event_details_starts_at'][0]){

				$output .= '<th>Starts</th>' ;

			}
			if($meta['event_details_ends_at'][0]){

				$output .= '<th>Ends</th>' ;

			}
			if($meta['event_details_entry_fee'][0]){

				$output .= '<th>Entry Fee</th>' ;

			}
			if($meta['event_details_rsvp'][0]){

				$output .= '<th>RSVP</th>' ;

			}


			if( $meta['event_details_starts_at'][0] || $meta['event_details_ends_at'][0] || $meta['event_details_entry_fee'][0] || $meta['event_details_rsvp'][0]){
				
				$output .= '</thead>
				<tbody>
				<tr>' ;

			}

			if($meta['event_details_starts_at'][0]){

				$output .= '<td>'.$meta['event_details_starts_at'][0].'</td>' ;

			}
			if($meta['event_details_ends_at'][0]){

				$output .= '<td>'.$meta['event_details_ends_at'][0].'</td>' ;

			}
			if($meta['event_details_entry_fee'][0]){

				$output .= '<td>$'.$meta['event_details_entry_fee'][0].'</td>' ;

			}
			if($meta['event_details_rsvp'][0]){

				$output .= '<td>Yes</td>' ;

			}

			if( $meta['event_details_starts_at'][0] || $meta['event_details_entry_fee'][0] || $meta['event_details_entry_fee'][0] || $meta['event_details_rsvp'][0]){
				
				$output .= '</tr></tbody></table>' ;

			}

			$output .= '</div>' ;
						
		}

		$output .= '</div>' ;
		$output .= '<div id="better_calendar_legend"><h2>My Upcoming Gig\'s</h2></div>' ;
		//$output .= '<div id="better_calendar_legend"><h2>Legend:</h2><div>Today: <span class="today">1</span></div><div>Event Date: <span class="event">25</span></div></div>' ;

		wp_reset_query() ;

		//return the output
		return $output ;
	}
  
} // end class

$betterCalendar = new BetterCalendar();

add_shortcode('better-calendar', array('BetterCalendar', 'better_calendar_shortcode')) ;