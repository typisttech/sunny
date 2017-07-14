<?php

declare(strict_types=1);

use TypistTech\Sunny\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('purge initiated when post updated');

$I->loginAsAdmin();
$I->amOnAdminPage('post.php?post=2&action=edit');

$I->amGoingTo('update a published post');
$I->fillField('post_title', 'Foo');
$I->click('#publish');

$I->wantToTest('purge initiated notice shows with post type of `Page`');
$I->see('Sunny: Purge initiated.');
$I->see('Reason: Page (ID: 2) is being edited');
