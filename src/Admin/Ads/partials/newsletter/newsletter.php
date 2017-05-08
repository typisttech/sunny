<?php
/**
 * Sunny
 *
 * Automatically purge CloudFlare cache, including cache everything rules.
 *
 * @package   Sunny
 *
 * @author    Typist Tech <sunny@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/sunny
 * @see       https://wordpress.org/plugins/sunny/
 */

declare(strict_types=1);

/* @var \TypistTech\Sunny\Admin\Ads\Newsletter $context Context */

?>

<div id="mlb2-4959648" class="ml-subscribe-form ml-subscribe-form-4959648">
    <div class="ml-vertical-align-center">
        <div class="subscribe-form ml-block-success" style="display:none">
            <div class="form-section">
                <h4>You Rock!</h4>
                <p>Thank you! Please check your mailbox for the confirmation email.</p>
                <p>I hate double opt-ins too. But... the internet is full of robots.</p>
            </div>
        </div>
        <form class="ml-block-form"
              action="//app.mailerlite.com/webforms/submit/b3e8l2"
              data-id="404526"
              data-code="b3e8l2"
              method="POST"
              target="_blank">
            <div class="subscribe-form">
                <div class="form-section mb10">
                    <h4>Typist Tech Articles</h4>
                    <p>Be the First to Know WordPress Tips and Tricks</p>
                </div>
                <div class="form-section">
                    <div class="form-group ml-field-email ml-validate-required ml-validate-email">
                        <input type="email"
                               name="fields[email]"
                               class="form-control"
                               placeholder="Email*"
                               value="<?php echo esc_html($context->getCurrentUserEmail()); ?>"
                               autocomplete="email"
                               x-autocompletetype="email"
                               spellcheck="false"
                               autocapitalize="off"
                               autocorrect="off">
                    </div>
                </div>
                <input type="hidden" name="ml-submit" value="1"/>
                <button type="submit" class="primary">
                    Subscribe Newsletter
                </button>
                <button disabled="disabled" style="display: none;" type="button" class="loading">
                    <img src="//static.mailerlite.com/images/rolling.gif" width="20" height="20"
                         style="width: 20px; height: 20px;">
                </button>
            </div>
        </form>
    </div>
</div>
