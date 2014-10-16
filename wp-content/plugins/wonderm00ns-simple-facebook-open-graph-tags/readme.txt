=== Facebook Open Graph Meta Tags for WordPress ===
Contributors: webdados, wonderm00n
Donate link: http://blog.wonderm00n.com/2011/10/14/wordpress-plugin-simple-facebook-open-graph-tags/
Tags: facebook, open graph, open graph protocol, seo, share, social, meta, schema, google+, g+, google, google plus, image, like, meta, search engine optimization
Requires at least: 3.5
Tested up to: 3.9
Stable tag: 1.1.2

This plugin inserts Facebook Open Graph, Google+/Schema.org and other Meta Tags into your WordPress Website for more efficient sharing results.

== Description ==

This plugin inserts Facebook Open Graph Tags into your WordPress Blog/Website for more effective and efficient Facebook sharing results.

It also allows you to add the Meta Description tag and Schema.org Name, Description and Image tags for more effective and efficient Google+ sharing results.

You can also choose to insert the "enclosure" and "media:content" tags to the RSS feeds, so that apps like RSS Graffiti and twitterfeed post the image to Facebook correctly.

It allows the user to choose which tags are, or not, included and also the default image if the post/page doesn't have one.

= The Facebook Open Graph Tags that this plugin inserts are: =

* **fb:app_id**: From settings on the options screen.
* **fb:admins**: From settings on the options screen.
* **og:locale**: From Wordpress locale or chosen by the user.
* **og:site_name**: From blog title.
* **og:title**: From post/page/archive/tag/... title.
* **og:url**: From the post/page permalink.
* **og:type**: "website" or "blog" for the homepage and "article" for all the others.
* **og:description**: From post/page excerpt if it exist, or from post/page content. From category/tag description on it's pages, if it exist. From tagline, or custom text, on all the others.
* **og:image**: From a specific custom field of the post/page, or if not set from the post/page featured/thumbnail image, or if it doesn't exist from the first image in the post content, or if it doesn't exist from the first image on the post media gallery, or if it doesn't exist from the default image defined on the options menu. The same image chosen here will be used and enclosure/media:content on the RSS feed.

= The Schema.org Tags that this plugin inserts are: =

* **name**: Same as "og:title".
* **description**: Same as "og:description".
* **image**: Same as "og:image".

= Other Tags: =

* **meta description**: Same as "og:description".
* **enclosure**: On RSS feeds, same as "og:image".
* **media:content**: On RSS feeds, same as "og:image".

= 3rd Party Integration: =

* **[WordPress SEO by Yoast](http://wordpress.org/plugins/wordpress-seo/)**: Allows you to use title, url (canonical) and description from WPSEO plugin.
* **[SubHeading](http://wordpress.org/extend/plugins/subheading/)**: Add the SubHeading to the post/page title.
* **[Business Directory Plugin](http://wordpress.org/extend/plugins/business-directory-plugin/)**: Allows you to use BDP listing contents as Open Graph Tags.


== Installation ==

1. Upload the `wonderm00n-open-graph` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Got to `Options`, `Facebook Open Graph Tags` to set it up

== Changelog ==

= 1.1.2 =
* Fix: Specific post image was not working properly
* Added a "Clear field" button to the specific post image options box
* When the homepage is set as a static page, the "homepage description" section on the settings page will reflect that

= 1.1.1 =
* Fix: a debug var_dump was left uncommented
* readme.txt adjustments

= 1.1 =

* WordPress SEO by Yoast integration: title, url (canonical) and description can now be fetched from this very popular SEO plugin
* Fix: small fix on javascript

= 1.0.1 =

* Corrected a nasty bug which would break the "Add Media" option. Thanks to @flynsarmy (yet again)
* Fix: version field upgrade on the database

= 1.0 =

* Plugin name changed from "Wonderm00n's Simple Facebook Open Graph Meta Tags" to "Facebook Open Graph Meta Tags for WordPress"
* You can now set a specific Open Graph image per post, if you don't want it to be the same as the post featured image
* Settings are now stored on a array instead of multiple variables on the options table (and necessary changes along the code)
* Internationalization support added
* Portuguese translation added (we welcome other translations if you want to do it)
* Added webdados as contributor (Wonderm00n's company)
* Fix: Several PHP warnings when WP_DEBUG is turned on. Thanks to @flynsarmy (yet again)
* Fix: og:type was not set correctly for the homepage in case it was a static page. Thanks to yakitori
* Fix: When the site url was not the same as the wordpress installation folder the wrong url was used in the homepage og:url/canonical tag. Thanks to theonetruebix
* Using the requested url as og:urgl/canonical on not known areas of wordpress. Not really a canonical url but better than using the homepage one

= 0.5.4 =

* Fix in order to be compatible with "Business Directory Plugin" 3.0

= 0.5.3 =

* Minor fix to avoid php notices filling up error logs. Thanks to @flynsarmy (yet again).

= 0.5.2.1 =

* Fixed version number.

= 0.5.2 =

* Minor fix to avoid php notices filling up error logs. Thanks to @flynsarmy (again).
* Fixed FacebookLocales.xml URL.
* By default the FacebookLocales.xml is loaded from the local cache (to save on bandwidth) and it's only loaded from Facebook URL by user request.
* Deleted some commented debug stuff and translate portuguese comments to english.

= 0.5.1 =

* Fixed a typo.
* Added the information about the recommended minimum image size.

= 0.5 =

* Added meta description and Schema.org name, description and image tags.

= 0.4.3 =

* Fixed a bug where the original, Wordpress stock, Canonical URL was not being removed.

= 0.4.2 =

* If using the "Business Directory Plugin" integration, the "og:url" tag is now correctly set in the category listing pages.

= 0.4.1 =

* Added the ability to set/replace the Canonical URL tag. Very important for SEO in the "Business Directory Plugin" integration.

= 0.4 =

* "Business Directory Plugin" plugin integration. It's now possible to populate "og:title", "og:url", "og:description" and "og:image" tags with each listing details. If a featured image is set it will be used. If not, the listing main image is used.

= 0.3.5 =

* Minor fixes to avoid php notices filling up error logs. Thanks to @flynsarmy.

= 0.3.4 =

* Fixed a bug where all the settings could be lost when saving other plugins options (Shame on me!!).

= 0.3.3 =

* Fixed a bug where unset options would become active again. Thanks to @scrumpit.

= 0.3.2 =

* Fixed a typo on the settings page.

= 0.3.1 =

* When saving the settings the $_POST array was showned for debug/development reasons. This output has been removed.

= 0.3 =

* "SubHeading" plugin integration. It's now possible add this field to the "og:title" tag.
* Changed the way defaults and user settings are loaded and saved, to "try" to eliminate the problem some users experienced where the user settings would disappear.
* Bugfix: "Also add image to RSS/RSS2 feeds?" option was not being correctly loaded.
* The plugin version is now showed both as a comment before the open graph tags and on the settings page.

= 0.2.3 =

* No changes. Had a problem updating to 0.2.2 on the Wordpress website.

= 0.2.2 =

* Bugfix: small change to avoid using the "has_cap" function (deprecated). Thanks to @flynsarmy.

= 0.2.1 =

* Bugfix: when the og:image is not hosted on the same domain as the website/blog.

= 0.2 =

* If the option is set to true, the same image obtained to the og:image will be added to the RSS feed on the "enclosure" and "media:content" tags so that apps like RSS Graffiti and twitterfeed post them correctly.

= 0.1.9.5 =

* It's now possible to choose how the post/page og:image tag is set. It means that if the user doesn't want to use the featured/thumbnail image, or the first image in the post content, or the first image on the media gallery, or even the default image, he can choose not to.

= 0.1.9 =

* Added the og:locale tag. This will be the Wordpress locale by default, but can be chosen by the user also.
* The og:type tag can now be set as 'website' or 'blog' for the homepage.
* A final trailing slash can now be added to the homepage url, if the user wants to. Avoids 'circular reference error' on the Facebook debugger.


= 0.1.8.1 =

* Fixed the namespace declarations.

= 0.1.8 =

* Type 'website' was being used as default for all the urls beside posts. This is wrong. According to Facebook Open Graph specification only the homepage should be 'website' and all the other contents must bu 'article'. This was fixed.
* On Category and Tags pages, their descriptions, if not blank, are used for the og:description tag.
* If the description comes out empty, the title is used on this tag.

= 0.1.7 =

* Changed the plugin priority, so that it shows up as late as possible on the <head> tag, and it won't be override by another plugin's Open Graph implementation, because other plugins usually don't allow to disable the tags. If you want to keep a specific tag from another plugin, you can just disable that tag on this plugin options.

= 0.1.6 =

* Settings link now shows up on the plugins list.
* Small fix to ensure admin functions only are running when on the admin interface.
* Some admin options now only show up when the tag is set to be included.


= 0.1.5 =

* Fixed the way Categories and Tags pages links were being retrieved that would cause an error on WP 3.0.
* Added the option to use a Custom text as homepage og:description instead of the Website Tagline.
* Fixed a bug that wouldn't allow to uncheck the og:image tag.

= 0.1.4 =

* Shortcodes are now stripped from og:description.
* Changed og:app_id and og:admins not to be included by default.

= 0.1.3 =

* Just fixing some typos.

= 0.1.2 =

* Fixing a bug for themes that do not support post thumbnail.

= 0.1.1 =

* Adding Open Graph Namespace to the HTML tag.

= 0.1 =

* First release.