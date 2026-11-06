<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Infolists\Components\TextEntry;

/**
 * Classe base per i blocchi di sola lettura dentro un form.
 *
 * Sostituisce `XotBasePlaceholder`, che estendeva `Filament\Forms\Components\Placeholder`,
 * deprecata in Filament 5 in favore di `TextEntry` con il metodo `state()`. Il nome
 * cambia insieme alla classe base: una classe chiamata «Placeholder» che estende
 * `TextEntry` direbbe il contrario di quello che fa.
 *
 * Differenza di API per chi migra: `->content($x)` diventa `->state($x)`, e per un
 * contenuto HTML serve `->html()`, che `Placeholder` faceva implicitamente accettando
 * un `HtmlString`.
 *
 * @method static static make(string $name)
 */
class XotBaseTextEntry extends TextEntry
{
    // Logica comune futura per i blocchi di sola lettura Xot
}
