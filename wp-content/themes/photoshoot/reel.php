<?php
/*
Template Name: Reel
*/
?>
<?php
$view->checkPreview();
$page = get_page(get_the_ID());
$postContent = $page->post_content;
$pageTitle = $view->titleValidator($page->post_title);
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());
$reelOptions = $view->getOptionsGroup('reelOptions');
$reelVideo = (isset($reelOptions['reelEmbedded']))?$reelOptions['reelEmbedded']:'';

?>

<div class="section-REAL"> 
        <!--add here url for this section background image-->
        <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
        <!--/section background image-->


        <!--real main container-->
        <div class="realMain">
            <div class="realContainer">
                <div class="hspacer"></div>
                <p class="sectionTitle textColor02"><?php echo $pageTitle['first'];?><span class="textColor01"><?php echo $pageTitle['last'];?></span></p>
                <div class="sectionHline"></div>
                <div class="hspacer"></div>
                
                <div class="defaultText textColor01">
                	<?php
                		echo wpautop(wptexturize(do_shortcode($postContent)));
                	?>
                </div>                
                
                <div class="hspacer"></div>
                
                <div class="videoContainer">
                    <?php
                    	echo $reelVideo;
                    ?>     
                </div>
                    
                    
                    
            </div>
        </div>
        <!--/real main container-->
      
      
    
</div>