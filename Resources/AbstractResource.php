<?php
namespace Tsk\OneDrive\Resources;

use GuzzleHttp\Psr7\Request;
use Tsk\OneDrive\Services\OneDriveService;
use Tsk\OneDrive\Client;

abstract class AbstractResource
{
    protected $client;

    protected $methods;
    /**
     * AbstractResource constructor.
     * @param $service OneDriveService|Client
     */
    public function __construct($service)
    {
        if ($service instanceof OneDriveService) {
            $this->client = $service->getClient();
        } elseif ($service instanceof Client) {
            $this->client = $service;
        }

        $this->methods = $this->getConfigMethods();
    }

    protected function request($methodName, $arguments, $expectedClass = null, $customPath = null, $isJsonContentType = true) {
        if (!isset($this->methods[$methodName])) {

            $class = get_class($this);
            throw new \InvalidArgumentException(
                "Unknown function: " . "{{$class}::{$methodName}()"
            );
        }
        $method = $this->methods[$methodName];
        $parameters = $arguments;

        if (!isset($method['parameters'])) {
            $method['parameters'] = array();
        }

        $postBody = null;
        if (isset($parameters['postBody'])) {
            $postBody = ($isJsonContentType) ? json_encode($parameters['postBody']) : $parameters['postBody'];
            unset($parameters['postBody']);
        }

        $headers = [];
        if (isset($parameters['headers'])) {
            $headers = $parameters['headers'];
            unset($parameters['headers']);
        }

        if ($isJsonContentType) {
            $headers['content-type'] = 'application/json';
        }

        foreach ($parameters as $key => $val) {
            if (!isset($method['parameters'][$key])) {
                throw new \InvalidArgumentException("($methodName) unknown parameter: '$key'");
            }
        }

        foreach ($method['parameters'] as $keyParam => $spec) {
            if (isset($spec['required']) &&
                $spec['required'] &&
                ! isset($parameters[$keyParam])
            ) {
                throw new \Exception("($methodName) missing required param: '$keyParam'");
            }
            if (isset($parameters[$keyParam])) {
                $value = $parameters[$keyParam];
                $parameters[$keyParam] = $spec;
                $parameters[$keyParam]['value'] = $value;
            } else {
                // delete null param.
                unset($parameters[$keyParam]);
            }
        }

        $path = null;
        if (is_null($customPath) && isset($method['path'])) {
            $path = $this->createRequestPath(
                $method['path'],
                $parameters
            );
        } elseif (!is_null($customPath)) {
            $path = $customPath;
        }

        $request = new Request(
            $method['httpMethod'],
            $path,
            $headers,
            $postBody ? $postBody : ''
        );

        $resultKey = null;
        if (isset($method['resultKey'])) {
            $resultKey = $method['resultKey'];
        }

        return $this->client->send($request, $expectedClass, $resultKey);
    }

    public function createRequestPath($path, $params){
        $requestUrl = $path;
        $queryVars = [];
        foreach ($params as $keyParam => $specParam) {
            if ($specParam['type'] == 'boolean') {
                $specParam['value'] = $specParam['value'] ? 'true' : 'false';
            }
            if ($specParam['location'] == 'path') {
                $search = '{'.$keyParam.'}';
                $requestUrl = str_replace($search, $specParam['value'], $requestUrl);
            } else if ($specParam['location'] == 'query') {
                if (is_array($specParam['value'])) {
                    foreach ($specParam['value'] as $value) {
                        $queryVars[] = $keyParam . '=' . rawurlencode(rawurldecode($value));
                    }
                } else {
                    $queryVars[] = $keyParam . '=' . rawurlencode(rawurldecode($specParam['value']));
                }
            }
        }

        if (!empty($queryVars)) {
            $requestUrl .= '?' . implode($queryVars, '&');
        }

        return $requestUrl;
    }

    abstract protected function getConfigMethods();
}