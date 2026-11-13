<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Post;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Post::class;

    public function up(): void
    {
        // `user_id` nasce bigint con lo scaffold iniziale, ma gli id di
        // Modules\User\Models\User sono UUID (HasUuids): ogni insert con un
        // utente reale fallisce con "Incorrect integer value". Stessa
        // conversione che XotBaseMigration::updateUserKeyString applica al
        // resto della piattaforma. Si converte solo se la colonna esiste ed e'
        // ancora bigint: gli ambienti gia' corretti non vengono toccati.
        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->hasColumn('user_id') && $this->getColumnType('user_id') === 'bigint') {
                $table->uuid('user_id')->nullable()->change();
            }
        });
    }
};
