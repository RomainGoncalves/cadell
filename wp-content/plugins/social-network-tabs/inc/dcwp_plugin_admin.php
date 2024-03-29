<?php
/**
* Admin DC plugins
* Version 1.0.1
*/

if(!class_exists('dcwp_plugin_admin_dcsnt')) {

	class dcwp_plugin_admin_dcsnt {

		var $hook 		= '';
		var $filename	= '';
		var $longname	= '';
		var $shortname	= '';
		var $optionname = '';
		var $homepage	= '';
		var $accesslvl	= 'manage_options';

		function __construct() {

			add_filter("plugin_action_links_{$this->filename}", array(&$this,'add_settings_link'));
			add_action('admin_menu', array(&$this,'add_option_page'));
			add_action("admin_init",array(&$this,'add_admin_styles'));
			add_action("admin_init",array(&$this,'add_admin_scripts'));
			
		}

		function add_admin_styles() {

			wp_enqueue_style("dcwp_admin_dcsnt_css", dc_jqsocialtabs::get_plugin_directory(). "/css/dcsnt_admin.css");

		}

		function add_admin_scripts() {

			wp_enqueue_script('postbox');
			wp_enqueue_script('jquery');
			wp_enqueue_script('dcwp_jquery_dcsnt_admin', dc_jqsocialtabs::get_plugin_directory(). '/inc/js/jquery.dcsnt.admin.js');

		}

		function add_option_page() {

			add_options_page($this->longname, 'Social Network Tabs', $this->accesslvl, $this->hook, array(&$this,'option_page'));

		}

		function add_settings_link($links) { 

			$settings_link = '<a href="options-general.php?page='.$this->hook.'">Settings</a>'; 
			array_unshift($links, $settings_link); 
			return $links; 

		}

		function dcwp_advert() {

			$content = '<ul class="dcwp-advert">';
			$content .= '<li class="last"><a href="http://codecanyon.net/item/wordpress-social-stream/2201708?ref=designchemical" class="dc-external"><img src="'.dc_jqsocialtabs::get_plugin_directory().'/images/dcwss_250.png" alt="WordPress Social Stream" /></a></li>';
			$content .= '<li class="last"><a href="http://codecanyon.net/item/wordpress-social-share-buttons/2927356?ref=designchemical" class="dc-external"><img src="'.dc_jqsocialtabs::get_plugin_directory().'/images/dcwsb_250.png" alt="WordPress Social Share Buttons" /></a></li>';
			$content .= '<li><a href="http://codecanyon.net/item/top-social-share-posts/1538572?ref=designchemical" class="dc-external"><img src="'.dc_jqsocialtabs::get_plugin_directory().'/images/dctsp_125.jpg" alt="Top Social Share Posts" /></a></li>';
			$content .= '</ul>';
			$this->postbox($this->hook.'-advert','Check Out Our Latest Plugins!',$content);		

		}
		
		function latest_posts() {

			$content ='<h4><a href="http://feeds.feedburner.com/DesignChemical"><img src="'.dc_jqsocialtabs::get_plugin_directory().'/images/rss_admin.png" alt="" />Subscribe For Updates</a></h4>';
			require_once(ABSPATH.WPINC.'/feed.php'); 
			
			$content .= '<ul class="dcwp-rss">';
			
			if ( $rss = fetch_feed( 'http://feeds.feedburner.com/DesignChemical' ) ) {
				
				if (!is_wp_error( $rss ) ) :
			
					$maxitems = $rss->get_item_quantity(5);
					$rss_items = $rss->get_items(0, $maxitems); 
				
				endif;
				
				if ($maxitems == 0) {
					$content .= '<li class="odd dcsmt-rss-item">No updates available ...</li>';
				} else {
				
					$count = 1;
					foreach ( $rss_items as $item ) :
					
						$time = dcsnt_wpcom_time_since(strtotime($item->get_date()));
						if($odd = $count%2){
							$rssClass = "odd dcwp-rss-item";
						} else {
							$rssClass = "even dcwp-rss-item";
						}
						$content .= '<li class="'.$rssClass.'">'.esc_html( $item->get_title() );
						$content .= ' ... <a href="'.esc_url( $item->get_permalink() ).'">'.$time.'&nbsp;ago</a></li>';
						$count++;
						
					endforeach;
				
				}
				
			} else {

				$content .= '<li class="odd dcsmt-rss-item">No updates available ...</li>';
			}

			$this->postbox($this->hook.'-latestpostbox','Design Chemical Lab:',$content);
		}

		function likebox(){

			$content = '<div class="text-group"><p><a href="https://twitter.com/'.$this->twitter.'" class="twitter-follow-button" data-count="vertical" data-lang="en">Follow @'.$this->twitter.'</a><script src="//platform.twitter.com/widgets.js" type="text/javascript"></script></p>';
			$content .= '<ul id="dc-share">';
			$content .= '<li id="dcssb-twitter"><a href="http://twitter.com/share" data-url="'.$this->homeshort.'" data-counturl="'.$this->homepage.'" data-text="'.$this->title.'" class="twitter-share-button" data-count="vertical" data-via="'.$this->twitter.'"></a></li>';
			$content .= '<li><iframe src="https://www.facebook.com/plugins/like.php?app_id=&amp;href='.urlencode($this->homepage).'&amp;send=false&amp;layout=box_count&amp;width=48&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:48px; height:62px;" allowTransparency="true"></iframe></li>';
			$content .= '<li id="dcssb-plusone"><g:plusone size="tall" href="'.$this->homepage.'" count="true"></g:plusone></li><script type="text/javascript">
				(function() {
					var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
					po.src = "https://apis.google.com/js/plusone.js";
					var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
				})();
				</script>';
			$content .= '<li id="dcssb-stumble"><script src="https://www.stumbleupon.com/hostedbadge.php?s=5&r='.$this->homepage.'"></script></li>';
			$content .= '<li id="dcssb-pinit"><a href="http://pinterest.com/pin/create/button/?url='.urlencode($this->homepage).'&media='.urlencode($this->imageurl).'&description='.urlencode($this->description).'" class="pin-it-button" count-layout="vertical">Pin It</a>';
			$content .= '<script type="text/javascript" src="https://assets.pinterest.com/js/pinit.js"></script></li>';
			$content .= '<li id="dcssb-linkedin"><script type="text/javascript" src="https://platform.linkedin.com/in.js"></script><script type="in/share" data-url="'.$this->homepage.'" data-counter="top"></script></li>';
			$content .= '<script type="text/javascript">
(function() {
var s = document.createElement("SCRIPT"), s1 = document.getElementsByTagName("SCRIPT")[0];
s.type = "text/javascript";
s.async = true;
s.src = "https://widgets.digg.com/buttons.js";
s1.parentNode.insertBefore(s, s1);
})();
</script>';
			$content .= '<li id="dcssb-digg"><a href="http://digg.com/submit?url='.urlencode($this->homepage).'&amp;title='.urlencode($this->title).'" class="DiggThisButton DiggMedium"><span style="display: none;">'.$this->description.'</span></a></li>';
			$content .= '<li id="dcssb-reddit"><script type="text/javascript">
							  reddit_url = "'.$this->homepage.'";
							  reddit_title = "'.$this->title.'";
							  reddit_newwindow="1"
							  </script>
							  <script type="text/javascript" src="https://www.reddit.com/static/button/button2.js"></script></li>';
			$content .= '</ul><div class="clear"></div></div>';

			$this->postbox($this->hook.'-likebox','Share it, rate it, tell your friends!',$content);
		}

		function postbox($id,$title,$content){

			?>

			<div id="<?php echo $id; ?>" class="postbox dcwp-box">				
				<h3 class="hndle"><span><?php echo $title; ?></span></h3>
				<div class="inside">
					<?php echo $content; ?>
				</div>
			</div>

			<?php			

		}
		
		function dcsnt_admin_tabs($current = 'social') {
			
			$tabs = array( 'social' => 'Social Networks', 'settings' => 'Settings', 'styling' => 'Styling', 'display' => 'Display' );
			echo '<h2 class="nav-tab-wrapper">';
			foreach( $tabs as $tab => $name ){
				$class = ( $tab == $current ) ? ' nav-tab-active' : '';
				echo '<a class="nav-tab'.$class.'" href="options-general.php?page='.$this->hook.'&tab='.$tab.'">'.$name.'</a>';
			}
			echo '</h2>';
		}

		function setup_admin_page($title,$subtitle) {

			?>

			<div class="wrap dcsnt-container">
				<h2 id="hdr-dcsnt"><a href="http://www.designchemical.com/blog/" target="_blank" id="dcwp-avatar"></a><?php echo $title; ?></h2>
			  <?php 
			  
				echo $this->dcsnt_admin_tabs();
				
				if (isset($_GET['settings-updated'])){
					if($_GET['settings-updated'] == 'true'){
						echo '<div id="message" class="updated fade"><p><strong>Settings updated</strong></p></div>';
					}
				}
				?>

			  <div class="postbox-container" style="width:68%; margin-right: 1%;">
			  <form method="post" id="dcsnt_settings_page" class="dcwp-form" action="options.php">
			  <div id="dcsnt-slider">
			    <div class="metabox-holder">
				  <div class="meta-box-sortables">
				    <div class="dcwp postbox">
					  <h3 class="hndle"><span><?php echo $subtitle; ?></span></h3>
					  <div class="inside">
					  
			<?php

		}

		function close_admin_page() {

		?>

		</div></div></div></div></div>
		<div class="submit-container">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			<input name="dcsnt_options[new_install]" type="hidden" value="no" />
		</div>
		</form>
		</div>

		<div id="dcsnt-side" class="postbox-container" style="width:30%;">
			<div class="metabox-holder">	
				<div class="meta-box-sortables">
					<?php
						$this->dcwp_advert();
						$this->likebox();
						$this->latest_posts();
					?>				
				</div>
			</div>
		</div>
	</div>

		<?php

		}
	}
}