<?php

/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;

trait SushiToPhpArray
{
    use Sushi;

    public function getSushiRows(): array
    {
        $name = Str::of($this->getTable())->replace('_', '-')->toString();

        $rows = TenantService::getConfig($name);

        return array_values($rows);

        /*
         * $files = File::glob($path.'/*.json');
         * $rows = [];
         * foreach ($files as $id => $file) {
         * $json = File::json($file);
         * $item = [];
         * foreach ($this->schema as $name => $type) {
         * $value = $json[$name] ?? null;
         * if (is_array($value)) {
         * $value = json_encode($value, JSON_PRETTY_PRINT);
         * }
         * $item[$name] = $value;
         * }
         * $rows[] = $item;
         * }
         *
         * return $rows;
         */
    }

    /**
     * bootUpdater function.
     */
    protected static function bootSushiToPhpArray(): void
    {
        /*
         * During a model create Eloquent will also update the updated_at field so
         * need to have the updated_by field here as well.
         */
        static::creating(function ($model): void {
            // Type safety for $model in closure
            if (! $model instanceof Model) {
                return;
            }

            // Model always has toArray()
            $model->toArray();
        });
        /*
         * updating.
         */
        static::updating(function ($model): void {
            // Type safety for $model in closure
            if (! $model instanceof Model) {
                return;
            }

            // Model always has toArray()
            $model->toArray();
        });
        // -------------------------------------------------------------------------------------
        /*
         * Deleting a model is slightly different than creating or deleting.
         * For deletes we need to save the model first with the deleted_by field
         */

        static::deleting(function ($model): void {
            // Type safety for $model in closure
            if (! $model instanceof Model) {
                return;
            }

        });

        // ----------------------
    }

    // end function boot
}

// end trait Updater
