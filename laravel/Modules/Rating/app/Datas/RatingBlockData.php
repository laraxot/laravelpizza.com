<?php

declare(strict_types=1);

namespace Modules\Rating\Datas;

use Modules\Rating\Enums\SupportedLocale;
use Spatie\LaravelData\Data;

/**
 * DTO per un blocco rating (particolarmente per il rendiconto bilancio.
 * Titolo, descrizione, posizione, immagini, localizzazione.
 *
 * Configura l'interfaccia utente di un blocco valutazione e guida la creazione
 * di DB ratings (con pattern laravel-nestedset / rating-data.migration).
 */
class RatingBlockData extends Data
{
    public function __construct(
        public readonly string $title = '',
        public readonly string $description = '',
        public readonly bool $disabled = false,
        public readonly int $position = 0,
        public readonly SupportedLocale $locale = SupportedLocale::IT,
        public readonly ?string $image_url = null,
    ) {}

    /**
     * Da un array grezzo verso un DTO tipizzato.
     *
     * @param  array<string,mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: is_string($data['title'] ?? '') ? ($data['title'] ?? '') : (is_scalar($data['title'] ?? '') ? (string) ($data['title'] ?? '') : ''),
            description: is_string($data['description'] ?? '') ? ($data['description'] ?? '') : (is_scalar($data['description'] ?? '') ? (string) ($data['description'] ?? '') : ''),
            disabled: isset($data['disabled']) ? (bool) $data['disabled'] : false,
            position: isset($data['position']) && is_numeric($data['position']) ? (int) $data['position'] : 0,
            locale: SupportedLocale::fromString(is_string($data['locale'] ?? 'it') ? ($data['locale'] ?? 'it') : 'it'),
            image_url: isset($data['image_url']) ? (is_string($data['image_url']) ? $data['image_url'] : null) : null,
        );
    }
}
