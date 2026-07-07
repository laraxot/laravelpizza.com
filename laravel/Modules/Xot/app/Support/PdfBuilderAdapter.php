<?php

declare(strict_types=1);

namespace Modules\Xot\Support;

use Modules\Xot\Contracts\PdfBuilderContract;
use Webmozart\Assert\Assert;

final class PdfBuilderAdapter implements PdfBuilderContract
{
    public function __construct(
        private object $builder,
    ) {
    }

    public function format(string $format): PdfBuilderContract
    {
        $this->builder = $this->callBuilderMethod('format', [$format]);

        return $this;
    }

    public function name(string $filename): PdfBuilderContract
    {
        $this->builder = $this->callBuilderMethod('name', [$filename]);

        return $this;
    }

    public function download(): PdfBuilderContract
    {
        $this->builder = $this->callBuilderMethod('download');

        return $this;
    }

    public function withBrowsershot(\Closure $callback): PdfBuilderContract
    {
        $this->builder = $this->callBuilderMethod('withBrowsershot', [$callback]);

        return $this;
    }

    public function base64(): string
    {
        $base64 = $this->callScalarMethod('base64');
        Assert::stringNotEmpty($base64);

        return $base64;
    }

    /**
     * @param list<mixed> $arguments
     */
    private function callBuilderMethod(string $method, array $arguments = []): object
    {
        Assert::methodExists($this->builder, $method);

        $result = $this->builder->{$method}(...$arguments);
        if (! is_object($result)) {
            throw new \RuntimeException(sprintf('Builder method [%s] did not return an object.', $method));
        }

        return $result;
    }

    private function callScalarMethod(string $method): string
    {
        Assert::methodExists($this->builder, $method);

        $result = $this->builder->{$method}();
        Assert::string($result);

        return $result;
    }
}
