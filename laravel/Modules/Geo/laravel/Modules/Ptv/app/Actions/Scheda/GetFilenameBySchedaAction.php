<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_replace;

/**
 * Action per generare il nome file PDF per una scheda.
 *
 * Questa action genera un nome file dinamico basato sui dati della scheda,
 * seguendo il pattern: scheda_{id}_{matr}_{cognome}_{nome}.pdf
 *
 * Se i campi identificativi non sono disponibili, restituisce 'scheda.pdf' come fallback.
 */
class GetFilenameBySchedaAction
{
    use QueueableAction;

    /**
     * Genera il nome file PDF per una scheda.
     *
     * Pattern generato:
     * - Se disponibili id, matr, cognome, nome: scheda_{id}_{matr}_{cognome}_{nome}.pdf
     * - Fallback: scheda.pdf
     *
     * @param  SchedaContract  $scheda  La scheda per cui generare il nome file
     * @return string Nome file PDF generato
     */
    public function execute(SchedaContract $scheda): string
    {
        // Verifica se i campi identificativi sono disponibili
        if (
            isset($scheda->id) &&
            isset($scheda->matr) &&
            isset($scheda->cognome) &&
            isset($scheda->nome)
        ) {
            // Normalizza i valori per evitare caratteri problematici nei nomi file
            $id = (string) $scheda->id;
            $matr = is_string($scheda->matr) ? $scheda->matr : '-';
            $cognome = is_string($scheda->cognome)
                ? $this->sanitizeFilename($scheda->cognome)
                : '-';
            $nome = is_string($scheda->nome)
                ? $this->sanitizeFilename($scheda->nome)
                : '-';

            return 'scheda_'.$id.'_'.$matr.'_'.$cognome.'_'.$nome.'.pdf';
        }

        // Fallback a nome file generico se i campi identificativi
        // non sono disponibili
        return 'scheda.pdf';
    }

    /**
     * Sanitizza una stringa per essere utilizzata come parte di un nome file.
     *
     * Rimuove o sostituisce caratteri problematici che potrebbero
     * causare problemi nei filesystem o nei client email.
     *
     * @param  string  $filename  Parte del nome file da sanitizzare
     * @return string Stringa sanitizzata
     */
    protected function sanitizeFilename(string $filename): string
    {
        // Rimuove caratteri problematici per i nomi file
        // Sostituisce spazi multipli con underscore
        // Rimuove caratteri speciali non alfanumerici
        // (mantiene underscore e trattini)
        $sanitized = preg_replace('/[^a-zA-Z0-9_-]/', '', $filename);

        // Se dopo la sanitizzazione la stringa è vuota, usa '-'
        if ($sanitized === '' || $sanitized === null) {
            return '-';
        }

        // Limita la lunghezza per evitare nomi file troppo lunghi
        return mb_substr((string) $sanitized, 0, 50);
    }
}
