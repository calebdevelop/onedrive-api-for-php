<?php
namespace Tsk\OneDrive\Services;


use Tsk\OneDrive\Client;
use Tsk\OneDrive\Resources\AboutResource;
use Tsk\OneDrive\Resources\ItemResource;
use App\OneDriveApi\GraphClient;

class OneDriveService
{
    /** View and manage the files in your OneDrive. */
    const ONEDRIVE_OFFLINE_ACCESS = 'offline_access';
    const ONEDRIVE_FILE_READ = 'files.read';
    const ONEDRIVE_FILE_READ_ALL = 'files.read.all';
    const ONEDRIVE_FILE_READ_WRITE = 'files.readwrite';
    const ONEDRIVE_FILE_READ_WRITE_ALL = 'files.readwrite.all';

    /* @var $client GraphClient */
    private $client;

    /* @var $items ItemResource */
    public $items;

    /** @var AboutResource */
    public $about;

    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->items = new ItemResource($this);
        $this->about = new AboutResource($this);
    }

    /**
     * @return GraphClient
     */
    public function getClient() {
        return $this->client;
    }

}