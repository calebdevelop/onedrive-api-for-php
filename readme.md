### Generate token

##### Get an Authorization code :

```
require __DIR__.'/../vendor/autoload.php';

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

Go to the Url indicate by $authUrl. After login, you are redirecting to 'http://localhost?code=xxxxxxx' with the get parameter 'code'
