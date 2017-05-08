<?php

declare(strict_types=1);

use TypistTech\Sunny\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('target groups show on debuggers page');

$I->loginToSunnySettingPage();
$I->amOnAdminPage('admin.php?page=sunny-debuggers');

$I->waitForText('homepage', 10, '.target-group > .row-title');
