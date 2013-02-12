$ = jQuery.noConflict();
$(document).ready(function(){
    var website = new PhotoShootWebsite();
    website.init();
});
//globalJS (sent from wordpress)
function PhotoShootWebsite(){
    
    var backgroundUtil;
    var siteUrl;
    this.init = function(){
        addDynamicStyles();
        siteUrl = "http://" + top.location.host.toString();
        addBusyContainer(); 
        addContainers();
        backgroundUtil = new ResizableBackground($('#backgroundContainer'));//showBackCallBack
        backgroundUtil.showBackCallBack(backgroundAnimationComplete);
        initMainMenu();
        addWindowListener();
        addFullScreenSupport();
    }
    
    function addDynamicStyles(){
        var dynamicStyle = '<style type="text/css">'; 
        for(var key in globalJS.CUSTOM_CSS){
            if(globalJS.CUSTOM_CSS[key]!=undefined&&globalJS.CUSTOM_CSS[key]!=null&&globalJS.CUSTOM_CSS[key]!=''){
                dynamicStyle+= '.'+key+'{'+globalJS.CUSTOM_CSS[key]+';}';
            }
        }
        dynamicStyle += '</style>';
        $(dynamicStyle).appendTo('head');    
    }    
     
    
    var menuItems;
    var menuScroll;
    var menuScrollInstance;
    //init main menu behavior
    function initMainMenu(){
        //closeMenuImediately();
        menuItems = [];
        $('#menuItemsSK ul li a').each(function(){
            menuItems.push({jqueryItem: $(this), data: null});
            $(this).addClass('textColor01');
            $(this).addClass('menuItemUnselected');            

            $(this).click(function(e){
                    var itemLink = $(this).attr('href');
                    var itemLinkStripped = itemLink.substring(0, siteUrl.length);                                      
                    if(itemLinkStripped!=siteUrl){
                        return;   
                    } 
                    e.preventDefault();
                    var itemLinkStrippedEnd = itemLink.substring(siteUrl.length, itemLink.length);                                        
                    openSection(itemLinkStrippedEnd);                
            });
        });
        adjustMenuSize();
        addMenuScroll();          
    }
    
    function addMenuScroll(){
        if(Modernizr.touch){
            $('#menuItemsSK').draggable({axis: 'y', stop: function(event,ui){
                if(ui.position.top>0){
                    //$('#menuItemsSK').css('top', '0px');
                    $('#menuItemsSK').stop().animate({
                        top: '0px'
                    });
                    return;
                }
                if(ui.position.top< 0-($('#menuItemsSK').height()-$('#menuExpandedSK').height())){                
                    //$('#menuItemsSK').css('top', 0-($('#menuItemsSK').height()-$('#menuExpandedSK').height())+'px');
                    $('#menuItemsSK').stop().animate({
                        top: 0-($('#menuItemsSK').height()-$('#menuExpandedSK').height())+'px'
                    });
                    return;
                }                        
            }});
            
            return;           
        }
        if($('#menuExpandedSK').height()<$('#menuItemsSK').height()){
            $('#menuExpandedSK').bind('mousemove', function(event){
                menuOnMouseMove(event);            
            });
        }
    }
    
    //menu scroll
    function menuOnMouseMove(e){
        if($('#menuExpandedSK').height()>$('#menuItemsSK').height()){
            return;
        }        
        var mouseCoordsY=(e.pageY - $('#menuExpandedSK').offset().top);
        var mousePercentY=mouseCoordsY/$('#menuExpandedSK').height();                
        var yratio = ($('#menuItemsSK').height() - $('#menuExpandedSK').height())/($('#menuExpandedSK').height());
        var yoff = -mouseCoordsY * yratio; //same for the mouseY.                      
        $('#menuItemsSK').stop().animate({
            top: yoff
        }, 2000, 'easeOutCirc');                                                     
    }    

    
    //add background, background grid pattern and pages content
    //add top menu container and close menu
    function addContainers(){
        $('<div id="backgroundContainer"></div>').appendTo('#contentWrapper');
        $('<div id="overlayGridPatern"></div>').appendTo('#contentWrapper');
        $('<div id="pagesContent"></div>').appendTo('#contentWrapper');                        
    }

    var mainMenuHeight;
    //adjust menu size and menu items height
    function adjustMenuSize(){
        
        var topH = $('#menuArrowUp').height();
        var logoH = $('#logoContainerSK').height();
        var bottomH = $('#menuArrowDown').height();
        
        var upDownSpacer = 50+15;
        $('#menuExpandedSK').css('height', $('#contentWrapper').height()-(topH+logoH+bottomH+upDownSpacer)+'px');
        
        
        //menu scroll      
        $('.menuScrollContent').css('height', $('#menuExpandedSK').height()+'px');
        $('.menuScrollContent').css('top', $('#menuExpandedSK').offset().top+'px');         
        
        
        return;      
    }

    
    var currentSection;
    var firstTimeLoad=true;
    //open a specific section    
    function openSection(itemLink, isWindowEvent){
        var realURL;
        if(!isWindowEvent){
            //console.log(itemLink+'button');            
        }else{
            //console.log(itemLink+'window');            
        }
        realURL = siteUrl+itemLink;
        if(currentSection==itemLink){          
            return;
        }
        
        if(!isValidSection(realURL)){
            //console.log('invalid section');
            return;
        }      
        currentSection = itemLink;
        
        if(window.location.href != "#!"+currentSection){
            window.location.href = "#!"+currentSection;
        }
        
        selectSectionButton(realURL);
        if(currentSectionUI!=null){                     
            removeCurrentSection(currentSectionUI, realURL);
        }else{          
            loadSection(realURL);
        }
        if(firstTimeLoad){
            PopUpManager.getInstance().showOpaque();            
        }      
    }
    
    function removeCurrentSection(sectionUI, newSectionURL){
        PopUpManager.getInstance().showRestrict();
        sectionUI.animate({
            left: $('#contentWrapper').width()+'px'
        }, 1000, 'easeOutQuint', function onComplete(){
            sectionUI.remove();
            var sectionIndex = sectionIsLoaded(newSectionURL);
            (sectionIndex==-1)?PopUpManager.getInstance().showBusy():null;
            (sectionIndex==-1)?loadSection(newSectionURL):showNewSection(sections[sectionIndex]);
        });
    }
    //check if section allready has been loaded
    function sectionIsLoaded(sectionURL){
        var isLoaded=-1;
        for(var i=0;i<sections.length;i++){
            if(sections[i].sectionURL==sectionURL){
                isLoaded=i;
                break;
            }
        }
        return isLoaded;
    }    
    
    var sections=[];
    //load section
    function loadSection(sectionURL){
        var sectionPath = sectionURL;
        
        var axjReq = new JQueryAjax();
        axjReq.getData(sectionPath, function(data){
            //section loaded            
           axjReq.loadImage(getBackgrounImageURL(data), function(img){
               //background image loaded
               //add data to sections array
               sections.push({sectionRawData: data, sectionURL: sectionURL, backgroundImage: img});
               displayNewSection(sectionURL);
           });
        }, function(){alert('could not load section: '+sectionURL)});
    }   
    
    //return url of section's background image
    function getBackgrounImageURL(data){
        var obj = $(data);
        return obj.find('.sectionBackgroundImage').attr('src');
    }
    
    var currentSectionUI;
    /**
     * display new section
     */
    function displayNewSection(sectionURL){
         var section = extractSection(sectionURL);
         showNewSection(section);
    }
    var pUtil;
    function showNewSection(section){
         if(firstTimeLoad){
             firstTimeLoad = false;          
         }else{
             PopUpManager.getInstance().dismiss(500, 'easeOutQuint');
         }         
         currentSectionUI = $(section.sectionRawData);         
         currentSectionUI.css('opacity', 0);         
         currentSectionUI.find('.sectionBackgroundImage').remove();              
         currentSectionUI.appendTo('#pagesContent');
         currentSectionUI.css('left', $('#contentWrapper').width()); 
         pUtil = new PagesUtils(currentSectionUI);         
         currentSectionUI.animate({          
             left: ($('#contentWrapper').width()-currentSectionUI.width())+'px',
             opacity: 1
         }, 1200, 'easeOutQuint', function onComplete(){
             backgroundUtil.showNewBackground(section.backgroundImage);
         });
         windowResize();       
    }
    
    /**
     * extract specific section object
     */
    function extractSection(sectionURL){
        var section;
        for(var i=0;i<sections.length;i++){
            if(sections[i].sectionURL==sectionURL){
                section = sections[i];
                break;
            }
        }
        return section;
    }     
    
    
    /**
     * extract specific section object
     */
    function extractSection(sectionURL){
        var section;
        for(var i=0;i<sections.length;i++){
            if(sections[i].sectionURL==sectionURL){
                section = sections[i];
                break;
            }
        }
        return section;
    }            
    
    //select clicked button
    function selectSectionButton(sectionURL){
          for(var i=0;i<menuItems.length;i++){
              menuItems[i].jqueryItem.removeClass('menuItemSelected');
              menuItems[i].jqueryItem.addClass('menuItemUnselected');
              menuItems[i].jqueryItem.removeClass('textColor02');
              menuItems[i].jqueryItem.addClass('textColor01');
               
               // $(this).addClass('textColor01');
              if(menuItems[i].jqueryItem.attr('href')==sectionURL){
                   menuItems[i].jqueryItem.removeClass('menuItemUnselected');                  
                  menuItems[i].jqueryItem.addClass('menuItemSelected');                  
                  menuItems[i].jqueryItem.removeClass('textColor01');  
                  menuItems[i].jqueryItem.addClass('textColor02');                
              }
          }
    }    
    
    //check if section exists
    function isValidSection(sectionURL){
        var valid=false;
         for(var i=0;i<menuItems.length;i++){
              if(menuItems[i].jqueryItem.attr('href')==sectionURL){
                  valid = true;
                  break;
              }             
         }
        return valid;
    }    
    
    /**
     * position current section on resize
     */
    function positionCurrentSection(){
        if(currentSectionUI!=null && currentSectionUI!=undefined){
            currentSectionUI.css('left', $('#contentWrapper').width()-currentSectionUI.width()+'px');
            currentSectionUI.css('top', '0px');
            currentSectionUI.css('height', $('#contentWrapper').height()+'px');
        }
    }
    
    /**
     * handle window resize
     */
    function windowResize(event){
        adjustMenuSize();
        positionCurrentSection();
    }
    
    //location has changed
    function windowlocationChange(){
        //console.log(window.location.href);
        var indexOf = window.location.href.indexOf('#!');
        if(indexOf==-1){
            var itemLink = menuItems[0].jqueryItem.attr('href');
            var itemLinkStrippedEnd = itemLink.substring(siteUrl.length, itemLink.length);            
            openSection(itemLinkStrippedEnd);
            return;
        }     
        var firstPart = window.location.href.substring(0, indexOf);
        var secondPart = window.location.href.substring(indexOf+3, window.location.href.length);        
        //openSection(window.location.href, true);
        openSection(window.location.href.substr(indexOf+2, window.location.href.length), true);
    }    
    
    //dispatch event to all listeners
    function addWindowListener(){
        EventBus.addEventListener(Event.WINDOW_RESIZE, windowResize);
        EventBus.addEventListener(Event.WINDOW_LOCATION_CHANGE, windowlocationChange);
        $(window).resize(function(){
            EventBus.dispatchEvent(new Event(Event.WINDOW_RESIZE, ""));
        });
        $(window).bind('hashchange', function() {
          EventBus.dispatchEvent(new Event(Event.WINDOW_LOCATION_CHANGE, ""));
        });        
        windowResize();  
        windowlocationChange();    
    }
    
    /**
     * called when background animation is complete
     */
    function backgroundAnimationComplete(){
        PopUpManager.getInstance().dismiss();
    }

    /**
     * Utils
     */ 
    //extract number
    function extractNumber(pxValue){
        var striped = pxValue.substring(0, pxValue.length-2);
        var val = parseFloat(striped);
        return val;
    } 
    
    
    //add busy container
    function addBusyContainer(){
        $('<div id="busyContainer"><div><img src="'+globalJS.RESOURCES_PATH+'/images/preloader.gif" /></div></div>').appendTo($('#contentWrapper'));
    }
    
     var fsUtil;
    /**
     * implement full screen
     */
    function addFullScreenSupport(){
        
        fsUtil = new FullScreenUtil(document.getElementById('contentWrapper'));
        if(fsUtil.isFullScreenAvailable()){
            //show fs buttons
            fsUtil.setStateCallBack(fullScreenStatus);
            var tooltipOff = new Tooltip($('#fs_off'), $('#contentWrapper'));
            var tooltipOnn = new Tooltip($('#fs_on'), $('#contentWrapper'));
           
            $('#fs_off').click(function(){
                fsUtil.enterFullScreen();
            });
            if(fsUtil.isExitFullScreenAvailable){
                $('#fs_on').click(function(){
                    fsUtil.exitFullScreen();
                });                
            }else{
                $('#fs_on').css('opaciy', 0);
            }
            fullScreenStatus(false);
        }else{
            //remove fs buttons
            $('#fullScreenButtons').remove();
        }
        
        $('.fullScreenBtn').click(function(){
            fsUtil.enterFullScreen();
        });        
    }
    
    function fullScreenStatus(val){
        if(val){
            $('#fs_on').css('visibility', 'visible');
            $('#fs_off').css('visibility', 'hidden');            
        }else{
            $('#fs_on').css('visibility', 'hidden');
            $('#fs_off').css('visibility', 'visible');            
        }
    }
    //end full screen implementation    
    
}


/**
 * popup manager class
 */ 
function PopUpManager(popupContainer){
     var popupContainer = popupContainer;
     stageResize();
     EventBus.addEventListener(Event.WINDOW_RESIZE, stageResize);
     
     var isFirstTime = true;
     //hide content while loading
     this.showOpaque = function(){
         popupContainer.addClass('busyContainerOpaque');
         popupContainer.find('img').css('visibility', 'visible');
         popupContainer.css('visibility', 'visible');
     }
     //show busy loading icon
     this.showBusy = function(){
         popupContainer.removeClass('busyContainerOpaque');
         popupContainer.find('img').css('visibility', 'visible');
         popupContainer.css('visibility', 'visible');
         popupContainer.css('opacity', 1);        
     }
     //prevent clicks during animation
     this.showRestrict = function(){
         popupContainer.removeClass('busyContainerOpaque');
         popupContainer.find('img').css('visibility', 'hidden');
         popupContainer.css('visibility', 'visible');
         popupContainer.css('opacity', 1);
     }
     //dismiss popup
     this.dismiss = function(time, efx){
        console.log($(this));
         isFirstTime = false;
         (time==undefined)?time=800:null;
         (efx==undefined)?efx='easeInExpo':null;  
         popupContainer.animate({
             opacity: 0
         }, time, efx, function onComplete(){
             $(this).css('visibility', 'hidden');
             $(this).find('img').css('visibility', 'hidden');
         });
     }
     
     this.getStatus = function(){
         return isFirstTime;
     }
     
     function stageResize(){
        popupContainer.find('div').css('top', popupContainer.height()/2-popupContainer.find('div').height()/2+'px');
     }    
 }
 
PopUpManager.getInstance=function(){
    if(PopUpManager.instance==null){
        PopUpManager.instance = new PopUpManager($('#busyContainer'));
    }
    return PopUpManager.instance;
}

/**
 * FULL SCREEN utils
 */
function FullScreenUtil(node){
    var elementUI = node;
    
    var fullScreenAvailable;
    //check if full screen is available
    this.isFullScreenAvailable = function(){
        try{
            if (elementUI.requestFullscreen) {
                fullScreenAvailable = true;
            }
            else if (elementUI.mozRequestFullScreen) {
                fullScreenAvailable = true;
            }
            else if (elementUI.webkitRequestFullScreen) {
                fullScreenAvailable = true;
            }
        }catch(e){}
        if(fullScreenAvailable){
            addFSListeners();
        }
        return fullScreenAvailable;
    }
    
    var isExitFullScreenAvailable;
    //check if isExit FS available
    this.isExitFullScreenAvailable = function(){
        try{
            if (document.exitFullscreen) {
                isExitFullScreenAvailable = true;
            }
            else if (document.mozCancelFullScreen) {
                isExitFullScreenAvailable = true;
            }
            else if (document.webkitCancelFullScreen) {
                isExitFullScreenAvailable = true;
            }
        }catch(e){}
        return isExitFullScreenAvailable;
    }    
    
    //exit FS
    this.exitFullScreen=function(){
        try{
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
            else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            }
            else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            }
        }catch(e){}
    }
    
    //enter FS
    this.enterFullScreen = function(){
        try{
            if (elementUI.requestFullscreen) {
                elementUI.requestFullscreen();
            }
            else if (elementUI.mozRequestFullScreen) {
                elementUI.mozRequestFullScreen();
            }
            else if (elementUI.webkitRequestFullScreen) {
                elementUI.webkitRequestFullScreen();
            }
        }catch(e){}
    }
    
    //add fullscreen listeners
    function addFSListeners(){
        document.addEventListener("fullscreenchange", function () {
            fullscreenStateChange(document.fullscreen);
        }, false);
        
        document.addEventListener("mozfullscreenchange", function () {
            fullscreenStateChange(document.mozFullScreen);
        }, false);
        
        document.addEventListener("webkitfullscreenchange", function () {
            fullscreenStateChange(document.webkitIsFullScreen);
        }, false);        
    }
    
    //changed fs state
    function fullscreenStateChange(isFullScreen){
        if(changeStateCallBack!=null && changeStateCallBack!=undefined){
            changeStateCallBack(isFullScreen)
        }
    }
    
    this.setStateCallBack=function(val){
        changeStateCallBack = val;
    }
    var changeStateCallBack;
}
/**
 * END FULL SCREEN utils
 */