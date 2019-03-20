<?php

namespace Tsk\OneDrive\Resources;

use Symfony\Component\Yaml\Yaml;
use Tsk\OneDrive\Models\About;

class AboutResource extends AbstractResource
{
    /**
     * @return About
     * @throws \Exception
     */
    public function get()
    {
        return $this->request('get', [], About::class);
    }

    protected function getConfigMethods()
    {
        $data =  Yaml::parseFile(__DIR__.'/config/about.yml');
        return isset($data['methods']) ? $data['methods'] : $data;
    }
}