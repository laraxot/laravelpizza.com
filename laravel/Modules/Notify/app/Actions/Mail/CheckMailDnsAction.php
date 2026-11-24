<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Mail;

use Closure;
use Safe\Exceptions\NetworkException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\dns_get_record;

/**
 * Checks the DNS records a mail provider asks for (CNAMEs for SPF/DKIM/tracking, plus a DMARC TXT).
 *
 * The typical failure it exists to catch: a DNS zone editor that completes a CNAME target without a
 * trailing dot, so `smtp.mailtrap.live` is published as `smtp.mailtrap.live.<zone>.` and the provider
 * never verifies the domain (mail then lands in spam). That case gets its own hint.
 *
 * Read-only: it only resolves names. Names are compared case-insensitively and without a trailing dot.
 *
 * @phpstan-type DnsResult array{record: string, expected: string, found: string|null, ok: bool, hint: 'missing'|'missing-trailing-dot'|'wrong-target'|null}
<<<<<<< .merge_file_QEWiyu
<<<<<<< HEAD
 *
 * @see docs/contracts/check-mail-dns-action.md
 *
 * @contract docs/contracts/check-mail-dns-action.md
=======
<<<<<<< HEAD
=======
 *
 * @see docs/contracts/check-mail-dns-action.md
 * @contract docs/contracts/check-mail-dns-action.md
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_fP4h6t
 */
class CheckMailDnsAction
{
    use QueueableAction;

    private const string DMARC_PREFIX = 'v=dmarc1';

    private const string HINT_MISSING = 'missing';

    private const string HINT_MISSING_TRAILING_DOT = 'missing-trailing-dot';

    private const string HINT_WRONG_TARGET = 'wrong-target';

    private const string RECORD_CNAME = 'CNAME';

    private const string RECORD_TXT = 'TXT';

    /**
     * @param  array<string, string>  $expectedCnames  label (relative to the domain) => expected target
     * @param  (Closure(string, string): list<string>)|null  $resolver  "(name, 'CNAME'|'TXT') => values"; null = system DNS
     * @return list<DnsResult> one row per CNAME in input order, then the DMARC row
     */
    public function execute(string $domain, array $expectedCnames, ?Closure $resolver = null): array
    {
        $resolver ??= self::systemResolver(...);
        $zone = self::normalize($domain);

        $results = [];
        foreach ($expectedCnames as $label => $target) {
            $results[] = $this->checkCname($label.'.'.$zone, $target, $zone, $resolver);
        }
        $results[] = $this->checkDmarc('_dmarc.'.$zone, $resolver);

        return $results;
    }

    /**
     * @param  Closure(string, string): list<string>  $resolver
     * @return DnsResult
     */
    private function checkCname(string $name, string $target, string $zone, Closure $resolver): array
    {
        $raw = $resolver($name, self::RECORD_CNAME);
        $found = array_map(self::normalize(...), $raw);
        $want = self::normalize($target);

        $hint = match (true) {
            $found === [] => self::HINT_MISSING,
            in_array($want, $found, true) => null,
            in_array($want.'.'.$zone, $found, true) => self::HINT_MISSING_TRAILING_DOT,
            default => self::HINT_WRONG_TARGET,
        };

        return ['record' => $name, 'expected' => $target, 'found' => $raw[0] ?? null, 'ok' => $hint === null, 'hint' => $hint];
    }

    /**
     * @param  Closure(string, string): list<string>  $resolver
     * @return DnsResult
     */
    private function checkDmarc(string $name, Closure $resolver): array
    {
        $raw = $resolver($name, self::RECORD_TXT);
        $found = array_values(array_filter($raw, static fn (string $txt): bool => str_starts_with(strtolower(trim($txt)), self::DMARC_PREFIX)));

        return [
            'record' => $name,
            'expected' => 'v=DMARC1',
            'found' => $found[0] ?? null,
            'ok' => $found !== [],
            'hint' => $found === [] ? self::HINT_MISSING : null,
        ];
    }

    private static function normalize(string $name): string
    {
        return strtolower(rtrim(trim($name), '.'));
    }

    /**
     * @return list<string>
     */
    private static function systemResolver(string $name, string $type): array
    {
        $isCname = $type === self::RECORD_CNAME;

        try {
            $records = dns_get_record($name, $isCname ? DNS_CNAME : DNS_TXT);
        } catch (NetworkException) {
            return [];
        }

        $key = $isCname ? 'target' : 'txt';
        $values = [];
        foreach ($records as $record) {
            $value = is_array($record) ? ($record[$key] ?? null) : null;
            if (is_string($value)) {
                $values[] = $value;
            }
        }

        return $values;
    }
}
