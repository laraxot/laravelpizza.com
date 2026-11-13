<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Translation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Translation::class;

    public function up(): void
    {
        // Stessa correzione di posts.user_id: la colonna era bigint e non puo'
        // contenere gli UUID di Modules\User\Models\User. Convertita solo se
        // esistente e ancora bigint.
        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->hasColumn('user_id') && $this->getColumnType('user_id') === 'bigint') {
                $table->uuid('user_id')->nullable()->change();
            }
        });
    }
};
