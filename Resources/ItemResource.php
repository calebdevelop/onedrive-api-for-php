<?php
namespace Tsk\OneDrive\Resources;

use Symfony\Component\Yaml\Yaml;
use Tsk\OneDrive\Models\Items;
use Tsk\OneDrive\Models\Thumbnail;

class ItemResource extends AbstractResource
{
    public function getThumbnail($itemId)
    {
        return $this->request('getThumbnail', ['itemId' => $itemId], Thumbnail::class, ['value', 0]);
    }

    public function createFolder($name, $folderId = null, $conflictBehaviorRename = true) {
        $postBody = [
            'name' => $name,
            "folder" => (Object)[]
        ];
        if ($conflictBehaviorRename) {
            $postBody['@microsoft.graph.conflictBehavior'] = "rename";
        }
        $params = [
            'parentItemId' => !is_null($folderId) ? $folderId : 'root',
            'postBody'     => $postBody
        ];
        return $this->request('createFolder', $params, Items::class);

    }

    protected function getConfigMethods()
    {
        $data =  Yaml::parseFile(__DIR__.'/config/item.yml');
        return isset($data['methods']) ? $data['methods'] : $data;
    }
}