<?php
/*
Template Name: Portfolio
*/
$view->checkPreview();
$page = get_page(get_the_ID());
$postContent = $page->post_content;
$pageTitle = $view->titleValidator($page->post_title);
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());
$backBTNLabel = $view->getThemeSpecificOption('portfolioBackButtonLabel');
$portfolioData = array();
?>

<?php $wpbp = new WP_Query(array('post_type' => 'sk_portfolio', 'posts_per_page' =>'-1' )); ?>
<?php if ($wpbp->have_posts()) :  while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
	 
<?php

$groupTitle = get_the_title($post->ID);
$custom = get_post_meta($post->ID, 'sk_portfolio', false);

//parse result
$groupsData = array();
$customData = $custom[0];
foreach ($customData as $key => $value){
	$imageSmall = wp_get_attachment_image_src($value['attachementID'], 'sk_portfolio-small');
	$imageMedium = wp_get_attachment_image_src($value['attachementID'], 'sk_portfolio-medium');
	//$imageLarge = wp_get_attachment_image_src($value['attachementID'], 'sk_portfolio-large');
	//$imageLarge = $value['originalImageURL'];
	$imageLarge = wp_get_attachment_image_src($value['attachementID'], 'full');
	$smallDescription = $value['smallDescription'];
	$groupData = array('imageSmall'=>$imageSmall, 'imageMedium'=>$imageMedium, 'imageLarge'=>$imageLarge, 'smallDescription'=>$smallDescription);
	array_push($groupsData, $groupData);								
}
$mediumImageURL = (isset($groupsData[0]['imageMedium']))?$groupsData[0]['imageMedium']:'';
array_push($portfolioData, array('groupTitle'=>$groupTitle, 'groupsData'=>$groupsData, 'mediumImageURL'=>$mediumImageURL));

?>
<?php endwhile; else: ?>
<p><?php echo('<br />No posts were found. Please add posts from admin!'); ?></p>			
<?php endif; ?>
<?php wp_reset_query(); ?>


<div class="section-portfolio-SECTION">
        <!--add here url for this section background image-->
        <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
        <!--/section background image-->
        
        <!--portfolio main content-->
        <div class="portfolioMainContent">
            
            <!--portfolio index -->
            <div class="portfolioIndexGallery" >
                
                <!--portfolio title and description-->
                <div class="galeriesDescription">
                    <div class="hspacer"></div>
                    <p class="sectionTitle textColor02"><?php echo $pageTitle['first'];?><span class="textColor01"><?php echo $pageTitle['last'];?></span></p>
                    <div class="sectionHline"></div>
                    <div class="defaultText textColor01">

                    	<?php
                    		//display portfolio description
                    		echo wpautop(wptexturize(do_shortcode($postContent)));
                    	?>
                    </div>
                    <div class="hspacer"></div>
                </div>
                <!--/portfolio title and description-->
                
                
                    <div class="portfolioItems">
                        
                        <?php
                        	$html = '';
                        	for ($i=0;$i<sizeof($portfolioData);$i++) {                        		
								$groupImage = $portfolioData[$i]['mediumImageURL'][0];
								$groupTitle = $portfolioData[$i]['groupTitle'];
								$groupsData = $portfolioData[$i]['groupsData'];
								
								$groupTitleValidate = $view->titleValidator($groupTitle);
								$html .= '                        
		                        <!--portfolio item (gallery)-->
		                        <div class="portfolioItem">
		                            <div class="portfolioItemContent">
		                                <div class="portfolioItemImage"><img src="'.$groupImage.'" /></div>                                
		                            </div>
		                            <p class="portfolioItemDescription textColor02">'.$groupTitle.'</p>
			                            <!--gallery content-->
			                            <p class="insideGalleryTitle">'.$groupTitleValidate['first'].'<span>'.$groupTitleValidate['last'].'</span></p>
			                            <div class="galeryItems">		                            
                            	';

								for ($j=0; $j < sizeof($groupsData); $j++) { 
									//$groupsData[j]['key']
									$smallDescription = $groupsData[$j]['smallDescription'];
									$imageSmall = $groupsData[$j]['imageSmall'][0];
									$imageLarge = $groupsData[$j]['imageLarge'][0];									
									$html .= '
			                                
			                                <!--inside gallery item-->                                
			                                <div class="galeryItem">
			                                    <div class="galeryItemContent">
			                                        <div class="galeryItemThumb"><img src="'.$imageSmall.'" /></div>
			                                        <a class="largeImage" href="'.$imageLarge.'"></a>
			                                        <p class="itemDescription">'.$smallDescription.'</p>                                
			                                    </div>                                                                
			                                </div>
			                                <!--/inside gallery item--> 			                           									
									';
								}
							$html .= '                                                                                                                                                                                                                                                                                                                  
			                                <div class="clear-fx"></div>
			                            </div>
			                             <!--/gallery cotent-->							
		                        </div>
		                        <!--/portfolio item (gallery)--> 				
							';								
							}							
							
							echo $html;
                        ?>						
                        <div class="clear-fx"></div>
                    </div>
              
                
            </div>
            <!--/portfolio index -->
            
            
            <!--!!! DO NOT EDIT BELLOW !!!-->
            <div class="portfolioOpened">
                <div class="gallerycontent">
                    <!--single gallery title and description -->
                    <div class="galeryDescription">
                        <div class="hspacer"></div>
                        <p id="insideGalleryTitle" class="sectionTitle textColor02"></p>
                        <div class="sectionHline"></div>
                        <div class="hspacer"></div>
                    </div>
                    <!--/single gallery title and description-->                     
                    <div class="galeryMask"></div>
                    <div class="backButtonContainer"><a class="backButton yellowButton backgroundColor01 textColor03" href="" title="back"><?php _e('Back', 'Photoshoot');?></a></div>                    
                </div>
            </div>
            
            
            
            
        </div>
        <!--/portfolio main content-->
</div>