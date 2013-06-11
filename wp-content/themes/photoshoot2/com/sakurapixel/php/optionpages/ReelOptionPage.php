<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/GenericOptionPage.php');
class ReelOptionPage extends GenericOptionPage{
		
		//page content - override
	public function showPageContent(){
		$options = get_option($this->getOptionGroup());
		$reelEmbedded = (isset($options['reelEmbedded'])&&$options['reelEmbedded']!='')?$options['reelEmbedded']:$this->getDefaultVid();
		?>
		
		<h2>Reel Page Settings</h2>
		<p>Info: Please note that the iframe width should not exceed 750px.</p>
		<form id="landingOptions" method="post" action="options.php">
			<?php settings_fields($this->getOptionGroup()); ?>
					
			<!--box-->	
			<div class="metaBoxContentBox">				
					<label class="customLabel">Embedded video code</label>
					<div class="hLine"></div>				
					<textarea class="boxContentTextarea" name="<?php echo $this->getOptionGroup();?>[reelEmbedded]" rows="4"><?php echo $reelEmbedded; ?></textarea>																																									
			</div>
			<!--/box-->			
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'Photoshoot') ?>" />
	      	</p>		
		</form>		
				
		<?php		
		
	}
	
	private function getDefaultVid(){
		$defVid = '<iframe src="http://player.vimeo.com/video/10101601?title=0&amp;byline=0&amp;color=fff79a&amp;autoplay=1" width="750" height="422" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		return $defVid;
	}	
		
}
?>