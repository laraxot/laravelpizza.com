<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Artisan;

use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\preg_match_all;

/**
 * Replaces Modules\Xot\Services\ArtisanService::errorShow().
 */
class ShowArtisanErrorLogAction
{
    use QueueableAction;

    public function execute(): Renderable
    {
        $view = 'xot::acts.artisan.error-show';
        $files = File::files(storage_path('logs'));
        $log = request('log', '');
        if (! is_string($log)) {
            $log = '';
        }
        $content = '';
        // basename(): `log` arriva dalla query string, niente path traversal fuori da storage/logs.
        $logPath = storage_path('logs/'.basename($log));
        if ($log !== '' && File::isFile($logPath)) {
            $content = File::get($logPath);
        }

        $pattern = '/url":"([^"]*)"/';
        // Str::matchAll restituisce il primo gruppo di ogni occorrenza (lista vuota se nessun match).
        $urls = Str::matchAll($pattern, $content)->unique()->values()->all();
        $view_params = [
            'view' => $view,
            'lang' => app()->getLocale(),
            'files' => $files,
            'content' => $content,
            'urls' => $urls,
        ];

        $result = view('xot::acts.artisan.error-show', $view_params);
        Assert::isInstanceOf($result, View::class);

        return $result;
    }
}
