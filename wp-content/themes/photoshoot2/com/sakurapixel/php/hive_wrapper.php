<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/hive.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/customposts/utils/CPTHelper.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/customposts/PortfolioPostType.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/customposts/SimpleGalleryPostType.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/HomeOptionsPage.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/DocumentionOptionPage.php');	
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/ContactOptionPage.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/ReelOptionPage.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/GenericBackgroundOptionPage.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/AboutOptionPage.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/SkShortcodes.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/ThemeOptionPage.php');

class HiveWrapper extends Hive{		
	//init handler - override Hive handler
	public function initializeHandler(){
		parent::initializeHandler();
		$this->addPortfolioCPT();
		$this->addTwoColumnGllery();
		$this->addOneColumnGllery();
		$this->add_iGallery();
		$this->addNewsCPT();
		parent::addAutomaticFeedlinksSupport();
		parent::checkContentWidth();
	}
	
	/*
	 * PORTFOLIO CPT
	 */
	private $portfolioCPT;
	
	private function addPortfolioCPT(){
		$settings = array('post_type' => 'sk_portfolio', 'name' => 'Portfolio', 'menu_icon' => IMAGES_ADMIN.'/icons/images-flickr.png',
		'singular_name' => 'Portfolio', 'rewrite' => 'portfolio', 'add_new' => 'Add new',
		'edit_item' => 'Edit', 'new_item' => 'New', 'view_item' => 'View item', 'search_items' => 'Search items',
		'not_found' => 'No item found', 'not_found_in_trash' => 'Item not found in trash');
		
		$cptHelper = new CPTHelper($settings);
		$this->portfolioCPT = new PortfolioPostType();
		$this->portfolioCPT->create($cptHelper, $settings);
		parent::removeSupport($settings['post_type'], 'editor');
		
		//add thumb support
		parent::addThumbSize(344, 216, array('post'));
		//add image size
		parent::addImageSize(222, 138, $settings['post_type'].'-small', true);
		parent::addImageSize(344, 216, $settings['post_type'].'-medium', true);	
	}
	
	/**
	 * iGALLERY CPT
	 */
	private $iGalleryCPT;
	private function add_iGallery(){
		$settings = array('post_type' => 'sk_igallery', 'name' => 'iGallery', 'menu_icon' => IMAGES_ADMIN.'/icons/images-stack.png',
		'singular_name' => 'iGallery', 'rewrite' => 'igallery', 'add_new' => 'Add new',
		'edit_item' => 'Edit', 'new_item' => 'New', 'view_item' => 'View item', 'search_items' => 'Search items',
		'not_found' => 'No item found', 'not_found_in_trash' => 'Item not found in trash');
		
		$cptHelper = new CPTHelper($settings);
		$this->iGalleryCPT = new PortfolioPostType();
		$this->iGalleryCPT->create($cptHelper, $settings);
		parent::removeSupport($settings['post_type'], 'editor');


		//add image size
		parent::addImageSize(270, 184, $settings['post_type'].'-small', true);		
	}
	
	/**
	 * TWO COLUM GALLERY CPT
	 */
	private $twoColumnGalleryCPT;
	private function addTwoColumnGllery()
	{
		$settings = array('post_type' => 'sk_two_column', 'name' => 'Two Columns Gallery', 'menu_icon' => IMAGES_ADMIN.'/icons/camera-plus.png',
		'singular_name' => 'Two Columns Gallery', 'rewrite' => 'gallery_two_col', 'add_new' => 'Add new',
		'edit_item' => 'Edit', 'new_item' => 'New', 'view_item' => 'View item', 'search_items' => 'Search items',
		'not_found' => 'No item found', 'not_found_in_trash' => 'Item not found in trash');
		
		$cptHelper = new CPTHelper($settings);
		$this->twoColumnGalleryCPT = new SimpleGalleryPostType();
		$this->twoColumnGalleryCPT->create($cptHelper, $settings);
		parent::removeSupport($settings['post_type'], 'editor');
		
		//add thumb support
		parent::addThumbSize(200, 100);
		//add image size
		parent::addImageSize(240, 320, $settings['post_type'].'-largeThumb', true);						
	}
	
	/**
	 * ONE COLUM GALLERY CPT
	 */
	private $oneColumnGalleryCPT;
	private function addOneColumnGllery()
	{
		$settings = array('post_type' => 'sk_one_column', 'name' => 'One Column Gallery', 'menu_icon' => IMAGES_ADMIN.'/icons/camera-black.png',
		'singular_name' => 'One Column Gallery', 'rewrite' => 'gallery_one_col', 'add_new' => 'Add new',
		'edit_item' => 'Edit', 'new_item' => 'New', 'view_item' => 'View item', 'search_items' => 'Search items',
		'not_found' => 'No item found', 'not_found_in_trash' => 'Item not found in trash');
		
		$cptHelper = new CPTHelper($settings);
		$this->oneColumnGalleryCPT = new SimpleGalleryPostType();
		$this->oneColumnGalleryCPT->create($cptHelper, $settings);
		parent::removeSupport($settings['post_type'], 'editor');
		
		//add thumb support
		parent::addThumbSize(200, 100);
		//add image size
		parent::addImageSize(439, 254, $settings['post_type'].'-largeThumb', true);						
	}
	
	/**
	 * NEWS CPT
	 */
	private function addNewsCPT(){
		$settings = array('post_type' => 'sk_news', 'name' => 'News Posts', 'menu_icon' => IMAGES_ADMIN.'/icons/calendar-select.png',
		'singular_name' => 'News Posts', 'rewrite' => 'news', 'add_new' => 'Add new',
		'edit_item' => 'Edit', 'new_item' => 'New', 'view_item' => 'View item', 'search_items' => 'Search items',
		'not_found' => 'No item found', 'not_found_in_trash' => 'Item not found in trash');
		
		$cptHelper = new CPTHelper($settings);
		register_post_type($settings['post_type'], $cptHelper->getPostArgs());		
	}
	
	//admin menu handler - override Hive handler
	public function adminMenuHandler(){
		//create pages
		$homeOptionPage = new HomeOptionsPage();
		$homeOptionPage->createMenuPage('Home Page Options', 'Home Page Options', 'administrator', 'home-options', IMAGES_ADMIN.'/icons/home1.png', NULL, 'homeOptions');		
		$reelOptionPage = new ReelOptionPage();
		$reelOptionPage->createMenuPage('Reel Page Options', 'Reel Page Options', 'administrator', 'reel-options', IMAGES_ADMIN.'/icons/film.png', NULL, 'reelOptions');		
		$contactOptionPage = new ContactOptionPage();
		$contactOptionPage->createMenuPage('Contact Page Options', 'Contact Page Options', 'administrator', 'contact-options', IMAGES_ADMIN.'/icons/contact.png', NULL, 'contactOptions');		
		$themeOptionPage = new ThemeOptionPage();
		$themeOptionPage->createMenuPage('Theme Options', 'Theme Options', 'administrator', 'theme-options_opts', IMAGES_ADMIN.'/icons/gear_arrow.png', NULL, 'themeOptions');		
		$docsOptionPage = new DocumentionOptionPage();
		$docsOptionPage->createMenuPage('Photoshoot Documentation', 'Photoshoot Documentation', 'administrator', 'theme-doc_opts', IMAGES_ADMIN.'/icons/notebook-pencil.png', NULL, 'themeDocs');		
		//submenu pages
											
	}
		
	//admin init handler - override Hive handler
	public function adminInitHandler(){
		//add meta box for PortfolioPostTypes
		$this->portfolioCPT->addMetaBox("Add items to this group");
		$this->twoColumnGalleryCPT->addMetaBox("Item Description");
		$this->oneColumnGalleryCPT->addMetaBox("Item Description");
		
		//add meta box for iGallery CPT
		$this->iGalleryCPT->addMetaBox("Add items to this gallery");	
	}
	
	/**
	 * SAVE POST HANDLER - override Hive handler
	 */
	 public function savePostHandler(){
		global $post;
		if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;
		}
		//portfolio save
		if(isset($post) && isset($_POST[$this->portfolioCPT->getPostSlug()])){
			update_post_meta($post->ID, $this->portfolioCPT->getPostSlug(), $_POST[$this->portfolioCPT->getPostSlug()]);
		}
		//igallery save
		if(isset($post) && isset($_POST[$this->iGalleryCPT->getPostSlug()])){
			update_post_meta($post->ID, $this->iGalleryCPT->getPostSlug(), $_POST[$this->iGalleryCPT->getPostSlug()]);
		}		
		//two column gallery save
		if(isset($post) && isset($_POST[$this->twoColumnGalleryCPT->getPostSlug()])){
			update_post_meta($post->ID, $this->twoColumnGalleryCPT->getPostSlug(), $_POST[$this->twoColumnGalleryCPT->getPostSlug()]);
		}
		//one column gallery save
		if(isset($post) && isset($_POST[$this->oneColumnGalleryCPT->getPostSlug()])){
			update_post_meta($post->ID, $this->oneColumnGalleryCPT->getPostSlug(), $_POST[$this->oneColumnGalleryCPT->getPostSlug()]);
		}							
	 }
	 
	/*
	 * register shortcodes 
	 */ 
	public function registerShortcodes(){
		$shorcodesHelper = new SkShortcodes();
		$shorcodesHelper->registerShortcodes();		
	}
	
	//read more link - override
	public function new_excerpt_more($more) {
	       global $post;
		return ' <a class="readMore textColor02" href="'. get_permalink($post->ID) . '">Read more...</a>';
	}
	
	//ajax comment handler - override
	public function comments_ajax_handler($comment_ID, $comment_status){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			switch($comment_status){
				case "0":
				wp_notify_moderator($comment_ID);
				echo "notify_pending";
				case "1": //Approved comment
				echo "success";
				$commentdata =& get_comment($comment_ID, ARRAY_A);
				$post =& get_post($commentdata['comment_post_ID']);
				wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
				break;
				default:
				echo "error";
			}
			/*
			try {
			    wp_notify_moderator($comment_ID);
			} catch (Exception $e) {}			
			*/
		exit;
		}		
	}
	
	/*
	 * ADMIN SCRIPTS/ STYLES - override Hive handler
	 */	
	public function adminEnqueueScriptsHandler(){
		//add default scripts
		parent::adminEnqueueScriptsHandler();
				
		//if add portfolio item screen
		$portfolioScreen = $this->portfolioCPT->getSettings();
		if(get_current_screen()->id == $portfolioScreen['post_type']){
			wp_register_script( 'portfolio_js', JS_ADMIN.'/portfolio/portfolio.js', array('jquery'));
			wp_enqueue_script( 'portfolio_js' );
			$js_data = array('POST_TYPE'=>$portfolioScreen['post_type']);
			wp_localize_script( 'portfolio_js', 'portfolioPHPObj', $js_data );
		}
		
		//if add igallery item screen
		$iGalleryScreen = $this->iGalleryCPT->getSettings();
		if(get_current_screen()->id == $iGalleryScreen['post_type']){
			wp_register_script( 'portfolio_js', JS_ADMIN.'/portfolio/portfolio.js', array('jquery'));
			wp_enqueue_script( 'portfolio_js' );
			$js_data = array('POST_TYPE'=>$iGalleryScreen['post_type']);
			wp_localize_script( 'portfolio_js', 'portfolioPHPObj', $js_data );
		}		
		
		$screenID = get_current_screen()->id;
		$last = substr($screenID, strlen($screenID)-5, strlen($screenID));

		if($last=='_opts'){
			//theme options screen
			$this->enqueueThickbox();
			 //color picker style
		     wp_register_style( 'cpicker_style', CSS_ADMIN.'/components/cpicker/css/colorpicker.css');
			 wp_register_style( 'cpicker_layout', CSS_ADMIN.'/components/cpicker/css/layout.css');		 
		     wp_enqueue_style( 'cpicker_style');
			 
			 //color picker script
			 wp_register_script( 'color_picker', JS_ADMIN.'/cpicker/colorpicker.js', array('jquery'));
			 wp_register_script( 'color_picker_eye', JS_ADMIN.'/cpicker/eye.js', array('jquery'));
			 wp_register_script( 'color_picker_layout', JS_ADMIN.'/cpicker/layout.js', array('jquery'));
			 wp_register_script( 'color_picker_utils', JS_ADMIN.'/cpicker/utils.js', array('jquery'));
			 wp_enqueue_script('color_picker');
			 wp_enqueue_script('color_picker_eye');	
			 wp_enqueue_script('color_picker_layout');	
			 wp_enqueue_script('color_picker_utils');				 
			 
			 //options script	
			 wp_register_script( 'theme_options', JS_ADMIN.'/theme_options/theme_options.js', array('jquery', 'color_picker'));			 
			 wp_enqueue_script('theme_options');				 			 			
		}
	}
	
	//load thinkbox (for admin)
	private function enqueueThickbox()
	{
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_style('thickbox');		
	}
	
	//WP Enqueue scripts handler - Frontend
	public function WPEnqueueScriptsHandler(){
		parent::WPEnqueueScriptsHandler();
		global $is_IE;
		if ( $is_IE ) {
		    wp_enqueue_script( 'html5IE', 'http://html5shim.googlecode.com/svn/trunk/html5.js');
		    wp_register_script( 'pngfix', JS.'/external/png_fix/supersleight-min.js', array('jquery'));
		}
		
		wp_register_script( 'mCustomScrollbar', JS.'/external/jquery/jquery.mCustomScrollbar.js', array('jquery'));
		wp_register_script( 'easing', JS.'/external/jquery/jquery.easing.1.3.js', array('jquery'));
		wp_register_script( 'jQui', JS.'/external/jquery/jquery-ui-1.8.21.custom.min.js', array('jquery'));
		wp_register_script( 'mousewheel', JS.'/external/jquery/jquery.mousewheel.js', array('jquery'));
		wp_register_script( 'touch_punch', JS.'/external/jquery/jquery.ui.touch-punch.min.js', array('jquery'));
		wp_register_script( 'EventBus', JS.'/com/sakurapixel/events/eventbus/EventBus.js', array('jquery'));
		wp_register_script( 'genericevents', JS.'/com/sakurapixel/events/genericevents.js', array('jquery'));
		wp_register_script( 'JQueryAjax', JS.'/com/sakurapixel/jqueryajax/JQueryAjax.js', array('jquery'));
		wp_register_script( 'ResizableBackground', JS.'/com/sakurapixel/ui/background/ResizableBackground.js', array('jquery'));
		wp_register_script( 'buttonsui', JS.'/com/sakurapixel/ui/buttons/buttonsui.js', array('jquery'));
		//wp_register_script( 'utils', JS.'/com/sakurapixel/utils/utils.js', array('jquery'));
		wp_register_script( 'PhotoShootLightbox', JS.'/com/sakurapixel/lightbox/PhotoShootLightbox.js', array('jquery'));
		wp_register_script( 'PagesUtils', JS.'/PagesUtils.js', array('jquery'));
									
		wp_register_script( 'main', JS.'/main.js', array('jquery'));
		wp_register_script( 'modernizr', JS.'/external/modernizr.js', array('main'));
		wp_register_script( 'sections', JS.'/sections.js', array('jquery'));
		wp_register_script( 'iGallery', JS.'/com/sakurapixel/galleries/iGallery.js', array('sections'));
		wp_register_script( 'jrotate', JS.'/external/jquery/jQueryRotateCompressed.2.2.js', array('sections'));
		

		wp_enqueue_script('modernizr');
		wp_enqueue_script('mCustomScrollbar');
		wp_enqueue_script('easing');
		wp_enqueue_script('jQui');
		wp_enqueue_script('mousewheel');
		wp_enqueue_script('touch_punch');
		wp_enqueue_script('EventBus');
		wp_enqueue_script('genericevents');
		wp_enqueue_script('JQueryAjax');
		wp_enqueue_script('ResizableBackground');
		wp_enqueue_script('buttonsui');
		wp_enqueue_script('utils');
		wp_enqueue_script('PhotoShootLightbox');
		wp_enqueue_script('PagesUtils');
		wp_enqueue_script('iGallery');
		wp_enqueue_script('jrotate');
		wp_enqueue_script('main');		
		wp_enqueue_script('sections');
		wp_enqueue_script( "comment-reply" );
		
		$themeOptions = get_option('themeOptions');		
		$lightboxisMouseMove = (isset($themeOptions['lightboxisMouseMove']))?$themeOptions['lightboxisMouseMove']:'';		
		$showLightboxPost = (isset($themeOptions['showLightboxPost']))?$themeOptions['showLightboxPost']:'';
		
		$contactOptions = get_option('contactOptions');
		$emailReceive = (isset($contactOptions['emailReceive']))?$contactOptions['emailReceive']:'youremail@yourwebsite.com';
		
		$blogNoticeMessage = __('***Your comment is awaiting moderation***', 'Photoshoot');
		$blogErrorMessage = __('You might have left one of the fields blank, or be posting too quickly', 'Photoshoot');
		
		$customCSS = array('textColor01'=>'color: #'.$themeOptions['primaryTextColor'],
		'textColor02'=>'color: #'.$themeOptions['secondaryTextColor'],
		'backgroundColor01'=>'background-color: #'.$themeOptions['secondaryTextColor']);		
		
		$js_data = array('RESOURCES_PATH'=>TEMPPATH, 'MAIL_SCRIPT' => TEMPPATH.'/mail.php', 'isMenuOpen'=>'ON',  
		'lightboxisMouseMove'=>$lightboxisMouseMove, 'showLightboxPost'=>$showLightboxPost, 'emailReceive'=>$emailReceive, 'MAIL_SCRIPT'=>TEMPPATH.'/mail.php',
		'CUSTOM_CSS'=>$customCSS, 'blogNoticeMessage'=>$blogNoticeMessage, 'blogErrorMessage'=>$blogErrorMessage);
		wp_localize_script('main', 'globalJS', $js_data);				
	}			
}

?>