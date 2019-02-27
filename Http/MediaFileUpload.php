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

    private $folderId;

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
    }

    public function nextChunk($chunk)
    {
        $resumeUri = $this->getResumeUri();
        /*
        $headers = array(
            'content-range' => "bytes $this->progress-$lastBytePos/$this->size",
            'content-length' => strlen($chunk),
            'expect' => '',
        );
        $request = new Request(
            'PUT',
            $resumeUri,
            $headers,
            Psr7\stream_for($chunk)
        );
        */
    }

    public function getResumeUri()
    {
        if (null === $this->resumeUri) {
            $this->resumeUri = $this->fetchResumeUri();
        }
        return $this->resumeUri;
    }

    private function fetchResumeUri()
    {
        $request = new Request(
            'PUT',
            $resumeUri,
            $headers,
            Psr7\stream_for($chunk)
        );
        $item = new ItemResource($this->client);
        $uploadSession = $item->createUploadSessionByFolder($this->fileName, $this->folderId);
        return $uploadSession->
    }
}