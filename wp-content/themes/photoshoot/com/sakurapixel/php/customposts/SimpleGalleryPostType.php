<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/customposts/GenericPostType.php');
class SimpleGalleryPostType extends GenericPostType{
				
	
	//meta box content
	public function meta_box_content(){
		global $post;
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;
		$custom = get_post_meta($post->ID, $this->getPostSlug(), false);
		$existingVal = "";
		if(isset($custom[0])){
			$existingVal = wptexturize($custom[0]['smallDescription']);
		}
		?>
		
			<div class="metaBoxContentBox">
				<label class="customLabel">Add small description</label>
				<input class="inputText fullWidth" type="text" name="<?php echo $this->getPostSlug();?>[smallDescription]" value="<?php echo $existingVal;?>" />
			</div>		
		
		<?php		
	}
	
}

?>