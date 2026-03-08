<?php

declare(strict_types=1);

namespace Modules\Xot\Exceptions\Formatters;

use Illuminate\Support\Facades\Auth;

class WebhookErrorFormatter
{
    public function __construct(
        private \Throwable $exception,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function format(): array
    {
        $user = Auth::user();
        $email = $user->email ?? 'CLI User';

        return [
            'message' => $exception->getMessage(
            'file' => $exception->getFile(
            'line' => $exception->getLine(
            'trace' => $exception->getTraceAsString(
            'exception' => sprintf('`%s` (Code `%s`)', get_class($exception
            'thrown_in' => sprintf('`%s`:%d', $exception->getFile(
            'user' => sprintf('%d <%s>', Auth::id() ?? 0, $email),
            'ip' => request()->ip(),
            'thrown_while_calling' => sprintf('[%s] %s', request()->getMethod(), request()->fullUrl()),
            'url_previous' => url()->previous(),
            /*
             * 'exception_details' => sprintf(
             * "Trace:\n```json \n %s \n ```\n\n Previous: \n `%s`",
             * json_encode($exception->getTrace(
             * $exception->getPrevious(
             * ),
             */
        ];
    }
}
