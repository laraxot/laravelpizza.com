<?php

declare(strict_types=1);

namespace Modules\Lang\Datas;

use Modules\Lang\Actions\ResolveDefaultTranslatableLocaleAction;
use Modules\Lang\Actions\ResolveTranslatableLocalesAction;
use Modules\Lang\Filament\Pages\SettingPage;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Lang del tenant corrente: in che lingue si modificano le traduzioni.
 *
 * Le lingue erano scritte a mano in quattro punti dell'editor dei file di traduzione
 * (`TranslationFileResource`, `LangBaseResource`, `EditTranslationFile`, `LocaleSwitcherRefresh`),
 * sempre `['it', 'en']`. Ora le leggono da qui tramite `ResolveTranslatableLocalesAction`.
 *
 * Non governa le lingue del sito: quelle sono `laravellocalization.supportedLocales` e
 * `app.locale`, lette da mcamara e dalle rotte di Cms. Le chiavi `default_locale` e
 * `available_locales` di `Modules/Lang/config/lang.php` non le leggeva nessuno e sono state tolte.
 *
 * @see SettingPage
 * @see ResolveTranslatableLocalesAction
 * @see ResolveDefaultTranslatableLocaleAction
 */
class LangConfigData extends Data
{
    use MakesFromTenantConfig;

    /** Lingua con cui si apre l'editor; `null`: quella dell'applicazione (`app.locale`). */
    public ?string $default_locale = null;

    /**
     * Lingue offerte dall'editor delle traduzioni.
     *
     * @var list<string>
     */
    public array $supported_locales = ['it', 'en'];
}
