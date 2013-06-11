<?php

class FrontView{
	
	private $hive;
	function __construct($hiveWrapper) {
		$this->hive = $hiveWrapper;
		$this->hive->addSingleMenuSupport();				
	}
	
	//get menu items
	public function getMenuItems($value='main'){
		$menuItems = $this->hive->getMenuItems($value);
		return $menuItems;
	}
	
	//get theme options
	public function getThemeOptions(){
		$themeOptions = get_option('themeOptions');
		return $themeOptions;
	}
	
	//get theme specific options
	public function getThemeSpecificOption($val){
		$themeOptions = get_option('themeOptions');
		return (isset($themeOptions[$val]))?$themeOptions[$val]:'null-option';
	}	
	
	//get theme logo
	public function getThemeLogoURL(){		
		$options = $this->getThemeOptions();
		$logo = (isset($options['logoImage'])&&$options['logoImage']!="")?$options['logoImage']:IMAGES."/default/logo.png";
		return $logo;
	}
	
	//get specific options group
	public function getOptionsGroup($optionsGroup){
		$options = get_option($optionsGroup);
		return $options;		
	}
	
	/*
	 * title validator
	 */
	public function titleValidator($value=''){
		if(!isset($value)||$value==""){
			$value = "Missing Title";
		}
        $pos = strpos($value, ' ');
		if($pos){
			$first = substr($value, 0, $pos);
			$last = substr($value, $pos, strlen($value));
		}else{
			$first = $value;
			$last = "";
		}
		$val = array('first' => $first, 'last' => $last);	
		return $val;
	}
	
	//get section background
	public function validateSectionBackground($value=''){
		$themeBackgrundOptions = get_option($value);
		$defaultBackground = IMAGES."/default/default_background.jpg";
		$backgroundImage = (isset($themeBackgrundOptions['backgroundImage'])&&$themeBackgrundOptions['backgroundImage']!="")?$themeBackgrundOptions['backgroundImage']:$defaultBackground;
		return $backgroundImage;
	}
	
	public function getPageFeaturedBackgroundImage($pageID){
		$defaultBackground = IMAGES."/default/default_background.jpg";
		if (has_post_thumbnail(get_the_ID())){
			$defaultBackground = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
		}
		return $defaultBackground;
	}
	
	//check if is preview
	public function checkPreview($isSingle=false){
         if(isset($_GET['preview'])){
            if($_GET['preview']==true){		  
				  //buildURL
				  $pageURL = $this->getCurrentURL();
				  $parseHost = parse_url($pageURL);				  
				  $buildURL  = site_url().'/#!'.$parseHost['path'];
				  header('Location: '.site_url());
				  /*
				  if(!$isSingle){
				  	header('Location: '.$buildURL);
				  }else{				  	
					header('Location: '.site_url());
				  }
				   */
             }
         }		
    }
    
    
	//returns current url
	private function getCurrentURL(){
		$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
		if ($_SERVER["SERVER_PORT"] != "80")
		{
		    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else 
		{
		    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;		
	}	
	
}


?>