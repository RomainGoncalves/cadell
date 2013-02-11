<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/customposts/GenericPostType.php');
class PortfolioPostType extends GenericPostType{	
	
	//meta box content
	public function meta_box_content(){	
		global $post;
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;
		
		$custom = get_post_meta($post->ID, $this->getPostSlug(), false);		
		$boxesData = array();
		if(isset($custom[0])){
			foreach ($custom[0] as $key => $value) {
				$boxData = array('data' => $value, 'box_key' => $key);
				array_push($boxesData, $boxData);				
			}
		}		
		?>
		<div id="portfolioContainer">
			
			<?php
			if(isset($boxesData)){				
					for ($i=0;$i<sizeof($boxesData);$i++) {						
						$boxData = $boxesData[$i];
						$imgPreview = wp_get_attachment_image_src($boxData['data']['attachementID'], 'medium');
				        $itemHTML = '';
				        $itemHTML .= '<div id="'.$boxData['box_key'].'" class="metaBoxContentBox">';
				        $itemHTML .= '<div class="itemActionMenu">';
				        $itemHTML .= '<a class="button-secondary alignright removeBTN" href="#'.$boxData['box_key'].'">Remove</a>';
				        $itemHTML .= '<a class="button-secondary alignright moveDownBTN" href="#'.$boxData['box_key'].'">Move down</a>';
				        $itemHTML .= '<a class="button-secondary alignright moveUpBTN" href="#'.$boxData['box_key'].'">Move up</a>';
				        $itemHTML .= '<div class="clear-fx"></div>';
				        $itemHTML .= '</div>';
				        $itemHTML .= '<label class="customLabel">Add small description</label>';
				        $itemHTML .= '<input class="inputText fullWidth" type="text" name="'.$this->getPostSlug().'['.$boxData['box_key'].'][smallDescription]" value="'.wptexturize($boxData['data']['smallDescription']).'" />';
				        $itemHTML .= '<div class="portfolioImgPreview"><img src="'.$imgPreview[0].'" /></div>';
				        $itemHTML .= '<input class="attachementThumbURL" type="hidden" name="'.$this->getPostSlug().'['.$boxData['box_key'].'][attachementThumbURL]" value="'.$boxData['data']['attachementThumbURL'].'" />';
				        $itemHTML .= '<input class="attachementID" type="hidden" name="'.$this->getPostSlug().'['.$boxData['box_key'].'][attachementID]" value="'.$boxData['data']['attachementID'].'" />';						
				        $itemHTML .= '<a class="button-secondary uploadImageBTN" href="#'.$boxData['box_key'].'">Upload image</a>'; 
				        $itemHTML .= '</div>';
						echo $itemHTML;				
					}
				}
			
			?>
						
		</div>
		<a id="addItemBTN" class="button-primary">Add new item</a>
		<?php
	}
	
}

?>