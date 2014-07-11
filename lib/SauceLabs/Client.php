<?php

namespace SauceLabs;

use SauceLabs\Api\ApiInterface;
use SauceLabs\Exception\InvalidArgumentException;
use SauceLabs\HttpClient\HttpClient;
use SauceLabs\HttpClient\HttpClientInterface;

/**
 * Simple yet very cool PHP GitHub client
 *
 * @original_author Joseph Bielawski <stloyd@gmail.com>
 *
 * Website: http://github.com/KnpLabs/php-github-api
 */
class Client
{
    /**
     * Constant for authentication method. Indicates the default, but deprecated
     * login with username and token in URL.
     */
    const AUTH_URL_TOKEN = 'url_token';

    /**
     * Constant for authentication method. Not indicates the new login, but allows
     * usage of unauthenticated rate limited requests for given client_id + client_secret
     */
    const AUTH_URL_CLIENT_ID = 'url_client_id';

    /**
     * Constant for authentication method. Indicates the new favored login method
     * with username and password via HTTP Authentication.
     */
    const AUTH_HTTP_PASSWORD = 'http_password';

    /**
     * Constant for authentication method. Indicates the new login method with
     * with username and token via HTTP Authentication.
     */
    const AUTH_HTTP_TOKEN = 'http_token';

    /**
     * @var array
     */
    private $options = array(
        'base_url'    => 'https://saucelabs.com/rest/v1/',

        'user_agent'  => 'php-github-api (http://github.com/alnutile/saucelabs_client)',
        'timeout'     => 10,

        'api_limit'   => 5000,
        'api_version' => 'beta',

        'cache_dir'   => null
    );

    /**
     * The Buzz instance used to communicate with GitHub
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Instantiate a new GitHub client
     *
     * @param null|HttpClientInterface $httpClient Github http client
     */
    public function __construct(HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $name
     *
     * @return ApiInterface
     *
     * @throws InvalidArgumentException
     */
    public function api($name)
    {
        switch ($name) {
            case 'me':
            case 'current_user':
                $api = new Api\CurrentUser($this);
                break;

            case 'usage':
            case 'team':
                $api = new Api\TestActivityAndUsage($this);
                break;

            case 'jobs':
                $api = new Api\Jobs($this);
                break;

            case 'tunnels':
                $api = new Api\Tunnels($this);
                break;

            case 'provider_information':
                $api = new Api\ProviderInformation($this);
                break;

            case 'partners':
                $api = new Api\Partners($this);
                break;

            case 'temporary_storage':
                $api = new Api\TemporaryStorage($this);
                break;

            case 'team_management':
                $api = new Api\TeamManagement($this);
                break;

            case 'status_image':
                $api = new Api\StatusImage($this);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }


    /**
     * Authenticate a user for all next requests
     *
     * @param string      $tokenOrLogin GitHub private token/username/client ID
     * @param null|string $password     GitHub password/secret (optionally can contain $authMethod)
     * @param null|string $authMethod   One of the AUTH_* class constants
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticate($tokenOrLogin, $password = null, $authMethod = null)
    {
        if (null === $password && null === $authMethod) {
            throw new InvalidArgumentException('You need to specify authentication method!');
        }

        if (null === $authMethod && in_array($password, array(self::AUTH_URL_TOKEN, self::AUTH_URL_CLIENT_ID, self::AUTH_HTTP_PASSWORD, self::AUTH_HTTP_TOKEN))) {
            $authMethod = $password;
            $password   = null;
        }

        if (null === $authMethod) {
            $authMethod = self::AUTH_HTTP_PASSWORD;
        }

        $this->getHttpClient()->authenticate($tokenOrLogin, $password, $authMethod);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient($this->options);
        }

        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Clears used headers
     */
    public function clearHeaders()
    {
        $this->getHttpClient()->clearHeaders();
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->getHttpClient()->setHeaders($headers);
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }

        return $this->options[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws InvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function setOption($name, $value)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
        }
        $supportedApiVersions = $this->getSupportedApiVersions();
        if ('api_version' == $name && !in_array($value, $supportedApiVersions)) {
            throw new InvalidArgumentException(sprintf('Invalid API version ("%s"), valid are: %s', $name, implode(', ', $supportedApiVersions)));
        }

        $this->options[$name] = $value;
    }

    /**
     * Returns an array of valid API versions supported by this client.
     *
     * @return array
     */
    public function getSupportedApiVersions()
    {
        return array('v1');
    }
}
