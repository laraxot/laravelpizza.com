# Rinvex Countries Usage in Lang Module

## Overview

The Lang module utilizes the [Rinvex Countries](https://github.com/rinvex/countries) package to provide comprehensive country data including names, ISO codes, flags, currencies, and geographical information. This package provides data for all 250+ countries worldwide.

## Installation

The package is installed via Composer:

```bash
composer require rinvex/countries
```

## Basic Usage

### Getting Single Country

```php
// Get single country by ISO alpha-2 code
$italy = country('it');

// Get country name
echo $italy->getName(); // "Italy"

// Get native name
echo $italy->getNativeName(); // "Italia"

// Get official name
echo $italy->getOfficialName(); // "Italian Republic"

// Get ISO codes
echo $italy->getIsoAlpha2(); // "IT"
echo $italy->getIsoAlpha3(); // "ITA"
echo $italy->getIsoNumeric(); // "380"
```

### Getting All Countries

```php
// Get all countries (short-listed for performance)
$countries = countries();

// Get countries with filtering
$oceaniaCountries = \Rinvex\Country\CountryLoader::where('geo.continent', ['OC' => 'Oceania']);
```

## Usage in NationalFlagSelect Component

The `NationalFlagSelect` component in `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Lang/app/Filament/Forms/Components/NationalFlagSelect.php` demonstrates practical usage:

```php
protected function getCountryOptions(): array
{
    // Get all countries using the countries() helper
    $countries = countries();
    
    // Sort countries by name
    $countries = Arr::sort($countries, function($c) {
        return $c['name'];
    });
    
    // Map countries to select options with flags
    $options = Arr::mapWithKeys($countries, function($c) {
        $code = $c['iso_3166_1_alpha2'];
        $label = $c['name'];
        $flag_name = strtolower($code);
        
        // Get localized country name from translation files
        $label = __('lang::countries.' . $flag_name);
        
        // Generate flag image HTML
        $flag_src = app(AssetAction::class)->execute('lang::svg/flag/' . $flag_name . '.svg');
        $flag = '<img src="' . $flag_src . '" class="h-4 w-6 mr-2" inline-block />';
        
        $html = '<span class="flex items-center gap-2">' . $flag . $label . '</span>';
        return [$code => "{$html}"];
    });
    
    return $options;
}
```

## Available Country Data

### Basic Information

- `getName()` - Common name in English
- `getOfficialName()` - Official name in English
- `getNativeName()` - Native name
- `getDemonym()` - Name of residents (e.g., "Italian")
- `getCapital()` - Capital city

### ISO Codes

- `getIsoAlpha2()` - 2-letter ISO code (e.g., "IT")
- `getIsoAlpha3()` - 3-letter ISO code (e.g., "ITA")
- `getIsoNumeric()` - Numeric ISO code (e.g., "380")

### Geographic Data

- `getContinent()` - Continent name
- `getRegion()` - Geographic region
- `getSubregion()` - Geographic sub-region
- `getLatitude()` - Latitude coordinates
- `getLongitude()` - Longitude coordinates
- `getArea()` - Land area in km²
- `getBorders()` - Array of bordering countries
- `isLandlocked()` - Boolean landlocked status

### Languages and Currencies

- `getLanguages()` - Array of official languages
- `getCurrency()` - Primary currency object
- `getCurrencies()` - All currencies used

### Communication

- `getCallingCode()` - International calling code
- `getCallingCodes()` - All calling codes
- `getTld()` - Top-level domain (e.g., ".it")
- `getTlds()` - All top-level domains

### Visual Elements

- `getFlag()` - SVG flag data
- `getEmoji()` - Flag emoji (e.g., "🇮🇹")

### Translations

- `getTranslations()` - Names in multiple languages
- `getTranslation($language)` - Name in specific language

## Integration with Translation Files

The Lang module maintains synchronized translation files for country names and nationalities:

- `Modules/Lang/lang/it/countries.php` - Italian country names
- `Modules/Lang/lang/en/countries.php` - English country names  
- `Modules/Lang/lang/de/countries.php` - German country names
- `Modules/Lang/lang/it/nationalities.php` - Italian nationalities
- `Modules/Lang/lang/en/nationalities.php` - English nationalities
- `Modules/Lang/lang/de/nationalities.php` - German nationalities

These files are kept in sync with the Rinvex Countries data to ensure all country codes have corresponding translations.

## Data Structure Example

Each country object contains comprehensive data:

```php
$italy = country('it');

// Returns structured data like:
[
    'name' => [
        'common' => 'Italy',
        'official' => 'Italian Republic',
        'native' => ['ita' => ['common' => 'Italia', 'official' => 'Repubblica Italiana']]
    ],
    'demonym' => 'Italian',
    'capital' => 'Rome',
    'iso_3166_1_alpha2' => 'IT',
    'iso_3166_1_alpha3' => 'ITA',
    'iso_3166_1_numeric' => '380',
    'currency' => ['EUR' => [...]], 
    'tld' => ['.it'],
    'languages' => ['ita' => 'Italian'],
    'geo' => [
        'continent' => ['EU' => 'Europe'],
        'area' => 301336,
        'borders' => ['AUT', 'FRA', 'SMR', 'SVN', 'CHE', 'VAT'],
        // ... more geo data
    ],
    'dialling' => [
        'calling_code' => ['39'],
        // ... more dialling data
    ],
    'extra' => [
        'emoji' => '🇮🇹',
        // ... more extra data
    ]
]
```

## Performance Considerations

- When retrieving all countries with `countries()`, you get a short-listed result set for better performance
- When retrieving a single country with `country('code')`, you get the full country details
- Consider caching country data for frequently accessed information
- Use filtering with `CountryLoader::where()` for specific subsets

## Best Practices

1. **Use ISO codes consistently** - Always use lowercase 2-letter ISO codes for consistency
2. **Leverage translations** - Use the translation files instead of hardcoding country names
3. **Cache when appropriate** - Cache country data for better performance in high-traffic scenarios
4. **Validate input** - Always validate country codes before using them
5. **Handle missing data** - Some countries may have incomplete data for certain fields

## Error Handling

```php
try {
    $country = country('invalid');
} catch (\Exception $e) {
    // Handle invalid country code
    $country = null;
}

// Check if country exists
if ($country) {
    echo $country->getName();
} else {
    echo 'Country not found';
}
```

## Related Documentation

- [Translation File Management](translation-file-management.md)
- [Filament Components](filament.md)
- [Localization System](laravel-localization.md)
- [Static Text Translation](static-text-translation.md)

## External Resources

- [Rinvex Countries GitHub Repository](https://github.com/rinvex/countries)
- [ISO 3166 Country Codes](https://en.wikipedia.org/wiki/ISO_3166-1)
- [Country Data Sources](https://github.com/rinvex/countries#data-sources)
