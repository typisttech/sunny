<?php

declare(strict_types=1);

namespace TypistTech\Sunny;

use Codeception\TestCase\WPTestCase;

/**
 * @coversDefaultClass \TypistTech\Sunny\OptionStore
 */
class OptionStoreTest extends WPTestCase
{
    /**
     * @var \TypistTech\Sunny\IntegrationTester
     */
    protected $tester;

    /**
     * @var OptionStore
     */
    private $optionStore;

    public function setUp()
    {
        parent::setUp();

        update_option('sunny_cloudflare_email', 'tester@example.com');
        update_option('sunny_cloudflare_api_key', 'passkey123');
        update_option('sunny_cloudflare_zone_id', 'two46o1');

        $this->optionStore = new OptionStore();
    }

    /**
     * @covers ::getApiKey
     */
    public function testGetApiKey()
    {
        $actual = $this->optionStore->getApiKey();
        $this->assertSame('passkey123', $actual);
    }

    /**
     * @covers ::getEmail
     */
    public function testGetEmail()
    {
        $actual = $this->optionStore->getEmail();
        $this->assertSame('tester@example.com', $actual);
    }

    /**
     * @coversNothing
     */
    public function testGetFromContainer()
    {
        $this->assertInstanceOf(
            OptionStore::class,
            $this->tester->getContainer()->get(OptionStore::class)
        );
    }

    /**
     * @covers ::getZoneId
     */
    public function testGetZoneId()
    {
        $actual = $this->optionStore->getZoneId();
        $this->assertSame('two46o1', $actual);
    }
}
