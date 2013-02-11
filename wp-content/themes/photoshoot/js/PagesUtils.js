function PagesUtils(sectionUI){
    
    var pageType = sectionUI.attr('class');
    var section;
    section = null;
    switch(pageType){
         case PagesUtils.HOME:
             //home section
             section = new HomeSection();
             section.init(sectionUI);
         break;
         case PagesUtils.ONE_COLUMN_SECTION:
             //one column gallery section             
             section = new OneColumnGalery(sectionUI);
         break;
         case PagesUtils.TWO_COLUMN_SECTION:
             //two column gallery section             
             section = new TwoColumnGalery(sectionUI);
         break;
         case PagesUtils.PORTFOLIO_SECTION:
             //open portfolio         
             section = new PrortfolioSection(sectionUI);
         break;
         case PagesUtils.CONTACT_SECTION:
             //open contact section         
             section = new ContactSection(sectionUI);
         break;
         case PagesUtils.REAL_SECTION:
             //open real section         
             section = new ReelSection(sectionUI);
         break;
         case PagesUtils.NEWS_SECTION:
             //open news section         
             section = new NewsSection(sectionUI);
         break;
         case PagesUtils.ABOUT_SECTION:
             //open about section         
             section = new AboutSection(sectionUI);
         break;
         case PagesUtils.BLOG_SECTION:
             //open blog section         
             section = new BlogSection(sectionUI);
         break;
         case PagesUtils.IGALLERY_SECTION:
             //open blog section         
             section = new IGallerySection(sectionUI);             
         break;                                                                                                       
    } 
}
PagesUtils.HOME = 'section-type-HOME';
PagesUtils.ONE_COLUMN_SECTION = 'section-one-column-SECTION';
PagesUtils.TWO_COLUMN_SECTION = 'section-two-column-SECTION';
PagesUtils.PORTFOLIO_SECTION = 'section-portfolio-SECTION';
PagesUtils.CONTACT_SECTION = 'section-CONTACT';
PagesUtils.REAL_SECTION = 'section-REAL';
PagesUtils.NEWS_SECTION = 'section-NEWS';
PagesUtils.ABOUT_SECTION = 'section-ABOUT';
PagesUtils.BLOG_SECTION = 'section-BLOG';
PagesUtils.IGALLERY_SECTION = 'section-IGALLERY';