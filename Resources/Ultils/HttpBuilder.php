<?php
namespace Tsk\OneDrive\Utils;


use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

class HttpBuilder
{
    /**
     * @param $http ClientInterface
     * @param $request RequestInterface
     * @param $expectedClass
     */
    public static function getResponse($http, $request, $expectedClass = null)
    {
        $response = $http->send($request);
        $content = $response->getBody()->getContents();
        if (is_null($expectedClass)) {
            return \GuzzleHttp\json_decode($content);
        } else {
            $tzData = \GuzzleHttp\json_decode($content);
            //to do map with $expectedClass
        }
    }
}