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
    public $downloadUrl;
    public $createdBy;
    public $lastModifiedBy;

    /** @var ParentReference */
    public $parentReference;

    protected $folder;
    /** @var $image Image */
    public $image;
    /* @var $video Video */
    public $video;
    /* @var $file File */
    public $file;

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

    public function setParentReference(ParentReference $ref)
    {
        $this->parentReference = $ref;
    }

    /**
     * @return ParentReference
     */
    public function getParentReference()
    {
        return $this->parentReference;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Video $video
     */
    public function setVideo(Video $video)
    {
        $this->video = $video;
    }

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
    public function getDownloadUrl()
    {
        return $this->downloadUrl;
    }

    /**
     * @param mixed $downloadUrl
     */
    public function setDownloadUrl($downloadUrl)
    {
        $this->downloadUrl = $downloadUrl;
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