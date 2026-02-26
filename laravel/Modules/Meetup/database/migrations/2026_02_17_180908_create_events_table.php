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
        $this->tableUpdate(function (Blueprint $table) {
            if (! $this->hasColumn('slug')) {
                $table->string('slug')->unique()->nullable()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->tableUpdate(function (Blueprint $table) {
            if ($this->hasColumn('slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};
