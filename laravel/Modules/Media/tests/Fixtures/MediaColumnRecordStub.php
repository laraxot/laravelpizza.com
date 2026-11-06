<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * Record con capacita media. Non viene mai salvato ne interrogato.
 */
class MediaColumnRecordStub extends Model
{
    public ?object $fakeMedia = null;

    /**
     * La firma replica quella di Spatie: le closure della colonna passano il nome
     * della collection, questo doppio restituisce sempre lo stesso media.
     */
    public function getFirstMedia(string $collection = 'default'): ?object
    {
        unset($collection);

        return $this->fakeMedia;
    }
}
