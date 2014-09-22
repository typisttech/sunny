=== Sunny (Connecting CloudFlare and WordPress) ===
Contributors: tangrufus
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_cart&business=tangrufus%40gmail%2ecom&lc=HK&item_name=Sunny%20%28CloudFlare%20Management%29%20Plugin%20Donation&item_number=sunny%2edonation%2ewp%2eorg&amount=10%2e00&currency_code=USD&button_subtype=products&no_note=0&add=1&bn=PP%2dShopCartBF%3abtn_cart_LG%2egif%3aNonHostedGuest
Tags: cloudflare, cache, CDN, performance, security, spam
Requires at least: 3.6.0
Tested up to: 4.0.0
Stable tag: 1.4.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically clear CloudFlare cache. And, protect your WordPress site at DNS level.

== Description ==

Sunny automatically clears CloudFlare cache. And, protect your WordPress site at DNS level.

= Features =

* Blacklist IP if attempt to login with bad username
* Automatically clears corresponding CloudFlare caches whenever a post/page/media attachment is updated, commented or trashed.
* Purge your entire CloudFlare cache manually
* Purge your a URL cache manually
* Test your CloudFlare API key

= How does Sunny different from CloudFlare's offical plugin? =

At the time of writting, CloudFlare's [offical plugin](https://wordpress.org/plugins/cloudflare/) doesn't purge anything for WordPress. It provides the real IP of your visitors and notify CloudFlare when you marking an IP as SPAM. However, it does not include a way to clear the cache or make adjustments to how it works. Here comes Sunny! Sunny focus on cache purging.

= Planned features =

* Blacklist an IP when WP Better Secuity lockdown it

= Things you need to know =

* You need a CloudFlare account.
* This plugin was not built by CloudFlare.

= How others talking about Sunny? =

* [Sunny: A Plugin to Automatically Clear CloudFlare Cache and Manage Settings in WordPress](http://wptavern.com/sunny-a-plugin-to-automatically-clear-cloudflare-cache-and-manage-settings-in-wordpress)

If you have written an article about `Sunny`, do [let me know](http://tangrufus.com/hire-rufus/).


= Who make this plugin? =

[Tang Rufus](http://tangrufus.com), a freelance developer for hire.

== Installation ==

1. Download the plugin.
1. Go to the WordPress Plugin menu and activate it.
1. Go to "Settings" --> "Sunny"
1. Fill in your CloudFlare account info
1. Test it with Connection Tester (via Settings Page)
1. That's it!


== Frequently Asked Questions ==

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

= Dose it support mulitsite? =

Confirmed that it doesn't work network wide. While this version of `Sunny` does not intended to support mulitsite, you might want to try activating `Sunny` on a per site basis (WPMU DEV has a step-by-step [tutorial](http://premium.wpmudev.org/manuals/wpmu-manual-2/activating-and-deactivating-plugins-on-a-per-site-basis/)). Please report your findings.

Moreover, I am planning to write a mulitsite version. [Drop me a note](http://tangrufus.com/hire-rufus/) if you want early asscess.


== Screenshots ==

1. CloudFlare Account Settings & Connection Tester
1. More Settings
1. Purgers


== Changelog ==

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
* Security: Checking page=sunny as referral
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

= 1.4.4 =
You can define your own bad usernames with Sunny now!