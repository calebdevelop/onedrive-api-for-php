<?php
namespace Tsk\OneDrive\Models;


class Items
{
    public $id;
    public $name;
    public $size;
    /* @var $createdDateTime \DateTimeInterface */
    public $createdDateTime;
    /* @var $lastModifiedDateTime \DateTimeInterface */
    public $lastModifiedDateTime;
    protected $cTag;
    protected $eTag;
    public $webUrl;
    public $createdBy;
    public $lastModifiedBy;
    public $parentReference;
    protected $folder;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedDateTime()
    {
        return $this->createdDateTime;
    }

    /**
     * @param mixed $createdDateTime
     */
    public function setCreatedDateTime(\DateTimeInterface $createdDateTime)
    {
        $this->createdDateTime = $createdDateTime;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getLastModifiedDateTime()
    {
        return $this->lastModifiedDateTime;
    }

    /**
     * @param mixed $lastModifiedDateTime
     */
    public function setLastModifiedDateTime(\DateTimeInterface $lastModifiedDateTime)
    {
        $this->lastModifiedDateTime = $lastModifiedDateTime;
    }

    /**
     * @return mixed
     */
    public function getCTag()
    {
        return $this->cTag;
    }

    /**
     * @param mixed $cTag
     */
    public function setCTag($cTag)
    {
        $this->cTag = $cTag;
    }

    /**
     * @return mixed
     */
    public function getETag()
    {
        return $this->eTag;
    }

    /**
     * @param mixed $eTag
     */
    public function setETag($eTag)
    {
        $this->eTag = $eTag;
    }

    /**
     * @return mixed
     */
    public function getWebUrl()
    {
        return $this->webUrl;
    }

    /**
     * @param mixed $webUrl
     */
    public function setWebUrl($webUrl)
    {
        $this->webUrl = $webUrl;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getLastModifiedBy()
    {
        return $this->lastModifiedBy;
    }

    /**
     * @param mixed $lastModifiedBy
     */
    public function setLastModifiedBy($lastModifiedBy)
    {
        $this->lastModifiedBy = $lastModifiedBy;
    }

    /**
     * @return mixed
     */
    public function getParentReference()
    {
        return $this->parentReference;
    }

    /**
     * @param mixed $parentReference
     */
    public function setParentReference($parentReference)
    {
        $this->parentReference = $parentReference;
    }

    /**
     * @return mixed
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param mixed $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }


}