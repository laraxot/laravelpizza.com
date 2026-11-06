<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\States\Transitions\XotBaseTransition;

/**
 * Coppia record + transizione concreta, per i test di XotBaseTransition.
 *
 * Prima era la funzione globale `xotBaseTransitionFixture()` in
 * `tests/Support/helpers.php`. Vedi {@see SafeEloquentCastFixture} per il
 * motivo dello spostamento.
 */
final class XotBaseTransitionFixture
{
    /**
     * @return array{0: Model, 1: XotBaseTransition}
     */
    public static function make(): array
    {
        $record = new class extends Model
        {
            /** @var string */
            protected $table = 'xot_transition_test';
        };

        $transition = new class($record) extends XotBaseTransition
        {
            public static string $name = 'test_transition';
        };

        return [$record, $transition];
    }
}
