<?php

declare(strict_types=1);

use TypistTech\Sunny\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('purge initiated when new post published');

$I->loginAsAdmin();
$I->amOnAdminPage('post-new.php');

$I->amGoingTo('publish a new post');
$I->fillField('post_title', 'Foo');
$I->click('#publish');

$I->wantToTest('purge initiated notice shows');
$I->see('Sunny: Purge initiated.');
