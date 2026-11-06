<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\NotifyTheme;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

use function Safe\mb_convert_encoding;
use function Safe\preg_replace;

/**
 * Story quaeris-send-invite-migrate-to-record-notification.md, Task 4.
 *
 * Migra il contenuto già scritto in `notify_themes` (email e sms, per ogni
 * `post_id`) verso `MailTemplate`, con lo slug nella stessa convenzione già usata
 * dalla scheda "Inviti" (`ManageMailTemplates`): `survey-pdf-<post_id>-invito`.
 *
 * Difetto 6: lo slug è a TRATTINI, non underscore — SpatieEmail::__construct()/
 * RecordNotification::__construct() fanno sempre Str::slug($slug) prima di
 * cercare/creare il MailTemplate, e Str::slug() converte gli underscore in
 * trattini. Uno slug con underscore non verrebbe mai trovato da SpatieEmail.
 *
 * Un solo passaggio, idempotente (`updateOrCreate`): rilanciarlo aggiorna i
 * template già migrati invece di duplicarli.
 */
class MigrateNotifyThemesToMailTemplateCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'notify:migrate-themes-to-mail-templates
        {--post-type=survey_pdf : post_type di notify_themes da migrare}
        {--dry-run : mostra solo cosa farebbe, non scrive nulla}';

    /**
     * @var string
     */
    protected $description = 'Migra i temi email/sms di notify_themes verso MailTemplate';

    public function handle(): int
    {
        $postType = SafeStringCastAction::cast($this->option('post-type'));
        $dryRun = (bool) $this->option('dry-run');

        /** @var list<int|string> $postIds */
        $postIds = NotifyTheme::query()
            ->where('post_type', $postType)
            ->distinct()
            ->pluck('post_id')
            ->all();

        $migrated = 0;
        $skipped = 0;

        foreach ($postIds as $postId) {
            $emailTheme = NotifyTheme::query()
                ->where('post_type', $postType)
                ->where('post_id', $postId)
                ->where('type', 'email')
                ->first();

            $smsTheme = NotifyTheme::query()
                ->where('post_type', $postType)
                ->where('post_id', $postId)
                ->where('type', 'sms')
                ->first();

            // Story quaeris-send-invite-migrate-to-record-notification.md, Difetto 1:
            // le righe auto-generate mai configurate a mano hanno il subject rotto
            // (chiave di traduzione letterale) — non c'è nulla di reale da migrare.
            if ($emailTheme !== null
                && $emailTheme->theme === 'ark'
                && $emailTheme->subject === 'quaeris::email.survey_pdf.subject'
            ) {
                $emailTheme = null;
            }

            if ($emailTheme === null && $smsTheme === null) {
                $skipped++;

                continue;
            }

            $slug = 'survey-pdf-'.$postId.'-invito';

            /** @var array<string, string> $data */
            $data = [
                'name' => 'Invito survey '.$postId,
                'html_layout_path' => 'base.html',
            ];

            if ($emailTheme !== null) {
                $data['subject'] = $this->convertPlaceholders($this->decodeRichText((string) $emailTheme->subject));
                $data['html_template'] = $this->convertPlaceholders($this->decodeRichText((string) $emailTheme->body_html));
            }

            if ($smsTheme !== null) {
                $data['sms_template'] = $this->convertPlaceholders($this->decodeRichText((string) $smsTheme->body));

                // Difetto 9 punto 5 (quaeris-send-invite-migrate-to-record-notification.md):
                // rinviato inizialmente per decisione dell'utente ("i mittenti li
                // imposta l'utente a mano via il form Inviti") — ripreso il
                // 2026-09-17 in vista del go-live: 76 righe su 81 di notify_themes
                // hanno un mittente reale configurato (es. "Gaia SpA"), senza
                // copiarlo ogni SMS partirebbe con il mittente di default
                // dell'account del gateway invece del nome dell'azienda/persona
                // già usato nel vecchio sistema.
                if (! empty($smsTheme->from)) {
                    $data['sms_from'] = $smsTheme->from;
                }
            }

            $this->line(
                ($dryRun ? '[DRY-RUN] ' : '').
                "slug={$slug} email=".($emailTheme !== null ? 'si' : 'no').
                ' sms='.($smsTheme !== null ? 'si' : 'no')
            );

            if (! $dryRun) {
                // Spatie\Sluggable\HasSlug rigenera lo slug dal subject ad ogni
                // salvataggio (create E update: MailTemplate::getSlugOptions() non
                // ha preventOverwrite(), quindi shouldSkipGeneration() ritorna
                // sempre false) — senza sopprimere gli eventi qui, lo slug che
                // scegliamo sopra verrebbe silenziosamente sovrascritto (o, per i
                // template senza subject, ridotto a un contatore tipo "-1", "-2").
                MailTemplate::withoutEvents(static function () use ($slug, $data): void {
                    MailTemplate::query()->updateOrCreate(
                        ['mailable' => SpatieEmail::class, 'slug' => $slug],
                        $data,
                    );
                });
            }

            $migrated++;
        }

        $this->info("Survey migrati: {$migrated}, saltati (nessun tema reale): {$skipped}.");

        return Command::SUCCESS;
    }

    private function convertPlaceholders(string $content): string
    {
        $converted = preg_replace('/##(\w+)##/', '{{$1}}', $content);

        return is_string($converted) ? $converted : $content;
    }

    /**
     * Tenta di correggere il difetto di doppia codifica preesistente nella
     * sorgente (`notify_themes.body_html`/`.body`, es. `Ã¨` invece di `è`), ma
     * solo se il risultato resta UTF-8 valido — alcuni contenuti mescolano
     * sequenze davvero doppio-codificate con caratteri fuori dal range
     * ISO-8859-1 (virgolette tipografiche, ecc.): su quelli la conversione
     * produce UTF-8 non valido, che poi rompe silenziosamente il JSON scritto
     * da HasTranslations (verificato: `json_encode` fallisce, l'attributo
     * finisce vuoto/falsy, MySQL rifiuta la colonna JSON). Meglio lasciare il
     * difetto cosmetico preesistente che rischiare di perdere il contenuto.
     *
     * NON è la stessa direzione di conversione di
     * `Modules\Notify\Actions\BuildMailMessageAction::decodeRichText()` — quel
     * metodo fa `mb_convert_encoding($decoded, 'UTF-8', 'ISO-8859-1')`, che su
     * questo esatto contenuto peggiora il difetto invece di correggerlo
     * (verificato: produce `ÃÂ¨`, non `è`) — un bug preesistente, segnalato
     * separatamente, non toccato da questa story. La direzione corretta per
     * una stringa PHP già UTF-8 che contiene visivamente il doppio-mojibake è
     * l'inversa: `mb_convert_encoding($decoded, 'ISO-8859-1', 'UTF-8')`.
     */
    private function decodeRichText(string $content): string
    {
        $decoded = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (str_contains($decoded, 'Ã') || str_contains($decoded, 'Â')) {
            $converted = mb_convert_encoding($decoded, 'ISO-8859-1', 'UTF-8');
            if (\is_string($converted) && mb_check_encoding($converted, 'UTF-8')) {
                $decoded = $converted;
            }
        }

        return $decoded;
    }
}
