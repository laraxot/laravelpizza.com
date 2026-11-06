<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Mail;

use Illuminate\Support\Str;
use RuntimeException;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Prova a recuperare email tramite l'engine configurato (IMAP / try).
 */
class TryMailAction
{
    use QueueableAction;

    public ?string $from = null;

    public string $to = '';

    public string $driver = 'duocircle';

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
    public function execute(string $to = '', ?string $body = null, array $vars = [], ?string $from = null, string $driver = 'duocircle'): void
    {
        $this->to = $to;
        $this->body = $body;
        $this->from = $from;
        $this->driver = $driver;

        foreach ($vars as $key => $value) {
            if (\is_string($key)) {
                $this->{$key} = $value;
            }
        }

        $this->vars = array_merge($this->vars, $vars);

        $engineClass = '\\Modules\\Notify\\Actions\\Mail\\Engines\\'.Str::studly($this->driver).'\\Try'.Str::studly($this->driver).'MailAction';
        Assert::classExists($engineClass, '['.__LINE__.']['.self::class.'] engine non trovato: '.$this->driver);

        $engine = app($engineClass);
        $execute = [$engine, 'execute'];
        if (! is_callable($execute)) {
            throw new RuntimeException(sprintf('Engine [%s] privo di execute().', $engineClass));
        }

        $execute($this->vars);
    }
}
