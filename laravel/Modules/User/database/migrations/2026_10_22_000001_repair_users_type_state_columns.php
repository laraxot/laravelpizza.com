<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\User;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = User::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('type')) {
                $table->string('type')->index()->nullable();
            }

            if (! $this->hasColumn('state')) {
                $table->string('state')->index()->nullable();
            }
        });
    }
};
