<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

use function Safe\preg_match;

/**
 * Elenco pubblico degli eventi (PRD FR-5, FR-6, FR-8): solo pubblicati, futuri o passati, filtrabili per citta' e date.
 * I filtri arrivano dalla query string (?city=Milano&from=2026-12-01&until=2026-12-31): l'URL si puo' condividere
 * e la pagina funziona anche senza JavaScript.
 */
class SearchPublicEventsAction
{
    use QueueableAction;

    public const string UPCOMING = 'upcoming';

    public const string PAST = 'past';

    /**
     * @param  array<string, mixed>  $filters  city, from, until (stringhe dalla query string; i valori non validi sono ignorati)
     * @return Collection<int, Event>
     */
    public function execute(string $timing, array $filters = [], int $limit = 50): Collection
    {
        $query = $this->baseQuery($timing);

        $city = self::cleanString($filters['city'] ?? null);
        if ($city !== null) {
            $query->where('location', $city);
        }

        $from = self::parseDate($filters['from'] ?? null);
        if ($from !== null) {
            $query->where('start_date', '>=', $from->startOfDay());
        }

        $until = self::parseDate($filters['until'] ?? null);
        if ($until !== null) {
            $query->where('start_date', '<=', $until->endOfDay());
        }

        return $query
            ->with('venue')
            // Futuri dal piu' vicino, passati dal piu' recente.
            ->orderBy('start_date', $timing === self::PAST ? 'desc' : 'asc')
            ->limit(max(1, min($limit, 200)))
            ->get();
    }

    /**
     * Citta' che hanno almeno un evento pubblicato nel periodo: le sole opzioni sensate per il filtro.
     *
     * @return list<string>
     */
    public function cities(string $timing): array
    {
        $cities = [];
        foreach ($this->baseQuery($timing)->distinct()->orderBy('location')->pluck('location') as $city) {
            if (is_string($city) && trim($city) !== '') {
                $cities[] = trim($city);
            }
        }

        return array_values(array_unique($cities));
    }

    /**
     * @return Builder<Event>
     */
    private function baseQuery(string $timing): Builder
    {
        $query = Event::query()->published();

        return $timing === self::PAST ? $query->past() : $query->upcoming();
    }

    private static function cleanString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : mb_substr($value, 0, 191);
    }

    private static function parseDate(mixed $value): ?Carbon
    {
        $value = self::cleanString($value);
        if ($value === null || preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) !== 1) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $value)?->startOfDay();
        } catch (Throwable) {
            return null;
        }
    }
}
