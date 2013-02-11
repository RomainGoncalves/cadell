<?php
require_once(CLASS_PATH.'/com/sakurapixel/php/optionpages/GenericOptionPage.php');
class AboutOptionPage extends GenericOptionPage {
	
	//page content - override
	public function showPageContent(){
		?>
		<h2>Home Page Settings</h2>
		<p>About page does not have any settings, please use the submenu 'About Page Options > Edit background' in order to set a background for this page.</p>
		<?php
	}
}


?>