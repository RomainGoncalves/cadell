<?php
/*
Template Name: Home Page
*/
$view->checkPreview();
$page = get_page(get_the_ID());
$postContent = $page->post_content;
$pageTitle = $page->post_title;
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());

$homeOptions = $view->getOptionsGroup('homeOptions');
$aboutTooltip = $homeOptions['aboutTooltip'];
$oneColTooltip = $homeOptions['oneColTooltip'];
$twoColTooltip = $homeOptions['twoColTooltip'];
						
$oneColumnShow = (isset($homeOptions['oneColumnShow']))?$homeOptions['oneColumnShow']:'';
$oneColumnItemsNo = $homeOptions['oneColumnItemsNo'];
						
$twoColumnShow = (isset($homeOptions['twoColumnShow']))?$homeOptions['twoColumnShow']:'';
$twoColumnItemsNo = $homeOptions['twoColumnItemsNo'];
?>

<?php //if show two col gallery ?>
<?php if ($twoColumnShow=='ON'): ?>
<?php
$postDataTwoCol = array();
?>

<?php $wpbp = new WP_Query(array('post_type' => 'sk_two_column', 'posts_per_page' =>'-1' )); ?>
<?php if ($wpbp->have_posts()) :  while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
	 
<?php
$featuredImageURL = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$thumbURL = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'sk_two_column-largeThumb');
$custom = get_post_meta($post->ID, 'sk_two_column', false);
$smallDescription = (isset($custom[0]['smallDescription']))?$custom[0]['smallDescription']:"";
array_push($postDataTwoCol, array("featuredImageURL"=>$featuredImageURL, "thumbURL"=>$thumbURL, "smallDescription"=>$smallDescription));
?>
<?php endwhile; else: ?>
<?php $twoColumnShow=='OFF'; ?>			
<?php endif; ?>
<?php wp_reset_query(); ?>

<?php endif; ?>
<?php 
if(isset($postDataTwoCol)){
	if(sizeof($postDataTwoCol)<$twoColumnItemsNo){
		$twoColumnItemsNo = sizeof($postDataTwoCol);
	}
if(sizeof($postDataTwoCol)==0){
 		$twoColumnShow = "OFF";
}	
}
//END if show two col gallery ?>


<?php //if show one col gallery ?>
<?php if ($oneColumnShow=='ON'): ?>
<?php
$postDataOneCol = array();
?>


<?php $wpbp = new WP_Query(array('post_type' => 'sk_one_column', 'posts_per_page' =>'-1' )); ?>
<?php if ($wpbp->have_posts()) :  while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
	 
<?php

$postTitle = $view->titleValidator(get_the_title($post->ID));
$featuredImageURL = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$thumbURL = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'sk_one_column-largeThumb');
$custom = get_post_meta($post->ID, 'sk_one_column', false);
$smallDescription = (isset($custom[0]['smallDescription']))?$custom[0]['smallDescription']:"";

array_push($postDataOneCol, array("postTitle"=>$postTitle, "featuredImageURL"=>$featuredImageURL, "thumbURL"=>$thumbURL, "smallDescription"=>$smallDescription));

?>
<?php endwhile; else: ?>
<?php $oneColumnShow = "OFF"; ?>		
<?php endif; ?>
<?php wp_reset_query(); ?> 

<?php endif; ?>
<?php 
if(isset($postDataOneCol)){
	if(sizeof($postDataOneCol)<$oneColumnItemsNo){
		$oneColumnItemsNo = sizeof($postDataOneCol);
	}
if(sizeof($postDataOneCol)==0){
	$oneColumnShow = "OFF";
}	
}
//END if show two col gallery ?>



<div class="section-type-HOME">
    
    <!--add here url for this section background image-->
    <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
    <!--/section background image-->
     
     <!--home right switch buttons-->
     <div id="homeButtons">
         <div class="aboutTextBTN" title="<?php echo $aboutTooltip;?>">
             <a href="#!content1"></a>
         </div>                   
         <?php
         if($twoColumnShow=='ON' && isset($postDataTwoCol)){
         	echo '
		         <div class="gridGalleryBTN" title="'.$twoColTooltip.'">
		             <a href="#!content2"></a>
		         </div>        	
         	';
         }         
         if($oneColumnShow=='ON' && isset($postDataOneCol)){
         	echo '
		         <div class="singleGalleryBTN" title="'.$oneColTooltip.'">
		             <a href="#!content3"></a>
		         </div>          	
         	';
         }
         ?>
                                                  
     </div>
      <!--/home right switch buttons-->
      
      
      <!--text content-->
      <div id="content1" class="aboutTextContent">
        <div class="homeTextContainer">         
            <div class="homeTextContent">
                <div class="hspacer"></div>
                <p class="homeFirstLevelTitle textColor02"><?php echo $pageTitle; ?></p>
                <div class="defaultText textColor01">
                	<?php						
                		echo wpautop(wptexturize(do_shortcode($postContent)));
                	?>                     
                </div>
                <div class="hspacer clear-fx"></div>
            </div>
        </div>
        
      </div>
      <!--/text content-->       
      
      
      <?php
      	if($twoColumnShow=='ON' && isset($postDataTwoCol)){
      		$html = '
		      <!--two column gallery content-->
		      <div id="content2" class="twoColumGalleryContent">
		          <div class="twoGalleryItemsContainer">      		
      		';
			
     		for($i=0;$i<$twoColumnItemsNo;$i++){
				$html .= '				        				            				            
              <!--two column item-->
              <div class="twoColumnItem">
                  <div class="twoColumnItemContent">
                      <div class="twoColumnImageContainer">
                          <img src="'.$postDataTwoCol[$i]['thumbURL'][0].'" />
                      </div>
                      <a class="largeImage" href="'.$postDataTwoCol[$i]['featuredImageURL'].'"></a>
                  </div>
                  <p class="itemDescription">'.$postDataTwoCol[$i]['smallDescription'].'</p>               
              </div>
              <!--/two column item-->             				            				                                                                                  				   				
				';								
			}			
			
      		$html .= '
		              <div class="clear-fx"></div>
		          </div>              
		      </div>
		      <!--/two column gallery content-->    		
      		';
			echo $html;			
      	}
      ?>
      
      <?php
      		if($oneColumnShow=='ON' && isset($postDataOneCol)){
      			$html = '
			      <!--one column gallery content-->
			      <div id="content3" class="oneColumGalleryContent">
			        <div class="oneGalleryItemsContainer">      			
      			';
				
	     		for($i=0;$i<$oneColumnItemsNo;$i++){
					$html .= '				        				            				            
		            <!--one column item-->
		            <div class="oneColumnItem">
		                <div class="oneColumnItemContent">
		                    <div class="oneColumnImageContainer">
		                        <img src="'.$postDataOneCol[$i]['thumbURL'][0].'" alt="Image item" />
		                    </div>
		                    <a class="largeImage" href="'.$postDataOneCol[$i]['featuredImageURL'].'"></a>
		                    <div class="oneColumnItemDescription">
		                        <p class="columnItemTitle textColor01"><span class="textColor02">'.$postDataOneCol[$i]['postTitle']['first'].'</span>'.$postDataOneCol[$i]['postTitle']['last'].'</p>
		                    </div>
		                    <p class="itemDescription">'.$postDataOneCol[$i]['smallDescription'].'</p>                   
		                </div>
		            </div>
		            <!--/one column item-->              				            				                                                                                  				   				
					';								
				}				
				
      			$html .= '
			        </div>
			      </div>
			      <!--/one column gallery content-->    			
      			';
      			echo $html;				
      		}
      ?>
    
</div>