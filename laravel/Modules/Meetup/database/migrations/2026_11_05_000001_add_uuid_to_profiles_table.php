<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Profile;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * BaseProfile::booted() valorizza sempre `uuid` alla creazione, ma la tabella profiles
 * del modulo Meetup non aveva la colonna: ogni accesso al pannello Meetup andava in 500
 * ("Unknown column 'uuid'") al primo profilo creato.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Profile::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('uuid')) {
                $table->string('uuid', 36)->nullable()->index()->after('id');
            }
        });
    }
};
