<?php
namespace Tsk\OneDrive\Models;


class Quota
{
    private $deleted;
    private $fileCount;
    private $remaining;
    private $state;
    private $total;

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getFileCount()
    {
        return $this->fileCount;
    }

    /**
     * @param mixed $fileCount
     */
    public function setFileCount($fileCount)
    {
        $this->fileCount = $fileCount;
    }

    /**
     * @return mixed
     */
    public function getRemaining()
    {
        return $this->remaining;
    }

    /**
     * @param mixed $remaining
     */
    public function setRemaining($remaining)
    {
        $this->remaining = $remaining;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }
}