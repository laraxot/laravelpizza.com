<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\OauthClient;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

return new class extends XotBaseMigration {
    public function up(): void
    {
        $xot = XotData::make();
        $userClass = $xot->getUserClass();
        $this->tableCreate(static function (Blueprint $table) use ($userClass): void {
            $table->string('id', 100)->primary();
            $table->foreignIdFor($userClass, 'user_id')->nullable()->index();
            $table->foreignIdFor(OauthClient::class, 'client_id');
            $table->string('name')->nullable();
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateUser($table);
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
