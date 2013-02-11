<?php
/*
Template Name: Blog
*/
?>
<?php $view->checkPreview();?>
<?php
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());
?>


<div class="section-BLOG">
    
        <!--add here url for this section background image-->
        <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
        <!--/section background image-->    
        
        <div class="blogMain">
        	<div class="blogContainer">
        	  
        	  <!--blog posts mask-->
        	  <div class="blogPostsMask">
			  <div class="blogPostsContent">
			        <?php query_posts('post_type=post&post_status=publish&posts_per_page=-1'); ?>
					  <?php if( have_posts() ): ?>
					        <?php while( have_posts() ): the_post(); ?>
					        	
				        		<!--blog post item-->
				        		<div class="sk_blog_post_item" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				        		<?php
				        			$title = $view->titleValidator(get_the_title(get_the_ID()));
				        		?>
							       
							       <a href="<?php the_permalink(); ?>" class="blogTitleLink sectionTitle textColor02"><?php echo $title['first'];?><span class="textColor01"><?php echo $title['last'];?></span></a>
							       <div class="sectionHline"></div>
							       <div class="hspacerSmall"></div>
							       
			                        <div class="defaultText textColor01">             	                        	                                                	
			                        	 <?php the_excerpt();?>                 
			                        </div>
			                        
			                        <div class="clear-fx"></div>
			                        <div class="hspacerSmall"></div>
			    
			                        <!--post meta-->
			                        <div class="getSocial">			                            
			                            <div class="postIco postIcoDate socialItems"></div>
			                            <div class="socialText socialItems textColor01"><?php echo get_the_date();?></div>
			                            
			                            <div class="postIco postAuthorIco postIcoSpace socialItems"></div>
			                            <div class="socialText socialItems textColor01"><?php echo __('by ', 'Photoshoot').get_the_author();?></div>
			                            
			                             <div class="postIco postComNum postIcoSpace socialItems"></div>
			                            <div class="socialText socialItems textColor01"><?php echo get_comments_number(get_the_ID()).__(' comments');?></div>			                            
			                            <div class="clear-fx"></div>     
			                        </div>
			                        <!--post meta-->
			                        <div class="hspacer"></div>			                        
			                        							       
							               			
				        		</div>
				        		<!--blog post item-->			        	
					        	
					        <?php endwhile; ?>
		
					  <?php else: ?>
					    <div id="post-404" class="noposts">
					        <p>No posts found</p>
					      </div><!-- /#post-404 -->
					  <?php endif; wp_reset_query(); ?>
       		        		       		        		        		
        	</div>
        	
        	</div>
        	<!--end blog posts mask-->
        </div>
    
</div>
