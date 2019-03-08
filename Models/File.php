<?php

namespace Tsk\OneDrive\Models;


class File
{
    private $mimeType;

    private $processingMetadata;

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param mixed $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return mixed
     */
    public function getProcessingMetadata()
    {
        return $this->processingMetadata;
    }

    /**
     * @param mixed $processingMetadata
     */
    public function setProcessingMetadata($processingMetadata)
    {
        $this->processingMetadata = $processingMetadata;
    }
}