<?php
/**
 * 
 */
class SkShortcodes{
	
	public function registerShortcodes(){
		add_shortcode('sk-italic-header', array($this, 'build_italic_header'));
		add_shortcode('sk-bold-header', array($this, 'build_bold_header'));
		add_shortcode('sk-medium-text', array($this, 'build_medium_text'));
		add_shortcode('sk-small-text', array($this, 'build_small_text'));
		add_shortcode('sk-button', array($this, 'build_sk_button'));
		add_shortcode('sk-phone-text', array($this, 'build_phone_text'));
		add_shortcode('sk-address-text', array($this, 'build_address_text'));
		
		add_shortcode('sk-youtube', array($this, 'build_shortcode_youtube'));
		add_shortcode('sk-vimeo', array($this, 'build_shortcode_vimeo'));
		add_shortcode('sk-soundcloud', array($this, 'build_shortcode_soundcloud'));
	}
	
	
	//build YT shortcode
	public function build_shortcode_youtube($atts) {
		$atts = shortcode_atts(
			array(
				'id' => '',
				'width' => 650,
				'height' => 360
			), $atts);		
			return '<div class="video"><iframe title="youtube video" width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://www.youtube.com/embed/' . $atts['id'] . '" frameborder="0" allowfullscreen></iframe></div>';
	}
	//build vimeo shortcode
	public function build_shortcode_vimeo($atts) {
		$atts = shortcode_atts(
			array(
				'id' => '',
				'width' => 650,
				'height' => 360
			), $atts);
			return '<div class="video"><iframe src="http://player.vimeo.com/video/' . $atts['id'] . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" frameborder="0"></iframe></div>';
	}
	
	//build soundcloud shortcode
	public function build_shortcode_soundcloud($atts) {
		$atts = shortcode_atts(
			array(
				'url' => '',
				'width' => '100%',
				'height' => 81,
				'comments' => 'true',
				'auto_play' => 'false',
				'color' => 'fff79a',
			), $atts);
		
			return '<object height="' . $atts['height'] . '" width="' . $atts['width'] . '"><param name="movie" value="http://player.soundcloud.com/player.swf?url=' . urlencode($atts['url']) . '&amp;show_comments=' . $atts['comments'] . '&amp;auto_play=' . $atts['auto_play'] . '&amp;color=' . $atts['color'] . '"></param><param name="allowscriptaccess" value="always"></param><embed allowscriptaccess="always" height="' . $atts['height'] . '" src="http://player.soundcloud.com/player.swf?url=' . urlencode($atts['url']) . '&amp;show_comments=' . $atts['comments'] . '&amp;auto_play=' . $atts['auto_play'] . '&amp;color=' . $atts['color'] . '" type="application/x-shockwave-flash" width="' . $atts['width'] . '"></embed></object>';
	}			
	
	
	//italic header
	public function build_italic_header($atts, $content = null){
		$return_val = '<p class="homeSecondLevelTitle textColor01">'.$content.'</p>';
		return $return_val;
	}
	//bold header
	public function build_bold_header($atts, $content = null){
		$return_val = '<p class="homeFirstLevelTitle textColor02">'.$content.'</p>';
		return $return_val;
	}
	//generic button
	public function build_sk_button($atts, $content = null){
	extract(shortcode_atts(array('url' => '', 'target'=>'_self', 'align'=>'alignleft'), $atts));		
		$return_val = '<a class="yellowButton backgroundColor01 textColor03 '.$align.'" target="'.$target.'" href="'.$url.'">'.$content.'</a>';
		return $return_val;
	}
	//medium text
	public function build_medium_text($atts, $content = null){
		$return_val = '<p class="nameTitle textColor01">'.$content.'</p>';
		return $return_val;
	}
	//medium text
	public function build_small_text($atts, $content = null){
		$return_val = '<p class="proffesion textColor01">'.$content.'</p>';
		return $return_val;
	}
	//phone text
	public function build_phone_text($atts, $content = null){
		$return_val = '<p class="phoneNo textColor02">'.$content.'</p>';
		return $return_val;
	}
	//address text
	public function build_address_text($atts, $content = null){
		$return_val = '<p class="addressInfo textColor01">'.$content.'</p>';
		return $return_val;
	}				
}

?>