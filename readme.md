# One Drive Api for PHP
##### The OneDrive REST API Official Documentation
https://docs.microsoft.com/en-us/onedrive/developer/rest-api/
##### Installation 
```$ composer require tarask/onedrive```
#### Generate token

##### Get an Authorization code :
```
require __DIR__.'/vendor/autoload.php';

use Tsk\OneDrive\Services\OneDriveService;
use Tsk\OneDrive\Client;

$client = new Client();
$client->setClientId('xxxxxxxx');
$client->setClientSecret('xxxxxxxx');
$client->setRedirectUri('http://localhost');
$client->setScopes([
    OneDriveService::ONEDRIVE_OFFLINE_ACCESS,
    OneDriveService::ONEDRIVE_FILE_READ,
    OneDriveService::ONEDRIVE_FILE_READ_ALL,
    OneDriveService::ONEDRIVE_FILE_READ_WRITE,
    OneDriveService::ONEDRIVE_FILE_READ_WRITE_ALL
]);
$authUrl = $client->createAuthUrl();

echo $authUrl;
```

Go to the browser and enter the generated url. <br>
After authentication, you will be redirected to `http://localhost?code=xxxxxxx`

##### Redeem the code for access tokens :
After getting the ``code`` value, you can recover your access token with ``$client->fetchAccessTokenWithAuthCode($_GET['code'])``.

```
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
file_put_contents(__DIR__.'/token.json', \json_encode($token));
```

##### Upload large files
```
$token = file_get_contents(__DIR__.'/token.json');
$client->setAccessToken($token);

$file = '/path/to/the/file.docx';

$handle   = fopen($file, 'rb');
$fileSize = filesize($file);
$chunkSize = 1024*1024;

$media = new MediaFileUpload($client, 'filename.docx', 'folderId', true, $chunkSize);
$media->setFileSize($fileSize);

$res = null;
while (!feof($handle)) {
    $bytes = fread($handle, $chunkSize);
    $res = $media->nextChunk($bytes);
}

echo 'FileId : ' . $res['id'];
print_r($res)
```