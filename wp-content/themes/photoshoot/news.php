<?php
/*
Template Name: News
*/
?>
<?php $view->checkPreview();?>
<?php
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());
$postsData = array();
?>

<?php $wpbp = new WP_Query(array('post_type' => 'sk_news', 'posts_per_page' =>'-1' )); ?>
<?php if ($wpbp->have_posts()) :  while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
	 
<?php

$title = $view->titleValidator(the_title("", "", false));
$p_date = get_the_date();
array_push($postsData, array('content'=>get_the_content(), 'title'=>$title, 'p_date'=>$p_date));

?>
<?php endwhile; else: ?>
<p><?php echo('<br />No posts were found. Please add posts from admin!'); ?></p>			
<?php endif; ?>
<?php wp_reset_query(); ?>


<div class="section-NEWS">
    
        <!--add here url for this section background image-->
        <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
        <!--/section background image-->    
        
        <div class="newsMain">
            <div class="newsMask">
                <div class="newsContainer">
                    
                    <?php
                    	$html = '';
						
						for ($i=0;$i<sizeof($postsData);$i++){ 
							$html .= '
			                    <!--news item-->
			                    <div class="sk_news_item">			                        
			                        <p class="sectionTitle textColor02">'.$postsData[$i]['title']['first'].'<span class="textColor01">'.$postsData[$i]['title']['last'].'</span></p>
			                        <div class="sectionHline"></div>
			                        <div class="hspacerSmall"></div>                        
			                        
			                        <div class="defaultText textColor01">             	                        	                                                	
			                        	 '.wpautop(wptexturize(do_shortcode($postsData[$i]['content']))).'                 
			                        </div>
			                        
			                        <div class="clear-fx"></div>
			                        <div class="hspacerSmall"></div>
			    
			                        <!--social links-->
			                        <div class="getSocial">			                            
			                            <div class="smallYellowArrow socialItems"></div>
			                            <div class="socialText socialItems textColor01">'.$postsData[$i]['p_date'].'</div>
			                            <div class="clear-fx"></div>     
			                        </div>
			                        <!--/social links-->
			                        <div class="hspacer"></div>                       
			                    </div>
			                    <!--/news item--> 							
							
							';
						}
						echo $html;
						
                    ?>
                                                           
                    
                </div>
                
            </div>
        </div>
    
</div>