<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Models\MailTemplate;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Garantisce il template `reset-password` della mail di reimpostazione password, in tutte le lingue del sito (DCP-285, D-05).
 *
 * Prima `SpatieEmail` lo creava al volo con il corpo di default di registrazione ("in attesa di approvazione"), senza il link e
 * nella sola lingua corrente. Qui si crea se manca e, per ogni lingua, si scrive il testo solo se la lingua e' vuota oppure ha
 * ancora quel default: un testo personalizzato dall'ente non si tocca. I testi sono in `user::reset_password_email`; il motore dei
 * segnaposto resta Mustache (`{{ reset_password_url }}`), nessun Blade::render su stringhe del database.
 */
class EnsureResetPasswordMailTemplateAction
{
    use QueueableAction;

    public const string SLUG = 'reset-password';

    /** Lingue del sito (it, en, de, es), le stesse dei file in `lang/`. */
    private const array LOCALES = ['it', 'en', 'de', 'es'];

    /** Il default di registrazione che SpatieEmail scriveva per qualunque slug. */
    private const string LEGACY_DEFAULT_MARKER = 'in attesa di approvazione';

    private const string URL_PLACEHOLDER = '{{ reset_password_url }}';

    private const string BUTTON_STYLE = 'display:inline-block;padding:12px 24px;background:#007a52;color:#ffffff;text-decoration:none;font-weight:600;border-radius:6px';

    public function execute(): MailTemplate
    {
        $template = MailTemplate::query()->firstOrCreate(
            ['mailable' => SpatieEmail::class, 'slug' => self::SLUG],
            ['html_layout_path' => 'base.html'],
        );

        foreach (self::LOCALES as $locale) {
            if ($this->needsDefault($template, $locale)) {
                $this->writeDefault($template, $locale);
            }
        }

        if ($template->isDirty()) {
            $template->save();
        }

        return $template;
    }

    private function needsDefault(MailTemplate $template, string $locale): bool
    {
        $html = SafeStringCastAction::cast($template->getTranslation('html_template', $locale, false));

        if ($html === '') {
            return true;
        }

        return ! str_contains($html, self::URL_PLACEHOLDER) && str_contains($html, self::LEGACY_DEFAULT_MARKER);
    }

    private function writeDefault(MailTemplate $template, string $locale): void
    {
        $app = SafeStringCastAction::cast(config('app.name'));
        $t = static fn (string $key): string => SafeStringCastAction::cast(__('user::reset_password_email.'.$key, ['app' => $app], $locale));

        $template->setTranslation('subject', $locale, $t('subject'));
        $template->setTranslation('html_template', $locale, '<p>'.e($t('greeting')).'</p><p>'.e($t('intro')).'</p>'
            .'<p><a href="'.self::URL_PLACEHOLDER.'" style="'.self::BUTTON_STYLE.'">'.e($t('action')).'</a></p>'
            .'<p style="font-size:13px;color:#4b5563">'.e($t('fallback')).'<br>'.self::URL_PLACEHOLDER.'</p>'
            .'<p style="font-size:13px;color:#4b5563">'.e($t('ignore')).'</p>');
        $template->setTranslation('text_template', $locale, $t('greeting').' '.$t('intro')."\n\n".self::URL_PLACEHOLDER."\n\n".$t('ignore'));
    }
}
