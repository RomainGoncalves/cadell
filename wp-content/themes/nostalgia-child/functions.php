<?php

/* Child functions.php */

function new_scripts(){

	//Remove blockUI
	wp_dequeue_script( 'jquery-block-ui' );
	wp_deregister_script( 'jquery-block-ui' );
	//Add proper file
	wp_enqueue_script('jquery-block-ui', get_stylesheet_directory_uri() . '/js/jquery.blockUI.js', array('jquery'));

}
add_action('wp_enqueue_scripts', 'new_scripts');