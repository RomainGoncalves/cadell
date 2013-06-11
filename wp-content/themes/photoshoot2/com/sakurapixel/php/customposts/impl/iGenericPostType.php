<?php

interface iGenericPostType{
	
	public function create($cptHelper, $settings);
	public function getSettings();
	public function getPostSlug();
}


?>