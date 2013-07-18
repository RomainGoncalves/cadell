=== Custom Facebook Feed ===
Contributors: smashballoon
Tags: facebook, custom, customizable, feed, seo, search engine, responsive, mobile, shortcode, social, status
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.3.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Custom Facebook Feed allows you to display a customizable Facebook feed of any public Facebook page on your website.

== Description ==

Display a **customizable**, **responsive** and **search engine crawlable** version of your Facebook feed on your WordPress site.

Other Facebook plugins use iframes to show your feed which don't allow you to customize how they look, aren't responsive and are not crawlable by search engines. The Custom Facebook Feed inherits your theme's style to display a feed which is responsive, crawlable and seamlessly matches the look and feel of your site.

* **Completely Customizable** - by default inherits your theme's styles
* **Feed content is crawlable by search engines adding SEO value to your site** - other Facebook plugins embed the feed using iframes which are not crawlable
* **Completely responsive and mobile optimized** - works on any screen size
* Use the shortcode to display the feed in a page, post or widget anywhere on your site
* Limit the number of posts to be shown in your feed
* Set a maximum length for both the post title and body text
* Use the shortcode to display feeds from multiple Facebook pages anywhere on your site

To display photos, videos and the number of likes, shares and comments for each post then [upgrade to the PRO version](http://smashballoon.com/custom-facebook-feed/wordpress-plugin/ "Custom Facebook Feed PRO"). Try out the [PRO demo](http://smashballoon.com/custom-facebook-feed/demo "Custom Facebook Feed Demo").

== Installation ==

1. Install the Custom Facebook Feed either via the WordPress plugin directory, or by uploading the files to your web server (in the `/wp-content/plugins/` directory).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the plugin settings page to configure your feed.
4. Use the shortcode `[custom-facebook-feed]` in your page, post or widget to display your feed.
5. You can display multiple feeds of different Facebook pages by specifying a Page ID directly in the shortcode: `[custom-facebook-feed id=SarahsBakery show=5]`.
6. You can limit the length of the title and body text by using `titlelength=100` and `bodylength=150` (for example) in the shortcode. `[custom-facebook-feed titlelength=100 bodylength=150]`.

== Frequently Asked Questions ==

= How do I find the Page ID of my Facebook page? =

If you have a Facebook page with a URL like this: `https://www.facebook.com/Your_Page_Name` then the Page ID is just `Your_Page_Name`.  If your page URL is structured like this: `https://www.facebook.com/pages/Your_Page_Name/123654123654123` then the Page ID is actually the number at the end, so in this case `123654123654123`.

= Are there any limitations on which page feeds I can display? =

The feed you're trying to display has to be a publicly accessible page. This means that you can't display the feed from your own personal profile or a group. This is to do with Facebook's privacy policies. You can't display a non-public feed publicly.

If your page has any restrictions on it (age, for example) then it means that people have to be signed into Facebook in order to view your page. This isn't desirable for most pages as it means that it isn't accessible by people who don't have a Facebook account and that your page can't be crawled and indexed by search engines.

An easy way to determine whether your page is set to public is to sign out of your Facebook account and try to visit your page. If Facebook forces you to sign in to view your page then it isn't public. You can change your page to public in your Facebook page settings simply by removing any restrictions you have on it, which will then allow the Custom Facebook Feed plugin to access and display your feed.

= What's an Access Token and why do I need one? =

An Access Token is required by Facebook in order to access their feeds.  Don't worry, it's easy to get one.  Just follow the step-by-step instructions [here](http://smashballoon.com/custom-facebook-feed/access-token/ "Getting an Access Token"). to get yours. Your Access Token will never expire.

= Can I show photos and videos in my feed? =

This plugin only allows you to display text updates from your feed. To display photos and videos in your feed you need to upgrade to the PRO version of the plugin. Try out a demo of the PRO version on the [Custom Facebook Feed website](http://smashballoon.com/custom-facebook-feed/demo "Custom Facebook Feed Demo"), and find out more about the PRO version [here](http://smashballoon.com/custom-facebook-feed/wordpress-plugin/ "Custom Facebook Feed PRO").

= Can I show the comments associated with each post? =

For this feature please upgrade to the [PRO version of the plugin](http://smashballoon.com/custom-facebook-feed/wordpress-plugin/ "Custom Facebook Feed PRO").

= Is the content of my feed crawlable by search engines? =

It sure is. Unlike other Facebook plugins which use iframes to embed your feed into your page once it's loaded, the Custom Facebook Feed uses PHP to embed your feed content directly into your page. This adds dynamic, search engine crawlable content to your site.

== Screenshots ==

1. Feed displayed in a page or post. By default the feed inherits your theme's default styles and is completely responsive.
2. Feed displayed in a side widget.
3. Configuring the plugin
4. Adding the shortcode to your page or post. The shortcode parameters are optional and can be used to override the default settings you set on the plugin settings page
5. Adding the shortcode to a widget

== Changelog ==

= 1.3.6 =
* Minor modifications

= 1.3.5 =
* New: Shared events now display event details (name, location, date/time, description) directly in the feed

= 1.3.4 =
* New: Email addresses within the post text are now hyperlinked
* Fix: Links beginning with 'www' are now also hyperlinked

= 1.3.3 =
* New: Added support for events - display the event details (name, location, date/time, description) directly in the feed
* Fix: Links within the post text are now hyperlinked
* Tweak: Added additional methods for retrieving feed data

= 1.3.2 =
* Fix: Now using the built-in WordPress HTTP API to get retrieve the Facebook data

= 1.3.1 =
* Fix: Fixed issue with certain statuses not displaying correctly

= 1.3.0 =
* Tweak: If 'Number of Posts to show' is not set then default to 10

= 1.2.9 =
* Fix: Now using cURL instead of file_get_contents to prevent issues with php.ini configuration on some web servers

= 1.2.8 =
* Fix: Fixed bug in specifying the number of posts to display

= 1.2.7 =
* Tweak: Prevented likes and comments by the page author showing up in the feed

= 1.2.6 =
* Tweak: Added help link to settings page

= 1.2.5 =
* Fix: Added clear fix

= 1.2.1 =
* Fix: Minor bug fixes

= 1.2 =
* New: Added the ability to define a maximum length for both the post title and body text

= 1.0 =
* Launch!