<?php
namespace Tsk\OneDrive\Resources;

use GuzzleHttp\Psr7\Request;
use Tsk\OneDrive\Services\OneDriveService;

abstract class AbstractResource
{
    protected $client;

    protected $methods;
    /**
     * AbstractResource constructor.
     * @param $service OneDriveService
     */
    public function __construct($service)
    {
        $this->client = $service->getClient();

        $this->methods = $this->getConfigMethods();
    }

    protected function request($methodName, $arguments, $expectedClass = null) {
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
            $postBody = (array) $parameters['postBody'];
            unset($parameters['postBody']);
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

        $path = $this->createRequestPath(
            $method['path'],
            $parameters
        );

        $request = new Request(
            $method['httpMethod'],
            $path,
            [
                'content-type' => 'application/json'
            ],
            $postBody ? json_encode($postBody) : ''
        );

        $resultKey = null;
        if ($method['resultKey']) {
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