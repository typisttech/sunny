=== Sunny ===
Contributors: typisttech, tangrufus
Donate link: https://www.typist.tech/donate/sunny/
Tags: cloudflare, firewall, security, spam
Requires at least: 4.7
Tested up to: 4.7.4
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically purge CloudFlare cache, including cache everything rules.

== Description ==

Automatically purge CloudFlare cache, including cache everything rules.

= Features =

* Automatically purge CloudFlare `cache everything` rules' caches
* Use the latest Cloudflare API v4
* Support custom post type
* Hide admin bar from public-facing pages

= Coming soon =

* WP REST Api support
* WP CLI support

= How does Sunny different from Cloudflare's official plugin? =

At the time of writing, Cloudflare's [official plugin](https://wordpress.org/plugins/cloudflare/) doesn't purge `cache everything` rules' caches. Here comes Sunny! Sunny focus on purging caches when needed.

= Compatibility =

* Works with Cloudflare's [official plugin](https://wordpress.org/plugins/cloudflare/)
* Works with [WP Cloudflare Guard (Automatically create firewall rules to block dangerous IPs.)](https://wordpress.org/plugins/wp-cloudflare-guard/)

= Things You Need to Know =

* You need PHP 7.0 or later
* You need WordPress 4.7 or later
* You need a Cloudflare account (free plan is okay)
* This plugin was not built by [Cloudflare, Inc](https://www.cloudflare.com/)

> If you like the plugin, feel free to [rate it](https://wordpress.org/support/plugin/sunny/reviews/#new-post) or [donate via PayPal](https://www.typist.tech/donate/sunny/). Thanks a lot! :)

= For Bloggers =

If you have written an article about `Sunny`, do [let me know](https://www.typist.tech/contact/). For any questions, shoot me an email at [info@typist.tech](mailto:info@typist.tech)

= For Developers =

Sunny is open source and hosted on [GitHub](https://github.com/TypistTech/sunny). Feel free to make [pull requests](https://github.com/Typisttech/sunny/pulls).

= Who make this plugin? =

[Tang Rufus](mailto:info@typist.tech), a freelance developer for hire.
I make [Typist Tech](https://www.typist.tech/) also.

= Support =

To save time so that we can spend it on development, please read the plugin's [FAQs](https://wordpress.org/plugins/sunny/faq/) first.
Before requesting support, and ensure that you have updated Sunny and WordPress to the latest released version and installed PHP 7 or later.

We hang out in the WordPress [support forum](https://wordpress.org/support/plugin/sunny) for this plugin.

If you know what `GitHub` is, use [GitHub issues](https://github.com/Typisttech/sunny/issues) instead.

== Installation ==

= Via WordPress admin dashboard =

1. Log in to your site’s Dashboard (e.g. www.your-domain.com/wp-admin)
1. Click on the `Plugins` tab in the left panel, then click “Add New”
1. Search for `Sunny` and the latest version will appear at the top of the list of results
1. Install it by clicking the `Install Now` link
1. When installation finishes, click `Activate Plugin`

= Via Manual Upload =

1. Download the plugin from [wordpress.org](https://downloads.wordpress.org/plugin/sunny.zip)
1. Unzip it
1. Upload it to `wp-content/plugins/`
1. Go to the WordPress plugin menu and activate it

= Via WP CLI =

1. `$ wp plugin install sunny --activate`

== Frequently Asked Questions ==

= What version of PHP do I need? =

PHP 7 or later.

= Is this plugin written by Cloudflare, Inc.? =

No.
This plugin is a [Typist Tech](https://www.typist.tech) project.

= Can I install Sunny, Sunny and Cloudflare's official plugin at the same time? =

Yes, all of them work together without problems.

* Install [WP Cloudflare Guard](https://wordpress.org/plugins/wp-cloudflare-guard/) if you want to protect your site from bad IPs
* Install [Sunny](https://wordpress.org/plugins/sunny/) if you want to purge CloudFlare's cache automatically
* Install the [official plugin](https://wordpress.org/plugins/cloudflare/) if you can't see the real IP from visitors

= Does this plugin available in my language? =

English works out of the box.

Traditional Chinese language pack is available [here](https://translate.wordpress.org/projects/wp-plugins/sunny/language-packs).

You can add your own translation at [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/sunny).

= How to get support? =

Use the WordPress support forum for this plugin at [https://wordpress.org/support/plugin/sunny](https://wordpress.org/support/plugin/sunny).

Make sure you have read the plugin's FAQs at [https://wordpress.org/plugins/sunny/faq/](https://wordpress.org/plugins/sunny/faq/). And, updated Sunny and WordPress to the latest released version before asking questions.

If you know what `GitHub` is, use [GitHub issues](https://github.com/Typisttech/sunny/issues) instead.

= How can I support this plugin? =

If you like the plugin, feel free to:

* Give us a 5-star review on [WordPress.org](https://wordpress.org/support/plugin/sunny/reviews/#new-post)
* Donate via [PayPal](https://www.typist.tech/donate/sunny/). Thanks a lot! :)
* Translate it at [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/sunny).

Besides, `Sunny` is open source and hosted on [GitHub](https://github.com/TypistTech/sunny). Feel free to make pull requests.

Last but not least, you can hire me. Shoot me an email at [info@typist.tech](mailto:info@typist.tech) or use this [contact form](https://www.typist.tech/contact/).

= What if I want more? =

Hire me!

Shoot me an email at [info@typist.tech](mailto:info@typist.tech) or use this [contact form](https://www.typist.tech/contact/).

== Screenshots ==

1. Cloudflare Settings
1. Purge when posts updated

== Changelog ==

Full change log available at [GitHub](https://github.com/typisttech/sunny/blob/master/CHANGELOG.md)

= 2.0.0 =

* Update to Cloudflare API v4
* Codebase rewrite

== Upgrade Notice ==

= 2.0.0 =

* Security functionalities have been separated to [Sunny](https://wordpress.org/plugins/sunny/)
* You have to re-enter Cloudflare settings.
