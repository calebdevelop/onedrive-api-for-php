<?php
namespace Tsk\OneDrive\Resources;

use Symfony\Component\Yaml\Yaml;
use Tsk\OneDrive\Models\Items;
use Tsk\OneDrive\Models\Share;
use Tsk\OneDrive\Models\Thumbnail;
use Tsk\OneDrive\Models\UloadSession;

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

    /**
     * @param $fileName
     * @param $folderId
     * @param string $conflictBehavior (rename | fail | replace)
     * @param null $description
     * @return UloadSession
     * @throws \Exception
     */
    public function createUploadSession($fileName, $folderId, $conflictBehavior = "rename", $description = null)
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
        return $this->request('createUploadSession', $params, UloadSession::class);
    }

    /**
     * @param $uploadSession UloadSession
     * @param $byte
     * @param $start
     * @param $end
     * @param $fileSize
     * @return mixed
     * @throws \Exception
     */
    public function uploadBytesToTheUploadSession($uploadSession, $byte, $start, $end, $fileSize)
    {
        $params = [
            'postBody' => $byte,
            'header'   => [
                'Content-Length' => ($end - $start) + 1,
                'Content-Range'  => "bytes $start-$end/$fileSize"
            ]
        ];
        return $this->request('uploadBytesToTheUploadSession', $params, null, $uploadSession->getUploadUrl());
    }

    public function getDownloadUrl($itemId) {
        return $this->request('getDownloadUrl', ['itemId' => $itemId]);
    }

    /**
     * @param $fileId
     * @param $type string view|edit|embed
     * @param $scope string anonymous|organization
     */
    public function shareLink($fileId, $type, $scope) {
        $params = [
            'itemId'   => $fileId,
            'postBody' => [
                'type'  => $type,
                'scope' => $scope
            ]
        ];

        return $this->request('shareLink', $params, Share::class);
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