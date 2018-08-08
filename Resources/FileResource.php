<?php
namespace Tsk\OneDrive\Resources;

use Symfony\Component\Yaml\Yaml;

class FileResource extends AbstractResource
{
    public function getThumbnail($itemId)
    {
        return $this->request('getThumbnail', ['itemId' => $itemId]);
    }

    protected function getConfigMethods()
    {
        $data =  Yaml::parseFile(__DIR__.'/config/file.yml');
        return isset($data['methods']) ? $data['methods'] : $data;
    }
}