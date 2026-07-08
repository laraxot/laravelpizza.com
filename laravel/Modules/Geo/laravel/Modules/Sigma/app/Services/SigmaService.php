<?php

declare(strict_types=1);

namespace Modules\Sigma\Services;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\TableList;

use function Safe\curl_exec;
use function Safe\curl_init;
use function Safe\curl_setopt;
use function Safe\fclose;
use function Safe\fopen;
use function Safe\realpath;

// ---------------------

class SigmaService
{
    public static bool $usecookie = true;

    /**
     * @param  array<string, mixed>  $params
     */
    public static function getTblsHtml(array $params): Renderable
    {
        extract($params);
        if (! isset($tbls)) {
            throw new Exception('!isset($tbls)');
        }

        if (! \is_array($tbls)) {
            $tbls = explode(',', (string) $tbls);
        }

        $tbls = TableList::whereIn('tbl', $tbls)->get();
        // Using a literal view-string to satisfy static analysis
        $view = 'sigma::get_tbls_html';

        return view($view)->with('rows', $tbls);
    }

    /**
     * @param  array<string, mixed>  $params
     * @return array<string, mixed>|string
     */
    public static function syncTable(array $params): string|array
    {
        extract($params);
        if (! isset($db)) {
            throw new Exception('!isset($db)');
        }

        if (! isset($tbl)) {
            throw new Exception('!isset($tbl)');
        }

        $db = (string) $db;
        $tbl = (string) $tbl;
        $filename = $db.'.'.$tbl;
        $params = [
            'sigma_user' => config('sigma.user'),
            'sigma_passwd' => config('sigma.passwd'),
            'filename' => 'txtd_'.$filename,
            'dir' => realpath(Storage::disk('cache')->path('')),
        ];

        $file_txtd = self::downloadSigmaFile($params);
        // dddx($file_txtd);
        /** @var array<int, array<string, mixed>> $txtd_array */
        $txtd_array = TxtdService::toArray($file_txtd);
        $txtd_fields = TxtdService::getFieldsNames(['data' => $txtd_array]);

        $fields_up_list = implode(', ', array_map(static fn (mixed $field): string => (string) $field, $txtd_fields));
        if (\count($txtd_fields) < 2) {
            return
                '<h3>File scaricato male ['
                .$file_txtd
                .'] provare a loggarsi in [https://sigtransfer.sigmapaghe.com/]</h3>';
        }

        TxtdService::createTable(['filename' => $file_txtd, 'conn' => 'generale', 'tbl' => $tbl]);

        $fields_up = [];
        foreach ($txtd_array as $item) {
            $nome = (string) ($item['nome'] ?? '');
            $tipo = (string) ($item['tipo'] ?? '');
            $dec = (int) ($item['dec'] ?? 0);

            $fieldname = TxtdService::fixFieldName($nome);
            if ($tipo === 'numero' && $dec > 0) {
                $fieldname = '@'.$fieldname;
            }

            $fields_up[] = $fieldname;
        }

        $fields_up_list = implode(', ', $fields_up);

        $sql =
            "LOAD DATA LOW_PRIORITY LOCAL INFILE '##file##'
	 INTO TABLE `generale`.`"
            .$tbl
            ."` character set latin1 FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\r\n' ("
            .$fields_up_list
            .')'
            .\chr(13);
        $sql_replace = [];
        foreach ($txtd_array as $item) {
            $tipo = (string) ($item['tipo'] ?? '');
            $dec = (int) ($item['dec'] ?? 0);
            $nome = (string) ($item['nome'] ?? '');

            if ($tipo === 'numero' && $dec > 0) {
                $fieldname = TxtdService::fixFieldName($nome);
                $sql_replace[] = $fieldname.' = REPLACE(@'.$fieldname.',"," , ".")';
            }
        }

        $sql_replace = implode(', '.\chr(13), $sql_replace);
        if (\strlen($sql_replace) > 3) {
            $sql = $sql.'SET '.$sql_replace.';';
        }

        echo '<pre>'.htmlspecialchars($sql).'</pre>';
        // dddx('a');
        $params = [
            'sigma_user' => config('sigma.user'),
            'sigma_passwd' => config('sigma.passwd'),
            'filename' => $filename,
            'dir' => Storage::disk('cache')->path(''),
        ];
        $file = self::downloadSigmaFile($params);
        $sql = str_replace('##file##', $file, $sql);
        // die('['.__LINE__.']['.__FILE__.']');
        // 'truncate table generale.ana10f';
        // $conn=\DB::connection();
        // -- Anag per dare un modello nello stesso database
        $conn = (new Anag)->getConnection();
        $pdo = $conn->getpdo();
        // dddx($conn->getConfig('options'));
        // dddx(\DB::connection()->getConfig('options'));
        // dddx($pdo);
        // $pdo->setAttribute(\PDO::MYSQL_ATTR_LOCAL_INFILE,true);

        $n_rows = $pdo->exec($sql);
        // https://programmertoself.wordpress.com/2014/12/07/seeding-databases-from-csv-files-in-laravel-4-2/
        // $rows = \Excel::load('C:\\tmp\\pay_3ptv.ANA10F.csv', function($reader) {
        // https://www.grok-interactive.com/blog/import-large-csv-into-mysql-with-php-part-1/
        // reader methods
        // dddx($n_rows);
        // })->get();
        // $row->n_rows=$n_rows;
        // $row->save();

        // \Session::flash('status', 'Tabella importata ! ' . $row->id .' n records: '.$n_rows );
        // return redirect()->back();
        return ['n_rows' => $n_rows];
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function downloadSigmaFile(array $params): string
    {
        // echo '<pre>'; print_r($params); echo '</pre>';
        // dddx('qui');
        // $filename,$dir
        $refer = isset($params['refer']) ? (string) $params['refer'] : '';

        extract($params);
        $url = 'https://sigtransfer.sigmapaghe.com/';

        $usecookie = self::$usecookie;
        $cookie_file = storage_path('cookie.txt');
        if ($usecookie) {
            /*
             * if (file_exists($usecookie)) {
             * if (! is_writable($usecookie)) {
             * $msg = "Can't write to $usecookie cookie file, change file permission to 777 or remove read only for windows.";
             * throw new \Exception($msg);
             * }
             * } else {
             */
            if (! is_writable($cookie_file)) {
                // die('['.__LINE__.']['.__FILE__.']');
                $msg = sprintf(
                    'Can\'t write to %s cookie file, change file permission to 777 or remove read only for windows.',
                    $cookie_file,
                );
                throw new Exception($msg);
            }

            /*
             }
             */
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // /////// PROXY
        curl_setopt($ch, CURLOPT_PROXY, 'http://proxy04:8080');
        curl_setopt($ch, CURLOPT_PROXYPORT, 8080);
        // curl_setopt ($ch, CURLOPT_PROXYUSERPWD, "sottanamarco:Strada07");
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'Administrator:pluto-1');
        // ////////////////////////////////
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)');
        if ($usecookie) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file); // da controllare
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); // da controllare
        }
        if ($refer !== '') {
            curl_setopt($ch, CURLOPT_REFERER, $refer);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // ///////////////////////////////////////////////////////////////////////////////////////
        $fields_string = '';
        $fields = [
            'user' => $params['sigma_user'],
            'pwd' => $params['sigma_passwd'],
        ];
        /*
         * //url-ify the data for the POST
         * foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
         * rtrim($fields_string,'&');
         */
        $fields_string = http_build_query($fields);

        curl_setopt($ch, CURLOPT_POST, \count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        curl_exec($ch);
        // //////////////////////////////
        if (! isset($filename)) {
            throw new Exception('!isset($filename)');
        }

        [$db, $table] = explode('.', (string) $filename);
        $table1 = substr($table, 0, 10);
        switch (strtolower($db)) {
            case 'pay_2ptv':
                $choice = 16;
                $url =
                    'https://sigtransfer.sigmapaghe.com/download?format=CSV+-+Excel&choice'
                    .$choice
                    .'=Scarica&param0='
                    .$table1;
                break;
            case 'pay_3ptv':
                $choice = 1;
                $url =
                    'https://sigtransfer.sigmapaghe.com/download?format=CSV+-+Excel&choice'
                    .$choice
                    .'=Scarica&param0='
                    .$table1;
                break;
            case 'txtd_pay_2ptv':
                $choice = 16;
                $url =
                    'https://sigtransfer.sigmapaghe.com/download?format=TXTD+-+Tracciato+record+x+TXT&choice'
                    .$choice
                    .'=Scarica&param0='
                    .$table1;
                break;
            case 'txtd_pay_3ptv':
                $choice = 1;
                $url =
                    'https://sigtransfer.sigmapaghe.com/download?format=TXTD+-+Tracciato+record+x+TXT&choice'
                    .$choice
                    .'=Scarica&param0='
                    .$table1;
                break;
        }

        // $url='https://sigtransfer.sigmapaghe.com/download?format=CSV+-+Excel&choice1=Scarica&param0='.substr($filename,0,10);
        // $url='https://sigtransfer.sigmapaghe.com/download?format=CSV+-+Excel&choice16=Scarica&param0='.substr($filename,0,10);
        // $url='https://sigtransfer.sigmapaghe.com/download?format=CSV+-+Excel&choice'.$choice.'=Scarica&param0='.$table;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        $filename = str_replace('xot_', '', (string) $filename); // i file xot_xxx son degli export da pay2 che non ho ancora l'accesso
        if (\is_array($filename)) {
            $filename = implode(' ', $filename);
        }

        if (! isset($dir)) {
            throw new Exception('!isset($dir)');
        }

        $dir = (string) $dir;
        $filename = (string) $filename;
        $path = $dir.'/'.$filename.'.csv';
        $path = str_replace('\\', '/', $path);
        $path = str_replace('//', '/', $path);

        $fp = fopen($path, 'w');
        if ($fp === false) {
            throw new Exception('fp is false');
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // $headerArr = array("HTTP/1.1","Accept-Encoding: gzip;q=1.0,compress;q=0.5,identity;q=0");
        // curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArr);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_exec($ch);
        // 'param0'=>'ced03f',
        // 'choice1'=>"  Scarica  ",
        curl_close($ch);
        fclose($fp);
        // echo "<br>".$file

        // return realpath($path.".csv");
        return $path;
    }

    // ----------------------------------------------------------------------------
}
