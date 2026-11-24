<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Facades\Config;
use Spatie\QueueableAction\QueueableAction;

/**
 * Class ThemeAction
 * Gestisce il tema dell'applicazione.
<<<<<<< .merge_file_bnz80M
 *
 * @see docs/contracts/theme-action.md
 *
=======
 * @see docs/contracts/theme-action.md
>>>>>>> .merge_file_Y63f2t
 * @contract docs/contracts/theme-action.md
 */
class ThemeAction
{
    use QueueableAction;

    /**
     * Nome del tema corrente.
     */
    private static string $currentTheme = 'default';

    /**
     * Imposta il tema corrente.
     */
    public static function setTheme(string $theme): void
    {
        self::$currentTheme = $theme;
        Config::set('theme.active', $theme);
    }

    /**
     * Recupera il tema corrente.
     */
    public static function getTheme(): string
    {
        return self::$currentTheme;
    }

    /**
     * Verifica se un tema specifico è attivo.
     */
    public static function isTheme(string $theme): bool
    {
        return self::$currentTheme === $theme;
    }

    /**
     * Recupera il percorso delle risorse del tema.
     */
    public static function getThemePath(): string
    {
        return resource_path('themes/'.self::$currentTheme);
    }

    public function execute(): void {}
}
