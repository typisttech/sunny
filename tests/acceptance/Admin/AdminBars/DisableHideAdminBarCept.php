<?php

declare(strict_types=1);

use TypistTech\Sunny\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantTo('disable hide admin bar and see it show on homepage');

$I->amGoingTo('check and submit the checkbox');
$I->loginToSunnySettingPage();
$I->amOnAdminPage('admin.php?page=sunny-admin-bar');
$I->click('#sunny_admin_bar_disable_hide');
$I->click('#submit');
$I->waitForText('Settings saved', 10);

$I->wantToTest('admin bar is shown on homepage');
$I->amOnPage('/');
$I->waitForText('Just another WordPress site');
$I->see('Howdy, admin');
