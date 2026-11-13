<?php

declare(strict_types=1);

namespace Modules\User\Actions\Login;

use Carbon\CarbonImmutable;
use InvalidArgumentException;
use Modules\User\Actions\Login\Concerns\ResolvesLoginLogQuery;

/**
 * Serie storica degli accessi da authentication_logs.
 *
 * Laravel Pulse aggrega al massimo 7 giorni (DatabaseStorage::store()
 * scarta le entry piu' vecchie e trim() purge gli aggregati): per
 * orizzonti superiori la sorgente di verita' resta authentication_logs.
 * Vengono conteggiate tutte le righe con timestamp valorizzato, anche
 * login_successful = false, in parita' con il backfill Pulse e con
 * GetLoginStatsAction ("tutto AuthenticationLog").
 *
 * I bucket sono calcolati sul timestamp UTC della colonna configurata.
 */
final class GetLoginHistoryAction
{
    use ResolvesLoginLogQuery;

    private const int MAX_BUCKETS = 5000;

    /**
     * @return array{labels: list<string>, data: list<int>}
     */
    public function execute(
        ?CarbonImmutable $since = null,
        string $granularity = 'day',
    ): array {
        if (! in_array($granularity, ['day', 'month'], true)) {
            throw new InvalidArgumentException(
                "Invalid granularity [{$granularity}]: day|month."
            );
        }

        $column = $this->loginLogColumn();

        $query = $this->authenticationLogQuery();

        if ($since === null) {
            $oldest = (clone $query)->min($column);

            if (! is_string($oldest)) {
                return ['labels' => [], 'data' => []];
            }

            $since = CarbonImmutable::parse($oldest, 'UTC')
                ->startOfDay();
        }

        $end = CarbonImmutable::now('UTC');

        // ponytail: scansione in PHP; authentication_logs e' nell'ordine di
        // 10^3-10^5 righe. Se cresce, spostare l'aggregazione in SQL.
        $bucketLength = $granularity === 'month' ? 7 : 10;

        $counts = [];

        // toBase(): evita il cast datetime del modello e legge le stringhe
        // SQL grezze, cosi' substr() produce bucket coerenti.
        $timestamps = $query
            ->toBase()
            ->where($column, '>=', $since->toDateTimeString())
            ->where($column, '<=', $end->toDateTimeString())
            ->pluck($column);

        foreach ($timestamps as $timestamp) {
            if (! is_string($timestamp)) {
                continue;
            }

            $bucket = substr($timestamp, 0, $bucketLength);
            $counts[$bucket] = ($counts[$bucket] ?? 0) + 1;
        }

        $cursor = $granularity === 'month'
            ? $since->startOfMonth()
            : $since->startOfDay();

        $labels = [];
        $data = [];
        $bucketCount = 0;

        while ($cursor->lessThanOrEqualTo($end)) {
            if (++$bucketCount > self::MAX_BUCKETS) {
                throw new InvalidArgumentException(
                    'History too long for day granularity: use month.'
                );
            }

            $key = $granularity === 'month'
                ? $cursor->format('Y-m')
                : $cursor->format('Y-m-d');

            $labels[] = $granularity === 'month'
                ? $cursor->format('m/Y')
                : $cursor->format('d/m/y');
            $data[] = $counts[$key] ?? 0;

            $cursor = $granularity === 'month'
                ? $cursor->addMonth()
                : $cursor->addDay();
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
