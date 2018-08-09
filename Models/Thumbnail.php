<?php
namespace Tsk\OneDrive\Models;

class Thumbnail
{
    protected $large;

    protected $medium;

    protected $small;

    /**
     * @return Image
     */
    public function getLarge()
    {
        return $this->large;
    }

    /**
     * @param mixed $large
     * @return Thumbnail
     */
    public function setLarge(Image $large)
    {
        $this->large = $large;

        return $this;
    }

    /**
     * @return Image
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * @param mixed $medium
     * @return Thumbnail
     */
    public function setMedium(Image $medium)
    {
        $this->medium = $medium;

        return $this;
    }

    /**
     * @return Image
     */
    public function getSmall()
    {
        return $this->small;
    }

    /**
     * @param mixed $small
     * @return Thumbnail
     */
    public function setSmall(Image $small)
    {
        $this->small = $small;

        return $this;
    }
}