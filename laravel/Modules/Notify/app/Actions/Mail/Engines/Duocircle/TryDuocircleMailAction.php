<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Mail\Engines\Duocircle;

use Exception;
use ReflectionMethod;
use Spatie\QueueableAction\QueueableAction;
use UnexpectedValueException;

class TryDuocircleMailAction
{
    use QueueableAction;

    public ?string $from = null;

    public string $to = '';

    public ?string $body = null;

    /** @var array<string, mixed> */
    public array $vars = [];

    /**
     * @param  array<string, mixed>  $vars
     * @return array<int, array{subject: string, attachments: int, body: string, moved: bool}>
     *
     * @throws Exception
     */
    public function execute(array $vars = []): array
    {
        foreach ($vars as $key => $value) {
            if (is_string($key)) {
                $this->{$key} = $value;
            }
        }
        $this->vars = array_merge($this->vars, $vars);

        $clientClass = 'Webklex\PHPIMAP\Client';
        $facadeClass = 'Webklex\IMAP\Facades\Client';
        if (! class_exists($clientClass) || ! class_exists($facadeClass)) {
            throw new Exception('Webklex PHPIMAP is not installed');
        }

        $client = $this->invoke($facadeClass, 'account', 'default');
        if (! is_object($client)) {
            throw new UnexpectedValueException('Webklex account() must return a client object');
        }

        $this->invoke($client, 'connect');
        $folders = $this->invoke($client, 'getFolders');
        if (! is_iterable($folders)) {
            throw new UnexpectedValueException('Webklex getFolders() must return an iterable');
        }

        $result = [];
        foreach ($folders as $folder) {
            if (! is_object($folder)) {
                throw new UnexpectedValueException('Webklex folder must be an object');
            }
            $query = $this->invoke($folder, 'messages');
            if (! is_object($query)) {
                throw new UnexpectedValueException('Webklex messages() must return a query object');
            }
            $all = $this->invoke($query, 'all');
            if (! is_object($all)) {
                throw new UnexpectedValueException('Webklex all() must return a query object');
            }
            $messages = $this->invoke($all, 'get');
            if (! is_iterable($messages)) {
                throw new UnexpectedValueException('Webklex get() must return an iterable');
            }

            foreach ($messages as $message) {
                if (! is_object($message)) {
                    throw new UnexpectedValueException('Webklex message must be an object');
                }
                $subject = $this->invoke($message, 'getSubject');
                $attachments = $this->invoke($message, 'getAttachments');
                $body = $this->invoke($message, 'getHTMLBody');
                if (! is_countable($attachments)) {
                    throw new UnexpectedValueException('Webklex attachments must be countable');
                }
                $result[] = [
                    'subject' => is_scalar($subject) ? (string) $subject : '',
                    'attachments' => count($attachments),
                    'body' => is_scalar($body) ? (string) $body : '',
                    'moved' => (bool) $this->invoke($message, 'move', 'INBOX.read')];
            }
        }

        return $result;
    }

    /**
     * Invoker via reflection verso la libreria Webklex: `mixed ...$arguments` e
     * ritorno `mixed` sono voluti — la libreria non dichiara tipi.
     */
    private function invoke(object|string $target, string $method, mixed ...$arguments): mixed
    {
        $reflection = new ReflectionMethod($target, $method);

        return $reflection->invokeArgs(is_object($target) ? $target : null, $arguments);
    }
}
