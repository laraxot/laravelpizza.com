<?php

declare(strict_types=1);

namespace Modules\Sigma\Services;

use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Safe\fclose;
use function Safe\fgetcsv;
use function Safe\fopen;
use function Safe\preg_replace;

class TxtdService
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function toArray(string $file_txtd): array
    {
        $handle = fopen($file_txtd, 'r');
        if ($handle === false) {
            throw new Exception('$handle = fopen($file_txtd, r);');
        }

        $riga = 0;
        $ris = [];
        $head = [];
        while (($data = fgetcsv($handle, 2000, '|')) !== false) {
            if ($data === []) {
                continue;
            }

            $riga++;
            /** @var list<string> $data */
            $row = array_map(trim(...), $data);
            $row = array_map(strtolower(...), $row);
            if ($riga === 2) {
                $head = $row;
            }

            if ($riga > 3 && isset($data[1])) {
                if (\count($head) !== \count($row)) {
                    continue;
                }

                /** @var array<string, string> $combined */
                $combined = array_combine($head, $row);
                $ris[] = $combined;
            }

            // end if
        }
        // end while
        fclose($handle);

        return $ris;
    }

    // end function

    public static function fixFieldName(string $str): string
    {
        $str = trim($str);
        if ($str === 'desc') {
            return 'desc1';
        } // descrizione;
        // preg_match_all(, subject, matches)
        $str = str_replace('§', '10', $str);
        $str = str_replace('\xA7', '10', $str);
        $str = str_replace('$', '11', $str);

        $str1 = (string) preg_replace('/[0-9a-z]/i', '', $str);

        switch (\ord($str1)) {
            case 0:
                break;
            case 167:
                $str = str_replace($str1, '10', $str);
                break;
            case 239:
                $str = str_replace($str1, '_', $str);
                break;
            default:
                echo '<h3>carattere non riconosciuto ['
                    .$str1
                    .']['
                    .\ord($str1)
                        .']['
                        .$str
                        .'] Aggiungerlo </h3>';
                exit('<hr/>['.__LINE__.']['.__FILE__.']');

                // break;
        }

        return $str;
    }

    // --------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     * @return array<int, string>
     */
    public static function getFieldsNames(array $params): array
    {
        // ✅ FIX PHPStan: Accesso esplicito invece di extract()
        $data = $params['data'] ?? null;
        $filename = $params['filename'] ?? null;

        if (! isset($data)) {
            if (! \is_string($filename) || $filename === '') {
                throw new Exception('Missing filename for getFieldsNames');
            }

            $data = self::toArray($filename);
        }

        if (! \is_array($data)) {
            return [];
        }

        $filteredRows = [];
        foreach ($data as $item) {
            if (! \is_array($item) || ! isset($item['nome'])) {
                continue;
            }
            $filteredRows[] = $item;
        }

        $collection = collect($filteredRows);
        $keyed = $collection->keyBy(
            static fn (array $item): string => self::fixFieldName((string) $item['nome'])
        );

        return $keyed->keys()->all();
    }

    // --------------------------------------------------------------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function createTable(array $params): string
    {
        $filenameParam = $params['filename'] ?? null;
        $connParam = $params['conn'] ?? null;
        $tblParam = $params['tbl'] ?? null;

        if (! \is_string($filenameParam) || $filenameParam === '') {
            throw new Exception('Missing filename parameter');
        }

        if (! \is_string($connParam) || $connParam === '') {
            throw new Exception('Missing conn parameter');
        }

        if (! \is_string($tblParam) || $tblParam === '') {
            throw new Exception('Missing tbl parameter');
        }

        $filename = $filenameParam;
        $conn = $connParam;
        $tbl = $tblParam;

        $tmp = self::toArray($filename);
        if (\count($tmp) < 2) {
            return '<h3> file scaricato male riprovare </h3>';
        }

        Schema::connection($conn)->dropIfExists($tbl);

        Schema::connection($conn)->create($tbl, static function (Blueprint $table) use ($tmp): void {
            $table->increments('id');
            // while (list($k, $v)=each($tmp)) {
            foreach ($tmp as $v) {
                if (! \is_array($v)) {
                    continue;
                }

                $nomeRaw = \array_key_exists('nome', $v) ? (string) $v['nome'] : '';
                $tipoRaw = \array_key_exists('tipo', $v) ? (string) $v['tipo'] : '';
                $lunghezzaRaw = \array_key_exists('lunghezza', $v) ? (int) $v['lunghezza'] : 0;
                $decRaw = \array_key_exists('dec', $v) ? (int) $v['dec'] : 0;

                $nome = self::fixFieldName($nomeRaw);
                $tipo = strtolower($tipoRaw);
                $lunghezza = $lunghezzaRaw;
                $dec = $decRaw;

                if ($nome === '') {
                    continue;
                }

                switch ($tipo) {
                    case 'carattere':
                        if ($lunghezza > 255) {
                            $table->text($nome);
                        } else {
                            $length = $lunghezza > 0 ? $lunghezza : 1;
                            $table->char($nome, $length);
                        }

                        break;
                    case 'numero':
                        if ($dec > 0) {
                            $precision = $lunghezza > 0 ? $lunghezza : 10;
                            $table->decimal($nome, $precision, $dec);
                        } else {
                            $table->integer($nome);
                        }

                        break;
                    default:
                        exit('['.$tipo.']['.__LINE__.']['.__FILE__.']');

                        // 117    Unreachable statement - code above always terminates.
                        // break;
                }
            }
        });

        return '<h3>Creato tabella '.$conn.'.'.$tbl.'</h3>';
    }

    // end createTable
}

// end class
