<?php
namespace Tsk\OneDrive\Resources;

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

    protected function request($methodName, $arguments, $exceptedClass = null) {
        if (!isset($this->methods[$methodName])) {

            $class = get_class($this);
            throw new \InvalidArgumentException(
                "Unknown function: " .
                "{{$class}::{$methodName}()"
            );
        }
        $method = $this->methods[$methodName];

    }

    abstract protected function getConfigMethods();
}