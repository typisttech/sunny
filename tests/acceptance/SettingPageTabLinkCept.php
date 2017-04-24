<?php

declare(strict_types=1);

use TypistTech\Sunny\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantTo('setting page has tab links');

$I->loginToSunnySettingPage();

$I->seeElement('#sunny-cloudflare-tab');

$I->click('#sunny-cloudflare-tab');
$I->waitForText('Sunny', 10, 'h1');
$I->seeInCurrentUrl('/wp-admin/admin.php?page=sunny-cloudflare');
