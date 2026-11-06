<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Config\ResolveModuleConfigDataAction;
use Modules\Xot\Tests\TestCase;
use Symfony\Component\Process\Process;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;
use function Safe\glob;

uses(TestCase::class)->group('no-xot-db');

dataset('laraxot modules', function (): array {
    $modulesPath = dirname(__DIR__, 5);
    $names = [];
    $iterator = new DirectoryIterator($modulesPath);
    foreach ($iterator as $file) {
        if ($file->isDot() || ! $file->isDir()) {
            continue;
        }

        $name = $file->getFilename();
        if (! str_starts_with($name, '.')
            && is_file($file->getPathname().'/module.json')
            && is_dir($file->getPathname().'/app')) {
            $names[$name] = [$name];
        }
    }

    return $names;
});

test('every module has a setting page class', function (string $module): void {
    expect(File::exists(base_path("Modules/{$module}/app/Filament/Pages/SettingPage.php")))->toBeTrue()
        ->and(class_exists("Modules\\{$module}\\Filament\\Pages\\SettingPage"))->toBeTrue();
})->with('laraxot modules');

test('every module setting page has a config data class the base can read', function (string $module): void {
    expect(ResolveModuleConfigDataAction::dataClassFor("Modules\\{$module}\\Filament\\Pages\\SettingPage"))
        ->toBe("Modules\\{$module}\\Datas\\{$module}ConfigData");
})->with('laraxot modules');

test('every module has setting page navigation labels in it and en', function (string $module): void {
    expect(File::exists(base_path("Modules/{$module}/lang/it/setting.php")))->toBeTrue()
        ->and(File::exists(base_path("Modules/{$module}/lang/en/setting.php")))->toBeTrue();
})->with('laraxot modules');

test('every module ignores lock files in its own repository', function (string $module): void {
    $gitignore = base_path("Modules/{$module}/.gitignore");

    expect(File::exists($gitignore))->toBeTrue()
        ->and(file_get_contents($gitignore))->toContain('*.lock');
})->with('laraxot modules');

/**
 * Le proprieta' della Data che la pagina deve esporre: tutte le pubbliche tranne `name` (la riempie il trait).
 *
 * @return list<string>
 */
function settingDataProperties(string $module): array
{
    $dataClass = ResolveModuleConfigDataAction::dataClassFor("Modules\\{$module}\\Filament\\Pages\\SettingPage");
    Assert::notNull($dataClass);
    $names = [];
    foreach ((new ReflectionClass($dataClass))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
        if (! $property->isStatic() && $property->getName() !== 'name') {
            $names[] = $property->getName();
        }
    }

    return $names;
}

/**
 * @return array<array-key, mixed>
 */
function settingFormSchema(string $module): array
{
    $page = app("Modules\\{$module}\\Filament\\Pages\\SettingPage");
    Assert::object($page);
    $schema = (new ReflectionMethod($page, 'getFormSchema'))->invoke($page);
    Assert::isArray($schema);

    return $schema;
}

/**
 * Moduli le cui impostazioni le legge un pacchetto da `config('<prefisso>.<chiave>')`, non il codice del progetto:
 * un'Action del modulo copia nel config le chiavi salvate (Activity: `ApplyActivityConfigAction`).
 *
 * @var array<string, array{directory: string, prefix: string}>
 */
const SETTING_PACKAGE_READERS = [
    'Activity' => ['directory' => 'vendor/spatie/laravel-activitylog/src', 'prefix' => 'activitylog'],
];

/**
 * Moduli le cui impostazioni le legge codice di un altro modulo. Tenant scrive il file `metatag`, che legge `MetatagData` di Xot
 * (a sua volta usato dal `Head` di Cms): `->title` e `->logo_height` stanno li'.
 *
 * @var array<string, list<string>>
 */
const SETTING_READER_MODULES = [
    'Tenant' => ['Xot'],
];

/**
 * File che leggono la proprieta' fuori dalla pagina e dalla Data del modulo: `->prop` o `->camelProp(` nel modulo, in un
 * modulo dichiarato in SETTING_READER_MODULES (per Xot, che e' la base di tutti, in ogni modulo), oppure `<prefisso>.prop`
 * nel pacchetto dichiarato in SETTING_PACKAGE_READERS.
 * E' un'euristica: prova che un lettore esiste, non che sia quello giusto. Lo si controlla a mano nella story del modulo.
 *
 * @return list<string>
 */
function settingPropertyReaders(string $module, string $property): array
{
    $needles = implode('|', array_unique([$property, Str::camel($property)]));
    // Xot e' la base di tutti: le sue impostazioni (`primary_lang`, `main_module`...) le leggono gli altri moduli via XotData.
    $directories = $module === 'Xot'
        ? settingAllModuleDirectories()
        : [
            base_path("Modules/{$module}/app"),
            base_path("Modules/{$module}/resources"),
            ...array_map(static fn (string $reader): string => base_path("Modules/{$reader}/app"), SETTING_READER_MODULES[$module] ?? []),
        ];
    $files = settingGrep('->('.$needles.')\b', array_values(array_filter($directories, static fn (string $directory): bool => is_dir($directory))));

    $package = SETTING_PACKAGE_READERS[$module] ?? null;
    if ($package !== null) {
        $files = [...$files, ...settingGrep($package['prefix'].'\.'.$property.'\b', [base_path($package['directory'])])];
    }

    $own = [
        base_path("Modules/{$module}/app/Filament/Pages/SettingPage.php"),
        base_path("Modules/{$module}/app/Datas/{$module}ConfigData.php"),
    ];

    return array_values(array_diff($files, $own));
}

/**
 * Le cartelle `app` e `resources` di tutti i moduli.
 *
 * @return list<string>
 */
function settingAllModuleDirectories(): array
{
    $directories = [...glob(base_path('Modules/*/app'), GLOB_ONLYDIR), ...glob(base_path('Modules/*/resources'), GLOB_ONLYDIR)];
    Assert::allString($directories);

    return array_values($directories);
}

/**
 * @param  list<string>  $directories
 * @return list<string>
 */
function settingGrep(string $pattern, array $directories): array
{
    $process = new Process(['grep', '-rlE', '--include=*.php', '-e', $pattern, ...$directories]);
    $process->run();

    return array_values(array_filter(explode("\n", $process->getOutput())));
}

test('every setting page exposes at least one configurable field', function (string $module): void {
    expect(settingFormSchema($module))->not->toBeEmpty();
})->with('laraxot modules');

test('the fields of a setting page are exactly the properties of its config data', function (string $module): void {
    expect(array_keys(settingFormSchema($module)))->toEqualCanonicalizing(settingDataProperties($module));
})->with('laraxot modules');

test('every field of a setting page has a label in it and en', function (string $module): void {
    foreach (['it', 'en'] as $locale) {
        $lang = File::getRequire(base_path("Modules/{$module}/lang/{$locale}/setting.php"));
        Assert::isArray($lang);

        foreach (settingDataProperties($module) as $property) {
            $label = Arr::get($lang, "fields.{$property}.label");

            expect($label)->toBeString("{$module} {$locale}: fields.{$property}.label")->not->toBe('');
        }
    }
})->with('laraxot modules');

test('the reader search finds nothing for a property that nobody reads', function (): void {
    expect(settingPropertyReaders('Trade', 'zz_property_nobody_reads'))->toBe([])
        ->and(settingPropertyReaders('Xot', 'zz_property_nobody_reads'))->toBe([])
        ->and(settingPropertyReaders('Activity', 'zz_property_nobody_reads'))->toBe([]);
});

test('every property of a config data is read by code outside the setting page', function (string $module): void {
    foreach (settingDataProperties($module) as $property) {
        expect(settingPropertyReaders($module, $property))->not->toBeEmpty("{$module}: nobody reads {$property}");
    }
})->with('laraxot modules');
