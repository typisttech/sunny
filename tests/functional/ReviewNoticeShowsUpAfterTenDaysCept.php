<?php

declare(strict_types=1);

use TypistTech\Sunny\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('review notice shows up after ten days');

$optionName = 'wrm_7c6bb0df81b695f1692c';
$I->amGoingTo('reset WP Review Me installed time');
$I->dontHaveOptionInDatabase($optionName);

$I->loginToSunnySettingPage();

$I->wantToTest('WP Review Me installed time is set within the past ten seconds');
$installed = $I->grabOptionFromDatabase($optionName);
$I->assertGreaterOrEquals(time() - 10, $installed);
$I->assertLessOrEquals(time(), $installed);

$I->amGoingTo('fast forward ten days and one minute (864060 seconds)');
$I->haveOptionInDatabase($optionName, time() - 864060);

$I->amOnAdminPage('/options-general.php');
$I->seeLink(
    'Click here to leave your review',
    'https://wordpress.org/support/plugin/sunny/reviews?rate=5#new-post'
);
