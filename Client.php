<?php
namespace Tsk\OneDrive;


use Tsk\OneDrive\Services\OAuth2;

class Client
{
    const API_BASE_PATH = 'https://graph.microsoft.com/v1.0';
    const AUTH_URL  = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize';
    const TOKEN_URL = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';

    /**
     * @var \GuzzleHttp\ClientInterface $http
     */
    private $http;

    /**
     * @var array access token
     */
    private $token;

    /**
     * @var array $config
     */
    private $config;

    /** @var array $requestedScopes */
    protected $requestedScopes = [];

    /**
     * Construct the Client.
     *
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->config = array_merge([
            'client_id'     => '',
            'client_secret' => '',
            'redirect_uri'  => null,
            'base_uri'      => self::API_BASE_PATH
        ], $config);
    }

    public function setAuthConfig($config)
    {
        $this->setClientId($config['client_id']);
        $this->setClientSecret($config['client_secret']);
        if (isset($config['redirect_uris'])) {
            $this->setRedirectUri($config['redirect_uri']);
        }
    }

    /**
     * @return \GuzzleHttp\ClientInterface implementation
     */
    public function getHttpClient()
    {
        if (null === $this->http) {
            $this->http = $this->createDefaultHttpClient();
        }

        return $this->http;
    }

    public function setScopes($scopes)
    {
        $this->requestedScopes = [];
        if (is_string($scopes)) {
            $this->requestedScopes[] = $scopes;
        } else if (is_array($scopes)) {
            foreach ($scopes as $scope) {
                $this->requestedScopes[] = $scope;
            }
        }
    }

    public function createAuthUrl($scope = null)
    {
        if (is_array($scope)) {
            $scope = implode(' ', $scope);
        } else {
            $scope = implode(' ', $this->requestedScopes);
        }
        $params = [
            'scope' => $scope
        ];
        $auth = $this->getOAuth2Service();

        return $auth->buildFullAuthorizationUri($params);
    }

    public function getOAuth2Service()
    {
        if (!isset($this->auth)) {
            $this->auth = $this->createOAuth2Service();
        }

        return $this->auth;
    }

    /**
     * create a default google auth object
     */
    protected function createOAuth2Service()
    {
        $auth = new OAuth2(
            [
                'clientId'           => $this->getClientId(),
                'clientSecret'       => $this->getClientSecret(),
                'authorizationUri'   => self::AUTH_URL,
                'tokenCredentialUri' => self::TOKEN_URL,
                'redirectUri'        => $this->getRedirectUri(),
                'base_uri'           => self::API_BASE_PATH
            ]
        );

        return $auth;
    }

    public function setClientId($clientId) {
        $this->config['client_id'] = $clientId;
    }

    public function getClientId()
    {
        return $this->config['client_id'];
    }

    public function setClientSecret($clientSecret)
    {
        $this->config['client_secret'] = $clientSecret;
    }

    public function getClientSecret()
    {
        return $this->config['client_secret'];
    }

    public function setRedirectUri($redirectUri)
    {
        $this->config['redirect_uri'] = $redirectUri;
    }

    public function getRedirectUri()
    {
        return $this->config['redirect_uri'];
    }

    protected function createDefaultHttpClient()
    {
        $options['base_uri'] = $this->config['base_path'];
        return new \GuzzleHttp\Client($options['base_uri']);
    }
}