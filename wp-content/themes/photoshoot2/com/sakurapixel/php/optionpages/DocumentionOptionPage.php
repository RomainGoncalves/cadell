<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/GenericOptionPage.php');
class DocumentionOptionPage extends GenericOptionPage {
	
	//page content - override
	public function showPageContent(){
		?>
		<iframe class="docIframe" src="<?php echo TEMPPATH?>/documentation/index.html">
			
		</iframe>
		<?php
	}
}

?>