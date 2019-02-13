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

Go to the browser and enter the url generate. 
After Authentification, you are redirecting to 'http://localhost?code=xxxxxxx'

##### Redeem the code for access tokens :
When you have received the ``code`` value, you can get the acces token using ``$client->fetchAccessTokenWithAuthCode($_GET['code'])``.
Make sure to copy this code in your redirect url.

```
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
file_put_contents(__DIR__.'/token.json', \json_encode($token));
```

