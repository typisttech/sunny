<?php

declare(strict_types=1);

use TypistTech\Sunny\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('donate me notice shows up after two weeks');

$optionName = 'sunny_donate_me_notice_last_enqueue';

$I->amGoingTo('reset donate me notice last enqueue timestamp');
$I->dontHaveOptionInDatabase($optionName);

$I->loginToSunnySettingPage();

$I->wantToTest('donate me notice last enqueue timestamp is set in the last 3 seconds');
$lastEnqueueTimestamp = $I->grabOptionFromDatabase($optionName);
$I->assertGreaterOrEquals(time() - 3, $lastEnqueueTimestamp->getTimestamp());
$I->assertLessOrEquals(time(), $lastEnqueueTimestamp->getTimestamp());

$I->amGoingTo('fast forward one month and one minute');
$lastEnqueueTimestamp->modify('-1 month');
$lastEnqueueTimestamp->modify('-1 minute');
$I->haveOptionInDatabase($optionName, $lastEnqueueTimestamp);

$I->amOnAdminPage('/options-general.php');
$I->seeLink('small donation', 'https://www.typist.tech/donate/sunny/');

$I->wantToTest('new donate me notice last enqueue timestamp is set in the last 3 seconds');
$lastEnqueueTimestamp = $I->grabOptionFromDatabase($optionName);
$I->assertGreaterOrEquals(time() - 3, $lastEnqueueTimestamp->getTimestamp());
$I->assertLessOrEquals(time(), $lastEnqueueTimestamp->getTimestamp());
