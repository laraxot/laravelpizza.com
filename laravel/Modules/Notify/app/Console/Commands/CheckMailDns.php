<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Actions\Mail\CheckMailDnsAction;

/**
 * Read-only check of the DNS records the mail provider requires for the sending domain.
 *
 * Lives in Notify because mail delivery belongs to this module; it is auto-registered by
 * XotBaseServiceProvider::registerCommands(). Expected records come from `notify.notify.mail_dns` (module config files are mounted as <module>.<file>).
 * Exit code 1 when any record is missing or wrong, so it can gate a deploy.
 *
 * @see Modules/Notify/docs/command-ownership.md
 */
final class CheckMailDns extends Command
{
    protected $signature = 'notify:check-dns
                            {domain? : Domain to check (default: notify.notify.mail_dns.domain)}';

    protected $description = 'Check the CNAME and DMARC records required by the mail provider (read-only)';

    public function handle(CheckMailDnsAction $check): int
    {
        $domain = $this->domainToCheck();
        $cnames = $this->expectedCnames();

        if ($domain === '' || $cnames === []) {
            $this->error('No domain or no expected CNAMEs: pass the domain or set notify.notify.mail_dns in config.');

            return self::FAILURE;
        }

        $results = $check->execute($domain, $cnames);

        $this->table(
            ['record', 'expected', 'found', 'status'],
            array_map(static fn (array $row): array => [
                $row['record'],
                $row['expected'],
                $row['found'] ?? '-',
                $row['hint'] ?? 'ok',
            ], $results),
        );

        return in_array(false, array_column($results, 'ok'), true) ? self::FAILURE : self::SUCCESS;
    }

    private function domainToCheck(): string
    {
        $argument = $this->argument('domain');
        $configured = config('notify.notify.mail_dns.domain');

        return is_string($argument) && $argument !== '' ? $argument : (is_string($configured) ? $configured : '');
    }

    /** @return array<string, string> */
    private function expectedCnames(): array
    {
        $configured = config('notify.notify.mail_dns.cnames');
        if (! is_array($configured)) {
            return [];
        }

        $cnames = [];
        foreach ($configured as $label => $target) {
            if (is_string($label) && is_string($target)) {
                $cnames[$label] = $target;
            }
        }

        return $cnames;
    }
}
