<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Helper;

use AspectMock\Test;
use Codeception\Module;
use Codeception\TestInterface;
use TypistTech\Sunny\Container;
use TypistTech\Sunny\Sunny;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\AbstractHook;

/**
 * Here you can define custom actions
 * All public methods declared in helper class will be available in $I
 */
class Integration extends Module
{
    /**
     * @var Container
     */
    private $container;

    public function _after(TestInterface $test)
    {
        Test::clean();

        delete_option('wpcfg_cloudflare_email');
        delete_option('wpcfg_cloudflare_api_key');
        delete_option('wpcfg_cloudflare_zone_id');
    }

    public function assertHooked(AbstractHook $hook)
    {
        $id = $hook->getId();

        $isHooked = $this->getContainer()->has($id);

        $this->assertTrue($isHooked);
    }

    public function getContainer(): Container
    {
        if (null === $this->container) {
            $sunny = new Sunny;
            $sunny->run();

            $this->container = $sunny->getContainer();
        }

        return $this->container;
    }
}
