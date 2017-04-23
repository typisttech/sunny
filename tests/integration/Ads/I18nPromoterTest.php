<?php

declare(strict_types=1);

namespace TypistTech\Sunny\Ads;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;
use TypistTech\Sunny\Admin;
use TypistTech\Sunny\Vendor\TypistTech\WPContainedHook\Action;
use TypistTech\Sunny\Vendor\Yoast_I18n_WordPressOrg_v2;

/**
 * @coversDefaultClass \TypistTech\Sunny\Ads\I18nPromoter
 */
class I18nPromoterTest extends WPTestCase
{
    /**
     * @var \TypistTech\Sunny\IntegrationTester
     */
    protected $tester;

    /**
     * @var I18nPromoter
     */
    private $i18nPromoter;

    public function setUp()
    {
        parent::setUp();

        $container = $this->tester->getContainer();

        $admin = Test::double(
            $container->get(Admin::class),
            [
                'getMenuSlugs' => [
                    'sunny-page-one',
                    'sunny-page-two',
                ],
            ]
        );
        $container->share(Admin::class, $admin->getObject());

        $this->i18nPromoter = $container->get(I18nPromoter::class);
    }

    /**
     * @coversNothing
     */
    public function testGetFromContainer()
    {
        $this->assertInstanceOf(
            I18nPromoter::class,
            $this->tester->getContainer()->get(I18nPromoter::class)
        );
    }

    /**
     * @covers ::getHooks
     */
    public function testHookedIntoAdminMenu()
    {
        $this->tester->assertHooked(
            new Action('admin_menu', I18nPromoter::class, 'run', 20)
        );
    }

    /**
     * @covers ::run
     */
    public function testYoastI18nWordPressOrgV2Initialized()
    {
        $yoastI18nWordPressOrgV2 = Test::double(Yoast_I18n_WordPressOrg_v2::class);

        $this->i18nPromoter->run();

        $yoastI18nWordPressOrgV2->verifyInvokedMultipleTimes('__construct', 2);
        $yoastI18nWordPressOrgV2->verifyInvokedOnce('__construct', [
            [
                'textdomain' => 'sunny',
                'plugin_name' => 'Sunny',
                'hook' => 'sunny_page_one_after_option_form',
            ],
        ]);
        $yoastI18nWordPressOrgV2->verifyInvokedOnce('__construct', [
            [
                'textdomain' => 'sunny',
                'plugin_name' => 'Sunny',
                'hook' => 'sunny_page_two_after_option_form',
            ],
        ]);
    }
}
