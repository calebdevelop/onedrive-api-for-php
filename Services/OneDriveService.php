<?php
namespace Tsk\OneDrive\Services;


use Tsk\OneDrive\Client;
use Tsk\OneDrive\Resources\FileResource;

class OneDriveService
{
    /** View and manage the files in your OneDrive. */
    const ONEDRIVE_OFFLINE_ACCESS = 'offline_access';
    const ONEDRIVE_FILE_READ = 'files.read';
    const ONEDRIVE_FILE_READ_ALL = 'files.read.all';
    const ONEDRIVE_FILE_READ_WRITE = 'files.readwrite';
    const ONEDRIVE_FILE_READ_WRITE_ALL = 'files.readwrite.all';

    /* @var $client Client */
    private $client;

    /* @var $file FileResource */
    public $file;

    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->file = new FileResource($this);
    }

    public function getClient() {
        return $this->client;
    }

}