<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Fixtures;

use Modules\Job\Datas\CommandData;
use Spatie\LaravelData\DataCollection;

/**
 * Sostituto di GetCommandsAction che restituisce una collezione di comandi fissa
 * (classe con nome, non anonima).
 */
final class StubGetCommandsAction
{
    /**
     * @param  DataCollection<int, CommandData>  $commands
     */
    public function __construct(private readonly DataCollection $commands) {}

    /**
     * @return DataCollection<int, CommandData>
     */
    public function execute(): DataCollection
    {
        return $this->commands;
    }
}
