<?php

namespace Tsk\OneDrive\Models;


class Share
{
    private $id;

    private $roles;

    /** @var ShareLink */
    private $link;

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
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return ShareLink
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param ShareLink $link
     */
    public function setLink(ShareLink $link)
    {
        $this->link = $link;
    }
}