<?
namespace App\Storage;

use MicrosoftAzure\Storage\Blob\BlobRestProxy;

class Storage{
    protected static $blobClient;
    public static function getblobClient(){
        if(self::$blobClient) return self::$blobClient;
        $connectionString = getenv('storage_connection_string');
        self::$blobClient = BlobRestProxy::createBlobService($connectionString);
        return self::$blobClient;
    }
    public static function getBlobtoText($name,$con = 'nozzang'){
        try {
            $blob = self::getblobClient()->getBlob($con,$name);
        } catch (\Exception $e) {
            return 'not found';
        }
        return stream_get_contents($blob->getContentStream());
    }
}
