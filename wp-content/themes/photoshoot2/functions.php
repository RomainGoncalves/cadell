<?php
//define global constants
define( 'TEMPPATH', get_bloginfo('stylesheet_directory'));
define( 'IMAGES', TEMPPATH. "/images");
define( 'JS', TEMPPATH. "/js");

define( 'JS_ADMIN', TEMPPATH. "/com/sakurapixel/js");
define( 'CSS_ADMIN', TEMPPATH. "/com/sakurapixel/css");
define( 'IMAGES_ADMIN', TEMPPATH. "/com/sakurapixel/images");
define('CLASS_PATH', realpath(dirname(__FILE__)));


require_once(CLASS_PATH.'/com/sakurapixel/php/hive_wrapper.php');
require_once(CLASS_PATH.'/com/sakurapixel/php/FrontView.php');

// Translation
load_theme_textdomain('Photoshoot', TEMPPATH.'/languages');

//init framework
$hive = new HiveWrapper();
$hive->start();
$view = new FrontView($hive);


?>