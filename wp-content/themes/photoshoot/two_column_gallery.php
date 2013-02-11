<?php
/*
Template Name: Two Column Gallery
*/
$view->checkPreview();
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());
$postData = array();
?>

<?php $wpbp = new WP_Query(array('post_type' => 'sk_two_column', 'posts_per_page' =>'-1' )); ?>
<?php if ($wpbp->have_posts()) :  while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
	 
<?php

//$postTitle = $view->titleValidator(get_the_title($post->ID));
$featuredImageURL = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$thumbURL = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'sk_two_column-largeThumb');
$custom = get_post_meta($post->ID, 'sk_two_column', false);
$smallDescription = (isset($custom[0]['smallDescription']))?$custom[0]['smallDescription']:"";

array_push($postData, array("featuredImageURL"=>$featuredImageURL, "thumbURL"=>$thumbURL, "smallDescription"=>$smallDescription));

?>
<?php endwhile; else: ?>
<p><?php echo('<br />No posts were found. Please add posts from admin!'); ?></p>			
<?php endif; ?>
<?php wp_reset_query(); ?>  


<div class="section-two-column-SECTION">
    
        <!--add here url for this section background image-->
        <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
        <!--/section background image-->

      <!--two column gallery content-->
      <div class="twoColumGalleryContent">
          <div class="twoGalleryItemsContainer">
              
     	<?php
     		$html = '';
     		for($i=0;$i<sizeof($postData);$i++){
				$html .= '				        				            				            
              <!--two column item-->
              <div class="twoColumnItem">
                  <div class="twoColumnItemContent">
                      <div class="twoColumnImageContainer">
                          <img src="'.$postData[$i]['thumbURL'][0].'" />
                      </div>
                      <a class="largeImage" href="'.$postData[$i]['featuredImageURL'].'"></a>
                  </div>
                  <p class="itemDescription">'.$postData[$i]['smallDescription'].'</p>               
              </div>
              <!--/two column item-->             				            				                                                                                  				   				
				';								
			}
			echo $html; 
     	?>              

  
              <div class="clear-fx"></div>
          </div>              
      </div>
      <!--/two column gallery content-->     	
     	
     	     
    
</div>