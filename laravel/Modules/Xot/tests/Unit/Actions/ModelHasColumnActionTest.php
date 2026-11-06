<?php

declare(strict_types=1);

use Modules\Xot\Actions\Model\ModelHasColumnAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/*
 * I componenti riutilizzabili si nascondono da soli dove la colonna non c'e': il controllo non
 * deve mai esplodere quando il componente non e' ancora legato a un model.
 */
test('a missing model or a non model class means no column, not an exception', function (): void {
    $action = app(ModelHasColumnAction::class);

    expect($action->execute(null, 'id'))->toBeFalse()
        ->and($action->execute(stdClass::class, 'id'))->toBeFalse();
});
