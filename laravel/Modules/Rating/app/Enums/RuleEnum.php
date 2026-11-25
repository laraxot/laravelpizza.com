<?php

declare(strict_types=1);

namespace Modules\Rating\Enums;

use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Regole di validazione applicabili al voto di un criterio.
 *
 * Il valore di ogni caso e' la stringa di regole Laravel, applicata da
 * `CompilaIndennitaResponsabilita` con `->rules((string) $rating->rule->value)`, ed e'
 * anche la chiave di traduzione letta da {@see EnumTrait::getLabel()}
 * (`rating::rule_enum.values.<valore>.label`): un caso senza la sua voce in
 * `lang/it/rule_enum.php` mostra la chiave grezza a schermo, senza errore.
 *
 * I tre tetti `max:4`, `max:5` e `max:6` non sono un'enumerazione di comodo: sono i
 * punteggi massimi che il CCI 2026-2028 assegna ai cinque criteri dell'art. 17 comma 6
 * (5, 6, 4, 4, 6 — somma 25). Un contratto successivo puo' cambiarli: se i tetti diventano
 * piu' di questi, il posto giusto non e' un caso in piu' qui ma un dato del criterio.
 *
 * @see ../../../IndennitaResponsabilita/docs/stories/8.22.ruleenum-zerosix-zerofour-per-art-17.story.md
 * @see ../../docs/stories/8.17.tetto-criterio-come-dato-non-enum.story.md
 */
enum RuleEnum: string implements HasLabel
{
    use EnumTrait;

    case Null = '';
    case ZeroFour = 'numeric|min:0|max:4';
    case ZeroFive = 'numeric|min:0|max:5';
    case ZeroSix = 'numeric|min:0|max:6';
    case ZeroOrMin4Max25 = 'min:0|max:25|not_in:1,2,3';
    case NullableNumericMin0Max25 = 'nullable|numeric|min:0|max:25';
}
