<?php

declare(strict_types=1);

namespace Modules\Sigma\Actions\WebService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

use function Safe\ini_set;

class SyncModelAction
{
    use QueueableAction;

    /**
     * Execute the action.
     *
     * @param  string  $tbl  Nome della tabella
     * @param  Model  $model  Modello da sincronizzare
     * @param  array<array-key, string>  $only  Campi da includere
     * @return int Numero di record sincronizzati
     */
    public function execute(string $tbl, Model $model, array $only = []): int
    {
        ini_set('memory_limit', '-1');

        // API
        $user = config('sigma_api.user');
        $pwd = config('sigma_api.pwd');

        $employees = Http::withBasicAuth(
            is_string($user) ? $user : '',
            is_string($pwd) ? $pwd : '',
        )->get('https://ws.sigmapaghe.com/hrdownloader/api/enti/90/queries/'.$tbl)->json();

        if (! is_array($employees)) {
            return 0;
        }

        /** @var array<int, array<string, mixed>> $employees */
        $employees = Arr::map($employees, static function (array $employee) use ($model, $only): array {
            /** @var array<string, mixed> $employee */
            $matr = $employee['MATR'] ?? '';
            $cognome = $employee['CONOME'] ?? '';
            $nome = $employee['NOME'] ?? '';
            $sesso = $employee['SESSO'] ?? '';
            $inail = $employee['INAIL'] ?? '';

            $data = [
                'matricola' => is_string($matr) ? $matr : (string) $matr,
                'cognome' => is_string($cognome) ? $cognome : (string) $cognome,
                'nome' => is_string($nome) ? $nome : (string) $nome,
                'sesso' => Str::lower(is_string($sesso) ? $sesso : (string) $sesso),
                'codice_fiscale' => 'STRNCL96E14L407V',
                'posizione_inail' => is_string($inail) ? $inail : (string) $inail,
            ];

            /** @var array<string, mixed> $where */
            $where = Arr::only($employee, $only);

            $model->updateOrCreate($where, $data);

            return $employee;
        });

        return count($employees);
    }
}
