<?php

declare(strict_types=1);

use TypistTech\Sunny\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('review me notice shows up after two weeks');

$optionName = 'sunny_review_me_notice_last_enqueue';

$I->amGoingTo('reset review me notice last enqueue timestamp');
$I->dontHaveOptionInDatabase($optionName);

$I->loginToSunnySettingPage();

$I->wantToTest('review me notice last enqueue timestamp is set in the last 3 seconds');
$lastEnqueueTimestamp = $I->grabOptionFromDatabase($optionName);
$I->assertGreaterOrEquals(time() - 3, $lastEnqueueTimestamp->getTimestamp());
$I->assertLessOrEquals(time(), $lastEnqueueTimestamp->getTimestamp());

$I->amGoingTo('fast forward 15 days and one minute');
$lastEnqueueTimestamp->modify('-15 days');
$lastEnqueueTimestamp->modify('-1 minute');
$I->haveOptionInDatabase($optionName, $lastEnqueueTimestamp);

$I->amOnAdminPage('/options-general.php');
$I->seeLink('leave a review on WordPress.org', 'https://wordpress.org/support/plugin/sunny/reviews/?filter=5#new-post');

$I->wantToTest('new review me notice last enqueue timestamp is set in the last 10 seconds');
$lastEnqueueTimestamp = $I->grabOptionFromDatabase($optionName);
$I->assertGreaterOrEquals(time() - 10, $lastEnqueueTimestamp->getTimestamp());
$I->assertLessOrEquals(time(), $lastEnqueueTimestamp->getTimestamp());
