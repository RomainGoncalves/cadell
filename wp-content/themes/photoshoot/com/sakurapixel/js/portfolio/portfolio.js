$ = jQuery.noConflict();
$(document).ready(function(){
    var instance = new PortfolioHandler();
    instance.init();
});


function PortfolioHandler(){
    //send trough WP
    var post_type_name = portfolioPHPObj['POST_TYPE'];
      
    var portfolioContainer = $('#portfolioContainer');
    var addItemBTN = $('#addItemBTN');
    
    var portfolioItems = [];
    
    this.init = function(){    
        addItemBTN.click(addNewPortfolioItem);
        try{
            resetBoxesData();
        }catch(e){}
    }
    //add new portfolio item
    function addNewPortfolioItem(e){
        e.preventDefault();
        var boxID = 'box_'+uniqueid();
        var box = $(buildPortfolioItem(boxID));
        box.appendTo(portfolioContainer);
        resetBoxesData();
    }
    
    //reset boxes data
    function resetBoxesData(){
        portfolioItems = new Array();
        $('.metaBoxContentBox').each(function(index){           
            var boxID = "#"+$(this).attr('id');
            portfolioItems.push({index: index, boxID: boxID});                           
        });        
        for(var i=0;i<portfolioItems.length;i++){
            $(portfolioItems[i].boxID).find('.moveUpBTN').css('display', 'inline');
            $(portfolioItems[i].boxID).find('.moveDownBTN').css('display', 'inline');
            if(i==0){
                $(portfolioItems[i].boxID).find('.moveUpBTN').css('display', 'none');
            }
            if(i==portfolioItems.length-1){
                $(portfolioItems[i].boxID).find('.moveDownBTN').css('display', 'none');
            }
        }
        resetListeners();
    }
    
    //add listeners
    function resetListeners(){
        $('.removeBTN').unbind('click', removeGroupHandler);
        $('.removeBTN').bind('click', removeGroupHandler);
        
        $('.moveDownBTN').unbind('click', moveDownBox);
        $('.moveDownBTN').bind('click', moveDownBox);
        
        $('.moveUpBTN').unbind('click', moveUpBox);
        $('.moveUpBTN').bind('click', moveUpBox);        
        
        $('.uploadImageBTN').unbind('click', uploadImageHandler);
        $('.uploadImageBTN').bind('click', uploadImageHandler);          
    }
    
    function removeGroupHandler(e){
        e.preventDefault();
        var boxID = $(this).attr('href');
        removeBox(boxID);
    }   
    
    //remove box
    function removeBox(boxID){       
        if(confirm('Are you sure you want to remove this product?')) {            
            $(boxID).remove();
            resetBoxesData();
        }else{}
    }
    
    //move box down
    function moveDownBox(e){        
        e.preventDefault();
        var boxID = $(this).attr('href');
        var indx = getCurrentPosition(boxID);
        var box = $(boxID);
        box.remove();
        box.insertAfter($(portfolioItems[indx+1].boxID));
        resetBoxesData();
    }
    
    //move box up
    function moveUpBox(e){
        e.preventDefault();
        var boxID = $(this).attr('href');
        var indx = getCurrentPosition(boxID);
        var box = $(boxID);
        box.remove();
        box.insertBefore($(portfolioItems[indx-1].boxID));
        resetBoxesData();
    }
    
    function getCurrentPosition(boxID){
        var indx = 0;
        for(var i=0;i<portfolioItems.length;i++){
            if(boxID==portfolioItems[i].boxID){
                indx = i;
                break;
            }
        }
        return indx;
    }
    
    
    var imageSelectedCallback;
    var uploadBoxID;
    //upload new logo
    function uploadImageHandler(e){
        e.preventDefault();
        var boxID = $(this).attr('href');
        uploadBoxID = boxID;
        imageSelectedCallback = portfolioImageUploadCallback;
        tb_show('Upload portfolio image', 'media-upload.php?post_id=0&type=image&TB_iframe=true', false);  
        return false;            
    }
    
    //catch logo upload
    var portfolioImageUploadCallback = function(originalImage, thumbImage, imageID){        
        $(uploadBoxID).find('.portfolioImgPreview img').attr('src', thumbImage);
         $(uploadBoxID).find('.attachementThumbURL').val(thumbImage);
         $(uploadBoxID).find('.attachementID').val(imageID);
         //$(uploadBoxID).find('.originalImageURL').val(originalImage);
    }       
    
    //build portfolio box
    function buildPortfolioItem(boxID){
        var itemHTML = '';
        itemHTML += '<div id="'+boxID+'" class="metaBoxContentBox">';
        itemHTML += '<div class="itemActionMenu">';
        itemHTML += '<a class="button-secondary alignright removeBTN" href="#'+boxID+'">Remove</a>';
        itemHTML += '<a class="button-secondary alignright moveDownBTN" href="#'+boxID+'">Move down</a>';
        itemHTML += '<a class="button-secondary alignright moveUpBTN" href="#'+boxID+'">Move up</a>';
        itemHTML += '<div class="clear-fx"></div>';
        itemHTML += '</div>';
        itemHTML += '<label class="customLabel">Add small description</label>';
        itemHTML += '<input class="inputText fullWidth" type="text" name="'+post_type_name+'['+boxID+'][smallDescription]" value="" />';
        itemHTML += '<div class="portfolioImgPreview"><img src="" /></div>';
        itemHTML += '<input class="attachementThumbURL" type="hidden" name="'+post_type_name+'['+boxID+'][attachementThumbURL]" />';
        itemHTML += '<input class="attachementID" type="hidden" name="'+post_type_name+'['+boxID+'][attachementID]" />';        
        itemHTML += '<a class="button-secondary uploadImageBTN" href="#'+boxID+'">Upload image</a>';
        itemHTML += '</div>';
        return itemHTML;
    }
    
    
    window.send_to_editor = function(html) {
        var originalImage = $(html).attr('href');
        var thumbImage = $(html).find('img').attr('src');
        var imgid = $(html).find('img').attr('class');
        var imageID = imgid.slice( ( imgid.search(/wp-image-/) + 9 ), imgid.length );
        imageSelectedCallback(originalImage, thumbImage, imageID);
        tb_remove();  
    }     
    
    //unique id
    function uniqueid(){
        var idstr=String.fromCharCode(Math.floor((Math.random()*25)+65));
        do {                
            // between numbers and characters (48 is 0 and 90 is Z (42-48 = 90)
            var ascicode=Math.floor((Math.random()*42)+48);
            if (ascicode<58 || ascicode>64){
                // exclude all chars between : (58) and @ (64)
                idstr+=String.fromCharCode(ascicode);    
            }                
        } while (idstr.length<32);    
        return (idstr);
    }    
    
    
    
}
