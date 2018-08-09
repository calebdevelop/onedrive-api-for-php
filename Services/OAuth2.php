<?php
/**
 * Created by PhpStorm.
 * User: tarask
 * Date: 8/8/18
 * Time: 8:18 AM
 */

namespace Tsk\OneDrive\Services;


use function GuzzleHttp\Psr7\build_query;
use function GuzzleHttp\Psr7\parse_query;
use GuzzleHttp\Psr7\Request;
use function GuzzleHttp\Psr7\uri_for;
use Psr\Http\Message\ResponseInterface;

class OAuth2
{
    private $clientId;

    private $redirectUri;

    private $authorizationUri;

    private $tokenCredentialUri;

    private $clientSecret;

    private $code;

    private $refreshToken;

    /**
     * The current grant type.
     *
     * @var string
     */
    private $grantType;

    public function __construct(array $config)
    {
        $opts = array_merge([
            'client_id'     => null,
            'client_secret' => null,
            'authorizationUri'   => null,
            'tokenCredentialUri' => null,
            'redirect_uri'  => null,
            'base_uri'      => null
        ], $config);

        $this->setAuthorizationUri($opts['authorizationUri']);
        $this->setRedirectUri($opts['redirect_uri']);
        $this->setTokenCredentialUri($opts['tokenCredentialUri']);
        $this->setClientId($opts['client_id']);
        $this->setClientSecret($opts['client_secret']);
        if (array_key_exists('refresh_token', $opts)) {
            $this->setRefreshToken($opts['refresh_token']);
        }
    }

    /**
     * @param $http \GuzzleHttp\ClientInterface
     */
    public function fetchAuthToken($http) {
        $request = $this->generateAccessTokenRequest();
        $response = $http->send($request);
        return $this->parseTokenFromResponse($response);
    }

    /**
     * @param $response ResponseInterface
     */
    private function parseTokenFromResponse($response) {
        $json = $response->getBody()->getContents();
        return \GuzzleHttp\json_decode($json, true);
    }

    /**
     * @return Request
     */
    public function generateAccessTokenRequest() {
        $uri = $this->getTokenCredentialUri();
        $params = [
            'client_id'     => $this->getClientId(),
            'redirect_uri'  => $this->getRedirectUri(),
            'client_secret' => $this->getClientSecret(),
            'grant_type'    => $this->getGrantType()
        ];
        if (!is_null($this->getCode())) {
            $params['code'] = $this->getCode();
        } elseif (!is_null($this->refreshToken)) {
            $params['refresh_token'] = $this->refreshToken;
        }

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        return new Request(
            'POST',
            $uri,
            $headers,
            build_query($params)
        );
    }

    public function getGrantType() {
        if (!is_null($this->grantType)) {
            return $this->grantType;
        }

        if (!is_null($this->getCode())) {
            return "authorization_code";
        } elseif (!is_null($this->refreshToken)) {
            return 'refresh_token';
        }

        return null;
    }

    public function setRefreshToken($refreshToken) {
        $this->refreshToken = $refreshToken;
    }

    public function getRefreshToken() {
        return $this->refreshToken;
    }

    public function buildFullAuthorizationUri(array $config = [])
    {

        if (is_null($this->getAuthorizationUri())) {
            throw new \InvalidArgumentException(
                'requires an authorizationUri to have been set');
        }

        $params = array_merge([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'scope' => null,
        ], $config);

        // Validate the auth_params
        if (is_null($params['client_id'])) {
            throw new \InvalidArgumentException(
                'missing the required client identifier');
        }
        if (is_null($params['redirect_uri'])) {
            throw new \InvalidArgumentException('missing the required redirect URI');
        }
        if (is_null($params['scope'])) {
            throw new \InvalidArgumentException('missing the required scope');
        }

        $result = clone $this->authorizationUri;
        $existingParams = parse_query($result->getQuery());
        $result = $result->withQuery(
            build_query(array_merge($existingParams, $params))
        );

        if ($result->getScheme() != 'https') {
            throw new \InvalidArgumentException(
                'Authorization endpoint must be protected by TLS');
        }

        return $result;

    }

    public function setAuthorizationUri($uri)
    {
        $this->authorizationUri = $this->coerceUri($uri);
    }

    public function getAuthorizationUri()
    {
        return $this->authorizationUri;
    }

    public function setRedirectUri($uri)
    {
        if (is_null($uri)) {
            $this->redirectUri = null;

            return;
        }
        // redirect URI must be absolute
        if (!$this->isAbsoluteUri($uri)) {
            if ('postmessage' !== (string)$uri) {
                throw new \InvalidArgumentException(
                    'Redirect URI must be absolute');
            }
        }
        $this->redirectUri = (string)$uri;
    }

    public function getRedirectUri() {
        return $this->redirectUri;
    }

    public function setTokenCredentialUri($uri)
    {
        $this->tokenCredentialUri = $this->coerceUri($uri);
    }

    public function getTokenCredentialUri()
    {
        return $this->tokenCredentialUri;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    private function isAbsoluteUri($uri)
    {
        $uri = $this->coerceUri($uri);

        return $uri->getScheme() && ($uri->getHost() || $uri->getPath());
    }

    private function coerceUri($uri)
    {
        if (is_null($uri)) {
            return;
        }

        return uri_for($uri);
    }
}