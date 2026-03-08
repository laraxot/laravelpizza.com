<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\Traits\HasContact;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

class HasContactDummyModel extends Model
{
    use HasContact;

    protected $table = 'notify_has_contact_dummy';

    protected $fillable = [];

    public function initContactTrait(): void
    {
        // @var mixed initializeHasContact(;
    }
}

test('has contact trait appends contact type fields to fillable', function () {
    $model = new HasContactDummyModel();
    $model->initContactTrait();

    expect($model->getFillable())->toContain('phone')
        ->and($model->getFillable())->toContain('mobile')
        ->and($model->getFillable())->toContain('email')
        ->and($model->getFillable())->toContain('pec')
        ->and($model->getFillable())->toContain('whatsapp')
        ->and($model->getFillable())->toContain('fax');
});
