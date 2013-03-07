
var activateGaleryOneClick = true;

/**
 * HOME SECTION
 */
function HomeSection(){
    
    var sectionUI;
    var contentButons;
    var firstTimeLoad=true;
    //init home section behavior
    this.init=function(sectionUIC){
        EventBus.addEventListener(Event.WINDOW_RESIZE, windowResize);
        sectionUI = sectionUIC;
        contentButons=[];
        var py=0;
        var startZ=81;
        sectionUI.find('#homeButtons div').each(function(){
            var btnLink = $(this).find('a').attr('href');
            btnLink = btnLink.substr(2, btnLink.length);
            var contentUI = $('#'+btnLink);
            
            var tooltip = new Tooltip($(this), $('#contentWrapper'));
            
            var isOtherSection = false;            
            //extract content type
            var type = contentUI.attr('class');
            //init one column type behavior
            (type=="oneColumGalleryContent")?new OneColumnGalery(contentUI):null;
            //init two column type behavior
            (type=="twoColumGalleryContent")?new TwoColumnGalery(contentUI):null;
            
            contentUI.css('z-index', startZ);
            startZ++;
            $(this).find('a').remove(); 
            $(this).css('position', 'relative');    
            $(this).css('top', py+'px');
            py+=40;       
            var btn;
            var contentType = $(this).attr('class');          
            switch(contentType){
                case 'aboutTextBTN':
                    btn = new GenericButton($(this), globalJS.RESOURCES_PATH+'/images/about_content_off.png', globalJS.RESOURCES_PATH+'/images/about_content_on.png');
                    btn.clickCallback(changeHomeContent);
                    btn.isSelected(false);
                break;
                case 'gridGalleryBTN':
                    btn  = new GenericButton($(this), globalJS.RESOURCES_PATH+'/images/grid_gallery_off.png', globalJS.RESOURCES_PATH+'/images/grid_gallery_on.png');
                    btn.clickCallback(changeHomeContent);
                    btn.isSelected(false);                    
                break;
                case 'singleGalleryBTN':
                    btn = new GenericButton($(this), globalJS.RESOURCES_PATH+'/images/single_gallery_off.png', globalJS.RESOURCES_PATH+'/images/single_gallery_on.png');
                    btn.clickCallback(changeHomeContent);
                    btn.isSelected(false);                    
                break;
                case 'otherSectionBTN':
                    isOtherSection = true;
                    btn = new GenericButton($(this), globalJS.RESOURCES_PATH+'/images/play_btn.png', globalJS.RESOURCES_PATH+'/images/play_btn.png');
                    btn.clickCallback(changeHomeContent);
                    btn.isSelected(false);                    
                break;                                              
            }
            contentButons.push({button: btn, itemUI: contentUI, isOtherSection: isOtherSection, btnLink:btnLink, contentType:contentType});
        });
        if(contentButons.length>0){
            $('#homeButtons').css('z-index', startZ);
            hideAllContent();
            windowResize();
            openHomeContent(0);
        }
    }
    
    /**
     * hide all home content
     */
    function hideAllContent(){
        for(var i=0;i<contentButons.length;i++){
            var itemUI = contentButons[i].itemUI;
            itemUI.css('left', -itemUI.width()+"px");
        }
    }
    
    //change home content
    function changeHomeContent(id){
        for(var i=0;i<contentButons.length;i++){
            if(id==contentButons[i].button.getID()){
                if(contentButons[i].isOtherSection){
                    document.location.href = "#!"+contentButons[i].btnLink;
                }else{
                    openHomeContent(i);
                }
            }
        }
    }
    
    var currentHomeContentUI;
    /**
     * open specific home content
     */
    function openHomeContent(contentIndex){
         for(var i=0;i<contentButons.length;i++){
             contentButons[i].button.isSelected(false);
             if(i==contentIndex){
                 contentButons[i].button.isSelected(true);
                 (!PopUpManager.getInstance().getStatus())?PopUpManager.getInstance().showRestrict():null;                 
                 if(currentHomeContentUI!=null&&currentHomeContentUI!=undefined){
                     removeOldContent(i);
                 }else{
                     showNewContent(i);
                 }
             }
         }
    }
    /**
     * remove old content
     */
    function removeOldContent(newContentIndex){
        var time = 800;
        ((currentHomeContentUI.width()+10)>sectionUI.width())?time=1000:null;
        currentHomeContentUI.animate({
            left: -currentHomeContentUI.width()+'px'
        }, time, 'easeOutQuint', function complete(){
            showNewContent(newContentIndex);
        });        
    }
    /**
     * show selected conent
     */
    function showNewContent(newContentIndex){
        currentHomeContentUI = contentButons[newContentIndex].itemUI;
        if(firstTimeLoad){
            firstTimeLoad = false;
            currentHomeContentUI.css('left', '0px');
            (!PopUpManager.getInstance().getStatus())?PopUpManager.getInstance().dismiss():null;
            return;
        }
        $('<div></div>').animate({
           left: '0px'
        }, 200, function onComplete(){
           (!PopUpManager.getInstance().getStatus())?PopUpManager.getInstance().dismiss():null;
        });        
        var time = 900;
        ((currentHomeContentUI.width()+10)>sectionUI.width())?time=1000:null;        
        currentHomeContentUI.animate({
            left: '0px'
        }, time, 'easeOutQuint', function complete(){
            //(!PopUpManager.getInstance().getStatus())?PopUpManager.getInstance().dismiss():null;
        });            
    }
    
    /**
     * handle window resize event
     */
    function windowResize(){
        for(var i=0;i<contentButons.length;i++){
            var itemUI = contentButons[i].itemUI;
            if(itemUI.height()<$('#pagesContent').height()){
                if(contentButons[i].contentType=="aboutTextBTN"){
                    itemUI.css('top', $('#pagesContent').height()/2-itemUI.height()/2+"px");
                }
            }
        }        
    }
}
/**
 * END HOME SECTION
 */



/*
 * PORTFOLIO SECTION
 */
function PrortfolioSection(sectionUI){
        
    var portfolioItems;
    var countLoadedPortfolioItems;
    var defaultMenuScrollContainer;
    init();
    function init(){
        portfolioItems = [];
        $(window).resize(function(){
            resizeEvent();
        });        
        $('.portfolioItem').each(function(index){
            var thumbURL = $(this).find('.portfolioItemImage img').attr('src');
            $(this).find('.portfolioItemImage img').remove();
            $(this).find('.portfolioItemContent').css('height', '0px');
            $(this).find('.portfolioItemContent').click(function(){
                openPortfolioGallery(index);
            });
            $(this).find('.portfolioItemDescription').css('visibility', 'hidden');
            $(this).find('.portfolioItemDescription').text($(this).find('.portfolioItemDescription').text()+' ('+$(this).find('.galeryItem').length+')');
            
            //console.log($(this).find('.galeryItem').length);
            var insideGalleryHTML = $(this).find('.galeryItems').html();
            
            var galleryInsideTitle = $(this).find('.insideGalleryTitle').html();
            $(this).find('.galeryItems').remove();
            $(this).find('.insideGalleryTitle').remove();            
            
            portfolioItems.push({jqueryItem: $(this), thumbURL: thumbURL, insideGalleryHTML:insideGalleryHTML, galleryInsideTitle:galleryInsideTitle});
        });
        sectionUI.find('.backButton').click(function(e){
            e.preventDefault();
            sectionUI.find('.portfolioMainContent').stop().animate({
                left: '0px'
            }, 1000, 'easeOutQuint');            
        });        
        countLoadedPortfolioItems=-1;
        loadPortfolioImage();        
        resizeEvent();             
    }
    
    /*
     * load portfolio thumb image
     */
    function loadPortfolioImage(){
         countLoadedPortfolioItems++;
         if(countLoadedPortfolioItems<portfolioItems.length){             
            //load thumb image
            var req = new JQueryAjax();
            req.loadImage(portfolioItems[countLoadedPortfolioItems].thumbURL, function(img){               
                img.appendTo(portfolioItems[countLoadedPortfolioItems].jqueryItem.find('.portfolioItemImage'));
                        
                portfolioItems[countLoadedPortfolioItems].jqueryItem.find('.portfolioItemContent').animate({
                    height: 236
                }, 600, 'easeInQuad', function onComplete(){
                    portfolioItems[countLoadedPortfolioItems].jqueryItem.find('.portfolioItemDescription').css('visibility', 'visible');                    
                    loadPortfolioImage();
                });                
                
            }, function(){alert('Broken image');});             
             
         }else{
             //('finish loaded');             
             sectionUI.find('.portfolioItems').mCustomScrollbar();
         }        
    }
    
    var countInsideItems;
    var insideItems;
    var insideGalleryScroll;
    //open specific portfolio gallery
    function openPortfolioGallery(indexNo){
        var items = $(portfolioItems[indexNo].insideGalleryHTML);
        
        try{
            sectionUI.find('.galeryMask div').remove();            
        }catch(e){}
        $('<div class="galeryItems"></div>').appendTo(sectionUI.find('.galeryMask')); 
        //change gallery title
        sectionUI.find('#insideGalleryTitle').html(portfolioItems[indexNo].galleryInsideTitle);
        $('.indexGalleriesTitle').find('span').addClass('textColor01');
        items.appendTo(sectionUI.find('.galeryMask .galeryItems'));
        sectionUI.find('.portfolioMainContent').stop().animate({
            left: '-900px'
        }, 900, 'easeOutQuint');
                        
        countInsideItems=-1;
        insideItems = [];
        sectionUI.find('.galeryMask .galeryItems .galeryItem').each(function(index){
            var thumb = $(this).find('.galeryItemThumb img').attr('src');
            var largeImageURL = $(this).find('.largeImage').attr('href');          
            var description = $(this).find('.itemDescription').html();
                        
            $(this).find('.largeImage').remove();
            $(this).find('.itemDescription').remove();
            $(this).find('.galeryItemThumb img').remove();
            var jqueryItem = $(this);
            
            $('<div class="galleryLaunchButton"><img src="'+globalJS.RESOURCES_PATH+'/images/open_gallery.png" /></div>').appendTo($(this).find('.galeryItemContent'));
            $(this).find('.galleryLaunchButton').css('visibility', 'hidden');
            
            $(this).click(function(){
                openLargeGalleryImage(index);
                selectItemInsideGallery(index);                
            });
            
            $(this).find('.galleryLaunchButton').click(function(){
                openLargeGalleryImage(index);
            });
            
            insideItems.push({jqueryItem:jqueryItem, thumb: thumb, largeImageURL:largeImageURL, description:description});
        });
        
        if(insideGalleryScroll!=null||insideGalleryScroll!=undefined){
            try{
                insideGalleryScroll.gcc();
            }catch(e){}
        }

        resizeEvent();
        loadSpecificGalleryItems();
    }
    
    var delayTime=100;
    //load inside gallery thumb
    function loadSpecificGalleryItems(){
        countInsideItems++;
        if(countInsideItems<insideItems.length){
            var req = new JQueryAjax();
            req.loadImage(insideItems[countInsideItems].thumb, function(img){               
                img.appendTo(insideItems[countInsideItems].jqueryItem.find('.galeryItemThumb'));
                
                insideItems[countInsideItems].jqueryItem.find('.galeryItemContent').delay(delayTime).animate({
                    width: '242px'
                }, 600, 'easeInQuad');
                delayTime+=50;
                loadSpecificGalleryItems();                                               
           });
                  
        }else{            
            sectionUI.find('.galeryItems').mCustomScrollbar();
        }
    }    
    
    //select inside gallery item
    function selectItemInsideGallery(index){
        for(var i=0;i<insideItems.length;i++){
            if(i!=index){
                insideItems[i].jqueryItem.css('box-shadow', 'none');
                insideItems[i].jqueryItem.find('.galleryLaunchButton').css('visibility', 'hidden');
            }else{
                insideItems[i].jqueryItem.css('box-shadow', '0px 0px 15px 2px rgba(255,255,255,1)');
                insideItems[i].jqueryItem.find('.galleryLaunchButton').css('visibility', 'visible');                
            }
        }
    }
    
    var lightboxUI;
    //open lghtbox
    function openLargeGalleryImage(index){
        var lightboxItems=[];
        for(var i=0;i<insideItems.length;i++){
            lightboxItems.push({imgURL: insideItems[i].largeImageURL, itemDescription: insideItems[i].description});
        }
        lightboxUI = new PhotoShootLightbox(lightboxItems, index);        
    }
    
    //window resized
    function resizeEvent(){       
        sectionUI.find('.portfolioItems').css('height', $('#pagesContent').height()-sectionUI.find('.galeriesDescription').height()+'px');
        sectionUI.find('.galeryItems').css('height', $('#pagesContent').height()-(97+40)+'px');
    }
}
/*
 * END PORTFOLIO SECTION
 */

/*
 * TwoColumnGalery class
 */
function TwoColumnGalery(gallery){
    var twoColumnGalleryItems;
    var countLoadedItem;
    init();
    function init(){
               
        twoColumnGalleryItems=[];
        var indx=0;
        gallery.find('.twoColumnItem').each(function(index){
            $('<div class="galleryLaunchButton"><img src="'+globalJS.RESOURCES_PATH+'/images/open_gallery.png" /></div>').appendTo($(this).find('.twoColumnItemContent'));
            var lightboxBTN = $(this).find('.galleryLaunchButton');
            lightboxBTN.css('visibility', 'hidden');
            lightboxBTN.click(function(){
                openLightBox(index);
            });
            
             if(activateGaleryOneClick){
                 $(this).click(function(){
                     openLightBox(index);
                 });
             }            
            
            var itemDescription = $(this).find('.itemDescription').html();
            $(this).find('.itemDescription').remove();                    
                        
            var largeImage = $(this).find('.largeImage').attr('href');
            $(this).find('.largeImage').remove();
            $(this).find('.twoColumnItemContent').css('height', '0px');
            $(this).css('box-shadow', 'none');
            twoColumnGalleryItems.push({jqueryItem: $(this), thumbURL: $(this).find('.twoColumnImageContainer img').attr('src'), largeImage:largeImage, lightboxBTN:lightboxBTN, itemDescription:itemDescription});
            $(this).find('.twoColumnImageContainer img').remove();
            indx++;
        });
        $(window).resize(function(){
            resizeEvent();
        });                                        
        countLoadedItem = -1;
        loadItem();
        resizeEvent();
        gallery.find('.twoGalleryItemsContainer').mCustomScrollbar();                 
    }
    
    var lightboxUI;
    /**
     * open lightbox
     */
    function openLightBox(btn){
        //var indx = extractLightboxIndex(btn, twoColumnGalleryItems);
        var indx = btn;
        var lightboxItems=[];
        for(var i=0;i<twoColumnGalleryItems.length;i++){
            lightboxItems.push({imgURL: twoColumnGalleryItems[i].largeImage, itemDescription: twoColumnGalleryItems[i].itemDescription});
        }
        lightboxUI = new PhotoShootLightbox(lightboxItems, indx);
    }
    //extract index
    function extractLightboxIndex(btn, items){
        var index=0;
        for(var i=0;i<items.length;i++){
            if(btn[0]==items[i].lightboxBTN[0]){
                index=i;
                break;
            }
        }
        return index;
    }
    
    //image loaded, show item
     function loadItem(){
         countLoadedItem++;
         if(countLoadedItem<twoColumnGalleryItems.length){             
            //load thumb image
            var req = new JQueryAjax();
            req.loadImage(twoColumnGalleryItems[countLoadedItem].thumbURL, function(img){               
                img.appendTo(twoColumnGalleryItems[countLoadedItem].jqueryItem.find('.twoColumnImageContainer'));
                img.click(function(){
                    selectItem($(this));
                });
                img.css('cursor', 'pointer');                             
                twoColumnGalleryItems[countLoadedItem].jqueryItem.find('.twoColumnItemContent').animate({
                    height: 340
                }, 600, 'easeInQuad', function onComplete(){
                    loadItem();
                });                
                
            }, function(){alert('Broken image');});             
             
         }else{
             //('finish loaded');
             resizeEvent();             
         }
     }
     
     function resizeEvent(){
         gallery.find('.twoGalleryItemsContainer').css('height', $('#contentWrapper').height()-60+'px');
     }
          
     //select one column item
     function selectItem(img){
         var item = extractItem(img);
     }
     
     //extract one column item index
     function extractItem(img){
         var index=0;
         for(var i=0;i<twoColumnGalleryItems.length;i++){
             twoColumnGalleryItems[i].jqueryItem.css('box-shadow', 'none');
             var img_obj = twoColumnGalleryItems[i].jqueryItem.find('.twoColumnImageContainer img');
             twoColumnGalleryItems[i].jqueryItem.find('.galleryLaunchButton').css('visibility', 'hidden'); 
             img_obj.css('cursor', 'pointer');
             if(img_obj[0]==img[0]){
                 twoColumnGalleryItems[i].jqueryItem.find('.galleryLaunchButton').css('visibility', 'visible');
                 img_obj.css('cursor', 'default');
                 twoColumnGalleryItems[i].jqueryItem.css('box-shadow', '0px 0px 15px 2px rgba(255,255,255,1)');
                 index=i;
             }
         }
         return i;
     }       
        
}



/*
 * OneColumnGalery class
 */
function OneColumnGalery(gallery){
    
    var oneColumnGalleryItems;
    var countLoadedItem;
    init();
    function init(){        
        
        oneColumnGalleryItems=[];
        gallery.find('.oneColumnItem').each(function(index){
            $('<div class="galleryLaunchButton"><img src="'+globalJS.RESOURCES_PATH+'/images/open_gallery.png" /></div>').appendTo($(this).find('.oneColumnItemContent'));

             var lightboxBTN = $(this).find('.galleryLaunchButton');
             lightboxBTN.css('visibility', 'hidden');
             
             lightboxBTN.click(function(){
                 openLightBox(index);
             });
             
             if(activateGaleryOneClick){
                 $(this).click(function(){
                     openLightBox(index);
                 });
             }
             
            var itemDescription = $(this).find('.itemDescription').html();
            $(this).find('.itemDescription').remove();                        
            
            var largeImage = $(this).find('.largeImage').attr('href');
            
            
            $(this).find('.largeImage').remove();
            $(this).find('.oneColumnItemContent').css('height', '0px');
            $(this).find('.oneColumnItemDescription').css('visibility', 'hidden');
            $(this).css('box-shadow', 'none');
            oneColumnGalleryItems.push({jqueryItem: $(this), thumbURL: $(this).find('.oneColumnImageContainer img').attr('src'), largeImage:largeImage, lightboxBTN:lightboxBTN, itemDescription:itemDescription});
            $(this).find('.oneColumnImageContainer img').remove();
        });
        $(window).resize(function(){
            resizeEvent();
        });
        resizeEvent();
        gallery.find('.oneGalleryItemsContainer').mCustomScrollbar();        
        countLoadedItem = -1;
        loadOneColumnItem();                  
    }
    //image loaded, show item
     function loadOneColumnItem(){
         countLoadedItem++;
         if(countLoadedItem<oneColumnGalleryItems.length){             
            //load thumb image
            var req = new JQueryAjax();
            req.loadImage(oneColumnGalleryItems[countLoadedItem].thumbURL, function(img){               
                img.appendTo(oneColumnGalleryItems[countLoadedItem].jqueryItem.find('.oneColumnImageContainer'));
                img.click(function(){
                    selectOneColumnItem($(this));
                });
                img.css('cursor', 'pointer');                             
                oneColumnGalleryItems[countLoadedItem].jqueryItem.find('.oneColumnItemContent').animate({
                    height: 275
                }, 600, 'easeInQuad', function onComplete(){
                    loadOneColumnItem();
                });                
                
            }, function(){alert('Broken image');});             
             
         }else{
             //('finish loaded');                                                   
         }
     }
     
     function resizeEvent(){
         gallery.find('.oneGalleryItemsContainer').css('height', $('#contentWrapper').height()-60+'px');
     }
     
     //select one column item
     function selectOneColumnItem(img){
         var item = extractOneColumnItem(img);
     }
     
     //undelect all items
     this.unselectItems = function(){
         for(var i=0;i<oneColumnGalleryItems.length;i++){
             oneColumnGalleryItems[i].jqueryItem.find('.oneColumnItemDescription').css('visibility', 'hidden');
             oneColumnGalleryItems[i].jqueryItem.find('.galleryLaunchButton').css('visibility', 'hidden');                                       
             oneColumnGalleryItems[i].jqueryItem.css('box-shadow', 'none');
             var img_obj = oneColumnGalleryItems[i].jqueryItem.find('.oneColumnImageContainer img');
             img_obj.css('cursor', 'pointer');
         }         
     }
     
     //extract one column item index
     function extractOneColumnItem(img){
         var index=0;
         for(var i=0;i<oneColumnGalleryItems.length;i++){
             oneColumnGalleryItems[i].jqueryItem.find('.oneColumnItemDescription').css('visibility', 'hidden');
             oneColumnGalleryItems[i].jqueryItem.find('.galleryLaunchButton').css('visibility', 'hidden');                                       
             oneColumnGalleryItems[i].jqueryItem.css('box-shadow', 'none');
             var img_obj = oneColumnGalleryItems[i].jqueryItem.find('.oneColumnImageContainer img');
             img_obj.css('cursor', 'pointer');
             if(img_obj[0]==img[0]){
                 oneColumnGalleryItems[i].jqueryItem.find('.oneColumnItemDescription').css('visibility', 'visible');
                 oneColumnGalleryItems[i].jqueryItem.find('.galleryLaunchButton').css('visibility', 'visible');
                 img_obj.css('cursor', 'default');
                 oneColumnGalleryItems[i].jqueryItem.css('box-shadow', '0px 0px 15px 2px rgba(255,255,255,1)');
                 index=i;
             }
         }
         return i;
     }
     
    var lightboxUI;
    /**
     * open lightbox
     */
    function openLightBox(btn){
        //var indx = extractLightboxIndex(btn, oneColumnGalleryItems);
        var indx = btn;
        var lightboxItems=[];
        for(var i=0;i<oneColumnGalleryItems.length;i++){
            lightboxItems.push({imgURL: oneColumnGalleryItems[i].largeImage, itemDescription: oneColumnGalleryItems[i].itemDescription});
        }
        lightboxUI = new PhotoShootLightbox(lightboxItems, indx);
    }
    //extract index
    function extractLightboxIndex(btn, items){
        var index=0;
        for(var i=0;i<items.length;i++){
            if(btn[0]==items[i].lightboxBTN[0]){
                index=i;
                break;
            }
        }
        return index;
    }     
     
             
}


/**
 * scroll class
 */
function ScrollUI(scrollTrack, scrollBTNNormal, scrollBTNOver){
    
    buildContainer(globalJS.RESOURCES_PATH+"/"+scrollTrack, globalJS.RESOURCES_PATH+"/"+scrollBTNNormal, globalJS.RESOURCES_PATH+"/"+scrollBTNOver);
    
    var scrollContainer;
    var scrollDragger;
    //build scroll container
    function buildContainer(scrollTrack, scrollBTNNormal, scrollBTNOver){
        scrollContainer = $('<div></div>');
        scrollContainer.css('width', '52px');
        scrollContainer.css('height', '100%');
        scrollContainer.css("background-image", "url('"+scrollTrack+"')");
        scrollContainer.css('overflow', 'hidden');
        
        //scroll dragger
        scrollDragger = $('<div></div>');
        //scrollDragger.css('position', 'relative');
        scrollDragger.css('display', 'block');
        scrollDragger.css('top', '0px');
        scrollDragger.css('width', '52px');
        scrollDragger.css('height', '52px');
        scrollDragger.css('cursor', 'pointer');
        scrollDragger.appendTo(scrollContainer);
        
        $('<div class="normalUI"><img src="'+scrollBTNNormal+'" alt="normal" /></div>').appendTo(scrollDragger);
        $('<div class="overUI"><img src="'+scrollBTNOver+'" alt="over" /></div>').appendTo(scrollDragger);
        
        scrollDragger.find('.normalUI').css('position', 'absolute');
        scrollDragger.find('.normalUI').css('z-index', 301);
        scrollDragger.find('.overUI').css('position', 'absolute');
        scrollDragger.find('.overUI').css('z-index', 302);
        scrollDragger.find('.overUI').css('visibility', 'hidden');
                     
        
        scrollDragger.hover(function(){
             scrollDragger.find('.overUI').css('visibility', 'visible');
             scrollDragger.find('.normalUI').css('visibility', 'hidden');
        }, function(){
             scrollDragger.find('.overUI').css('visibility', 'hidden');
             scrollDragger.find('.normalUI').css('visibility', 'visible');
        });                              
    }
    
    var scrolledContentUI;
    var contentMaskUI;    
    this.initBehavior=function(scrolledContentUIF, contentMaskUIF, isAccurate){
        var accurateVal = 0;
        if(isAccurate){
            accurateVal = 52;
        }
        scrolledContentUI = scrolledContentUIF;
        contentMaskUI = contentMaskUIF;
        scrollDragger.draggable({ axis: "y", containment: "parent",
                    drag: function(event, ui) {
                       ratio = ((contentMaskUI.height()+(accurateVal)) - (scrolledContentUI.height()+scrollDragger.height()))/(scrollContainer.height()-scrollDragger.height());

                       var yPosition = Math.round(0 + ((ui.position.top - 0) * ratio));
                       scrolledContentUI.stop().animate({
                           top: yPosition
                       }, 600, 'easeOutQuad');                                                
                    }});
                            
            scrolledContentUI.mousewheel(function(event, delta, deltaX, deltaY) {   
                if(!enableWheel){
                    return;
                }                            
                var actualPositionY = extractNumber(scrolledContentUI.css('top'));
                var finalPosition = actualPositionY;
                var restrict;
                if(actualPositionY>0){
                    restrict = true;
                    finalPosition = 0;                    
                    scrolledContentUI.stop().animate({
                                   top: 0
                               }, 300, 'easeOutQuad');            
                }
                if(actualPositionY<-(scrolledContentUI.height()-contentMaskUI.height())){
                    restrict = true;
                    finalPosition = -(scrolledContentUI.height()-contentMaskUI.height());
                    scrolledContentUI.stop().animate({
                                   top: -(scrolledContentUI.height()-contentMaskUI.height())
                               }, 300, 'easeOutQuad');                                                              
                }                
                
                if(finalPosition<0){
                    var per = ((-finalPosition)*100)/(scrolledContentUI.height()-contentMaskUI.height()+scrollDragger.height());
                    var py = (scrollContainer.height()*per)/100;
                    scrollDragger.css('top', py+'px');
                }

                
                if(!restrict){
                    scrolledContentUI.css('top', (extractNumber(scrolledContentUI.css('top'))+deltaY*9)+'px');
                }      
            });
                        
        validateScroll();       
    }
    
    //extract number
    function extractNumber(pxValue){
        var striped = pxValue.substring(0, pxValue.length-2);
        var val = parseFloat(striped);
        return val;
    }    
    
    var enableWheel = true;
    function validateScroll(){
        if(scrolledContentUI.height()<=contentMaskUI.height()){
            scrollContainer.css('visibility', 'hidden');
            enableWheel = false;
        }else{
            scrollContainer.css('visibility', 'visible');
            enableWheel = true;
        }
    }
    
    //called from external
    this.validate=function(){
        validateScroll();
    }    
    
    this.getScrollContainer = function(){
        return scrollContainer;
    }
    
    this.gcc = function(){
        try{
            scrollContainer.remove();
        }catch(e){}
    }
    
   $(window).resize(function(){       
       try{
           validateScroll();
           scrollDragger.css('top', '0px');
               scrolledContentUI.stop().animate({
                   top: '0px'
               }, 1200, 'easeOutQuad');           
       }catch(e){}
   });    
     
}

/**
 * ABOUT SECTION
 */
function AboutSection(sectionUI){
        

        $(window).resize(function(){
            resizeEvent();
        });
        resizeEvent();         
        sectionUI.find('.aboutContainer').mCustomScrollbar(); 
        new CustomLightboxPost(sectionUI.find('.aboutContainer'));       
        //window resized
        function resizeEvent(){
            sectionUI.find('.aboutContainer').css('height', $('#contentWrapper').height()-120+'px');                    
        }
        

}
/**
 * END ABOUT SECTION
 */

function CustomLightboxPost(postContainerUI){
        
        if(globalJS.showLightboxPost!="ON"){
            return;
        }
        //check if its allowed
        /**
         * search for images
         */                 
        var postImages = [];
        var regularLightbox;
        regularPostLightbox(postContainerUI);
        function regularPostLightbox(postContainer){
            postImages = new Array();
            postContainer.find('img').each(function(indx){                
                postImages.push({imgURL: $(this).attr('src'), itemDescription:"", jQueryItem: $(this)});
                $(this).data('indx', indx);
            });
            
            for(var i=0;i<postImages.length;i++){
                postImages[i].jQueryItem.click(function(e){
                    e.preventDefault();
                    
                    //var lightboxItms = new Array({imgURL: $(this).parent('a').attr('href'), itemDescription:""});
                    //regularLightbox = new PhotoShootLightbox(lightboxItms, 0);
                    openLightbox($(this));                   
                });
            }                        
        }
        
        function openLightbox(jItem){
            regularLightbox = new PhotoShootLightbox(postImages, jItem.data('indx'));
        }
}

/*
 * NEWS SECTION
 */
function NewsSection(sectionUI){                
        $(window).resize(function(){
            resizeEvent();
        });         
        sectionUI.find('.newsMask').mCustomScrollbar();
        resizeEvent();
        //window resized
        function resizeEvent(){
            sectionUI.find('.newsMask').css('height', $('#contentWrapper').height()+'px');                    
        }
                        
}
/*
 * END NEWS SECTION
 */


/**
 * iGALLERY SECTION
 */
function IGallerySection(sectionUI){
        $(window).resize(function(){
            resizeEvent();
        });                 
        resizeEvent();
        sectionUI.find('.iGalleryMask').mCustomScrollbar({advanced:{updateOnContentResize:true}});
        //window resized
        function resizeEvent(){
            try{
                 sectionUI.find('.iGalleryMask').css('height', $('#contentWrapper').height()-60+'px');
            }catch(e){}                    
        }
        
        var iGallery = new IGallery();
        iGallery.init();            
}
/**
 * end iGALLERY SECTION
 */


/**
 * BLOG SECTION
 */
function BlogSection(sectionUI){
        $(window).resize(function(){
            resizeEvent();
        });                 
        resizeEvent();        
        sectionUI.find('.blogPostsMask').mCustomScrollbar();
        
        var postsContainer =  sectionUI.find('.blogContainer');
        //window resized
        function resizeEvent(){
            sectionUI.find('.blogPostsMask').css('height', $('#contentWrapper').height()+'px');
            try{
                 sectionUI.find('.blogPostMask').css('height', $('#contentWrapper').height()+'px');
            }catch(e){}                    
        }
        
        var currentPostURL;
        $('.readMore').click(function(e){
            e.preventDefault();            
            loadPostContent($(this).attr('href'), displayBlogPost);
        });
        
        $('.blogTitleLink').click(function(e){
            e.preventDefault();            
            loadPostContent($(this).attr('href'), displayBlogPost);
        });        

        
        //load post content
        function loadPostContent(postURL, callback){
            currentPostURL = postURL;
            PopUpManager.getInstance().showBusy();
            var axjReq = new JQueryAjax();
            axjReq.getData(postURL, function(data){
                //section loaded
                PopUpManager.getInstance().dismiss();         
                callback(data);
            }, function(){alert('could not load section: '+postURL)});            
        }
        
        var currentPostUI;        
        //display blog post
        function displayBlogPost(data){            
            currentPostUI = $(data);
            currentPostUI.css('left', '850px');
            currentPostUI.css('top', '0px');
            currentPostUI.appendTo($('.blogMain'));          
            postNav();
            
            new CustomLightboxPost(currentPostUI.find('.singleContent'));
                                           
            postsContainer.animate({
            left: '-850px'
            }, 1000, 'easeOutQuint', function onComplete(){
                
            });
            currentPostUI.animate({
            left: '0px'
            }, 1000, 'easeOutQuint', function onComplete(){                                               
            });            
        }
        
        function initScroll(){
            resizeEvent();
            sectionUI.find('.blogPostMask').mCustomScrollbar({advanced:{updateOnContentResize:true}});            
        }
        
        function postNav(){
            currentPostUI.find('#nextBlogPost a').css('text-decoration', 'none');
            currentPostUI.find('#nextBlogPost a').addClass('defaultText');
            currentPostUI.find('#nextBlogPost a').addClass('textColor02');
            
            currentPostUI.find('#nextBlogPost a').click(function(e){
                e.preventDefault();
                var tempLink = $(this).attr('href');
                navigatePosts(tempLink);
            });
            
            currentPostUI.find('#previousBlogPost a').css('text-decoration', 'none');
            currentPostUI.find('#previousBlogPost a').addClass('defaultText');
            currentPostUI.find('#previousBlogPost a').addClass('textColor02');
            
            currentPostUI.find('#previousBlogPost a').click(function(e){
                e.preventDefault();
                var tempLink = $(this).attr('href');
                navigatePosts(tempLink);                
            });
            currentPostUI.find('#backToPostsBTN').click(function(e){
                e.preventDefault();
                closePost();
            });
            initScroll();
            initFormActions();                       
        }
        
        function navigatePosts(tempLink){            
            loadPostContent(tempLink, nextPrevPostReloaded);
        }
        
        function nextPrevPostReloaded(data){
            PopUpManager.getInstance().showBusy();
            currentPostUI.animate({
                opacity: 0
            }, 700, 'easeOutQuint', function onComplete(){
                currentPostUI.html('');            
                currentPostUI.html($(data).html());
                currentPostUI.css('opacity', 0);
                currentPostUI.stop().animate({
                    opacity: 1
                }, 1000, 'easeOutQuint', function onComplete(){
                    PopUpManager.getInstance().dismiss();
                });
                postNav();
            });            
        }
        
        function closePost(){
            PopUpManager.getInstance().showOpaque();
            postsContainer.animate({
            left: '0px'
            }, 1000, 'easeOutQuint', function onComplete(){
                
            });
            currentPostUI.animate({
            left: '850px'
            }, 1000, 'easeOutQuint', function onComplete(){  
                try{
                   currentPostUI.remove();
                   PopUpManager.getInstance().dismiss();
                }catch(e){}                                          
            });            
        }
        
        //handle post comments
        var postCommentsForm;
        var postCommentsFormBTN;
        //default post comment
        function initFormActions(){
            postCommentsForm = $('#commentform');
            postCommentsFormBTN = $('#submit');
            
            postCommentsFormBTN.addClass('yellowButton');
            postCommentsFormBTN.addClass('backgroundColor01');
            postCommentsFormBTN.addClass('textColor03');
            postCommentsFormBTN.addClass('submitButton');            
            
            postCommentsFormBTN.click(function(e){
                e.preventDefault();
                processForm(postCommentsForm);
            });            
        }
        
        function processForm(commentform){
            PopUpManager.getInstance().showBusy();
            var formdata=commentform.serialize();
            var formurl=commentform.attr('action');

            $.ajax({
                type: 'post',
                url: formurl,
                data: formdata,
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    PopUpManager.getInstance().dismiss();
                    $('#comment_notice').html(globalJS.blogErrorMessage);
                },
                success: function(data, textStatus){
                    PopUpManager.getInstance().dismiss();
                    if(data=="success" || data=="notify_pending"){
                        //success
                    }
                    else{
                        //'***Your comment is awaiting moderation***');
                    }
                    reloadComments();               
                }
            });
        }
        //reload comments
        function reloadComments(){            
            loadPostContent(currentPostURL, postReloaded);
        }
        
        function postReloaded(data){
            currentPostUI.find('.commentlist').html('');
            var tempPostData = $(data).find('.commentlist').html();
            currentPostUI.find('.commentlist').html(tempPostData);            
            document.getElementById('commentform').value = "";
            resizeEvent();
            
        }
        
}


/*
 * REEL SECTION
 */
function ReelSection(sectionUI){
    
    var timer;
    var video;
    delayVideo();
       
    //delay video (used for smooth animation)
    function delayVideo(){
        video = sectionUI.find('.videoContainer').html();
        sectionUI.find('.videoContainer iframe').remove();
        try{
            timer = setTimeout(addVideo, 2000);
        }catch(e){}        
    }
    
    //add google map
    function addVideo(){        
        $(video).appendTo(sectionUI.find('.videoContainer'));
        sectionUI.find('.videoContainer').css('opacity', 0);
        sectionUI.find('.videoContainer').delay(400).animate({
            opacity: 1
        }, 800);
    }    
}
/*
 * END REEL SECTION
 */



/**
 * CONTACT section
 * @param {Object} sectionUI
 */
function ContactSection(sectionUI){
    
    var timer;
    var gmap;
    delayMap();
    initFieldsBehavior();
    sendBTNBehavior();
    
            
    //delay map (used for smooth animation)
    function delayMap(){
        gmap = sectionUI.find('.mapContent').html();
        sectionUI.find('.mapContent iframe').remove();
        try{
            timer = setTimeout(addMap, 2100);
        }catch(e){}
    }
    
    //add google map
    function addMap(){        
        $(gmap).appendTo(sectionUI.find('.mapContent'));
        sectionUI.find('.mapContent').css('opacity', 0);
        sectionUI.find('.mapContent').delay(400).animate({
            opacity: 1
        }, 800);
    }
    
    
    //send button behavior
    function sendBTNBehavior(){
        //thankYouText
        sectionUI.find('#thankYouText').css('visibility', 'hidden');
        sectionUI.find('#sendBTN').click(function(e){
            e.preventDefault();
            var valid = true;
            for(var i=0;i<fields.length;i++){
                if(!fields[i].valid){
                    valid = false;
                    fields[i].ui.addClass('errorField');
                }
            }
            if(valid){
                //send email
                var name = document.getElementById('name').value;
                var email = document.getElementById('email').value;
                var message = document.getElementById('txt').value;
                $.post(globalJS.MAIL_SCRIPT, {name:name, email:email, message:message, receiveEmail: globalJS.emailReceive}, function(data){
                    if(data.success){
                        //console.log('OK')
                    }else{
                        //console.log('NOT OK')
                    }
                    
                }, 'json');
                            
                sectionUI.find('#thankYouText').css('visibility', 'visible');
                for(var i=0;i<fields.length;i++){
                    activateInactive(true, fields[i].ui);
                    fields[i].ui.removeClass('errorField');
                    if(fields[i].type!="txt"){
                        fields[i].ui.val(fields[i].initialMessage);
                    }else{
                        document.getElementById('txt').value = fields[i].initialMessage;
                    }
                }
            }else{
                
            }
        });
    }    
    
    
    var nameField;
    var emailField;
    var messageField;
    
    var fields;
    function initFieldsBehavior(){
        fields = [];
        fields.push({ui: sectionUI.find('#name'), type: "input", initialMessage: sectionUI.find('#name').val(), valid: false});
        fields.push({ui: sectionUI.find('#email'), type: "email", initialMessage: sectionUI.find('#email').val(), valid: false});
        fields.push({ui: sectionUI.find('#txt'), type: "txt", initialMessage: sectionUI.find('#txt').html(), valid: false});
        fields.push({ui: sectionUI.find('#venue'), type: "venue", initialMessage: sectionUI.find('#venue').html(), valid: false});
        fields.push({ui: sectionUI.find('#date'), type: "date", initialMessage: sectionUI.find('#date').html(), valid: false});
        fields.push({ui: sectionUI.find('#offer'), type: "offer", initialMessage: sectionUI.find('#offer').html(), valid: false});
        fields.push({ui: sectionUI.find('#time'), type: "time", initialMessage: sectionUI.find('#time').html(), valid: false});
        
        
        for(var i=0;i<fields.length;i++){
            fields[i].ui.addClass('defaultInfo');
            fields[i].ui.focus(function(){
                var index = extractIndex($(this));
                if(this.value==fields[extractIndex($(this))].initialMessage){
                    this.value="";
                    activateInactive(false, $(this));
                }else{
                    
                }
                validateField(this, index);
            });
            fields[i].ui.blur(function(){
                var index = extractIndex($(this));
                if(this.value==""){
                    this.value=fields[index].initialMessage;
                    activateInactive(true, $(this));
                }else{
                    activateInactive(false, $(this));
                }
                validateField(this, index);               
            });            
        }
    }
    
    function validateField(fieldUI, index){
        var valid = false;
        if(fieldUI.value==fields[index].initialMessage || fieldUI.value==""){
            fields[index].ui.removeClass('errorField');
            fields[index].valid = false;
            return false;
        }
        //input validation
        if(fields[index].type=="input"){
            if(fieldUI.value.length>4){
                valid = true;
            }
        }
        //email validation
        if(fields[index].type=="email"){
            var atpos = fieldUI.value.indexOf("@");
            var dotpos = fieldUI.value.lastIndexOf(".");
            valid = true;
            if (atpos<1 || dotpos<atpos+2 || dotpos+2>=fieldUI.value.length){
               valid = false;
            }
        }
        //message validation
        if(fields[index].type=="txt"){
            if(fieldUI.value.length>5){
                valid = true;
            }
        }                
        if(!valid){
            fields[index].ui.addClass('errorField');
        }else{
            fields[index].ui.removeClass('errorField');
        }
        fields[index].valid = valid;
        return valid;
    }
    
    function extractIndex(ui){
        var index = 0;
        for(var i=0;i<fields.length;i++){
            if(fields[i].ui[0]==ui[0]){
                index = i;
                break;
            }
        }
        return index;
    }
    
    //activate inactive style
    function activateInactive(val, ui){
        if(val){
            ui.removeClass('userInput');
            ui.addClass('defaultInfo');                        
            return;
        }
        ui.removeClass('defaultInfo');
        ui.addClass('userInput');                  
    }    
}
/**
 * END CONTACT section
 */
