<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Mail;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\Theme\GetThemeContextAction;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;

use function Safe\file_get_contents;

/**
 * Action to resolve and load the appropriate email HTML layout.
 *
 * It uses GetThemeContextAction to determine the current season/context
 * and looks for an appropriate layout file in the current theme.
 */
class GetMailLayoutAction
{
    use QueueableAction;

    /**
     * Resolve and return the layout HTML content.
     *
     * @param  string  $baseName  The base name of the layout (default: 'base')
     * @return string The HTML content of the layout
     */
    public function execute(string $baseName = 'base'): string
    {
        $xot = XotData::make();
        $pub_theme = $xot->pub_theme;
        $themePath = base_path('Themes/'.$pub_theme.'/resources/mail-layouts');

        $context = app(GetThemeContextAction::class)->execute();

        // Potential filenames to check in priority order
        // 1. Specific base layout for the context (e.g. base_christmas.html) - Allows overriding base layout per season
        // 2. Context specific layout (e.g. christmas.html) - The standard seasonal layout
        // 3. Generic base layout (base.html) - Fallback for when no seasonal layout is found
        // Potential filenames to check in priority order
        $candidates = [
            $baseName.'_'.$context.'.html', // 1. Specific Context (e.g. welcome_christmas.html)
        ];

        if ($baseName !== 'base') {
            $candidates[] = $baseName.'.html';   // 2. Specific Base (e.g. welcome.html) - Before generic seasonal!
        }

        // Special priority for professional christmas layout if available
        if ($context === 'christmas') {
            $candidates[] = 'christmas-professional.html';
        }

        $candidates[] = $context.'.html';       // 3. Generic Seasonal (e.g. christmas.html)
        $candidates[] = 'base.html';              // 4. Fallback Base (base.html)

        $layoutPath = '';
        foreach ($candidates as $candidate) {
            $path = $themePath.'/'.$candidate;
            if (File::exists($path)) {
                $layoutPath = $path;
                break;
            }
        }

        // Final fallback if nothing found
        if ($layoutPath === '') {
            $layoutPath = $themePath.'/base.html';
        }

        if (! File::exists($layoutPath)) {
            return '{{{ body }}}'; // Bare minimum fallback
        }

        $content = file_get_contents($layoutPath);

        return app(SafeStringCastAction::class)->execute($content);
    }
}
