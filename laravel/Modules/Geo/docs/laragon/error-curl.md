Download the latest cacert.pem file from
https://curl.se/docs/caextract.html

Update your php.ini file:  
Locate your php.ini file and find the line ;curl.cainfo =.  
Change it to: curl.cainfo = "C:\path\to\cacert.pem" (replace with the actual path where you saved the cacert.pem file).  
Restart Laragon:  
After making these changes, restart your Laragon server to apply the new settings.  

---------------------------------
c:\laragon\etc\ssl\solo.cer
https://community.postman.com/t/laragon-laravel-curl-error-60-ssl-certificate-problem-self-signed-certificate/33401/2
----------------------------------

[curl]
curl.cainfo = "C:\xampp\php\extras\ssl\cacert.pem"

[openssl]
openssl.cafile = "C:\xampp\php\extras\ssl\cacert.pem"

[curl]
curl.cainfo = "PATH/TO/cacert.pem"
 

[openssl]
openssl.capath = "PATH/TO/cacert.pem"  
openssl.cafile = "PATH/TO/cacert.pem"

var_dump(openssl_get_cert_locations());  
echo "openssl.cafile: ", ini_get('openssl.cafile'), "\n";  
echo "curl.cainfo: ", ini_get('curl.cainfo'), "\n";  

$http = new GuzzleHttp\Client(['verify' => '/path/to/cacert.pem']);
$client = new Google_Client();
$client->setHttpClient($http);



--------------------
composer config -g -- disable-tls true  
composer config -g secure-http false   
composer clearcache   

composer config --global cafile PATH/TO/cacert.pem  
composer config --global capath PATH/TO/DIRECTORY/WHERE cacert.pem is placed  




