=== Plugin Name ===
Contributors: 99robots, charliepatel
Tags: jquery accordion category, list category posts in jquery accordion
Requires at least: 3.0.1
Tested up to: 5.7.2
Stable tag: 2.1

A simple post listing by category widget using jQuery UI Accordion

== Description ==

Very simple and easy to use plugin that lists posts in jQuery UI Accordion listed by categories.

Note that the plugin uses WordPress' enqueue script functions to call jQuery and all other required js calls. If the sidebar widget does not provide the required effects, its probably your theme or some other plugin calling the jQuery again without using the built-in WordPress' enqueue script functions. In that case, the jQuery will mostly conflict with each other.

== Installation ==

1. Upload `jquery-accordion-categories` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Appearance > Widgets, and drag the jQuery Accordion Categories to your sidebar

== Frequently Asked Questions ==

= Does it load the jQueryUI core files automatically? =

Yes, just drag the widget in your sidebar, and it will do the rest.

= Can I change the number of categories and posts displayed? =

Yes, go to WP-Admin > Settings > jQuery Accordion Cateogories and change the values.

= I added the sidebar widget, but the categories and posts are listed without the Accordion effects, what could be the problem? =

If the sidebar widget does not provide the required effects, its probably your theme or some other plugin calling the jQuery again without using the built-in WordPress' enqueue script functions. In that case, the jQuery will mostly conflict with each other.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the directory of the stable readme.txt, so in this case, `/tags/4.3/screenshot-1.png` (or jpg, jpeg, gif)
2. This is the second screen shot

== Changelog ==
= 2.1 =
* UPDATED: Compatibility with WordPress 5.7.2
* FIXED: Deprecated functions, notices & errors

= 2.0 =
* UPDATED: Compatibility with WordPress 5.2.3
* FIXED: Deprecated functions, notices & errors

= 1.0 =
* This is a new plugin and first version, will be adding more features to it soon, will update the Changelog then.

== Upgrade Notice ==
No previous version was available from which you could upgrade.

== Arbitrary section ==

== A brief Markdown Example ==

Ordered list:

Automatically adds the jQuery UI Accordion.
Optimized code to list large number of categories and posts in sidebar

Unordered list:
