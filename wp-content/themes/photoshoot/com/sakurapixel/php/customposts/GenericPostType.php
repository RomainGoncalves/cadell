<?php
/**
 * generic CPT
 */
require_once(CLASS_PATH.'/com/sakurapixel/php/customposts/impl/iGenericPostType.php');
class GenericPostType{
	
	protected $settings;
	protected $cptHelper;
		
	//create custom post
	public function create($cptHelper, $settings){
		$this->settings = $settings;
		$this->cptHelper = $cptHelper;
		register_post_type($settings['post_type'], $cptHelper->getPostArgs());
	}
	
	//return post settings
	public function getSettings(){
		return $this->settings;
	}
	
	//return post slug
	public function getPostSlug(){
		return $this->settings['post_type'];
	}
	
	//add meta box 
	public function addMetaBox($boxTitle){
		add_meta_box($this->settings['post_type'].'_boxID', $boxTitle, array($this, 'meta_box_content'), $this->settings['post_type'], 'normal', 'high');
	}		
	
	//to be overriden
	public function meta_box_content(){}
	
}

?>