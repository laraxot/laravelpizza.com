<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Models\OauthClient;

/**
 * Story user-passport-create-client-credentials-button.md, Task 6 (AC9).
 *
 * Bonifica una tantum dei client OAuth associati a un utente prima che
 * OauthClient::booted() sincronizzasse automaticamente owner_id/owner_type
 * da user_id: trova ogni client con user_id valorizzato e owner_id/owner_type
 * vuoti, e li risalva. Il salvataggio da solo basta — riusa lo stesso hook
 * del modello, nessuna logica duplicata qui.
 */
class BackfillOauthClientOwnerCommand extends Command
{
    protected $signature = 'user:backfill-oauth-client-owner
        {--dry-run : mostra solo quali client verrebbero corretti, non scrive nulla}';

    protected $description = 'Sincronizza owner_id/owner_type dai client OAuth che hanno solo user_id valorizzato';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        $clients = OauthClient::query()
            ->whereNotNull('user_id')
            ->where(function (Builder $query): void {
                $query->whereNull('owner_id')->orWhereNull('owner_type');
            })
            ->get();

        if ($clients->isEmpty()) {
            $this->info('Nessun client da bonificare: tutti i client con user_id hanno già owner_id/owner_type.');

            return Command::SUCCESS;
        }

        $fixed = 0;
        $skipped = 0;

        foreach ($clients as $client) {
            $this->line(($dryRun ? '[DRY-RUN] ' : '')."client={$client->id} name={$client->name} user_id={$client->user_id}");

            if ($dryRun) {
                continue;
            }

            $client->save();
            $client->refresh();

            if ($client->owner_id !== null && $client->owner_type !== null) {
                $fixed++;
            } else {
                $skipped++;
                $this->warn("  -> non corretto: nessun utente trovato per user_id={$client->user_id} (owner() ha restituito null)");
            }
        }

        if ($dryRun) {
            $this->info("Trovati {$clients->count()} client da bonificare (dry-run, nessuna scrittura).");
        } else {
            $this->info("Bonificati: {$fixed}, saltati (owner non risolvibile): {$skipped}.");
        }

        return Command::SUCCESS;
    }
}
