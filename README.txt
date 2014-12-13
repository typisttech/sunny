=== Sunny (Connecting CloudFlare and WordPress) ===
Contributors: tangrufus, wphuman
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_cart&business=tangrufus%40gmail%2ecom&lc=HK&item_name=Sunny%20%28CloudFlare%20Management%29%20Plugin%20Donation&item_number=sunny%2edonation%2ewp%2eorg&amount=10%2e00&currency_code=USD&button_subtype=products&no_note=0&add=1&bn=PP%2dShopCartBF%3abtn_cart_LG%2egif%3aNonHostedGuest
Tags: cloudflare, cache, CDN, performance, security, spam
Requires at least: 3.6.0
Tested up to: 4.1.0
Stable tag: 1.5.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically clear CloudFlare cache. And, protect your WordPress site at DNS level.

== Description ==

Sunny automatically clears CloudFlare cache. And, protect your WordPress site at DNS level.

= Features =

* Integrate with [iThemes Security](https://wordpress.org/plugins/better-wp-security/), [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) and [WordPress Zero Spam](https://wordpress.org/plugins/zero-spam)
* Blacklist IP if attempt to login with bad username
* Automatically clears corresponding CloudFlare caches whenever a post/page/media attachment is updated, commented or trashed.
* Purge CloudFlare cache from WordPress admin dashboard
* Test your CloudFlare API key

= Guide =
* Step-by-step [tutorial](https://wphuman.com/make-cloudflare-supercharge-wordpress-sites/)

= How does Sunny different from CloudFlare's offical plugin? =

At the time of writting, CloudFlare's [offical plugin](https://wordpress.org/plugins/cloudflare/) doesn't purge anything for WordPress. It provides the real IP of your visitors and notify CloudFlare when you marking an IP as SPAM. However, it does not include a way to clear the cache or make adjustments to how it works. Here comes Sunny! Sunny focus on cache purging.

= Things you need to know =

* You need a CloudFlare account.
* This plugin was not built by CloudFlare.

= How others talking about Sunny? =

* [Sunny: A Plugin to Automatically Clear CloudFlare Cache and Manage Settings in WordPress](http://wptavern.com/sunny-a-plugin-to-automatically-clear-cloudflare-cache-and-manage-settings-in-wordpress)

If you have written an article about `Sunny`, do [let me know](http://tangrufus.com/hire-rufus/).


= Who make this plugin? =

[Tang Rufus](http://tangrufus.com), a freelance developer for hire.
I make [WP Human](https://wphuman.com) also.

= Requirement =
* PHP 5.3 or later

== Installation ==

1. Download the plugin.
1. Go to the WordPress Plugin menu and activate it.
1. Go to "Settings" --> "Sunny"
1. Fill in your CloudFlare account info
1. Test it with Connection Tester (via Settings Page)
1. That's it!

Check out this [step-by-step guide](https://wphuman.com/make-cloudflare-supercharge-wordpress-sites/) for detail instructions.


== Frequently Asked Questions ==

Check out this [step-by-step tutorial](https://wphuman.com/make-cloudflare-supercharge-wordpress-sites/).

= Is this plugin written by CloudFlare, Inc.? =

No.
Sunny is written by [Tang Rufus](http://tangrufus.com)

= Can I install both Sunny and CloudFlare's offical plugin at the same time? =

Yes.

= When should I install Sunny and CloudFlare's offical plugin at the same time? =

Install Sunny if you want to purge CloudFlare's cache automatically.
Install the offical plugin if you can't see the real IP from visitors.

= When does Sunny purge my cache? =

Every time a *published* post is updated or commented.
Or, every time post status change from/to `published`

= What pages does it purge when a post is updated? =

The post itself, homepage and its catories, tags and taxonomies archive.
Use the URL purger on `Tools` tab to check what will be cleared for a particular URL.
You can disable this behavior via the `General` tab.

= What if Sunny blacklisted my IP? =

1. Login [CloudFlare](http://cloudflare.com).
2. Release you IP on the threat control dashborad.

= Parse error: syntax error, unexpected T_FUNCTION in ... =
If you come across this error, make sure that you have PHP 5.3 or later installed.

= Dose it support mulitsite? =

Confirmed that it doesn't work network wide. While this version of `Sunny` does not intended to support mulitsite, you might want to try activating `Sunny` on a per site basis (WPMU DEV has a step-by-step [tutorial](http://premium.wpmudev.org/manuals/wpmu-manual-2/activating-and-deactivating-plugins-on-a-per-site-basis/)). Please report your findings.

Moreover, I am planning to write a mulitsite version. [Drop me a note](https://wphuman.com/contact/) if you want early asscess.


== Screenshots ==

1. Account Settings
1. General Settings
1. Email Settings
1. Tools
1. Integration


== Changelog ==

= 1.5.1 =
* Fix: Activator incorrect message
* Fix: `ITSEC_Lockout` constructor missing argument
* Security: Add black index files
* Developer: Rename `intergrated_plugin_name` --> `intergrated_plugin_slug`
* Developer: Remove views files in `public` folder
* Developer: Refactor `Sunny_Settings` & `Sunny_Sanitization_Helper` with dependency inversion principle
* Developer: Rename folder `plublic` to `modules`\
* Developer: Modularize `Sunny_iThemes_Security` and `Sunny_Zero_Spam`

= 1.5.0 =
* Fix: update notice not showing
* Developer: Better file headers
* Developer: Introduce abstract spam module
* Deprecated: plugin_screen_hook_suffix

= 1.4.16 =
* New Translation: zh_HK

= 1.4.15 =
* New Feature: Integrate with [Contact Form 7](https://wordpress.org/plugins/contact-form-7/)
* Fix: Zero Spam module early quit before getting IPs
* Developer: WP Plugin Boilerplate - Change name -> plugin_name for consistency. See [this commit](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/commit/025d61efee426aadda743d09fcbcaa9db83d76f4)
* Developer: WP Plugin Boilerplate - Fixing require() -> require_once(). See [this commit](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/commit/2960b6c1c875d52f625d862b6e1a28dd4e6f4110)
* Deverloper: WP Plugin Boilerplate -  Create functions for activation and deactivation hooks. See [this commit](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/commit/e015b9cd7c402167aa526c20be9c53e2aa17845d)

= 1.4.14 =
* Allow CLI scripts access, see [https://wordpress.org/support/topic/plugin-blocks-cli](https://wordpress.org/support/topic/plugin-blocks-cli)
* Add [WordPress Zero Spam](https://wordpress.org/plugins/zero-spam) hooks

= 1.4.13 =
* Tweak: Use `zero_spam_ip_blocked` instead of `zero_spam_found_spam_registration` and `zero_spam_found_spam_comment`
* Tweak: Sanitize in [Easy Digital Downloads way](https://github.com/easydigitaldownloads/Easy-Digital-Downloads/pull/2533)

= 1.4.12 =
* New Feature: Integrate with [iThemes Security](https://wordpress.org/plugins/better-wp-security/)
* Performance boost: Early quit if unnecessary
* Tweak: Use jQuery UI style on setting pages
* Fix: Unable to send [WordPress Zero Spam](https://wordpress.org/plugins/zero-spam) blacklist notification emails

= 1.4.11 =
* New Feature: Integrate with [WordPress Zero Spam](https://wordpress.org/plugins/zero-spam)
* Add: WP Human as contributor
* Add: WP Human [tutorial](https://wphuman.com/make-cloudflare-supercharge-wordpress-sites/) admin notice

= 1.4.10 =
* Update screenshots

= 1.4.9 =
* Add: WP Human [tutorial](https://wphuman.com/make-cloudflare-supercharge-wordpress-sites/)
* Add: URL input fields
* Tweak: Use PHP `filter_var` to validate IPs and check localhost IPs
* Tweak: Line breaks between input fields and labels
* Fix: Typo

= 1.4.8 =
* Tweak: Use WP Human newletter signup form
* Deprecated: zone_ips, Pull recent IPs visiting site

= 1.4.7 =
* Fix: `127.0.0.1` is localhost

= 1.4.6 =
* Fix: Separating admin notices and email notification
* Fix: Log email notification into php error log only if `WP_DEBUG` is true

= 1.4.5 =
* Performance: Not loading plugin css
* Security: Checking `page=sunny` as referral
* Fix: `check wp_http_referer` bugged with question marks
* Fix: Empty customized bad usernames issue


= 1.4.4 =
* New: Customize bad usernames
* New: Non-ajax support to `Tools` Ttb
* New: Prevent network wide activation

= 1.4.3 =
* Fix: Deactivation hook typo

= 1.4.2 =
* New: Option to disable email notifications
* Fix: Set default email frequency to immediately
* Security Fix

= 1.4.1 =
* New: zh_TW Translation

= 1.4.0 =
* Code Rewrite & File Organization
* New: Defer noticifcation emails
* New: Ban IP if Login As `Administrator`
* New :Purge when status change from/to `published`
* Fix: IP being banned twice
* Fix: Duplicate blacklist notification email
* Fix: Admin bar always been hided

= 1.3.0 =
* New:Ban IP if Login As `Admin`

= 1.2.6 =
* Bug Fix

= 1.2.5 =
* New: Mailing List Signup Form

= 1.2.4 =
* Improve Performance

= 1.2.3 =
* New: Support special type top level domains


= 1.2.2 =
* New: Ready for localization
* Fix: Class 'Parent' not found fatal error

= 1.2.1 =
* Bug Fix

= 1.2.0 =
* New: Admin bar hider
* Code Rewrite
* UI Improvement
* Performance Improvement
* Remove: GitHub Updater

= 1.1.1 =
* Fix: Wrong version number

= 1.1.0 =
* New: URL purger
* New: Purge related URLs during post update
* Better Description and Documents

= 1.0.4 =
* Tidy up source code according to WordPress coding standard

= 1.0.3 =
* Tidy ReadMe

= 1.0.2 =
* New: PayPal Donation Link

= 1.0.1 =
* Submit to WordPress Plugin Directory

= 1.0.0 =
Initial Release

* New: Readme.txt
* New: Screenshots

= 0.0.2 =
* New: GitHub Updater

= 0.0.1 =
* Initial Alpha Test

== Upgrade Notice ==

= 1.4.16 =
Sunny now works with Contact Form 7! And, zh_HK translation available!

= 1.4.15 =
Sunny now works with Contact Form 7!

= 1.4.12 =
Sunny now works with iThemes Security!

= 1.4.4 =
You can define your own bad usernames with Sunny now!
