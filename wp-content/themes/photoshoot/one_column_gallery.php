<?php
/*
Template Name: One Column Gallery
*/
$view->checkPreview();
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());
$postData = array();
?>

<?php $wpbp = new WP_Query(array('post_type' => 'sk_one_column', 'posts_per_page' =>'-1' )); ?>
<?php if ($wpbp->have_posts()) :  while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
	 
<?php

$postTitle = $view->titleValidator(get_the_title($post->ID));
$featuredImageURL = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$thumbURL = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'sk_one_column-largeThumb');
$custom = get_post_meta($post->ID, 'sk_one_column', false);
$smallDescription = (isset($custom[0]['smallDescription']))?$custom[0]['smallDescription']:"";

array_push($postData, array("postTitle"=>$postTitle, "featuredImageURL"=>$featuredImageURL, "thumbURL"=>$thumbURL, "smallDescription"=>$smallDescription));

?>
<?php endwhile; else: ?>
<p><?php echo('<br />No posts were found. Please add posts from admin!'); ?></p>			
<?php endif; ?>
<?php wp_reset_query(); ?>  


<div class="section-one-column-SECTION">
    
        <!--add here url for this section background image-->
        <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
        <!--/section background image-->

      <!--one column gallery content-->
      <div class="oneColumGalleryContent">
        <div class="oneGalleryItemsContainer">


     	<?php
     		$html = '';
     		for($i=0;$i<sizeof($postData);$i++){
				$html .= '				        				            				            
	            <!--one column item-->
	            <div class="oneColumnItem">
	                <div class="oneColumnItemContent">
	                    <div class="oneColumnImageContainer">
	                        <img src="'.$postData[$i]['thumbURL'][0].'" alt="Image item" />
	                    </div>
	                    <a class="largeImage" href="'.$postData[$i]['featuredImageURL'].'"></a>
	                    <div class="oneColumnItemDescription">
	                        <p class="columnItemTitle textColor01"><span class="textColor02">'.$postData[$i]['postTitle']['first'].'</span>'.$postData[$i]['postTitle']['last'].'</p>
	                    </div>
	                    <p class="itemDescription">'.$postData[$i]['smallDescription'].'</p>                   
	                </div>
	            </div>
	            <!--/one column item-->              				            				                                                                                  				   				
				';								
			}
			echo $html; 
     	?>
     	
        </div>
      </div>
      <!--/one column gallery content-->      	
     	
     	     
    
</div>