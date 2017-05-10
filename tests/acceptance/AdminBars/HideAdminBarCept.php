<?php

declare(strict_types=1);

use TypistTech\Sunny\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('admin bar is hidden on homepage');

$I->loginAsAdmin();
$I->amOnPage('/');
$I->waitForText('Just another WordPress site');
$I->dontSee('Howdy, admin');
