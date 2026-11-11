<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\EventUser;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Promemoria del giorno prima (SendEventRemindersAction): quando e' stato inviato, per non mandarlo due volte.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = EventUser::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('reminder_sent_at')) {
                $table->timestamp('reminder_sent_at')->nullable()->after('registered_at');
            }
        });
    }
};
