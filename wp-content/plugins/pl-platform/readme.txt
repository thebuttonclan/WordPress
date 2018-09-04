=== PageLines Platform 5 ===
Requires at least: 4.1
Contributors: pagelines
Tested up to: 4.7.1
Stable tag: 5.1.8
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Tags: page builder, responsive, widget, widgets, builder, page, admin, gallery, content, cms, pages, post, css, layout, grid

A complete drag & drop editing system for ANY WordPress theme. Insanely fast, bloat free and beautifully designed.

== Description ==

Welcome to PageLines Platform. This plugin connects your site to the PageLines platform and infrastructure.
It's designed to help you build great websites, faster.

[youtube https://www.youtube.com/watch?v=mG6VFUruTkw]

= Editing For Professionals =

Platform 5 was built for web professionals and their clients. It is extremely fast, bloat-free, and fun to work with. Designers do what they love, clients get the control they need.

= No Coding, No Debugging =

Coding is tedious and frustrating, even if you are great at it. That's why Platform 5 allows you to drop in sections of pre-coded design with a single-click.
[View All Extensions](https://www.pagelines.com/extensions/)

= Supercharge any WP theme =

Platform 5 is a plugin that works with any standard WordPress theme. Add it to existing client sites or use it with that old framework you love.

= A few more reasons you'll love Platform 5... =


* **Mobile First**
Platform 5 was built with mobile devices in mind. It is responsive and looks great everywhere.

* **Drag & Drop**
Control page layouts with a simple drag and drop system that won't get in your way.

* **Fast as Hell**
Platform 5 is rendered in the visitors browser so it runs fast even on cheap hosting.

* **Developer Friendly**
PageLines supports all the WordPress tools you are used to. Child themes, templates, plugins, etc...

* **Extension Based**
Platform 5 is extension oriented, which means it's as lean or powerful as you want it to be.

== Installation ==

= Minimum Requirements =

* WordPress 3.8 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of Platform 5, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type Platform 5 and click Search Plugins. Once you’ve found our plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now”.

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your webserver via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work just like any other WordPress plugin; as always though, ensure you backup your site just in case.


== Screenshots ==

1. Drag & Drop.
2. One Click extension install.
3. Global Options panel.
4. Per Section controls.

== Changelog ==

= 5.1.6 =

* Added primary button color option
* Fixed inline editing of text

= 5.1.5 =

* Make sure oauth response is not a WP_Error.

= 5.1.4 =

* Remove src from images in hidden section template modules.
* New Pro Feature: Ability to set default padding for sections (1rem default).
* Fixed a layout issue with widget section on Safari.
* Tested with PHP 7.1, no issues.

= 5.1.3 =

* Clean up.

= 5.1.2 =

* Tested with WordPress 4.7
* Fixed an fatal error when section files are loaded and the php file no longer exists.

= 5.1.1 =

* Revert search button changes.

= 5.1.0 =

* Basic Inline Editing for section content added. ( More to follow! )
* Enhanced SVG support for images using native <svg> tag.
* New PageID option support.
* Updated Font Awesome to 4.7.0

= 5.0.163 =

* Fix google font loader priority.

= 5.0.162 =

* Better error handling with tokens/oauth.

= 5.0.161 =

* New arg added to pl_searchform() you can now change placeholder text.

= 5.0.160 =

* New filter: pl_pagination
* New function: pl_enqueue_google_font. Usage: pl_enqueue_google_font( 'Fjalla One' );

= 5.0.159 =

* Fix extensions issue introduced in .157

= 5.0.158 =

* Extensions not loading issue fixed.
* wpengine added to staging whitelist.
* logged-in body tag added.

= 5.0.157 =

* Check if user has PHP cURL extension before trying to oauth request.
* Bump tested up to.
* Update all urls to https where appropriate.

= 5.0.156 =

* 'script' option type bypasses kses.
* Internal updates use CDN urls.
* Fix javascript error if no data received on Extensions page.
* pl_uploads_url filter added to shortcode output.

= 5.0.155 =

* Multisite/Extend. Make sure were using network admin urls where needed. Fixes all the things.

= 5.0.154 =

* Fix pagination on single post pages.
* Add support for WP 4.7 WP_Hook()
* Increase timeout for store connections.
* flywheelsites domain added to whitelist.

= 5.0.153 =

* Extend, fixed an issue if an extension folder is deleted PL5 still thinks its there.
* Extend, New type: Page Templates, these are typically templates for one page sites.
* Extend, Use SSL links for CDN.
* Extend, Default to showing all extensions 20 per page.

= 5.0.152 =

* Various touch events added in the builder, editing is now possible using ipads.
* Multisite, only show account on the root site.
* Multisite, Allow the extend page, but remove all install/update buttons.
* Builder, allow new filter 'template'.
* Builder live script loading adjustments.

= 5.0.151 =

* pl_maybe_unserialize() Use actual function as a callback instead of create_function()
* Check a plugin is actually installed before we try and update it.
* Fixed jQuery error on extend page.
  Low cost hosting that blocks all external HTTP requests would break the ajax for extend.

= 5.0.150 =

* myftpupload now detected as a staging site, no need to activate.
* Raw IPs as domains are also considered staging sites, http://111.222.333.444 for example.
* Removed languages folder, not needed for language packs.
* Added items_wrap to args for nav menus.

= 5.0.149 =

* Use wp_json_encode()
* Use wp_send_json()
* Fix untranslatable string.
* Make sure a plugin is installed before checking for updates.

= 5.0.148 =

* Small UI fixes.
* PageLines Plugins can now use 'reqver' header to require a certain version of Platform 5, just like sections.
* PageLines Plugins data is now cached in the database for faster retrieval. A lot less hits to the file system.
* Add a default array to Shortcodes, fixes an issue when 'filter' isnt declared. Props MrFent.
* Check for nonce on user profile save.

= 5.0.147 =

* preg_replace /e modifier replaced with preg_replace_callback.

= 5.0.146 =

* Remove unneeded i18n code as we use language packs natively.
* Small UI CSS fixes.
* overflow-x hidden added to .site-wrap, fixes some issues with negative margins.

= 5.0.145 =

* Updated FontAwesome libs to 4.6.3
* Fixed an issue with DMS1/2 image picker and PL5. Thanks Trevor Corson.
* New filter 'pl_button_link_options'.
* 'staging', 'dev', 'xip' as domain parts are used as staging domains.

= 5.0.144 =

* Fix undefined index with PHP 7.1alpha1
* Fixed minor z-index glitch in builder for hidden sections.
* Added current post/page slug/id under section advanced settings.
* Alternative script loader option added under main advanced settings.

= 5.0.143 =

* 'pl_btn_classes', 'pl_btn_sizes' filters added.
* Updates for PageLines theme updates were broken on multisites installs.

= 5.0.142 =

* Fix undefined variable on accounts page.
* Reworked auto-updates, now fully tested on ManageWP and Jetpack, should work with all the other
  remote admin providers.
* Added PL_DISABLE_UPDATES to disable all PageLines Extension updates.

= 5.0.141 =

* If no menu selected, show 1st available menu instead of nothing at all.
* Added PL_ALTERNATIVE_FOOTER_SCRIPTS as an alternative footer scripts loader.
* Only show the updates subscribe button if the admin user is the one with the 'connected' account.
* Use count_select not select_count for an option type.

= 5.0.140 =

* Add Subscribe to extension updates button in Extend.
* Add object-fit:cover to background videos, props Doug.
* Fix grid xs-2 with .666 not .667
* section_head() was not being executed during shortcodes, props MrFent.

= 5.0.139 =

* Mobile toggle fixes for menu section and ios devices.
* You can now select 'All' with select terms.
* Updates to the account area if users are affiliates.
* Wrapper fix, fixes an issue where certain scripts were being loaded twice.

= 5.0.138 =

* Fixed a CSS issue in wp-admin post editor.

= 5.0.137 =

* Fixed an isset() php warning.
* Fixed an issue where comma was being stripped from excepts.

= 5.0.136 =

* Icons updated to 4.6.1
* Various fixes for internal forms.

= 5.0.135 =

* Searchform CSS namespaced, fixes an issue with 3rd party themes.
* Various forms tweaks.
* Bugs and other improvements.

= 5.0.134 =

* Buttons now accept shortcodes, [pl_site_url] etc.

= 5.0.133 =

* Namespaced .description class in admin. Fixes an issue with Woocommerce.

= 5.0.132 =

* Fixed delete button for missing sections.

= 5.0.131 =

* Clicking Builder button while editing a page/post in wp-admin now opens that page/post in builder.
* Admin area messages should only show in admin area.
* Code cleanup using PHPCodesniffer and WordPress-Core ruleset.

= 5.0.130 =

* Fix links on plugins page
* Allow use of PageNavi if installed for page navigation


= 5.0.129 =

* Make sure during oauth handshake its actually PL5 and not jetpack
* Multi extension install fixed
* Media Picker CSS tweaks, search is now visible again

= 5.0.127 =

* Smooth scroll for all anchors removed

= 5.0.126 =

* Hide on page fixed
* New Grid size added pl-col-ss

= 5.0.125 =

* Public Release

== Upgrade Notice ==

= 5.0.129 =
Fixes an issue with other plugins that use oauth, jetpack facebook etc.
