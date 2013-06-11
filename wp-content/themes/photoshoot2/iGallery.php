<?php
/*
Template Name: iGallery
*/
?>
<?php $view->checkPreview();?>
<?php
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());
$igalleryData = array();
?>
<?php $wpbp = new WP_Query(array('post_type' => 'sk_igallery', 'posts_per_page' =>'-1' )); ?>
<?php if ($wpbp->have_posts()) :  while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
	
<?php

$groupTitle = get_the_title($post->ID);
$custom = get_post_meta($post->ID, 'sk_igallery', false);

//parse result
$groupsData = array();
$customData = $custom[0];
foreach ($customData as $key => $value){
	$imageSmall = wp_get_attachment_image_src($value['attachementID'], 'sk_igallery-small');
	$imageLarge = wp_get_attachment_image_src($value['attachementID'], 'full');
	$smallDescription = $value['smallDescription'];
	$groupData = array('imageSmall'=>$imageSmall, 'imageLarge'=>$imageLarge, 'smallDescription'=>$smallDescription);
	array_push($groupsData, $groupData);								
}
array_push($igalleryData, array('groupTitle'=>$groupTitle, 'groupsData'=>$groupsData));

?>
<?php endwhile; else: ?>
<p><?php echo('<br />No posts were found. Please add posts from admin!'); ?></p>			
<?php endif; ?>
<?php wp_reset_query(); ?>	
	

<div class="section-IGALLERY">
	
        <!--add here url for this section background image-->
        <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
        <!--/section background image-->
        
        <!--igallery main-->
        <div class="igalleryMain">
        	
        	<div class="iGalleryUI">
        		
        		<div class="iGalleryMask">
        			<!--iGallery content-->
        			<div class="iGalleryContent">
        				
        				<?php
        					$allGalleries = '';
        					for ($i=0;$i<sizeof($igalleryData);$i++){
        						$groupsData = $igalleryData[$i]['groupsData'];
								
								$gallerieHTML = '
						                    <!--gallery-->
						                    <div class="gallery">                                                                                                                                                                                                                                                                                                                                           		
								';									
								
								for ($j=0; $j < sizeof($groupsData); $j++){
									$smallDescription = $groupsData[$j]['smallDescription'];
									$imageSmall = $groupsData[$j]['imageSmall'][0];
									$imageLarge = $groupsData[$j]['imageLarge'][0];
									$gallerieHTML .= '
					                        <div class="galleryItem">
					                            <img src="'.$imageSmall.'" />
					                            <a class="largeImage" href="'.$imageLarge.'"></a>
					                            <p class="lightboxCaption">'.$smallDescription.'</p>                            
					                        </div> 				
									';																		
								}
								$gallerieHTML .= '
						                    </div>
						                    <!--/gallery-->		
								';
								$allGalleries .= $gallerieHTML;
        					}
							$return_val = '

							        <!--back to galleries button-->
							        <p id="iGalBackButton"><a class="iBackButton backgroundColor01 textColor03" href="">Back</a></p>
							        <!--/back to galleries button-->     
							
							                <!--iGallery container-->
							                <div class="iGalleryContainer">
							                    
							                    <!--loading text-->
							                    <p class="iGalleryLoading textColor03">loading...</p>
							                    
												'.$allGalleries.'
							                    <div class="clear-fx"></div>                                                                           
							          
							                </div>
							                <!--/iGallery container-->
							                	
							';
							echo $return_val;        				
        				?>
        				
        				
        				
        			</div>
        			<!--end iGallery content-->
        		</div>
        		
        	</div>
        	
        </div>
        <!--end igallery main--> 	
	
</div>