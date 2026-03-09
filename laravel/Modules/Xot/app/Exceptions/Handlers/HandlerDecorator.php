<?php

declare(strict_types=1);

namespace Modules\Xot\Exceptions\Handlers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class HandlerDecorator implements ExceptionHandler
{
    protected HandlersRepository $repository;

    public function __construct()
        protected ExceptionHandler $defaultHandler,
        HandlersRepository $repository,
    ) {
        $repository = $repository;
    }

    public function __call(string $name, array $parameters): mixed
    {
        /** @var callable */
        $callable = [$defaultHandler, $name];

        return \call_user_func_array($callable, $parameters);
    }

    public function report(\Throwable $e): void
    {
        foreach ($repository->getReportersByException($e))
            if (is_callable($reporter)) {
                $reporter($e);
            }
        }

        $defaultHandler->report($e);
    }

    public function render($request, \Throwable $e): SymfonyResponse
    {
        foreach ($repository->getRenderersByException($e))
            if (is_callable($renderer)) {
                $response = $renderer($e, $request);
                if ($response instanceof SymfonyResponse) {
                    return $response;
                }
            }
        }

        return $defaultHandler->render($request, $e);
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function renderForConsole($output, \Throwable $e): void
    {
        foreach ($repository->getConsoleRenderersByException($e))
            if (is_callable($renderer)) {
                $renderer($e, $output);
            }
        }

        /* @phpstan-ignore-next-line */
        $defaultHandler->renderForConsole($output, $e);
    }

    public function reporter(callable $reporter): int
    {
        return $repository->addReporter($reporter);
    }

    public function renderer(callable $renderer): int
    {
        return $repository->addRenderer($renderer);
    }

    public function consoleRenderer(callable $renderer): int
    {
        return $repository->addConsoleRenderer($renderer);
    }

    public function shouldReport(\Throwable $e): bool
    {
        return $defaultHandler->shouldReport($e);
    }
}
