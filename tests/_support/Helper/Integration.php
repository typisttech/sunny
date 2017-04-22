<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Helper;

use AspectMock\Test;
use Codeception\Module;
use Codeception\TestInterface;

/**
 * Here you can define custom actions
 * All public methods declared in helper class will be available in $I
 */
class Integration extends Module
{
    public function _after(TestInterface $test)
    {
        Test::clean();

        delete_option('wpcfg_cloudflare_email');
        delete_option('wpcfg_cloudflare_api_key');
        delete_option('wpcfg_cloudflare_zone_id');
    }
}
