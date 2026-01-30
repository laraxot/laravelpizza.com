# Convenzioni Namespace per Filament

> **Regola fondamentale:** Il namespace dei componenti Filament è sempre `Modules\<NomeModulo>\Filament`, anche se i file si trovano fisicamente in `app/Filament`. **Non va mai aggiunto `App` nel namespace.**

## Struttura Corretta dei File

### Posizionamento

I componenti Filament **DEVONO** essere posizionati nelle seguenti directory:

```
Modules/NomeModulo/app/Filament/Resources/  # Risorse Filament
Modules/NomeModulo/app/Filament/Pages/      # Pagine Filament
Modules/NomeModulo/app/Filament/Widgets/    # Widget Filament
```

### Namespace

Il namespace corretto è `Modules\NomeModulo\Filament\[Resources|Pages|Widgets]` (senza il segmento `app`):

```php
// ✅ CORRETTO
namespace Modules\User\Filament\Widgets;

// ❌ ERRATO
namespace Modules\User\App\Filament\Widgets;
```

## Traduzioni nei Blocks Filament

- **Non usare mai `->label()` nei componenti Filament**
  - Le etichette sono gestite automaticamente dal LangServiceProvider
  - Utilizzare la struttura espansa per i campi nei file di traduzione
  - Seguire la convenzione di naming per le chiavi di traduzione: `modulo::risorsa.fields.campo.label`

- **Struttura Corretta per getFormSchema()**
  ```php
  public function getFormSchema(): array
  {
      return [
          'title' => Forms\Components\TextInput::make('title'),
          'content' => Forms\Components\RichEditor::make('content'),
      ];
  }
  ```

- Per le regole generali e best practice consulta la doc del modulo [Xot](../../Xot/project_docs/README.md).

## Regole Tailwind CSS con Filament
- **IMPORTANTE:** Con Filament 3.x, usare solo `tailwindcss@3.x` (NO 4.x). Riferimento: [Filament Docs](https://filamentphp.com/project_docs/3.x/notifications/installation#installing-tailwind-css).
- Tutti i temi custom devono rispettare questa versione.

## Regole build/publish temi custom
- Per temi custom (es. Themes/One) la build e pubblicazione asset si fa SOLO dalla cartella del tema:
  ```sh
  npm run build
  npm run copy
  ```
- Non usare mai `vendor:publish` per asset dei temi custom.
- Vedi anche [README tema One](../../../../Themes/One/README.md)

## Preview custom in Filament
- **Per anteprime custom nelle pagine Filament usare sempre `ViewEntry`** (mai `CustomEntry`).
- `CustomEntry` **non esiste** in Filament 3.x.
- La preview va sempre fatta tramite Blade custom e `ViewEntry`:

```php
Section::make('Anteprima')
    ->schema([
        ViewEntry::make('preview')
            ->view('cms::sections.preview', [
                'blocks' => $this->record->content_blocks,
                'section' => $this->record,
            ]),
    ]),
```

- [Doc ufficiale Filament ViewEntry](https://filamentphp.com/project_docs/3.x/infolists/entries/custom)

## Collegamenti Bidirezionali

### Modulo Xot (Core)
- [README.md](../../Xot/project_docs/README.md) - Indice principale della documentazione
- [Struttura dei Moduli](../../Xot/project_docs/MODULE_STRUCTURE.md) - Struttura standard dei moduli
- [Case Sensitivity delle Directory](../../Xot/project_docs/DIRECTORY-CASE-SENSITIVITY.md) - Regole per la case sensitivity
- [Regole per i Namespace](../../Xot/project_docs/NAMESPACE-RULES.md) - Convenzioni per i namespace

### Filament
- [Widget Filament](../../Xot/project_docs/filament/widgets/xot-base-widget.md) - Documentazione su XotBaseWidget
- [Polling nei Widget](../../Xot/project_docs/filament/widgets/FILAMENT_WIDGETS_POLLING.md) - Implementazione del polling
- [Risorse Filament](../../Xot/project_docs/filament-resources.md) - Struttura delle risorse Filament

### Moduli Correlati
- [Lang - Filament Translations](../../Lang/project_docs/filament-translations.md) - Traduzioni in Filament
- [UI - Form Filament Widgets](../../UI/project_docs/form_filament_widgets.md) - Widget per form Filament
- [User - Filament Best Practices](../../User/project_docs/FILAMENT_BEST_PRACTICES.md) - Best practices per Filament

### Documentazione Interna
- [README del modulo Cms](./README.md) - Indice principale del modulo Cms
- [Filament Widget Registrazione](./filament-widget-registrazione.md) - Widget di registrazione
- [Filament Widgets in Blade](./filament-widgets-in-blade.md) - Uso dei widget in Blade

---

> **Nota**: Questo documento è linkato anche dal README di Xot per garantire coerenza tra i moduli.
