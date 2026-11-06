<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Ente;

use Modules\Tenant\Datas\EnteData;
use Spatie\QueueableAction\QueueableAction;

use function Safe\parse_url;
use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Dati dell'ente (DCP-289) letti da `config('ente')`, il file `config/<tenant>/ente.php` che compila l'ente, e restituiti gia' normalizzati.
 *
 * Regola: un valore mancante o non valido vale stringa vuota, mai un segnaposto. Telefono: solo cifre con `+` iniziale, 3-15 cifre, dopo
 * aver tolto spazi, punti, trattini, parentesi e barre. Email e PEC: indirizzo ASCII semplice (niente `?`, `&`, `%` che in un `mailto:`
 * aggiungerebbero parametri). URL: solo `http` o `https` con host, senza spazi, virgolette o parentesi angolari. Social: solo le reti con
 * un'icona nello sprite Design Comuni. Ogni testo puo' essere una stringa o una mappa per lingua.
 */
class GetEnteDataAction
{
    use QueueableAction;

    /** Rete => etichetta. L'icona e' `it-<rete>` nello sprite Bootstrap Italia. */
    public const array SOCIAL_NETWORKS = [
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
        'mastodon' => 'Mastodon',
        'telegram' => 'Telegram',
        'tiktok' => 'TikTok',
        'twitter' => 'X (Twitter)',
        'whatsapp' => 'WhatsApp',
        'youtube' => 'YouTube',
        'rss' => 'RSS',
    ];

    public function execute(?string $locale = null): EnteData
    {
        $config = config('ente');
        $raw = is_array($config) ? $config : [];
        $locale ??= app()->getLocale();

        $text = fn (string $key): string => $this->text($raw[$key] ?? null, $locale);

        return new EnteData(
            name: $text('name'),
            region_name: $text('region_name'),
            region_url: $this->url($text('region_url')),
            address: $text('address'),
            pec: $this->email($text('pec')),
            email: $this->email($text('email')),
            phone: $this->phone($text('phone')),
            toll_free: $this->phone($text('toll_free')),
            tax_code: $text('tax_code'),
            vat: $text('vat'),
            dpo_name: $text('dpo_name'),
            dpo_email: $this->email($text('dpo_email')),
            hours: $text('hours'),
            social: $this->social($raw['social'] ?? null, $locale),
        );
    }

    /**
     * Stringa, o mappa lingua => stringa (lingua richiesta, poi `app.fallback_locale`, poi il primo valore testuale).
     */
    private function text(mixed $value, string $locale): string
    {
        if (is_array($value)) {
            $fallback = config('app.fallback_locale');
            $picked = $value[$locale] ?? (is_string($fallback) ? ($value[$fallback] ?? null) : null);
            if (! is_string($picked)) {
                $picked = array_find($value, static fn (mixed $candidate): bool => is_string($candidate));
            }
            $value = $picked;
        }

        if (! is_string($value)) {
            return '';
        }

        // tolti i caratteri di controllo tranne a capo e tabulazione (l'indirizzo e gli orari possono andare su piu' righe)
        return trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $value));
    }

    private function phone(string $value): string
    {
        $digits = preg_replace('/[\s.\-()\/]/', '', $value);

        return preg_match('/^\+?\d{3,15}$/', $digits) === 1 ? $value : '';
    }

    private function email(string $value): string
    {
        $simple = preg_match('/^[A-Za-z0-9._+\-]+@[A-Za-z0-9\-]+(\.[A-Za-z0-9\-]+)*\.[A-Za-z]{2,}$/', $value) === 1;

        return $simple && filter_var($value, FILTER_VALIDATE_EMAIL) !== false ? $value : '';
    }

    private function url(string $value): string
    {
        if ($value === '' || preg_match('/[\s<>"\'\\\\\x00-\x1F\x7F]/', $value) === 1) {
            return '';
        }

        try {
            $scheme = parse_url($value, PHP_URL_SCHEME);
            $host = parse_url($value, PHP_URL_HOST);
        } catch (\Throwable) {
            return '';
        }

        $isWeb = is_string($scheme) && in_array(strtolower($scheme), ['http', 'https'], true);

        return $isWeb && is_string($host) && $host !== '' ? $value : '';
    }

    /**
     * @return list<array{network: string, label: string, url: string, icon: string}>
     */
    private function social(mixed $value, string $locale): array
    {
        if (! is_array($value)) {
            return [];
        }

        $items = [];
        foreach ($value as $entry) {
            if (! is_array($entry)) {
                continue;
            }

            $network = strtolower($this->text($entry['network'] ?? null, $locale));
            $url = $this->url($this->text($entry['url'] ?? null, $locale));
            if (! array_key_exists($network, self::SOCIAL_NETWORKS) || $url === '') {
                continue;
            }

            $label = $this->text($entry['label'] ?? null, $locale);
            $items[] = [
                'network' => $network,
                'label' => $label !== '' ? $label : self::SOCIAL_NETWORKS[$network],
                'url' => $url,
                'icon' => 'it-'.$network,
            ];
        }

        return $items;
    }
}
