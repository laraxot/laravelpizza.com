<?php

declare(strict_types=1);
/**
 * @see https://smsvi-docs.web.app/docs/restful/send-batch/
 */

namespace Modules\Notify\Actions\Mail\Engines\Duocircle;

use RuntimeException;
use Spatie\QueueableAction\QueueableAction;

/**
 * Invia email tramite engine Duocircle (WIP).
 */
class SendDuocircleMailAction
{
    use QueueableAction;

    public ?string $from = null;

    public string $to = '';

    public ?string $body = null;

    /**
     * @var array<string, mixed>
     */
    public array $vars = [];

    /**
     * @param  array<string, mixed>  $vars
     *
     * @throws RuntimeException
     */
    public function execute(array $vars = []): void
    {
        foreach ($vars as $key => $value) {
            if (\is_string($key)) {
                $this->{$key} = $value;
            }
        }

        $this->vars = array_merge($this->vars, $vars);

        throw new RuntimeException('WIP ['.__LINE__.']['.self::class.']');
    }
}
