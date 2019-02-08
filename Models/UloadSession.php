<?php

namespace Tsk\OneDrive\Models;


class UloadSession
{
    private $uploadUrl;
    private $expirationDateTime;

    /**
     * @return mixed
     */
    public function getUploadUrl()
    {
        return $this->uploadUrl;
    }

    /**
     * @param mixed $uploadUrl
     */
    public function setUploadUrl($uploadUrl)
    {
        $this->uploadUrl = $uploadUrl;
    }

    /**
     * @return mixed
     */
    public function getExpirationDateTime()
    {
        return $this->expirationDateTime;
    }

    /**
     * @param mixed $expirationDateTime
     */
    public function setExpirationDateTime($expirationDateTime)
    {
        $this->expirationDateTime = $expirationDateTime;
    }
}