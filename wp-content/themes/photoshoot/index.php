<?php $view->checkPreview();?>
<?php get_header(); ?>

<?php
$menuItems = $view->getMenuItems('main');
$themeOptions = $view->getThemeOptions();
$logo = $view->getThemeLogoURL();
?>


        <!--main menu-->
        <div id="mainMenu">
        	<div class="menuSpacerTop"></div>
        	<div id="menuArrowUp"></div>
        	
        	<div class="genericMenuContainer">
        		<div id="logoContainerSK"><img src="<?php echo $logo;?>" alt="logo" /></div>
        		<div id="lineUnderLogo"></div>
        		<div class="menuSpacerTop"></div>
        	</div>
        	
        	<div id="menuExpandedSK" class="genericMenuContainer">        		
        		<div id="menuExpandedContentSK">
                    <div id="menuItemsSK">
                        <ul>                        	
                        	<?php
                        	for ($i=0; $i < sizeof($menuItems); $i++) {
								echo '<li><a href="'.$menuItems[$i]['menuItemURL'].'">'.$menuItems[$i]['menuItemTitle'].'</a></li>';
								if($i<sizeof($menuItems)-1){
									echo '<li class="menuSeparator"></li>';
								}
							}
                        	?>
                                                     
                        </ul>
                    </div>
                    <!--/menu items-->         			
        		</div>
        	</div>
        	
        	<div id="menuArrowDown">
                <?php DISPLAY_ACURAX_ICONS(); ?></div>
        	<div class="menuSpacerBottom"></div>        	
        	
        </div>
        <!--/main menu-->
        
        <!--fullscreen button-->
        <div id="fullScreenButtons">
            <div id="fs_on" title="<?php echo $themeOptions['exitFSTooltip']; ?>"><img src="<?php echo IMAGES.'/full_screen_on.png';?>" alt="" /></div>
            <div id="fs_off" title="<?php echo $themeOptions['enterFSTooltip']; ?>"><img src="<?php echo IMAGES.'/full_screen_off.png';?>" alt="" /></div>
        </div>
        <!--/fullscreen button--> 



<?php get_footer(); ?>