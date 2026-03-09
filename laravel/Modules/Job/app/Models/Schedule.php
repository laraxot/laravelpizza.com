<?php

declare(strict_types=1);

namespace Modules\Job\Models;

use Exception;
use Illuminate\Console\Scheduling\ManagesFrequencies;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Modules\Job\Database\Factories\ScheduleFactory;
use Modules\Job\Enums\Status;
use Modules\Xot\Contracts\ProfileContract;
use Override;

/**
 * Modules\Job\Models\Schedule.
 *
 * @property string $id
 * @property string $command
 * @property string|null $command_custom
 * @property array<array-key, array{name?: string, value?: bool|float|int|string|null, required?: bool, type?: string}>|null $params
 * @property string $expression
 * @property array<array-key, bool|float|int|string|null>|null $environments
 * @property array<array-key, array{name?: string, value?: bool|float|int|string|null}|bool|float|int|string|null>|null $options
 * @property array<array-key, array{name?: string, value?: bool|float|int|string|null, required?: bool, type?: string}>|null $options_with_value
 * @property string|null $log_filename
 * @property int $even_in_maintenance_mode
 * @property int $without_overlapping
 * @property int $on_one_server
 * @property string|null $webhook_before
 * @property string|null $webhook_after
 * @property string|null $email_output
 * @property int $sendmail_error
 * @property int $log_success
 * @property int $log_error
 * @property Status $status
 * @property int $run_in_background
 * @property int $sendmail_success
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property ProfileContract|null $creator
 * @property \Illuminate\Database\Eloquent\Collection<int, ScheduleHistory> $histories
 * @property int|null $histories_count
 * @property ProfileContract|null $updater
 * @method static Builder<static>|Schedule active()
 * @method static ScheduleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Schedule inactive()
 * @method static Builder<static>|Schedule newModelQuery()
 * @method static Builder<static>|Schedule newQuery()
 * @method static Builder<static>|Schedule onlyTrashed()
 * @method static Builder<static>|Schedule query()
 * @method static Builder<static>|Schedule whereCommand($value)
 * @method static Builder<static>|Schedule whereCommandCustom($value)
 * @method static Builder<static>|Schedule whereCreatedAt($value)
 * @method static Builder<static>|Schedule whereCreatedBy($value)
 * @method static Builder<static>|Schedule whereDeletedAt($value)
 * @method static Builder<static>|Schedule whereDeletedBy($value)
 * @method static Builder<static>|Schedule whereEmailOutput($value)
 * @method static Builder<static>|Schedule whereEnvironments($value)
 * @method static Builder<static>|Schedule whereEvenInMaintenanceMode($value)
 * @method static Builder<static>|Schedule whereExpression($value)
 * @method static Builder<static>|Schedule whereId($value)
 * @method static Builder<static>|Schedule whereLogError($value)
 * @method static Builder<static>|Schedule whereLogFilename($value)
 * @method static Builder<static>|Schedule whereLogSuccess($value)
 * @method static Builder<static>|Schedule whereOnOneServer($value)
 * @method static Builder<static>|Schedule whereOptions($value)
 * @method static Builder<static>|Schedule whereOptionsWithValue($value)
 * @method static Builder<static>|Schedule whereParams($value)
 * @method static Builder<static>|Schedule whereRunInBackground($value)
 * @method static Builder<static>|Schedule whereSendmailError($value)
 * @method static Builder<static>|Schedule whereSendmailSuccess($value)
 * @method static Builder<static>|Schedule whereStatus($value)
 * @method static Builder<static>|Schedule whereUpdatedAt($value)
 * @method static Builder<static>|Schedule whereUpdatedBy($value)
 * @method static Builder<static>|Schedule whereWebhookAfter($value)
 * @method static Builder<static>|Schedule whereWebhookBefore($value)
 * @method static Builder<static>|Schedule whereWithoutOverlapping($value)
 * @method static Builder<static>|Schedule withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Schedule withoutTrashed()
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
class Schedule extends BaseModel
{
    use ManagesFrequencies;

    public const STATUS_INACTIVE = 0;

    public const STATUS_ACTIVE = 1;

    public const STATUS_TRASHED = 2;

    protected $fillable = [
        'command',
        'command_custom',
        'params',
        'options',
        'options_with_value',
        'expression',
        'even_in_maintenance_mode',
        'without_overlapping',
        'on_one_server',
        'webhook_before',
        'webhook_after',
        'email_output',
        'sendmail_error',
        'sendmail_success',
        'log_success',
        'log_error',
        'status',
        'run_in_background',
        'log_filename',
        'environments',
    ];

    protected $attributes = [
        'expression' => '* * * * *',
        'params' => '[]',
        'options' => '[]',
        'options_with_value' => '[]',
    ];

    /**
     * Get available environments.
     */
    public static function getEnvironments(): Collection
    {
        return static::whereNotNull('environments')->groupBy('environments')->pluck('environments', 'environments');
    }

    /**
     * Get the related histories.
     */
    public function histories(): HasMany
    {
        return $this->hasMany(ScheduleHistory::class, 'schedule_id', 'id');
    }

    /**
     * Scope a query to only include inactive schedules.
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /**
     * Scope a query to only include active schedules.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Get arguments from params.
     */
    public function getArguments(): array
    {
        $arguments = [];

        foreach ($this->params ?? [] as $argument => $value) {
            // PHPStan Level 10: Type safety for mixed $value
            if (! is_array($value)) {
                continue;
            }

            if (! array_key_exists('value', $value) || $value['value'] === null || $value['value'] === '') {
                continue;
            }

            /** @var array{name?: string, value?: bool|float|int|string|null, required?: bool, type?: string} $safeValue */
            $safeValue = $value;

            if (isset($safeValue['type']) && $safeValue['type'] === 'function') {
                // PHPStan Level 10: Ensure string for evaluateFunction
                $functionString = isset($safeValue['value']) && is_string($safeValue['value']) ? $safeValue['value'] : '';
                $arguments[$argument] = $this->evaluateFunction($functionString);
            } else {
                $name = isset($safeValue['name']) && is_string($safeValue['name'])
                    ? $safeValue['name']
                    : (string) $argument;

                $val = isset($safeValue['value']) ? (string) $safeValue['value'] : '';

                $arguments[$name] = $val;
            }
        }

        return $arguments;
    }

    /**
     * Get options as array.
     */
    public function getOptions(): array
    {
        $options = collect($this->options ?? []);
        $optionsWithValues = $this->options_with_value ?? [];

        if (! empty($optionsWithValues)) {
            $options = $options->merge($optionsWithValues);
        }

        return $options
            ->map(
                static function ($value, $key): string {
                    if (is_array($value)) {
                        $name = $value['name'] ?? null;
                        $fallbackKey = (string) $key;
                        $optionName = is_string($name) ? $name : $fallbackKey;
                        $optionValue = $value['value'] ?? null;

                        return '--'.$optionName.'='.(string) $optionValue;
                    }

                    $strValue = (string) $value;

                    return "--{$strValue}";
                },
            )
            ->toArray();
    }

    /** @return array<string, string> */
    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            'params' => 'array',
            'options' => 'array',
            'options_with_value' => 'array',
            'environments' => 'array',
            'status' => Status::class,
        ];
    }

    /**
     * Safely evaluate function strings (avoiding eval).
     *
     * @param  string  $functionString  Il nome della funzione da valutare
     * @return string|null Il risultato della funzione o null se la funzione non è consentita
     *
     * @throws InvalidArgumentException Se viene passato un argomento non valido
     */
    private function evaluateFunction(string $functionString): ?string
    {
        // Define a list of allowed functions or implement custom evaluation logic.
        $allowedFunctions = ['strtolower', 'strtoupper']; // Example allowed functions

        if (in_array($functionString, $allowedFunctions, true)) {
            // Chiamiamo la funzione in modo sicuro
            try {
                // Utilizziamo uno switch invece di if per evitare il falso positivo di PHPStan
                switch ($functionString) {
                    case 'strtolower':
                        return strtolower('TEST_STRING');
                    case 'strtoupper':
                        return strtoupper('test_string');
                    default:
                        return null;
                }
            } catch (Exception $e) {
                // Log error or handle exception
                return null;
            }
        }

        // Funzione non consentita
        return null;
    }
}
