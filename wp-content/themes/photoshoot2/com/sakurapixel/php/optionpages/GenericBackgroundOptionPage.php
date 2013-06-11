<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/GenericOptionPage.php');
/**
 * Genrric background page
 */
class GenericBackgroundOptionPage extends GenericOptionPage {
	
	private $pageTitle;
	function __construct($pageTitle){
		$this->pageTitle = $pageTitle;
	}
		//page content - override
	public function showPageContent(){
		$options = get_option($this->getOptionGroup());
		
		$backgroundImage = (isset($options['backgroundImage']))?$options['backgroundImage']:'';
		$backgroundImageSmall = (isset($options['backgroundImageSmall']))?$options['backgroundImageSmall']:IMAGES."/default/default_background_small.jpg";		
		
		?>
		
		<h2><?php echo $this->pageTitle;?></h2>
		<form id="landingOptions" method="post" action="options.php">
			<?php settings_fields($this->getOptionGroup()); ?>
					
			<!--box-->	
			<div class="metaBoxContentBox" id="backImgContainer">				
					<label class="customLabel">Set background image (1980x1080px recommended background image)</label>
					<div class="hLine"></div>
					<div>
						<img id="backIMG" src="<?php echo $backgroundImageSmall; ?>" />
					</div>
					<div class="space01"></div>
					<a class="button-secondary" id="uploadBackBTN" href="#backImgContainer">Upload background image</a>
					<input id="largeImage" class="inputText fullWidth" type="hidden" name="<?php echo $this->getOptionGroup();?>[backgroundImage]" value="<?php echo $backgroundImage;?>" />
					<input id="smallImage" class="inputText fullWidth" type="hidden" name="<?php echo $this->getOptionGroup();?>[backgroundImageSmall]" value="<?php echo $backgroundImageSmall;?>" />																																												
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