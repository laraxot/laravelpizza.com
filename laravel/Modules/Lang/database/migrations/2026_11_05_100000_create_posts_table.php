<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Post;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Canonical owner migration for the Post model.
 *
 * Existing numeric user_id values are preserved as strings; an explicit
 * mapping is still required before those legacy rows can resolve to UUID users.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Post::class;

    public function up(): void
    {
        if (! $this->tableExists()) {
            return;
        }

        $this->tableUpdate(function (Blueprint $table): void {
            $this->convertUserIdToUuidIfLegacyBigint(
                table: $table,
                preserveLegacyValues: true,
            );
        });
    }
};
