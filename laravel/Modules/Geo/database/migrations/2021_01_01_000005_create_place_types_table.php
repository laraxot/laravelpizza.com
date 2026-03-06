<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $blueprint): void {
            $blueprint->increments('id');
            $blueprint->string('name')->index();
            $blueprint->text('description')->nullable();
            $blueprint->timestamps();
        });
    }
};
