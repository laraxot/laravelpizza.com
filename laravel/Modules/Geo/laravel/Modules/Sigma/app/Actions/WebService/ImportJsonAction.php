<?php

declare(strict_types=1);

namespace Modules\Sigma\Actions\WebService;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Modules\Sigma\Models\Anag;
use Spatie\QueueableAction\QueueableAction;
use stdClass;

use function Safe\json_decode;
use function Safe\mb_convert_encoding;

class ImportJsonAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $filename, string $disk, string $tbl): string
    {
        // $this->downloadFile();
        // $filename = 'wstr01f-oggi.csv';
        $tbl_arr = explode('_', $tbl);
        $tbl_name = Arr::first($tbl_arr);
        $tbl_name = strtolower((string) $tbl_name);

        $contentRaw = Storage::disk($disk)->get($filename);
        if ($contentRaw === null) {
            return '<h1 style="color:red;">File non trovato: '.$filename.'</h1>';
        }

        // mb_internal_encoding('UTF-8');

        /** @var string $content */
        $content = mb_convert_encoding($contentRaw, 'UTF-8', 'UTF-8');

        /** @var stdClass|array<mixed>|null $rows */
        $rows = json_decode($content); // JSON_UNESCAPED_UNICODE

        // $rows = json_decode($content, false, 512, JSON_UNESCAPED_UNICODE);
        if (is_object($rows) && isset($rows->messaggio)) {
            /** @var string $messaggio */
            $messaggio = $rows->messaggio;
            if ($messaggio === 'La query non ha prodotto alcun record') {
                return '<h3>'.$tbl_name.' [0] Records</h3>';
            }

            /** @var string $errorMsg */
            $errorMsg = json_last_error_msg();

            return
                '<h2 style="color:red">
                Tbl: ['
                .$tbl
                .']<br/>
                Filename:['
                .$filename
                .']<br/>
                messaggio ['
                .$messaggio
                .']
                Json error ['
                .$errorMsg
                .']
                Line ['
                .__LINE__
                .']
            </h2>'
                .$content;
        }

        $conn = (new Anag)->getConnection();
        $dbname = $conn->getDatabaseName();
        $pdo = $conn->getpdo();
        try {
            $rowsCount = is_array($rows) ? count($rows) : (is_object($rows) ? count(get_object_vars($rows)) : 0);
            if ($rowsCount > 5) {
                $sql = 'truncate table '.$dbname.'.'.$tbl_name;
                $pdo->exec($sql);
            }
        } catch (Exception $exception) {
            /** @var string $errorMsg */
            $errorMsg = json_last_error_msg();

            return
                '<h1 style="color:red;">TABELLA IMPORTATA MALE <br/>
                Tbl: ['
                .$tbl
                .']<br/>
                Filename:['
                .$filename
                .']<br/>
                e:['
                .$exception->getMessage()
                .']
                Json error ['
                .$errorMsg
                .']
                Line ['
                .__LINE__
                .']
                </h1>'
                .$content;
        }

        // $n_rows = $pdo->exec($sql);
        $rowsArray = is_array($rows) ? $rows : (is_object($rows) ? [$rows] : []);
        foreach ($rowsArray as $row) {
            if (\is_object($row)) {
                $row = get_object_vars($row);
            }

            if (! is_array($row)) {
                continue;
            }

            /** @var array<int, string> $keys */
            $keys = collect($row)->map(static fn ($item, $key): string => strtolower((string) $key))->all();

            /** @var array<int, string|int|float> $values */
            $values = collect($row)->map(static function ($item, $key): string|int|float {
                if (is_numeric($item)) {
                    return $item;
                }
                $itemString = is_string($item) ? $item : (string) $item;
                $tmp = str_replace(',', '.', $itemString);
                if (is_numeric($tmp)) {
                    return $tmp;
                }

                return '"'.str_replace('"', '', $itemString).'"';
            })->all();
            $sql =
                'INSERT INTO `'
                .$dbname
                .'`.'
                .$tbl_name
                .' ('
                .implode(', ', $keys)
                .') VALUES ('
                .implode(', ', $values)
                .');';
            // echo '<pre>'.print_r($sql, true).'</pre>';
            try {
                $n_rows = $pdo->exec($sql);
            } catch (Exception $e) {
                dddx(['e' => $e->getMessage(), 'row' => $row, 'filename' => $filename, 'tbl' => $tbl]);
            }
        }

        // return  '<h3>N Righe: '.$n_rows.'</h3>';
        $rowsCount = is_countable($rows) ? count($rows) : 0;

        return '<h3>'.$tbl_name.' ['.$rowsCount.'] Records</h3>';
    }
}
