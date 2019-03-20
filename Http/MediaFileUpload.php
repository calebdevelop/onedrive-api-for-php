<?php

namespace Tsk\OneDrive\Http;

use Tsk\OneDrive\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use Tsk\OneDrive\Resources\ItemResource;

class MediaFileUpload
{
    /** @var Client */
    private $client;

    private $chunkSize;

    private $resumable;

    private $resumeUri;

    private $fileName;

    private $fileSize;

    private $folderId;

    private $uploadSession;

    private $item;

    private $start = 0;

    public function __construct(
        Client $client,
        $fileName,
        $folderId,
        $resumable = false,
        $chunkSize = false
    )
    {
        $this->client = $client;
        $this->resumable = $resumable;
        $this->chunkSize = $chunkSize;
        $this->fileName = $fileName;
        $this->folderId = $folderId;
        $this->item = new ItemResource($this->client);
    }

    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }

    public function nextChunk($chunk)
    {
        $end = $this->chunkSize + $this->start + 1;
        if ($end > ($this->fileSize - 1)) {
            $end = ($this->fileSize - 1);
        }
        $reponse = $this->item->uploadBytesToTheUploadSession($this->getUploadSession(), $chunk, $this->start, $end, $this->fileSize);
        $this->start = $end + 1;

        return $reponse;
    }

    public function getUploadSession()
    {
        if (null === $this->resumeUri) {
            $this->uploadSession = $this->fetchUploadSession();
        }
        return $this->uploadSession;
    }

    private function fetchUploadSession()
    {
        $uploadSession = $this->item->createUploadSession($this->fileName, $this->folderId);
        return $uploadSession;
    }
}