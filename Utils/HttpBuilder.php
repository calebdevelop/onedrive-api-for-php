<?php
/**
 * Created by PhpStorm.
 * User: tarask
 * Date: 8/8/18
 * Time: 10:54 PM
 */

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
            $result = \GuzzleHttp\json_decode($content);
            return $result;
        } else {
            //to do
            $tzData = \GuzzleHttp\json_decode($content);
        }
    }
}