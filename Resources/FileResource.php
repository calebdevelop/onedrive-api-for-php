<?php
namespace Tsk\OneDrive\Resources;

class FileResource extends AbstractResource
{
    public function getThumbnail($itemId) {
        $this->request('getThumbnail', null);
    }

    protected function getConfigMethods()
    {
        return include __DIR__.'/config/file.php';
    }
}