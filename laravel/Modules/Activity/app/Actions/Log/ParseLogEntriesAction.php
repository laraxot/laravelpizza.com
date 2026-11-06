<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Modules\Activity\Datas\LogEntryData;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_match;

/**
 * Divide il testo di un log in VOCI nel formato Monolog di Laravel:
 *
 *     [2026-09-20 10:34:23] production.ERROR: messaggio ...
 *     #0 /path/file.php(12): stack trace (righe successive)
 *
 * Ogni riga che inizia con `[data ora] ambiente.LIVELLO:` apre una nuova voce; tutte le righe
 * successive (stack trace, contesto JSON) restano attaccate alla voce a cui appartengono.
 * Eventuali righe iniziali non riconosciute (per esempio una voce tagliata) formano una voce
 * "grezza" senza data ne' livello.
 */
class ParseLogEntriesAction
{
    use QueueableAction;

    private const string HEADER_PATTERN = '/^\[(?<ts>\d{4}-\d{2}-\d{2}[ T]\d{2}:\d{2}:\d{2}(?:[.,]\d+)?(?:[+-]\d{2}:?\d{2}|Z)?)\]\s+(?<env>[\w.-]+)\.(?<level>[A-Za-z]+):\s?(?<msg>.*)$/';

    /**
     * @return list<LogEntryData>
     */
    public function execute(string $text): array
    {
        if ($text === '') {
            return [];
        }

        $entries = [];
        $isOpen = false;
        $timestamp = null;
        $environment = null;
        $level = null;
        $message = '';
        $body = '';

        // Normalizza i fine riga (\r\n e \r) e divide: explode() restituisce sempre list<string>.
        foreach (explode("\n", str_replace(["\r\n", "\r"], "\n", $text)) as $line) {
            $isHeader = preg_match(self::HEADER_PATTERN, $line, $match) === 1;

            if ($isHeader && isset($match['ts'], $match['env'], $match['level'], $match['msg'])) {
                if ($isOpen) {
                    $entries[] = $this->entry($timestamp, $environment, $level, $message, $body);
                }

                $isOpen = true;
                $timestamp = $match['ts'];
                $environment = $match['env'];
                $level = mb_strtoupper($match['level']);
                $message = $match['msg'];
                $body = $line;

                continue;
            }

            if (! $isOpen) {
                if (trim($line) === '') {
                    continue;
                }

                $isOpen = true;
                $timestamp = null;
                $environment = null;
                $level = null;
                $message = $line;
                $body = $line;

                continue;
            }

            $body .= "\n".$line;
        }

        if ($isOpen) {
            $entries[] = $this->entry($timestamp, $environment, $level, $message, $body);
        }

        return $entries;
    }

    private function entry(?string $timestamp, ?string $environment, ?string $level, string $message, string $body): LogEntryData
    {
        return new LogEntryData(
            timestamp: $timestamp,
            environment: $environment,
            level: $level,
            message: $message,
            body: rtrim($body),
        );
    }
}
