<?php

declare(strict_types=1);

namespace TypistTech\Sunny;

use Codeception\Actor;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends Actor
{
    use _generated\FunctionalTesterActions;

    public function loginToSunnySettingPage()
    {
        $this->loginAsAdmin();
        $this->activatePlugin('sunny');
        $this->fail();
        $this->amOnAdminPage('admin.php?page=sunny-cloudflare');
        $this->fail();
    }
}
