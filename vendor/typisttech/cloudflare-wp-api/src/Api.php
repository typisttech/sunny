<?php
/**
 * Cloudflare WP API.
 *
 * WordPress HTTP API replacement of the jamesryanbell/cloudflare package.
 *
 * @package   Cloudflare\WP
 * @author    Typist Tech <cloudflare-wp-api@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 * @see       https://www.typist.tech/projects/cloudflare-wp-api
 */

declare(strict_types = 1);

namespace TypistTech\Sunny\Vendor\Cloudflare;

use WP_Error;

/**
 * Class Api.
 */
class Api extends BaseApi
{
    /**
     * API call method for sending requests via wp_remote_request.
     *
     * @param string      $path   Path of the endpoint
     * @param array|null  $data   Data to be sent along with the request
     * @param string|null $method Type of method that should be used ('GET', 'POST', 'PUT', 'DELETE', 'PATCH')
     *
     * @return  array|WP_Error
     */
    protected function request($path, array $data = null, $method = null)
    {
        $authError = $this->authenticationError();
        if (null !== $authError) {
            return $authError;
        }

        $url  = 'https://api.cloudflare.com/client/v4/' . $path;
        $args = $this->prepareRequestArguments($data, $method);

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        return $this->decode($response);
    }

    /**
     * Return WP Error if this object does not contain necessary info to perform API requests.
     *
     * @return null|WP_Error
     */
    private function authenticationError()
    {
        if (empty($this->email) || empty($this->auth_key)) {
            return new WP_Error('authentication-error', 'Authentication information must be provided');
        }

        if (! is_email($this->email)) {
            return new WP_Error('authentication-error', 'Email is not valid');
        }

        return null;
    }

    /**
     * Prepare arguments for wp_remote_request.
     *
     * @param array|null  $data   Data to be sent along with the request
     * @param string|null $method Type of method that should be used ('GET', 'POST', 'PUT', 'DELETE', 'PATCH')
     *
     * @return array
     */
    private function prepareRequestArguments(array $data = null, string $method = null): array
    {
        $data   = (null === $data) ? [] : $data;
        $method = (null === $method) ? 'GET' : $method;

        // Removes null entries
        $data = array_filter($data, function ($val) {
            return (null !== $val);
        });

        $headers = [
            'Content-Type' => 'application/json',
            'X-Auth-Email' => $this->email,
            'X-Auth-Key'   => $this->auth_key,
        ];

        $args = [
            'body'    => wp_json_encode($data),
            'headers' => $headers,
            'method'  => strtoupper($method),
            'timeout' => 15,
        ];

        return $args;
    }

    /**
     * Decode Cloudflare response.
     *
     * @param array $response The response from Cloudflare.
     *
     * @return array|WP_Error
     */
    private function decode(array $response)
    {
        $decoded_body = json_decode($response['body'], true);

        if (null === $decoded_body) {
            return new WP_Error('decode-error', 'Unable to decode response body', $response);
        }

        if (true !== $decoded_body['success']) {
            return $this->wpErrorFor($decoded_body['errors'], $response);
        }

        return $response;
    }

    /**
     * Decode Cloudflare error messages to WP Error.
     *
     * @param array $errors   The error messages from Cloudflare.
     * @param array $response The full response from Cloudflare.
     *
     * @return WP_Error
     */
    private function wpErrorFor(array $errors, array $response): WP_Error
    {
        $wpError = new WP_Error;
        foreach ($errors as $error) {
            $wpError->add($error['code'], $error['message'], $response);
        }

        return $wpError;
    }
}
