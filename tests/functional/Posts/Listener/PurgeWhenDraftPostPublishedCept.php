<?php

declare(strict_types=1);

use TypistTech\Sunny\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('purge initiated when draft post published');

$I->loginAsAdmin();
$I->amOnAdminPage('post.php?post=922&action=edit');

$I->amGoingTo('publish a draft post');
$I->click('#publish');

$I->wantToTest('purge initiated notice shows');
$I->see('Sunny: Purge initiated.');
