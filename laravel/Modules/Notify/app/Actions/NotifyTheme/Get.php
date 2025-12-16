<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\NotifyTheme;

use Illuminate\Support\Str;
use Modules\Notify\Datas\NotifyThemeData;
use Modules\Notify\Models\NotifyTheme;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;

/**
 * -- buildmailmessage ha troppi pezzi simili ..
 */
class Get
{
    use QueueableAction;

    public function execute(string $name, string $type, array $view_params): NotifyThemeData
    {
        $xotData = XotData::make();

        if (! isset($view_params['post_id'])) {
            $view_params['post_id'] = 0;
        }
        if (! isset($view_params['lang'])) {
            $view_params['lang'] = app()->getLocale();
        }

        $theme = NotifyTheme::firstOrCreate(
            [
                'lang' => $view_params['lang'],
                'type' => $type, // email,sms,whatsapp,piccione
                'post_type' => $name,
                'post_id' => $view_params['post_id'], // in questo caso il tipo come register type 3 in cui la pwd e' solo autogenerata
            ],
            ['view_params' => []],
        );

        $module_name_low = Str::lower($xotData->main_module);

        $trad_mod = $module_name_low . '::' . $type . '.' . $name;

        if ($theme->subject === null) {
            $subject = trans($trad_mod . '.subject');
            $theme->update(['subject' => $subject]);
        }

        if ($theme->theme === null) {
            $theme->update(['theme' => 'ark']);
        }

        if ($theme->body_html === null) {
            $html = trans($trad_mod . '.body_html');
            if (isset($view_params['body_html']) && $html === ($trad_mod . '.body_html')) {
                $html = '##body_html##';
            }

            $theme->update(['body_html' => $html]);
        }

        $theme_array = $theme->toArray();
        unset($theme_array['view_params']);

        $view_params = array_merge($theme_array, $view_params);

        $view_params['now'] = now()->format('d/m/Y');

        $body_html = $theme->body_html;
        $subject = $theme->subject;

        if ($theme->theme !== 'empty') {
            $view_params['logo'] = $theme->logo;
        } else {
            // Verifichiamo che i valori siano stringhe o utilizziamo valori di default
            $logoPath = '';
            $logoWidth = '100';
            $logoHeight = '100';

            if (isset($theme->logo['path']) && is_string($theme->logo['path'])) {
                $logoPath = $theme->logo['path'];
            }

            if (isset($theme->logo['width'])) {
                if (is_string($theme->logo['width'])) {
                    $logoWidth = $theme->logo['width'];
                } elseif (is_numeric($theme->logo['width'])) {
                    $logoWidth = (string) $theme->logo['width'];
                }
            }

            if (isset($theme->logo['height'])) {
                if (is_string($theme->logo['height'])) {
                    $logoHeight = $theme->logo['height'];
                } elseif (is_numeric($theme->logo['height'])) {
                    $logoHeight = (string) $theme->logo['height'];
                }
            }

            $view_params['logo'] =
                '<img src="' . $logoPath . '" width="' . $logoWidth . '" height="' . $logoHeight . '" />';

            // $view_params['logo'] = '<img src="'.\Request::getSchemeAndHttpHost().'/uploads/6/logo_VERITAS_piccolo.png" width="' . $theme->logo['width'] . ' "height="' . $theme->logo['height'] . '" />';
        }

        // dddx([$theme, $view_params]);

        foreach ($view_params as $k => $v) {
            if (is_string($v)) {
                $body_html = (string) Str::replace('##' . $k . '##', $v, (string) $body_html);
                $subject = (string) Str::replace('##' . $k . '##', $v, (string) $subject);
            }
        }

        $view_params['body_html'] = $body_html;
        // $view_params['logo'] = $theme->logo;
        if (empty($theme->view_params)) {
            $theme->update(['view_params' => $view_params]);
        }

        return NotifyThemeData::from([
            'from_email' => $theme->from_email,
            'from' => $theme->from,
            'subject' => $subject,
            'body_html' => $body_html,
            'view_params' => $view_params,
        ]);
    }
}
