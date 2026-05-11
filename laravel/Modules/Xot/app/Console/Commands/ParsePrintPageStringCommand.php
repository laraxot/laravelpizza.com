<?php

declare(strict_types=1);

/**
 * @see ---
 */

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Modules\Xot\Actions\ParsePrintPageStringAction;

class ParsePrintPageStringCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'xot:parse-print-page {str}';

    /**
     * The console command description.
     */
    protected $description = ' esplode';

    /**
     * Create a new command instance.
     */

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $str = $this->argument('str');
        if (! is_string($str)) {
            throw new \Exception('argument str must be a string');
        }
        dddx(app(ParsePrintPageStringAction::class)->execute($str));
    }
}
