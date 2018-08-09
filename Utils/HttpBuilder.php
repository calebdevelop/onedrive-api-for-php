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
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

        $result = \GuzzleHttp\json_decode($content);
        if (!is_null($expectedClass)) {

            $normalizer = new ObjectNormalizer(
                null,
                null,
                null,
                new ReflectionExtractor()
            );

            $serializer = new Serializer([$normalizer]);

            $result = $serializer->denormalize($result->value[0], $expectedClass);
        }
        return $result;
    }
}