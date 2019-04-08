<?php

namespace Tsk\OneDrive\Models;


class ParentReference
{
    private $id;
    private $driveId;
    private $driveType;
    private $name;
    private $path;

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
    public function getDriveId()
    {
        return $this->driveId;
    }

    /**
     * @param mixed $driveId
     */
    public function setDriveId($driveId)
    {
        $this->driveId = $driveId;
    }

    /**
     * @return mixed
     */
    public function getDriveType()
    {
        return $this->driveType;
    }

    /**
     * @param mixed $driveType
     */
    public function setDriveType($driveType)
    {
        $this->driveType = $driveType;
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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}