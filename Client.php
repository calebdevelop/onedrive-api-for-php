<?php
namespace Tsk\OneDrive;


use GuzzleHttp\Psr7\Request;
use Tsk\OneDrive\Services\OAuth2;
use Tsk\OneDrive\Utils\HttpBuilder;

class Client
{
    const API_BASE_PATH = 'https://graph.microsoft.com/v1.0/';
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
        if (isset($config['redirect_uri'])) {
            $this->setRedirectUri($config['redirect_uri']);
        }
    }

    /**
     * @return \GuzzleHttp\Client
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

    public function fetchAccessTokenWithAuthCode($code = null)
    {
        if (strlen($code) == 0) {
            throw new \InvalidArgumentException("Invalid code");
        }
        $auth = $this->getOAuth2Service();
        $auth->setCode($code);
        $creds = $auth->fetchAuthToken($this->getHttpClient());
        if ($creds && isset($creds['access_token'])) {
            $creds['created'] = time();
            $this->setAccessToken($creds);
        }
        return $creds;
    }

    public function refreshToken($refreshToken = null) {
        if(is_null($refreshToken) && !$this->token && !isset($this->token['refresh_token'])) {
            throw new \InvalidArgumentException('$refreshToken parameters token is required');
        }
        $refreshToken = !is_null($refreshToken) ? $refreshToken : $this->token['refresh_token'];
        $auth = $this->getOAuth2Service();
        $auth->setRefreshToken($refreshToken);
        $creds = $auth->fetchAuthToken($this->getHttpClient());
        if ($creds && isset($creds['access_token'])) {
            $creds['created'] = time();
            $this->setAccessToken($creds);
        }
        return $creds;
    }

    public function getOAuth2Service()
    {
        if (!isset($this->auth)) {
            $this->auth = $this->createOAuth2Service();
        }

        return $this->auth;
    }

    public function setAccessToken($token)
    {
        if (is_string($token)) {
            if ($json = json_decode($token, true)) {
                $token = $json;
            } else {
                // token String
                $token = array(
                    'access_token' => $token,
                );
            }
        }
        if ($token == null) {
            throw new \InvalidArgumentException('invalid json token');
        }
        if (!isset($token['access_token'])) {
            throw new \InvalidArgumentException("Invalid token format");
        }
        $this->token = $token;
    }

    public function getAccessToken()
    {
        return $this->token;
    }

    protected function createOAuth2Service()
    {
        $auth = new OAuth2(
            [
                'client_id'           => $this->getClientId(),
                'client_secret'       => $this->getClientSecret(),
                'authorizationUri'   => self::AUTH_URL,
                'tokenCredentialUri' => self::TOKEN_URL,
                'redirect_uri'        => $this->getRedirectUri(),
                'base_uri'           => self::API_BASE_PATH
            ]
        );

        return $auth;
    }

    /**
     * @param $request Request
     * @param null $expectedClass
     */
    public function send($request, $expectedClass = null, $resultKey = []) {
        $http = $this->getHttpClient();

        //refresh token
        if (isset($this->token['refresh_token']) && $this->isAccessTokenExpired()) {
            $creds = $this->refreshToken();
            if (!isset($creds['access_token'])) {
                throw new \Exception(\GuzzleHttp\json_encode($creds));
            }
        }
        $request = $request->withHeader('authorization', 'Bearer '. $this->token['access_token']);
        return HttpBuilder::getResponse($http, $request, $expectedClass, $resultKey);
    }

    public function isAccessTokenExpired() {
        if (!$this->token) {
            return true;
        }

        $created = 0;
        if (isset($this->token['created'])) {
            $created = $this->token['created'];
        }
        // If the token is set to expire in the next 30 seconds.
        return ($created + ($this->token['expires_in'] - 30)) < time();
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
        $options = [
            'base_uri' => $this->config['base_uri'],
            'allow_redirects' => false,
            //'curl' => ['CURLOPT_SSL_VERIFYPEER' => false]
        ];

        $client = new \GuzzleHttp\Client($options);


        return  $client;
    }
}