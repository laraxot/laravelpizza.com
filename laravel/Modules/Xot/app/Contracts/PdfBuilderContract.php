<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

interface PdfBuilderContract
{
    public function format(string $format): self;

    public function name(string $filename): self;

    public function download(): self;

    /**
     * @param \Closure(object): void $callback
     */
    public function withBrowsershot(\Closure $callback): self;

    public function base64(): string;
}
