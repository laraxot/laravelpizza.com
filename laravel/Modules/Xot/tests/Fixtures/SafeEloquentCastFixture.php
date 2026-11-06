<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

/**
 * Coppia action + model gia' popolata, per i test di SafeEloquentCastAction.
 *
 * Prima viveva come funzione globale in `tests/Support/helpers.php`, caricata
 * via `autoload-dev.files`. La cartella `tests/Support/` non esiste piu': i
 * fixture stanno in `tests/Fixtures/`, dove il PSR-4 li risolve da solo.
 */
final class SafeEloquentCastFixture
{
    /**
     * @return array{0: SafeEloquentCastAction, 1: Model}
     */
    public static function make(): array
    {
        $action = app(SafeEloquentCastAction::class);

        $model = new class extends Model
        {
            /** @var string */
            protected $table = 'safe_eloquent_cast_test';

            /** @var list<string> */
            protected $fillable = ['name', 'age', 'score', 'active', 'meta', 'empty', 'nickname'];

            /**
             * @return array<string, string>
             */
            protected function casts(): array
            {
                return ['meta' => 'array'];
            }
        };

        $model->setAttribute('name', 'Mario');
        $model->setAttribute('age', 42);
        $model->setAttribute('score', 12.5);
        $model->setAttribute('active', true);
        $model->setAttribute('meta', ['k' => 'v']);
        $model->setAttribute('empty', '');

        return [$action, $model];
    }
}
