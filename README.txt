=== Sunny ===
Contributors: typisttech, tangrufus
Donate link: https://typist.tech/donation/
Tags: cloudflare, speed, caching, cache, rest-api
Requires at least: 4.7
Requires PHP: 7.0.0
Tested up to: 4.9.1
Stable tag: 2.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically purge Cloudflare cache, including cache everything rules.

== Description ==

Automatically purge Cloudflare cache, including cache everything rules.

= Warning!!! =

This plugin is not for normal users! Read the whole [readme](https://wordpress.org/plugins/sunny/#description) and [FAQ](https://wordpress.org/plugins/sunny/#faq) before installing.

Cloudflare cache everything rules breaks most WordPress dynamic functionalities:

* [WordPress Nonces](https://codex.wordpress.org/WordPress_Nonces) will be cached
* Forms must be loaded via AJAX unless you’re using the USD$ 200 Cloudflare plan. [Learn more](https://github.com/TypistTech/sunny/issues/118#issuecomment-324325599)

Sunny shows a few admin notices in WP admin dashboard promoting the author's web development services every 2 weeks.They are dismissible via the `X` button on the right corner. See faq for more info.This is a free plugin, free as in free of charge and in freedom. You can always remove those notices without breaking other parts of Sunny.

The next major release of Sunny(v3.0.0) will require:

- PHP 7.1
- WordPress 4.9
- Properly working [WP Cron](https://typist.tech/articles/ensure-wp-cron-runs-on-time/)

= Features =

* Automatically purge Cloudflare `cache everything` rules' caches
* Use the latest Cloudflare API v4
* Support custom post type
* Hide admin bar from public-facing pages
* WP REST API support
* [Extendable Laravel-like container](https://github.com/Typisttech/sunny#extending-sunny)

= Debuggers =

Go `Sunny` --> `Debuggers`, it shows:

* All related urls to be purged for a given post
* Show targeted urls which always be purged
* `Cache Status` of a given URL

= How does Sunny different from Cloudflare's official plugin? =

At the time of writing, Cloudflare's [official plugin](https://wordpress.org/plugins/cloudflare/) doesn't purge `cache everything` rules' caches. Here comes Sunny! Sunny focus on purging caches when needed.

= Compatibility =

* Works with Cloudflare's [official plugin](https://wordpress.org/plugins/cloudflare/)
* Works with [WP Cloudflare Guard (Automatically create firewall rules to block dangerous IPs.)](https://wordpress.org/plugins/wp-cloudflare-guard/)

= Things You Need to Know =

* You need PHP `7.0` or later
* You need WordPress `4.7` or later
* You need a Cloudflare account (free plan is okay)
* This plugin was not built by [Cloudflare, Inc](https://www.cloudflare.com/)

> If you like the plugin, feel free to [rate it](https://wordpress.org/support/plugin/sunny/reviews/#new-post) or [donate](https://typist.tech/donation/). Thanks a lot! :)

= Support =

To save time so that we can spend it on development, please read the plugin's [FAQ](https://wordpress.org/plugins/sunny/faq/) first. Before requesting support, and ensure that you have updated Sunny and WordPress to the latest released version and installed PHP 7 or later.

You can get support via [GitHub issues](https://github.com/Typisttech/sunny/issues)(preferred) and WordPress [support forum](https://wordpress.org/support/plugin/sunny).

If you don't provide these information, your support ticket will be ignored:

* PHP version number (if you say `latest`, your ticket will be closed without replies)
* WordPress version number
* Sunny version number
* What is the current behavior
* What is the expected or desired behavior
* Step to reproduce current behavior
* Does it behave the same when Sunny is disabled
* Does it behave the same when only Sunny is enabled
* What have you tried to resolve the issue

= For Developers =

Sunny is open source and hosted on [GitHub](https://github.com/TypistTech/sunny). Feel free to make [pull requests](https://github.com/Typisttech/sunny/pulls).

You can also tweak `Sunny` to work for you by [extending its Laravel-like container](https://github.com/Typisttech/sunny#extending-sunny).

== Frequently Asked Questions ==

= How can I purge extra URLs? =

Post related urls are filterable by `Strategies` and `sunny_post_related_urls`. See examples on [Sunny Purge Extra URLs Example](https://github.com/TypistTech/sunny-purge-extra-urls-example).

If you don't understand the example code, [hire me](https://typist.tech/contact/) instead.

= How can I tweak Sunny to work for my special needs?=

Extend its [Laravel-like container](https://github.com/Typisttech/sunny#extending-sunny).

= What version of PHP do I need? =

PHP `7.0` or later.

= What version of WordPress do I need? =

WordPress `4.7` or later.

= What to do when `Parse error: syntax error`? =

If you encountered this error:

`Parse error: syntax error, unexpected ‘:’, expecting ‘;’ or ‘{‘ in wp-content/plugins/sunny/src/Sunny.php on line XX`

You probably running on a old version of PHP. Upgrade your server to PHP `7.0` or later.

= Unable to dismiss advertisements =

Sunny shows a few admin notices in WP admin dashboard promoting the author's web development services every 2 weeks.
They are dismissible via the `X` button on the right corner.

Why do they don’t go away?
Your caching settings are incorrect! Possible issues:

* Database query caches not purged when updated
* Object cache expire time too long
* Cloudflare is caching `wp-admin`

Sunny works with database query caching and object caching. This plugin won't fix improper server configuration.

But... other plugins don't have this issue?

I doubt. Sunny saves/retrieves those notices via [Options API](https://codex.wordpress.org/Options_API) which commonly used in plugins. Thus, other plugins should get outdated options as well. Hire a developer to check your site!

If you still not convinced, submit a pull request with failing test case via [GitHub](https://github.com/TypistTech/sunny).

= Should I install Sunny version 1 because of PHP 5 incompatibles? =

No. Sunny version 1 uses Cloudflare API v1 which [deprecated since 9th November, 2016](https://blog.cloudflare.com/sunsetting-api-v1-in-favor-of-cloudflares-current-client-api-api-v4/). Either update your server or uninstall Sunny.

= Don't know how to update PHP? =

* Contact you hosting company
* Switch to a better hosting such as [WP Engine](https://typist.tech/go/wp-engine-isnt-business-worth-29-month/) or [Kinsta](https://typist.tech/go/kinsta-staging-environment/)
* Hire me [https://typist.tech/contact](https://typist.tech/contact)

= Will you support older versions of PHP or WordPress? =

Depends. I accept this kind of custom coding jobs. However, prepare for being rejected if the requirement doesn't make sense.
Shoot me an email at [info@typist.tech](mailto:info@typist.tech) or use this [contact form](https://typist.tech/contact/).

= Is this plugin written by Cloudflare, Inc.? =

No. This plugin is a [Typist Tech](https://typist.tech) project.

= Who make this plugin? =

[Tang Rufus](mailto:info@typist.tech), a freelance developer for hire. I make [Typist Tech](https://typist.tech/) also.

= Can I install Sunny, Sunny and Cloudflare's official plugin at the same time? =

Yes, all of them work together without problems.

* Install [WP Cloudflare Guard](https://wordpress.org/plugins/wp-cloudflare-guard/) if you want to protect your site from bad IPs
* Install [Sunny](https://wordpress.org/plugins/sunny/) if you want to purge Cloudflare's cache automatically
* Install the [official plugin](https://wordpress.org/plugins/cloudflare/) if you can't see the real IP from visitors

= Does this plugin available in my language? =

English works out of the box.

Traditional Chinese language pack is available [here](https://translate.wordpress.org/projects/wp-plugins/sunny/language-packs).

You can add your own translation at [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/sunny).

= How to get support? =

Read the whole [readme](https://wordpress.org/plugins/sunny/#description) and [FAQ](https://wordpress.org/plugins/sunny/#faq) first!

= How can I support this plugin? =

If you like the plugin, feel free to:

* Give us a 5-star review on [WordPress.org](https://wordpress.org/support/plugin/sunny/reviews/#new-post)
* Translate it at [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/sunny)
* [Donate](https://typist.tech/donation/). Thanks a lot! :)

Besides, `Sunny` is open source and hosted on [GitHub](https://github.com/TypistTech/sunny). Feel free to make pull requests.

Last but not least, you can hire me. Shoot me an email at [info@typist.tech](mailto:info@typist.tech) or use this [contact form](https://typist.tech/contact/).

= What if I want more? =

Hire me! Shoot me an email at [info@typist.tech](mailto:info@typist.tech) or use this [contact form](https://typist.tech/contact/).

== Screenshots ==

1. Cloudflare Settings
1. Admin Bar Settings
1. Purge when Post Updated
1. Debuggers - Cache Status for a Given URL
1. Debuggers - Related URLs for a Given Post
1. Debuggers - Additional URLs for Every Purge
1. Annoying Sunny v1 deprecated notice

== Changelog ==

Full change log available at [GitHub](https://github.com/typisttech/sunny/blob/master/CHANGELOG.md)

= 2.4.1 =

* Add required php version to README.txt
* Apply code style patches and minor refactoring
* Test on PHP nightly
* Update dependencies

= 2.4.0 =

* Extract targets service provider
* Show post type name in purge initiated notices

= 2.3.0 =

* Expose Container via WordPress action in Laravel style

= 2.2.1 =

* Fix: Ensure admins have a chance to view PHP 5.x unsupported notice
* Fix: Do not force sticky notice when WP_DEBUG is true

= 2.2.0 =

* Purge adjacent posts urls
* Debugger: Check whether a url is cached by Cloudflare
* Add lots of tests

= 2.1.0 =

* Better WP REST API support
* Purge homepage (both dynamic and static)
* Add Debugger: Show all urls to be purged for a given post
* Add Debugger: Show targeted urls which always be purged
* Fix: Missing post url when purging

= 2.0.1 =

* Self deactivate if PHP version is older than `7.0.0`

= 2.0.0 =

* Update to Cloudflare API v4
* Codebase rewrite
