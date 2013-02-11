<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/GenericOptionPage.php');
class ThemeOptionPage extends GenericOptionPage{
	
		//page content - override
	public function showPageContent(){
		$options = get_option($this->getOptionGroup());
		$logoImage = (isset($options['logoImage'])&&$options['logoImage']!='')?$options['logoImage']:IMAGES.'/default/logo.ong';
		$primaryTextColor = (isset($options['primaryTextColor'])&&$options['primaryTextColor']!='')?$options['primaryTextColor']:'FFFFFF';
		$secondaryTextColor = (isset($options['secondaryTextColor'])&&$options['secondaryTextColor']!='')?$options['secondaryTextColor']:'fff79a';
		
		$enterFSTooltip = wptexturize((isset($options['enterFSTooltip']))?$options['enterFSTooltip']:'Click to enter full screen!');
		$exitFSTooltip = wptexturize((isset($options['exitFSTooltip']))?$options['exitFSTooltip']:'Click to exit full screen!');
		
		$lightboxMouseChecked = '';
		$lightboxisMouseMove = (isset($options['lightboxisMouseMove']))?$options['lightboxisMouseMove']:"";		
		if($lightboxisMouseMove=='ON'){
			//echo "SET and ON";
			$lightboxMouseChecked = 'checked';
		}else{
			//echo "NOT SET";
		}
		
		$showBlogCommentsChecked = '';
		$showBlogComments = (isset($options['showBlogComments']))?$options['showBlogComments']:"";
		if($showBlogComments=='ON'){
			$showBlogCommentsChecked = 'checked';
		}

		$showBlogReplayChecked = '';
		$showBlogReplay = (isset($options['showBlogReplay']))?$options['showBlogReplay']:"";
		if($showBlogReplay=='ON'){
			$showBlogReplayChecked = 'checked';
		}

		$showLightboxRegularPostChecked = '';
		$showLightboxPost = (isset($options['showLightboxPost']))?$options['showLightboxPost']:"";
		if($showLightboxPost=='ON'){
			$showLightboxRegularPostChecked = 'checked';
		}
		
		$googleAnalytics = wptexturize((isset($options['googleAnalytics']))?$options['googleAnalytics']:'');


		?>
		
		<h2>Theme General Settings</h2>
		<form id="landingOptions" method="post" action="options.php">
			<?php settings_fields($this->getOptionGroup()); ?>
					
			<!--box-->	
			<div class="metaBoxContentBox" id="imgContainer">				
					<label class="customLabel">Theme logo (218x117px recommended)</label>
					<div class="hLine"></div>				
					<div>
						<img id="logoIMG" src="<?php echo $logoImage; ?>" />
					</div>
					<div class="space01"></div>
					<a class="button-secondary" id="uploadLogoBTN" href="#imgContainer">Upload logo image</a>
					<input id="largeImage" class="inputText fullWidth" type="hidden" name="<?php echo $this->getOptionGroup();?>[logoImage]" value="<?php echo $logoImage;?>" />																																															
			</div>
			<!--/box-->
			
			<!--box-->	
			<div class="metaBoxContentBox">
					<label class="customLabel">Theme text colors</label>
					<div class="hLine"></div>
					<label class="customLabel">Text primary color</label>
					<input id="primaryTextColor" class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[primaryTextColor]" value="<?php echo $primaryTextColor;?>" />
					<label class="customLabel">Text secondary color</label>
					<input id="secondaryTextColor" class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[secondaryTextColor]" value="<?php echo $secondaryTextColor;?>" />
					<div class="space01"></div>
					<a id="resetColorsBTN" class="button-secondary">Reset to default</a>																																																								
			</div>
			<!--/box-->
			
			<!--box-->	
			<div class="metaBoxContentBox">				
					<label class="customLabel">Full screen tooltips</label>
					<div class="hLine"></div>
					<label class="customLabel">Enter full screen tooltip</label>
					<input class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[enterFSTooltip]" value="<?php echo $enterFSTooltip;?>" />
					<label class="customLabel">Exit full screen tooltip</label>
					<input class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[exitFSTooltip]" value="<?php echo $exitFSTooltip;?>" />																																																								
			</div>
			<!--/box-->
			
			<!--box-->	
			<div class="metaBoxContentBox">				
					<label class="customLabel">General settings</label>
					<div class="hLine"></div>
					<div class="space01"></div>					
					<input type="checkbox" name="<?php echo $this->getOptionGroup();?>[lightboxisMouseMove]" value="ON" <?php echo $lightboxMouseChecked;?> />
					<label class="chBLabel">Is lightbox mouse move (image movement based on mouse position)</label>
					<div class="space01"></div>
					<input type="checkbox" name="<?php echo $this->getOptionGroup();?>[showLightboxPost]" value="ON" <?php echo $showLightboxRegularPostChecked;?> />
					<label class="chBLabel">Show Photoshoot lightbox for images within regular pages and regular posts.</label>						
					<div class="space01"></div>
					<input type="checkbox" name="<?php echo $this->getOptionGroup();?>[showBlogComments]" value="ON" <?php echo $showBlogCommentsChecked;?> />
					<label class="chBLabel">Show blog comments</label>
					<div class="space01"></div>
					<input type="checkbox" name="<?php echo $this->getOptionGroup();?>[showBlogReplay]" value="ON" <?php echo $showBlogReplayChecked;?> />
					<label class="chBLabel">Show blog replay form (Show existing comments - users can not post comments anymore)</label>																																																																																					
			</div>
			<!--/box-->
			
			
			<!--box-->	
			<div class="metaBoxContentBox">				
					<label class="customLabel">Google Analytics</label>
					<div class="hLine"></div>				
					<textarea class="boxContentTextarea" name="<?php echo $this->getOptionGroup();?>[googleAnalytics]" rows="4"><?php echo $googleAnalytics; ?></textarea>																																																								
			</div>
			<!--/box-->			
			
														
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'Photoshoot') ?>" />
	      	</p>		
		</form>		
		
		<?php		
		
	}	
}

?>