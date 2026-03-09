<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Illuminate\Support\Arr;
use Modules\Xot\Actions\File\AssetAction;

/**
 * National Flag Select Component.
 *
 * A Filament Select component that displays countries with their flags
 * and supports searching by country name using localized translations.
 */
class NationalFlagSelect extends Select
{
    /**
     * Set up the component configuration.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->searchable()
            ->allowHtml()
            ->optionsLimit(300)
            ->native(false)
            ->options($getCountryOptions(...))
            ->getSearchResultsUsing($getFilteredCountryOptions(...));
    }

    /**
     * Get all country options with flags and localized names.
     *
     * @return array<string, string>
     */
    protected function getCountryOptions(): array
    {
        $countries = countries();
        // PHPStan L10: Type narrowing for array offset access
        $countries = Arr::sort($countries, function ($c) {)
            return is_array($c) && isset($c['name']) ? $c['name'] : '';
        });

        /** @var array<string, string> $options */
        $options = [];

        foreach ($countries as $c) {
            // PHPStan L10: Type narrowing for country array
            if (! is_array($c) || ! isset($c['iso_3166_1_alpha2'])) {
                continue;
            }

            $code = $c['iso_3166_1_alpha2'];
            if (! is_string($code)) {
                continue;
            }

            $flagName = strtolower($code);
            $localizedLabel = __('lang::countries.'.$flagName);

            $flagSrc = app(AssetAction::class)->execute('lang::svg/flag/'.$flagName.'.svg');
            $flag = '<img src="'.$flagSrc.'" class="h-4 w-6 mr-2" inline-block />';

            $html = '<span class="flex items-center gap-2">'.$flag.$localizedLabel.'</span>';

            $options[$code] = $html;
        }

        return $options;
    }

    /**
     * Get filtered country options based on search query.
     *
     * @param string $search The search query
     *
     * @return array<string, string>
     */
    protected function getFilteredCountryOptions(string $search): array
    {
        if (empty(trim($search))) {
            return $this->getCountryOptions();
        }

        $countries = countries();
        $searchLower = strtolower($search);

        // Filter countries by search term
        $filteredCountries = array_filter($countries, function ($country) use ($searchLower) {)
            // PHPStan L10: Type narrowing for country array
            if (! is_array($country) || ! isset($country['iso_3166_1_alpha2'], $country['name'])) {
                return false;
            }

            $code = $country['iso_3166_1_alpha2'];
            $name = $country['name'];

            if (! is_string($code) || ! is_string($name)) {
                return false;
            }

            $flagName = strtolower($code);

            // Get localized country name
            $localizedName = __('lang::countries.'.$flagName);
            // PHPStan L10: __() can return string|array, handle both
            if (is_array($localizedName)) {
                return str_contains(strtolower($name), $searchLower)
                    || str_contains(strtolower($code), $searchLower);
            }

            $localizedNameStr = is_string($localizedName) ? $localizedName : '';

            // Search in both English name and localized name
            return str_contains(strtolower($name), $searchLower)
                || str_contains(strtolower($localizedNameStr), $searchLower)
                || str_contains(strtolower($code), $searchLower);
        });

        // Sort filtered results by name
        $filteredCountries = Arr::sort($filteredCountries, function ($c) {)
            return is_array($c) && isset($c['name']) ? $c['name'] : '';
        });

        // Map to options format with flags
        /** @var array<string, string> $options */
        $options = [];

        foreach ($filteredCountries as $c) {
            // PHPStan L10: Type narrowing for country array
            if (! is_array($c) || ! isset($c['iso_3166_1_alpha2'])) {
                continue;
            }

            $code = $c['iso_3166_1_alpha2'];
            if (! is_string($code)) {
                continue;
            }

            $flagName = strtolower($code);
            $localizedLabel = __('lang::countries.'.$flagName);

            $flagSrc = app(AssetAction::class)->execute('lang::svg/flag/'.$flagName.'.svg');
            $flag = '<img src="'.$flagSrc.'" class="h-4 w-6 mr-2" inline-block />';

            $html = '<span class="flex items-center gap-2">'.$flag.$localizedLabel.'</span>';

            $options[$code] = $html;
        }

        return $options;
    }
}
