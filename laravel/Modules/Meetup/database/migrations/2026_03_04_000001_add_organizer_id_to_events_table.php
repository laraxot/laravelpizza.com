<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Event;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Event::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // user_id va creato (o convertito) prima di organizer_id, che viene posizionato dopo user_id:
        // su un database nuovo la tabella events non ha ancora user_id.
        $this->tableUpdate(function (Blueprint $table) {
            if ($this->hasColumn('user_id')) {
                if ($this->getColumnType('user_id') === 'bigint') {
                    $table->string('user_id', 36)->index()->nullable()->change();
                }
            } else {
                $table->string('user_id', 36)->index()->nullable()->after('id');
            }
        });

        $this->tableUpdate(function (Blueprint $table) {
            if (! $this->hasColumn('organizer_id')) {
                $table->string('organizer_id', 36)->nullable()->index()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->tableUpdate(function (Blueprint $table) {
            if ($this->hasColumn('organizer_id')) {
                $table->dropColumn('organizer_id');
            }
        });
    }
};
