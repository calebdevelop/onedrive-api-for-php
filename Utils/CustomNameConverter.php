<?php
namespace Tsk\OneDrive\Utils;


use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class CustomNameConverter implements NameConverterInterface
{
    public function normalize($propertyName)
    {
        return $propertyName;
    }

    public function denormalize($propertyName)
    {
        return '@microsoft.graph.' === substr($propertyName, 0, 17) ? substr($propertyName, 17) : $propertyName;
    }
}