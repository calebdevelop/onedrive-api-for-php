<?php
namespace Tsk\OneDrive\Resources;

use Symfony\Component\Yaml\Yaml;
use Tsk\OneDrive\Models\Thumbnail;

class ItemResource extends AbstractResource
{
    public function getThumbnail($itemId)
    {
        return $this->request('getThumbnail', ['itemId' => $itemId], Thumbnail::class);
    }

    public function createFolder() {

    }

    protected function getConfigMethods()
    {
        $data =  Yaml::parseFile(__DIR__.'/config/item.yml');
        return isset($data['methods']) ? $data['methods'] : $data;
    }
}