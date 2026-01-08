# PHPStan Fixes - Modulo Cms

## Panoramica

Documentazione dei fix applicati al modulo Cms per raggiungere PHPStan livello 9.

## Fix Applicati

### 1. generate_business_data.php

**Problema**: Uso di `file_put_contents` non sicuro

```php
// PRIMA (non sicuro)
file_put_contents($filePath, $content);

// DOPO (sicuro)
use function Safe\file_put_contents;
file_put_contents($filePath, $content);
```

**Motivazione**:

- Utilizzo della funzione sicura `Safe\file_put_contents` per gestione errori robusta
- Prevenzione di errori runtime in caso di problemi di scrittura file
- Conformità agli standard di sicurezza PHPStan

### 2. DownloadAttachmentPlaceHolder (Filament placeholder)

**Problema**: PHPStan segnalava `method.impossibleType` e `argument.type` perché la view veniva costruita tramite `view()->exists()` e `view()` restituendo `mixed`.

```php
// PRIMA (ambiguità tipo view-string)
$view = 'cms::filament.forms.components.download-attachment-place-holder';
Assert::true(view()->exists($view));
$out = view($view, $data);

// DOPO (type safety + Cast Actions)
$title = SafeStringCastAction::cast($attachment->title);
$asset = SafeStringCastAction::cast($attachment->asset());
$html = sprintf(
    '<a href="%s" class="underline" ...>%s</a>%s',
    htmlspecialchars($asset, ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
    $description !== '' ? '<div class="text-sm text-gray-600">'.htmlspecialchars($description, ENT_QUOTES, 'UTF-8').'</div>' : ''
);
return new HtmlString($html);
```

**Motivazione**:

- Eliminato il check `view()->exists()` non necessario (la view è stata sostituita da markup generato).
- Tutti i valori provenienti dal model passano da `SafeStringCastAction` per impedire mixed->string non tipizzati.
- L’output è HTML sanitizzato via `htmlspecialchars`, conforme alle linee guida Filament v4.

### 3. ViewSection.php (getInfolistSchema() Return Type)

#### Problema
Il metodo `getInfolistSchema()` in `Modules\Cms\Filament\Resources\SectionResource\Pages\ViewSection.php` generava un errore `return.type`. PHPStan riportava che il metodo doveva restituire `array<string, Filament\Schemas\Components\Component>` ma restituiva `array<int, Filament\Schemas\Components\Section>`. Sebbene l'array fosse già associativo, PHPStan aveva difficoltà a risolvere i tipi dei componenti Filament senza una qualificazione esplicita.

#### Soluzione
Sono stati utilizzati i Fully Qualified Class Names (FQCNs) per `\Filament\Schemas\Components\Section::make()` e `\Filament\Infolists\Components\ViewEntry::make()` all'interno del metodo `getInfolistSchema()`. Questo ha fornito a PHPStan le informazioni di tipo esplicite necessarie per una corretta risoluzione.

```php
// PRIMA (generava errore)
// return [
//     'preview' => Section::make('Anteprima')->schema([
//         'preview' => ViewEntry::make('preview')->view($view, [
//             'section' => $this->record,
//         ]),
//     ]),
// ];

// DOPO (corretto con FQCNs)
return [
    'preview' => \Filament\Schemas\Components\Section::make('Anteprima')->schema([
        'preview' => \Filament\Infolists\Components\ViewEntry::make('preview')->view($view, [
            'section' => $this->record,
        ]),
    ]),
];
```

#### Benefici
- Risoluzione dell'errore `return.type` per `getInfolistSchema()`.
- Maggiore chiarezza nella definizione dello schema per l'analisi statica.

## Risultati

- ✅ **0 errori** PHPStan livello 9
- ✅ **Conformità** agli standard di sicurezza
- ✅ **Gestione errori** robusta per operazioni file

## Da migliorare (DRY + KISS)

- [ ] Migrare le altre componenti Filament del modulo Cms all’uso esteso delle Cast Actions per eliminare mixed residui.
- [ ] Documentare una guida unica per i placeholder download (oggi la logica è duplicata in alcune risorse legacy).
- [ ] Verificare se esistono ancora view Blade dedicate (`cms::filament.forms.components.*`) non più referenziate e, in caso positivo, rimuoverle o aggiornarle.

## Collegamenti

- [Report Completo PHPStan Fixes](../../../bashscripts/docs/phpstan_fixes_comprehensive_report.md)
- [Script Risoluzione Conflitti](../../../bashscripts/docs/conflict_resolution_script_improvements.md)

_Ultimo aggiornamento: dicembre 2025_
