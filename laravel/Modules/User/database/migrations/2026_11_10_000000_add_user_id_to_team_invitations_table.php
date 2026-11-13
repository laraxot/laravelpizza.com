<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\TeamInvitation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * TeamInvitation dichiara `user_id` (chi ha invitato) fra i fillable e nel docblock, ma
 * la migration di creazione non ha mai avuto la colonna: ogni invito salvato con
 * l'invitante falliva con "Unknown column 'user_id'". Additiva e idempotente.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = TeamInvitation::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('user_id')) {
                $table->uuid('user_id')->nullable()->index();
            }
        });
    }
};
