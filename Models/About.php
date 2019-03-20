<?php
namespace Tsk\OneDrive\Models;


class About
{
    private $id;
    private $driveType;
    private $owner;

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
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return Quota
     */
    public function getQuota()
    {
        return $this->quota;
    }

    /**
     * @param Quota $quota
     */
    public function setQuota(Quota $quota)
    {
        $this->quota = $quota;
    }
    /** @var Quota */
    private $quota;
}