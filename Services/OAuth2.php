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
use function GuzzleHttp\Psr7\uri_for;

class OAuth2
{
    private $clientId;

    private $redirectUri;

    /**
     * - authorizationUri
     *   The authorization server's HTTP endpoint capable of
     *   authenticating the end-user and obtaining authorization.
     *
     * @var \Psr\Http\Message\UriInterface
     */
    private $authorizationUri;

    private $tokenCredentialUri;

    private $clientSecret;

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
        $this->setRedirectUri($opts['redirectUri']);
        $this->setTokenCredentialUri($opts['tokenCredentialUri']);
        $this->setClientId($opts['clientId']);
        $this->setClientSecret($opts['clientSecret']);
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

    public function setTokenCredentialUri($uri)
    {
        $this->tokenCredentialUri = $this->coerceUri($uri);
    }

    public function getTokenCredentialUri()
    {
        return $this->tokenCredentialUri;
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