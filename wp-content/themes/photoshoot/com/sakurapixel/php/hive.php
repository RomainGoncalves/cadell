<?php
/*
 * Hive framework
 * author: SakuraPixel
 */
class Hive{
	
	function __construct(){}
	
	//init handler
	public function initializeHandler(){
		$this->registerShortcodes();
	}
	
	//register shortcodes
	public function registerShortcodes(){}
	
	//save post handler
	public function savePostHandler(){}
	
	//admin menu handler
	public function adminMenuHandler(){}
	
	//admin init handler
	public function adminInitHandler(){}
	
	//admin enqueue scripts handler
	public function adminEnqueueScriptsHandler(){
		//default styles	
		wp_register_style('admin-style', CSS_ADMIN.'/admin.css');
		wp_enqueue_style('admin-style');
		//default JS
		wp_enqueue_script('jquery');
		//wp_enqueue_script('thickbox');
		//wp_enqueue_script('media-upload'); 	
	}
	
	//WP Enqueue scripts handler
	public function WPEnqueueScriptsHandler(){
		wp_deregister_script('jquery');
		wp_register_script( 'jquery', JS.'/external/jquery/jquery_1_7.min.js', false, '1.7.1');
		wp_enqueue_script('jquery');		
	}
	
	//init listeners
	public function start(){
		add_action('save_post', array($this, 'savePostHandler'));
		add_action('admin_init', array($this, 'adminInitHandler'));
		add_action('admin_enqueue_scripts', array($this, 'adminEnqueueScriptsHandler'));				
		add_action('admin_menu', array($this, 'adminMenuHandler'));
		add_action('init', array($this, 'initializeHandler'));
		add_action("wp_enqueue_scripts", array($this, 'WPEnqueueScriptsHandler'));
		add_action('comment_post', array($this, 'comments_ajax_handler'), 20, 2);
		add_filter('excerpt_more', array($this, 'new_excerpt_more'));
	}
	
	//add thumb size/support
	public function addThumbSize($w, $h, $postTypes=NULL){
		if(function_exists('add_theme_support')){
			(isset($postTypes))?add_theme_support('post-thumbnails', array('post')):add_theme_support('post-thumbnails');
	        set_post_thumbnail_size($w, $h, true );			
		}
	}
	
	//add image size
	public function addImageSize($w, $h, $imageName, $cropMode=false){
		if(function_exists('add_image_size')){	          
			add_image_size($imageName, $w, $h, $cropMode);	
		}		
	}
	
	//remove support
	public function removeSupport($postTypeSlug, $val){
		remove_post_type_support($postTypeSlug, $val);
	}
	
	public function addThemeSupport($support){
		if(function_exists('add_theme_support')){
			add_theme_support($support);
		}
	}
	//add automatic feed links
	public function addAutomaticFeedlinksSupport(){
		if(function_exists('add_theme_support')){
			add_theme_support('automatic-feed-links');
		}		
	}
	
	//check content width
	public function checkContentWidth(){
		if (!isset( $content_width )) $content_width = 1000;
	}
	
	//add menu support
	public function addSingleMenuSupport(){
		add_theme_support('nav-menus');
		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus(
				array(
				  'main' => 'Main Nav'
				)
			);
		}		
	}	
	
	/*
	 * FRONTEND SUPPORT
	 */	 
	 //get menu items
	 public function getMenuItems($menu_slug){
	 	$items = array();
		$locations = get_nav_menu_locations();
		if (isset($locations[$menu_slug ])){
			$menu = wp_get_nav_menu_object( $locations[$menu_slug]);
			if(isset($menu->term_id)){
				$menu_items = wp_get_nav_menu_items($menu->term_id);				
				foreach((array)$menu_items as $key => $menu_item ) {
					    $title = $menu_item->title;
					    $url = $menu_item->url;
						array_push($items, array('menuItemTitle'=>$title, 'menuItemURL'=>$url));
				}
			}else{
				//build dummy menu info
				array_push($items, array('menuItemTitle'=>'Please asign menu from admin - @See documentation ', 'menuItemURL'=>''));
			}
		}
		return $items;
	 }
	
	//read more link - overriden
	public function new_excerpt_more($more) {}
	
	//notify comments added through ajax
	public function comments_ajax_handler($comment_ID, $comment_status){}
	
}

?>