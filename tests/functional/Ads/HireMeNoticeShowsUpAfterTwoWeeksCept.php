<?php

declare(strict_types=1);

use TypistTech\Sunny\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('hire me notice shows up after two weeks');

$optionName = 'sunny_hire_me_notice_last_enqueue';

$I->amGoingTo('reset hire me notice last enqueue timestamp');
$I->dontHaveOptionInDatabase($optionName);

$I->loginToSunnySettingPage();

$I->wantToTest('hire me notice last enqueue timestamp is set in the last 3 seconds');
$lastEnqueueTimestamp = $I->grabOptionFromDatabase($optionName);
$I->assertGreaterOrEquals(time() - 3, $lastEnqueueTimestamp->getTimestamp());
$I->assertLessOrEquals(time(), $lastEnqueueTimestamp->getTimestamp());

$I->amGoingTo('fast forward two weeks and one minute');
$lastEnqueueTimestamp->modify('-2 weeks');
$lastEnqueueTimestamp->modify('-1 minute');
$I->haveOptionInDatabase($optionName, $lastEnqueueTimestamp);

$I->amOnAdminPage('/options-general.php');
$I->see("If you're looking for help with development");
$I->seeLink('contact form', 'https://www.typist.tech/contact/');

$I->wantToTest('new hire me notice last enqueue timestamp is set in the last 10 seconds');
$lastEnqueueTimestamp = $I->grabOptionFromDatabase($optionName);
$I->assertGreaterOrEquals(time() - 10, $lastEnqueueTimestamp->getTimestamp());
$I->assertLessOrEquals(time(), $lastEnqueueTimestamp->getTimestamp());
