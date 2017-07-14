<?php

declare(strict_types=1);

use TypistTech\Sunny\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('purge initiated when new post published');

$I->loginAsAdmin();
$I->amOnAdminPage('post-new.php?post_type=page');

$I->amGoingTo('publish a new page');
$I->fillField('post_title', 'Foo');
$I->click('#publish');

$I->wantToTest('purge initiated notice shows with post type of `Page`');
$I->see('Sunny: Purge initiated.');
$I->see('Reason: Page');
