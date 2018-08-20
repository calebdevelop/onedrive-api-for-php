<?php
namespace Tsk\OneDrive\Resources;

use Symfony\Component\Yaml\Yaml;
use Tsk\OneDrive\Models\Items;
use Tsk\OneDrive\Models\Thumbnail;

class ItemResource extends AbstractResource
{
    /**
     * @param string $itemId
     * @return Thumbnail
     */
    public function getThumbnail($itemId)
    {
        return $this->request('getThumbnail', ['itemId' => $itemId], Thumbnail::class);
    }

    /**
     * @param $itemId
     * @return Items
     */
    public function get($itemId) {
        return $this->request('get', ['itemId' => $itemId], Items::class);
    }

    public function createFolder($name, $folderId = null, $conflictBehaviorRename = true) {
        $postBody = [
            'name' => $name,
            "folder" => (Object)[]
        ];
        if ($conflictBehaviorRename) {
            $postBody['@microsoft.graph.conflictBehavior'] = "rename";
        }
        if (is_null($folderId)) {
            return $this->createFolderOnRoot($postBody, $conflictBehaviorRename);
        }
        $params = [
            'parentItemId' => !is_null($folderId) ? $folderId : 'root',
            'postBody'     => $postBody
        ];
        return $this->request('createFolder', $params, Items::class);
    }

    /**
     * @param $path
     * @return Items
     */
    public function getItemByPath($path) {
        return $this->request('getItemByPath', ['itemPath' => $path], Items::class);
    }


    public function createUploadSessionByFolder($fileName, $folderId, $conflictBehavior = "rename", $description = null)
    {
        $params = [
            'folderId' => $folderId,
            'fileName' => $fileName,
            'postBody' => [
                "item" => [
                    "@microsoft.graph.conflictBehavior" => $conflictBehavior, //possible value => "rename | fail | overwrite",
                    "description"    => ($description) ? $description : ''
                ]
            ]
        ];
        return $this->request('createUploadSessionByFolder', $params);
    }

    public function getDownloadUrl($itemId) {
        return $this->request('getDownloadUrl', ['itemId' => $itemId]);
    }

    private function createFolderOnRoot($postBody) {
        return $this->request('createFolderOnRoot', ['postBody' => $postBody], Items::class);
    }

    protected function getConfigMethods()
    {
        $data =  Yaml::parseFile(__DIR__.'/config/item.yml');
        return isset($data['methods']) ? $data['methods'] : $data;
    }
}