<?php

declare(strict_types=1);

namespace Modules\User\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Team;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Team::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('owner_id')) {
                $table->uuid('owner_id')->nullable()->after('id');
            }
        });
    }
};
