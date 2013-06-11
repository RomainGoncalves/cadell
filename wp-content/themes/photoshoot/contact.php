<?php
/*
Template Name: Contact
*/
?>
<?php $view->checkPreview();?>
<?php
$page = get_page(get_the_ID());
$postContent = $page->post_content;
$pageTitle = $view->titleValidator($page->post_title);
$backgroundImage = $view->getPageFeaturedBackgroundImage(get_the_ID());
$contactOptions = $view->getOptionsGroup('contactOptions');
$secondTitle = $view->titleValidator(__('Message me', 'Photoshoot'));


$mapEmbedded = $contactOptions['mapEmbedded'];

$showSocial = (isset($contactOptions['showSocial']))?$contactOptions['showSocial']:'';
$socialTwitter = (isset($contactOptions['socialTwitter']))?$contactOptions['socialTwitter']:'';
$socialFacebook = (isset($contactOptions['socialFacebook']))?$contactOptions['socialFacebook']:'';
$socialOther = (isset($contactOptions['socialOther']))?$contactOptions['socialOther']:'';
?>

<div class="section-CONTACT">
    
        <!--add here url for this section background image-->
        <img class="sectionBackgroundImage" src="<?php echo $backgroundImage;?>" />
        <!--/section background image-->


        <!--contact main container-->
        <div class="contactMain">
            <div class="contactContainer">
                <div class="hspacer"></div>
                <p class="sectionTitle textColor02"><?php echo $pageTitle['first'];?><span class="textColor01"><?php echo $pageTitle['last'];?></span></p>
                <div class="sectionHline"></div>
                <div class="hspacer"></div>
                <div>
                    <!--contact info-->
                    <div class="contactInfo">
		                <p class="defaultText textColor01">
		                	<?php
		                		echo wpautop(wptexturize(do_shortcode($postContent)));								
		                	?>
		                </p>    
                    </div>
                    <!--/contact info-->
                    
                    <!--google map content-->
                    <div class="mapContent">
                        <?php echo $mapEmbedded;?>    
                    </div>
                    <!--/google map content-->
                    
                    <div class="clear-fx"></div>
                    <div class="hspacer"></div>

                    <!--social links-->
                    <?php
                    	if($showSocial=='ON'){
                    		$twitter = '';
							if($socialTwitter!=''){
								$twitter = '<div class="socialIco socialItems"><a href="'.$twitter.'" target="_blank"><img src="'.IMAGES.'/social_icon1.png" alt="social link" /></a></div>';
							}
							$fb = '';
							if($socialFacebook!=''){
								$fb = '<div class="socialIco socialItems"><a href="'.$socialFacebook.'" target="_blank"><img src="'.IMAGES.'/social_icon2.png" alt="Facebook page" /></a></div>';
							}
							$other = '';
							if($socialOther!=''){
								$other = '<div class="socialIco socialItems"><a href="'.$socialOther.'" target="_blank"><img src="'.IMAGES.'/social_icon3.png" alt="social link" /></a></div>';
							}
                    		$socialHtml = '
			                    <div class="getSocial">
			                        <div class="socialText socialItems textColor02">'.__('Get social', 'Photoshoot').'</div>
			                        <div class="smallYellowArrow socialItems"></div>
			                        '.$twitter.$fb.$other.'
			                        <div class="clear-fx"></div>     
			                    </div>                    		
                    		';
							
							echo $socialHtml;
                    	}
                    ?>
                    <!--/social links-->               
                </div>
                
                
                <p class="sectionTitle textColor02"><?php echo $secondTitle['first'];?><span class="textColor01"><?php echo $secondTitle['last'];?></span></p>
                <div class="sectionHline"></div>
                <div class="hspacer"></div>
                
                <p class="mandatoryFields"><?php _e('All fields are mandatory', 'Photoshoot');?></p>
                <!--contact form-->
                <form name="contact" class="contactForm" action="">
                    <div id="inputsArea">                        
                        <div><input type="text" id="name" class="textInput" value="<?php _e('Your name...', 'Photoshoot');?>" /></div>
                        <div class="hspacer"></div>
                        <div><input type="text" id="email" class="textInput" value="<?php _e('Your email...', 'Photoshoot');?>" /></div>
                    </div>
                    <div id="textArea">
                        <textarea id="txt" rows="0" cols="0" id="message"><?php _e('Your message...', 'Photoshoot');?></textarea>   
                    </div>
                    <div class="clear-fx"></div>
                </form>
                <!--/contact form-->
                
                <div class="hspacer"></div>
                <p id="thankYouText"><?php _e('Your message has been sent!', 'Photoshoot');?></p>
                <div class="formButton"><a id="sendBTN" class="yellowButton backgroundColor01 textColor03 alignright" href="" title="contact"><?php _e('SEND', 'Photoshoot');?></a></div>                                    
                <div class="clear-fx"></div>
            </div>           
        </div> 
        <!--/contact main container-->
      
      
    
</div>