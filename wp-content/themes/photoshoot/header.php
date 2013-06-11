<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<title><?php bloginfo('name'); ?>  <?php wp_title(); ?></title>

    <!-- CSS Custom
  ================================================== -->        
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />        

    <!-- Fonts
  ================================================== -->     
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,600' rel='stylesheet' type='text/css' />
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300' rel='stylesheet' type='text/css' />
    
    <link href='http://fonts.googleapis.com/css?family=Signika:700' rel='stylesheet' type='text/css' />

<?php wp_head(); ?>

<?php
$themeOptions = get_option('themeOptions');
$googleAnalyticsCode = (isset($themeOptions['googleAnalytics']))?$themeOptions['googleAnalytics']:'';
echo $googleAnalyticsCode;
?>
</head>

<body <?php body_class(); ?>>
    <!--content wrapper-->
    <div id="contentWrapper">