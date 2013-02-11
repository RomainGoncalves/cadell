<?php $view->checkPreview(true);?>
<div class="blogContainerInner">
	
	 <!--blog posts mask-->
     <div class="blogPostMask">
     	<div class="blogPostContent">     		
     		
			<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
				<?php
					$title = $view->titleValidator(get_the_title(get_the_ID()));
				?>		
                <div class="hspacer"></div>
                <p class="sectionTitle textColor02"><?php echo $title['first'];?><span class="textColor01"><?php echo $title['last'];?></span></p>
                <div class="sectionHline"></div>
                <div class="singlePostNav">
                	<a id="backToPostsBTN" href="#" class="defaultText textColor02"><?php echo('« '.__('Back', 'Photoshoot'));?></a>
                	<p id="nextBlogPost" class="alignright"><?php next_post_link('%link', __('Next', 'Photoshoot').' »');?></p>
                	<p id="previousBlogPost" class="alignright"><?php previous_post_link('%link', '« '.__('Previous', 'Photoshoot'));?></p>
                	<div class="clear-fx"></div>
                </div>
                
                <div <?php post_class(); ?>>
                
			      <div class="defaultText textColor01 singleContent">             	                        	                                                	
			          <?php the_content();?>                 
			      </div>                	
                </div>	
			
			<?php endwhile; else: ?>
				<p><?php _e('No posts were found. Sorry!', 'Photoshoot'); ?></p>
			<?php endif; ?>     		
     		
     		
			<div class="hspacerSmall"></div>
			    
			<!--post meta-->
			<div class="getSocial">			                            
			    <div class="postIco postIcoDate socialItems"></div>
			    <div class="socialText socialItems textColor01"><?php echo get_the_date();?></div>
			                            
			    <div class="postIco postAuthorIco postIcoSpace socialItems"></div>
			    <div class="socialText socialItems textColor01"><?php echo __('by ', 'Photoshoot').get_the_author();?></div>
			                            
			    <div class="postIco postComNum postIcoSpace socialItems"></div>
			    <div class="socialText socialItems textColor01"><?php echo (get_comments_number(get_the_ID()).__(' comments', 'Photoshoot'));?></div>			                            
			    <div class="clear-fx"></div>     
			 </div>
			 <!--post meta-->
			  <div class="hspacer"></div>     		
     		
     		
     		 <?php comments_template(); ?>    		     		    		     		     		     		
     	</div>
     </div>	
	 <!--blog posts mask-->
	 
</div>