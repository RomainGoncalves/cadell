$ = jQuery.noConflict();
$(document).ready(function(){
    try{
        var instance = new OptionsUtil();
        instance.cpicker();
    }catch(e){
        console.log(e);
    }
});

function OptionsUtil(){
    var uploadBTN = $('#uploadLogoBTN');
    var imageUI = $('#logoIMG');
    var boxID;
    var imageSelectedCallback;
    
    
    uploadBTN.click(function(e){
        e.preventDefault();
        boxID = $(this).attr('href');
        imageSelectedCallback = portfolioImageUploadCallback;    
        tb_show('Upload logo image', 'media-upload.php?post_id=0&type=image&TB_iframe=true', false);  
        return false;
    });
    
    //catch  upload
    var portfolioImageUploadCallback = function(originalImage, thumbImage, imageID){        
        imageUI.attr('src', thumbImage);
        $(boxID).find('#largeImage').val(originalImage);
    }
    
    window.send_to_editor = function(html) {
        var originalImage = $(html).attr('href');
        var thumbImage = $(html).find('img').attr('src');
        var imgid = $(html).find('img').attr('class');
        var imageID = imgid.slice( ( imgid.search(/wp-image-/) + 9 ), imgid.length );
        imageSelectedCallback(originalImage, thumbImage, imageID);
        tb_remove();  
    }
    
    this.cpicker = function(){        
        $('#primaryTextColor, #secondaryTextColor').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val(hex);
                $(el).ColorPickerHide();
            },
            onBeforeShow: function () {
                $(this).ColorPickerSetColor(this.value);
            }            
        }).bind('keyup', function(){
            $(this).ColorPickerSetColor(this.value);
        });
    }
    
    //reset theme colors
    $('#resetColorsBTN').click(function(e){
        e.preventDefault();
        $('#primaryTextColor').val('FFFFFF');
        $('#secondaryTextColor').val('fff79a');
    });              
}
