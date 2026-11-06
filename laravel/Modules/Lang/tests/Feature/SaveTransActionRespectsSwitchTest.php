<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Config;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Tests\TestCase;

use function Safe\file_get_contents;

uses(TestCase::class);

/*
 * `AutoLabelAction` chiama `SaveTransAction` ogni volta che una chiave manca, e la
 * suite passa su migliaia di etichette: senza interruttore i test riscrivono i file
 * di lingua dell'albero di lavoro e lasciano in `git status` modifiche che nessuno
 * ha fatto a mano. E' gia' successo due volte.
 *
 * Il valore di test arriva da phpunit.xml (LANG_SAVE_MISSING_TRANSLATIONS=false).
 */
it('non scrive niente quando la scrittura delle chiavi mancanti e spenta', function (): void {
    Config::set('lang.save_missing_translations', false);

    $target = base_path('Modules/Lang/lang/it/lang.php');
    $before = is_file($target) ? file_get_contents($target) : null;

    app(SaveTransAction::class)->execute('lang::lang.chiave_che_non_esiste.label', 'valore');

    $after = is_file($target) ? file_get_contents($target) : null;

    expect($after)->toBe($before);
});

it('sotto test non scrive nemmeno senza configurazione esplicita', function (): void {
    // Il caso che conta: nessuno ha impostato niente, e la suite non deve comunque
    // toccare l'albero. E' lo scenario in cui il difetto e' gia' tornato due volte.
    Config::offsetUnset('lang.save_missing_translations');

    $target = base_path('Modules/Lang/lang/it/lang.php');
    $before = is_file($target) ? file_get_contents($target) : null;

    app(SaveTransAction::class)->execute('lang::lang.altra_chiave_assente.label', 'valore');

    expect(is_file($target) ? file_get_contents($target) : null)->toBe($before);
});
