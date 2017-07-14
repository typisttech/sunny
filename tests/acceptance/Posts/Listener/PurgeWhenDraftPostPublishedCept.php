<?php

declare(strict_types=1);

use TypistTech\Sunny\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('purge initiated when draft post published');

$I->loginAsAdmin();
$I->amOnAdminPage('post.php?post=922&action=edit');

$I->amGoingTo('publish a draft post');
$I->click('#publish');

$I->wantToTest('purge initiated notice shows with post type of `Post`');
$I->see('Sunny: Purge initiated.');
$I->see('Reason: Post');
