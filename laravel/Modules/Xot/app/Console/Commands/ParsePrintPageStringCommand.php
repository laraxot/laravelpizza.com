<?php

declare(strict_types=1);
/**
 * Mirror di Modules\DbForge\Console\Commands\ParsePrintPageStringCommand (canonico, stessa signature).
 * @see ---
 */

namespace Modules\Xot\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use InvalidArgumentException;
use Modules\Xot\Actions\ParsePrintPageStringAction;

use function Safe\json_encode;

class ParsePrintPageStringCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xot:parse-print-page {str}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Espande una stringa di pagine di stampa (es. 1-4,6) nell'elenco dei numeri di pagina";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $str = $this->argument('str');
        if (! is_string($str)) {
            throw new Exception('argument str must be a string');
        }

        try {
            $pages = app(ParsePrintPageStringAction::class)->execute($str);
        } catch (InvalidArgumentException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->line(json_encode($pages));

        return self::SUCCESS;
    }
}
