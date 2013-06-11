<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/GenericOptionPage.php');
class ContactOptionPage extends GenericOptionPage{
	
	//page content - override
	public function showPageContent(){
		$options = get_option($this->getOptionGroup());
		
		$emailReceive = (isset($options['emailReceive']))?$options['emailReceive']:'youremail@yourwebsite.com';		
		$mapEmbedded = (isset($options['mapEmbedded'])&&$options['mapEmbedded']!='')?$options['mapEmbedded']:$this->getDefaultMap();
		
		
		$showSocialChecked = "";
		$showSocial = "ON";
		$showSocial = (isset($options['showSocial']))?$options['showSocial']:"";
		if($showSocial=='ON'){
			$showSocialChecked = 'checked';
		}		
		
		$socialTwitter = wptexturize((isset($options['socialTwitter']))?$options['socialTwitter']:$this->getDefaultSocialURL());
		$socialFacebook = wptexturize((isset($options['socialFacebook']))?$options['socialFacebook']:$this->getDefaultSocialURL());
		$socialOther = wptexturize((isset($options['socialOther']))?$options['socialOther']:$this->getDefaultSocialURL());
		//socialTwitter
		?>
		
		<h2>Contact Page Settings</h2>
		<form id="landingOptions" method="post" action="options.php">
			<?php settings_fields($this->getOptionGroup()); ?>
					
			<!--box-->	
			<div class="metaBoxContentBox">				
					<label class="customLabel">Email (where to receive contact form messages)</label>
					<div class="hLine"></div>				
					<input class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[emailReceive]" value="<?php echo $emailReceive;?>" />																																																
			</div>
			<!--/box-->
			<!--box-->	
			<div class="metaBoxContentBox">				
					<label class="customLabel">Google map iframe code (400x250 px iframe)</label>
					<div class="hLine"></div>				
					<textarea class="boxContentTextarea" name="<?php echo $this->getOptionGroup();?>[mapEmbedded]" rows="4"><?php echo $mapEmbedded; ?></textarea>																																									
			</div>
			<!--/box-->
			
			<!--box-->
			<div class="metaBoxContentBox">				
					<label class="customLabel">Social buttons</label>
					<div class="hLine"></div>
					
					<input type="checkbox" name="<?php echo $this->getOptionGroup();?>[showSocial]" value="ON" <?php echo $showSocialChecked;?> />
					<label class="chBLabel">Show social buttons</label>					
					<div class="hLine"></div>
					
					<label class="customLabel">Twitter URL</label>
					<input class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[socialTwitter]" value="<?php echo $socialTwitter;?>" />
					<label class="customLabel">Facebook URL</label>
					<input class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[socialFacebook]" value="<?php echo $socialFacebook;?>" />
					<label class="customLabel">Other</label>
					<input class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[socialOther]" value="<?php echo $socialOther;?>" />																																																								
			</div>
			<!--/box-->
																							
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'Photoshoot') ?>" />
	      	</p>		
		</form>		
		
		<?php
	}

	public function getDefaultMap(){
		$defMap = '
			<iframe width="400" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=San+Francisco,+CA,+United+States&amp;aq=0&amp;oq=san+fra&amp;sll=45.843342,24.977871&amp;sspn=0.06876,0.181789&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=San+Francisco,+California&amp;ll=37.77493,-122.419416&amp;spn=0.004876,0.011362&amp;z=14&amp;output=embed"></iframe>		
		';
		return $defMap;
	}
	
	private function getDefaultSocialURL(){
		return'http://themeforest.net/user/SakuraPixel/';
	}
}

?>