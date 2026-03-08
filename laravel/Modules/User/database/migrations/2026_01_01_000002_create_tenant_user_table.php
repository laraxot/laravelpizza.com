<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

<<<<<<< HEAD
use function Safe\file_put_contents;

||||||| 6161e129d
use function Safe\file_put_contents;

return new class extends XotBaseMigration
{
=======
>>>>>>> feature/ralph-loop-implementation
return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table
            // $table->uuid('id')->primary();
            $table->id();
            $table->foreignId('tenant_id');
            $table->uuid('user_id')->nullable()->index();

            // $table->foreignIdFor(\Modules\Xot\Datas\XotData::make()->getUserClass());
            // $table->string('role')->nullable();
            // $table->unique(['team_id', 'user_id']);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
