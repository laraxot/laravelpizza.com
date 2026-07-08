<?php

declare(strict_types=1);

namespace Modules\Sigma\Actions\WebService;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Sigma\Datas\WebServiceDownloadResData;
use Spatie\QueueableAction\QueueableAction;

use function Safe\ini_set;

class DownloadAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $tbl, string $format): WebServiceDownloadResData
    {
        ini_set('memory_limit', '-1');
        $url = 'https://ws.sigmapaghe.com/hrdownloader/api/enti/90/queries';
        $user = 'Prov_TV';
        $pwd = '@ProvTV123!';

        $ext = $format;
        if ($ext === 'file') {
            $ext = 'zip';
        }

        $filename = Str::slug($tbl).'-'.date('Ymd').'.'.$ext;
        $path = Storage::disk('cache')->path($filename);
        $path = str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], (string) $path);

        $full_url = $url.'/'.$tbl.'?_format='.$format;

        $client = new GuzzleClient;
        $response = $client->get($full_url, [
            'auth' => [
                $user,
                $pwd,
            ],
            'sink' => $path,
        ]);

        $message =
            '<hr/>
            <br/>Tbl :'
            .$tbl
            .'
            <br/>Filename: '
            .$filename
            .'
            <br/>Format: '
            .$format
            .'
       
          <br/> Size: '
            .File::size($path)
            .'
          <br/>Status: '
            .$response->getStatusCode()
            .'
          <br/>ReasonPhrase :'
            .$response->getReasonPhrase()
            .'
          <br/>ProtocolVersion :'
            .$response->getProtocolVersion()
            .'
          ';

        return WebServiceDownloadResData::from(['filename' => $filename, 'disk' => 'cache', 'message' => $message]);
    }
}
