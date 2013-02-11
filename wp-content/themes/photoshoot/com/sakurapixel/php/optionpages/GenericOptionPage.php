<?php

class GenericOptionPage{
		
	protected $menu_slug;
	protected $optionsGroup;
	protected $submenu_slug;
	//create menu page
	public function createMenuPage($page_title, $menu_title, $capability, $menu_slug, $icon_url, $position, $optionsGroup){
		$this->menu_slug = $menu_slug;
		$this->optionsGroup = $optionsGroup;
		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, array($this, 'showPageContent'), $icon_url, $position);
		add_action( 'admin_init', array($this, 'registerSettingsGroups'));
	}
	
	//get option group
	protected function getOptionGroup(){
		return $this->optionsGroup;
	}
	
	//create menu subpage
	public function createSubmenuPage($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $optionsGroup){
		$this->menu_slug = $parent_slug;
		$this->submenu_slug = $menu_slug;
		$this->optionsGroup = $optionsGroup;		
		add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'showPageContent'));
		add_action( 'admin_init', array($this, 'registerSettingsGroups'));
	}
	
	//register settings group
	public function registerSettingsGroups(){
		register_setting($this->optionsGroup, $this->optionsGroup);
	}
	
	//page content
	public function showPageContent(){}
	
	
}

?>