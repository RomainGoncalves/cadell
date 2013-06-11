<?php
	// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="no-comments defaultText textColor01"><?php _e('Comments are password protected.', 'Photoshoot')?></p>
	<?php
		return;
	}
	// End Do not delete these lines
	
	function comments_filter($comment, $args, $depth){
		$GLOBALS['comment'] = $comment;
	    ?>
	    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	        <article id="comment-<?php comment_ID(); ?>" class="comment">
				<div class="comment_avatar">
					<?php echo get_avatar($comment, 54); ?>
				</div>
				<?php if ($comment->comment_approved == '0') : ?>
					 <div class="comment-content defaultText textColor02"><?php _e('***Your comment is awaiting moderation***', 'Photoshoot');?></div>
				<?php endif; ?>				
				<p class="author_link textColor02"><a class="author_link textColor02 author_link_bold" href="<?php echo get_comment_author_url(); ?>"><?php echo comment_author();?></a><?php echo (get_comment_date().' '.get_comment_time())?></p>				        	
	            <div class="comment-content defaultText textColor01"><?php comment_text(); ?></div>
	            <div class="clear-fx"></div>	            
	        </article>
	    </li>
	    <?php
	}
?>

<?php
$themeOptions = get_option('themeOptions');	
$isBlogComments = (isset($themeOptions['showBlogComments']))?$themeOptions['showBlogComments']:'';
$isBlogReplay = (isset($themeOptions['showBlogReplay']))?$themeOptions['showBlogReplay']:'';
?>

<?php if ( have_comments() && $isBlogComments=="ON") : ?>

	<div class="commentsContainer">
		
		<ol class="commentlist">
			<?php wp_list_comments(array('avatar_size'=>52, 'callback'=>'comments_filter')); ?>
		</ol>
		
	</div>

<?php else : // this is displayed if there are no comments so far ?>

	<!--No comments were found-->

<?php endif; ?>
<?php $current_user = get_currentuserinfo();?>
<!--add comment form-->
<?php if ( comments_open() && $isBlogComments=="ON" && $isBlogReplay=="ON") : ?>
	
	<div class="postCommentForm">
		<p id="comment_notice" class="defaultText textColor02"></p>
		<p class="homeSecondLevelTitle textColor01"><?php _e('Leave A Comment', 'Photoshoot');?></p>
		<?php
			$commenter = wp_get_current_commenter();
			$logged_in_as = '';

			if(is_user_logged_in()){
				//<p class="logged-in-as defaultText textColor01">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>
				$adminUrl = '<a class="author_link textColor02 author_link_bold" href="'.admin_url( 'profile.php' ).'">'.$user_identity.'</a>';
				$logoutUrl = '<a class="author_link textColor02 author_link_bold" href="'.wp_logout_url(site_url()).'">'.__('Log out?', 'Photoshoot').'</a>';
				$logged_in_as = '											
					<p class="logged-in-as defaultText textColor01">'.__('Logged in as ', 'Photoshoot').$adminUrl.$logoutUrl.'</p>';				
			}
			$comment_field = '
				<p class="comment-form-comment">'.'<textarea id="comment" class="comment_textarea defaultText" placeholder="'.__('your comment *', 'Photoshoot').'" name="comment" cols="45" rows="8"></textarea></p>			
			';
			$fields =  array(
			    'author' => '<p class="comment-form-author">' .
			        '<input id="author" name="author" class="comment_textInput defaultText" placeholder="'.__('your name*', 'Photoshoot').'" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" /></p>',
			    'email'  => '<p class="comment-form-email">' .
			        '<input id="email" name="email" class="comment_textInput defaultText" placeholder="'.__('your email*', 'Photoshoot').'" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" /></p>',
			    'url'    => '<p class="comment-form-url">'.
			        '<input id="url" name="url" class="comment_textInput defaultText" placeholder="'.__('your website', 'Photoshoot').'" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" /></p>',
			);
			$comments_args = array('comment_notes_before'=>'', 'comment_notes_after'=>'', 'title_reply'=>'', 'fields'=>$fields, 'comment_field' => $comment_field, 'label_submit'=>__('Post Comment', 'Photoshoot'), 
			'logged_in_as'=>$logged_in_as);
		?>
		<?php comment_form($comments_args); ?>
	</div>
	
<?php endif; ?>
<!--/add comment form-->
