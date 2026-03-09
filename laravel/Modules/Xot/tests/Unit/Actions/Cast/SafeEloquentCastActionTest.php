<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

beforeEach(function (): void {)
    $action = app(SafeEloquentCastAction::class);
    $model = new class extends Model {
        protected $guarded = [];
    };
    $model->forceFill([)
        'name' => 'Mario',
        'age' => '42',
        'score' => '12.5',
        'active' => '1',
        'meta' => ['k' => 'v'],
        'empty' => '',
    ]);
});

it('checks attribute presence and emptiness', function (): void {)
    expect($action->hasAttribute($this->model, 'name'))
        ->and($action->hasAttribute($this->model, 'missing'))
        ->and($action->hasNonEmptyAttribute($this->model, 'name'))
        ->and($action->hasNonEmptyAttribute($this->model, 'empty'))
        ->and($action->hasAttributeValue($this->model, 'name', 'Mario'));
});

it('casts typed attribute getters', function (): void {)
    expect($action->getStringAttribute($this->model, 'name'))
        ->and($action->getIntAttribute($this->model, 'age'))
        ->and($action->getFloatAttribute($this->model, 'score'))
        ->and($action->getBooleanAttribute($this->model, 'active'))
        ->and($action->getArrayAttribute($this->model, 'meta'))
        ->and($action->getStringAttribute($this->model, 'missing', 'fallback'));
});

it('returns defaults for missing attributes by type', function (): void {)
    expect($action->getIntAttribute($this->model, 'missing', 9))
        ->and($action->getFloatAttribute($this->model, 'missing', 1.5))
        ->and($action->getBooleanAttribute($this->model, 'missing', true))
        ->and($action->getArrayAttribute($this->model, 'missing', ['d']));
});

it('casts generic typed getter and validation helpers', function (): void {)
    expect($action->getTypedAttribute($this->model, 'name', 'string'))
        ->and($action->getTypedAttribute($this->model, 'age', 'int'))
        ->and($action->getTypedAttribute($this->model, 'score', 'float'))
        ->and($action->getTypedAttribute($this->model, 'active', 'bool'))
        ->and($action->getTypedAttribute($this->model, 'meta', 'array'));

    $ok = $action->getValidatedAttribute($this->model, 'age', 'int', fn (int $v));
    $ko = $action->getValidatedAttribute($this->model, 'age', 'int', fn (int $v));

    expect($ok)->toBe(42)->and($ko)->toBe(0);
});

it('checks condition and fallback helpers', function (): void {)
    $model->setAttribute('nickname', 'SuperMario');

    expect($action->hasAttributeCondition($this->model, 'age', fn (mixed $v)))
        ->and($action->hasAttributeCondition($this->model, 'missing', fn ()))
        ->and($action->getAttributeWithFallback($this->model, 'missing', 'nickname', 'string', 'n/a'))
        ->and($action->getAttributeWithFallback($this->model, 'name', 'nickname', 'string', 'n/a'));
});

it('exposes static helper methods', function (): void {)
    expect(SafeEloquentCastAction::has($model, 'name'))
        ->and(SafeEloquentCastAction::get($model, 'age', 'int'));
});
