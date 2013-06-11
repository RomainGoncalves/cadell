<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/GenericOptionPage.php');
class HomeOptionsPage extends GenericOptionPage{

	//page content - override
	public function showPageContent(){
		$options = get_option($this->getOptionGroup());
		
		$oneColumnShow = "ON";
		$oneColumnChecked = "";
		$oneColumnItemsNo = 6;
		$twoColumnShow = "ON";
		$twoColumnChecked = "";
		$twoColumnItemsNo = 6;
			
		$oneColumnShow = (isset($options['oneColumnShow']))?$options['oneColumnShow']:"";
		$oneColumnItemsNo = (isset($options['oneColumnItemsNo']))?$options['oneColumnItemsNo']:6;
			
		$twoColumnShow = (isset($options['twoColumnShow']))?$options['twoColumnShow']:"";
		$twoColumnItemsNo = (isset($options['twoColumnItemsNo']))?$options['twoColumnItemsNo']:6;
		
		if($oneColumnShow=='ON'){
			$oneColumnChecked = 'checked';
		}
		if($twoColumnShow=='ON'){
			$twoColumnChecked = 'checked';
		}		
		
		$aboutTooltip = wptexturize((isset($options['aboutTooltip']))?$options['aboutTooltip']:'About me');
		$oneColTooltip = wptexturize((isset($options['oneColTooltip']))?$options['oneColTooltip']:'Open recent exibits');
		$twoColTooltip = wptexturize((isset($options['twoColTooltip']))?$options['twoColTooltip']:'Recent trends');								
		
		?>
		<h2>Home Page Settings</h2>
		<form id="landingOptions" method="post" action="options.php">
			<?php settings_fields($this->getOptionGroup()); ?>
					
			<!--one column settings-->	
			<div class="metaBoxContentBox">				
					<label class="customLabel">One Column Gallery settings</label>
					<div class="hLine"></div>				
					<input type="checkbox" name="<?php echo $this->getOptionGroup();?>[oneColumnShow]" value="ON" <?php echo $oneColumnChecked;?> />
					<label class="chBLabel">Add One Column Gallery to homepage</label>
					<div class="space01"></div>
					<input class="numStep" type="number" name="<?php echo $this->getOptionGroup();?>[oneColumnItemsNo]" value="<?php echo $oneColumnItemsNo;?>" min="1" max="20" /><label class="chBLabel">Max number of gallery items</label>							
			</div>
			<!--/one column settings-->
			
			<!--two column settings-->	
			<div class="metaBoxContentBox">				
					<label class="customLabel">Two Columns Gallery settings</label>
					<div class="hLine"></div>
					<input type="checkbox" name="<?php echo $this->getOptionGroup();?>[twoColumnShow]" value="ON" <?php echo $twoColumnChecked;?> />
					<label class="chBLabel">Add Two Columns Gallery to homepage</label>
					<div class="space01"></div>
					<input class="numStep" type="number" name="<?php echo $this->getOptionGroup();?>[twoColumnItemsNo]" value="<?php echo $twoColumnItemsNo;?>" min="1" max="20" /><label class="chBLabel">Max number of gallery items</label>							
			</div>
			<!--/two column settings-->
			
			<!--tooltips-->	
			<div class="metaBoxContentBox">				
					<label class="customLabel">Home page tooltips</label>
					<div class="hLine"></div>
					<label class="customLabel">Text section's tooltip</label>
					<input class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[aboutTooltip]" value="<?php echo $aboutTooltip;?>" />
					<label class="customLabel">One Column gallery's tooltip</label>
					<input class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[oneColTooltip]" value="<?php echo $oneColTooltip;?>" />
					<label class="customLabel">Two Columns gallery's tooltip</label>
					<input class="inputText fullWidth" type="text" name="<?php echo $this->getOptionGroup();?>[twoColTooltip]" value="<?php echo $twoColTooltip;?>" />																					
			</div>
			<!--/tooltips-->							
			
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'Photoshoot') ?>" />
	      	</p>		
		</form>				
		
		<?php		
	}	
}

?>