$ = jQuery.noConflict();
$(document).ready(function(){
    try{
        var instance = new BackgroundUtil();
    }catch(e){}
});

function BackgroundUtil(){
    var uploadBTN = $('#uploadBackBTN');
    var imageUI = $('#backIMG');
    var boxID;
    var imageSelectedCallback;
    
    uploadBTN.click(function(e){
        e.preventDefault();
        boxID = $(this).attr('href');
        imageSelectedCallback = portfolioImageUploadCallback;    
        tb_show('Upload background image', 'media-upload.php?post_id=0&type=image&TB_iframe=true', false);  
        return false;
    });
    
    //catch  upload
    var portfolioImageUploadCallback = function(originalImage, thumbImage, imageID){        
        imageUI.attr('src', thumbImage);
        $(boxID).find('#largeImage').val(originalImage);
        $(boxID).find('#smallImage').val(thumbImage);
    }
    
    window.send_to_editor = function(html) {
        var originalImage = $(html).attr('href');
        var thumbImage = $(html).find('img').attr('src');
        var imgid = $(html).find('img').attr('class');
        var imageID = imgid.slice( ( imgid.search(/wp-image-/) + 9 ), imgid.length );
        imageSelectedCallback(originalImage, thumbImage, imageID);
        tb_remove();  
    }          
}
