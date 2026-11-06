<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Azione per l'invio di SMS tramite Agile Telecom.
 */
class NormalizePhoneNumberAction
{
    use QueueableAction;

    public function execute(string $phoneNumber): string
    {
        // Un numero con "+" o "00" davanti ha gia' il prefisso internazionale
        $isInternational = preg_match('/^\s*(\+|00)/', $phoneNumber) === 1;

        // Rimuove parentesi e il loro contenuto
        $phoneNumber = preg_replace("/\([0-9]+?\)/", '', $phoneNumber);
        Assert::string($phoneNumber, 'Failed to remove parentheses from phone number');

        // Rimuove spazi e caratteri non numerici
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        Assert::string($phoneNumber, 'Failed to remove non-numeric characters from phone number');

        // Rimuove gli zeri iniziali
        $phoneNumber = ltrim($phoneNumber, '0');
        Assert::notEmpty($phoneNumber, 'Phone number contains no digits');

        if ($isInternational) {
            return "+{$phoneNumber}";
        }

        // Prefisso italiano
        $prefix = '39';

        // Verifica se il numero non inizia già con il prefisso corretto
        if (! preg_match('/^'.$prefix.'/', $phoneNumber)) {
            $phoneNumber = $prefix.$phoneNumber;
        }

        return "+{$phoneNumber}";
    }
}
