<?php
/*
Template Name: About
*/
?>
<?php $view->checkPreview();?>
<?php
$page = get_page(get_the_ID());
$postContent = $page->post_content;
$pageTitle = $view->titleValidator($page->post_title);
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());

?>
<div class="section-ABOUT">
    
        <!--add here url for this section background image-->
        <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
        <!--/section background image-->    
        
        <div class="aboutMain">
            <div class="aboutTop">
                <div class="hspacer"></div>
                <p class="sectionTitle textColor02"><?php echo $pageTitle['first'];?><span class="textColor01"><?php echo $pageTitle['last'];?></span></p>
                <div class="sectionHline"></div>
                <div class="hspacer"></div>                  
            </div>
            <div class="aboutMask">
                <div class="aboutContainer">                
                	
                    <div class="defaultText textColor01 sk_about_content">
                    	<?php
                    		echo wpautop(wptexturize(do_shortcode($postContent)));							
                    	?>                      
                    </div>     
                     <div class="clear-fx"></div>
                </div>
                
            </div>
        </div>
    
</div>