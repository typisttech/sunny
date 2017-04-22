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
class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;

    public function loginToSunnySettingPage()
    {
        $this->loginAsAdmin();
        $this->waitForText('Dashboard', 10, 'h1');
        $this->seeLink('Sunny');
        $this->click('Sunny');
        $this->click('Sunny');
        $this->waitForText('Sunny', 10, 'h1');
        $this->seeInCurrentUrl('/wp-admin/admin.php?page=sunny-cloudflare');
    }
}
