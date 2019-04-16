<?php
namespace Tsk\OneDrive\Resources;

use Symfony\Component\Yaml\Yaml;
use Tsk\OneDrive\Models\File;
use Tsk\OneDrive\Models\Items;
use Tsk\OneDrive\Models\Share;
use Tsk\OneDrive\Models\Thumbnail;
use Tsk\OneDrive\Models\UloadSession;
use GuzzleHttp\Psr7;

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

    /**
     * @param $itemId
     * @param array $properties
     * @return Items
     * @throws \Exception
     */
    public function update($itemId, array $properties)
    {
        $params = [
            'itemId' => $itemId,
            'postBody' => $properties
        ];

        return $this->request('update', $params, Items::class);
    }

    public function delete($itemId)
    {
        return $this->request('delete', ['itemId' => $itemId]);
    }

    /**
     * @param $itemId
     * @param $folderDestinationId
     * @param null $destinationName
     * @return Items
     * @throws \Exception
     */
    public function move($itemId, $folderDestinationId, $destinationName = null)
    {
        $params = [
            'itemId'   => $itemId,
            'postBody' => [
                'parentReference' => [
                    'id' => $folderDestinationId
                ]
            ]
        ];
        if (!is_null($destinationName)) {
            $params['postBody']['name'] = $destinationName;
        }
        return $this->request('move', $params, Items::class);
    }

    /**
     * @param $name
     * @param null $folderId
     * @param bool $conflictBehaviorRename
     * @return Items
     * @throws \Exception
     */
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
     * @param $itemId
     * @param $content
     * @return Items
     * @throws \Exception
     */
    public function replaceExistingFile($itemId, $content)
    {
        $params = [
            'itemId' => $itemId,
            'postBody' => Psr7\stream_for($content)
        ];
        return $this->request('replaceExistingFile', $params, Items::class, null, false);
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
            'headers'   => [
                'Content-Length' => ($end - 1) - $start,
                'Content-Range'  => "bytes $start-$end/$fileSize"
            ]
        ];
        return $this->request('uploadBytesToTheUploadSession', $params, null, $uploadSession->getUploadUrl(), false);
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