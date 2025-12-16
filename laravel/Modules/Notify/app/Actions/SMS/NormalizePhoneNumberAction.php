<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Illuminate\Support\Facades\Http;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Azione per l'invio di SMS tramite Agile Telecom.
 */
class NormalizePhoneNumberAction
{
    public function execute(string $phoneNumber): string
    {
        // Rimuove parentesi e il loro contenuto
        $phoneNumber = preg_replace("/\([0-9]+?\)/", '', $phoneNumber);

        // Rimuove spazi e caratteri non numerici
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Rimuove gli zeri iniziali
        $phoneNumber = ltrim($phoneNumber, '0');

        // Prefisso italiano
        $prefix = '39';

        // Verifica se il numero non inizia già con il prefisso corretto
        if (!preg_match('/^' . $prefix . '/', $phoneNumber)) {
            $phoneNumber = $prefix . $phoneNumber;
        }

        return "+{$phoneNumber}";
    }
}
