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
class RestapiTester extends Actor
{
    use _generated\RestapiTesterActions;

    public function assertForbiddenDelete(string $route, array $params = null, array $files = null)
    {
        $params = $params ?? [];
        $files = $files ?? [];

        $this->haveHttpHeader('Content-Type', 'application/json');
        $this->sendDELETE($route, $params, $files);

        $this->assertForbidden();
    }

    private function assertForbidden()
    {
        $this->seeResponseIsJson();
        $this->seeResponseContainsJson([
            'code' => 'rest_forbidden',
            'message' => 'Sorry, you are not allowed to do that.',
            'data' => [
                'status' => 403,
            ],
        ]);
        $this->seeResponseCodeIs(403);
    }

    public function assertForbiddenGet(string $route, array $params = null)
    {
        $params = $params ?? [];

        $this->haveHttpHeader('Content-Type', 'application/json');
        $this->sendGET($route, $params);

        $this->assertForbidden();
    }

    public function setAdminAuth()
    {
        $this->loginAsAdmin();
        $_COOKIE[ LOGGED_IN_COOKIE ] = $this->grabCookie(LOGGED_IN_COOKIE);
        wp_set_current_user(1);
        $restNonce = wp_create_nonce('wp_rest');
        $this->haveHttpHeader('X-WP-Nonce', $restNonce);
    }
}
