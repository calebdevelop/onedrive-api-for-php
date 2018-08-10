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
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use GuzzleHttp\json_decode;

class HttpBuilder
{
    /**
     * @param $http ClientInterface
     * @param $request RequestInterface
     * @param $expectedClass
     */
    public static function getResponse($http, $request, $expectedClass = null, $resultKey = [])
    {
        $response = $http->send($request);

        $content = $response->getBody()->getContents();

        $result = json_decode($content, true);
        if (!is_null($expectedClass)) {

            $normalizer = new ObjectNormalizer(
                null,
                null,
                null,
                new ReflectionExtractor()
            );

            $serializer = new Serializer([$normalizer, new DateTimeNormalizer()]);

            $tzData = $result;
            if (!empty($resultKey)) {
                $tmp = $tzData;
                foreach ($resultKey as $key) {
                    if (isset($tmp[$key])) {
                        $tmp = $tmp[$key];
                        continue;
                    }
                    throw new \Exception('Invalid result key : '. json_encode($resultKey));
                }
                $tzData = $tmp;
            }

            $result = $serializer->denormalize($tzData, $expectedClass);
        }
        return $result;
    }
}