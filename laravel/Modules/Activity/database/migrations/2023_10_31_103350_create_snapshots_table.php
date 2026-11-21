<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('aggregate_uuid');
                $table->unsignedInteger('aggregate_version');
                $table->jsonb('state');
                $table->index('aggregate_uuid');
            },
        );

        $this->tableUpdate(
            function (Blueprint $table) {
                $this->updateTimestamps($table, false);
            },
        );
    }
};
