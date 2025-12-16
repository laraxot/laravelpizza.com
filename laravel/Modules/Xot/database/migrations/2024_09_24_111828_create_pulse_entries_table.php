<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! $this->shouldRun()) {
            return;
        }
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('timestamp');
            $table->string('type');
            $table->mediumText('key');
            match ($this->driver()) {
                'mariadb', 'mysql' => $table->char('key_hash', 16)->charset('binary')->virtualAs('unhex(md5(`key`))'),
                'pgsql' => $table->uuid('key_hash')->storedAs('md5("key")::uuid'),
                'sqlite' => $table->string('key_hash'),
                default => throw new InvalidArgumentException('Unsupported driver: '.$this->driver()),
            };
            $table->bigInteger('value')->nullable();

            $table->index('timestamp'); // For trimming...
            $table->index('type'); // For purging...
            $table->index('key_hash'); // For mapping...
            $table->index(['timestamp', 'type', 'key_hash', 'value']); // For aggregate queries...
        });
    }
};
