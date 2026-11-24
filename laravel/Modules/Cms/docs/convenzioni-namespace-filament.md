---
title: "convenzioni namespace filament"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_ouDDRp
<<<<<<< .merge_file_2CVWfb
<<<<<<< .merge_file_JZEPoq
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_fWikIG
=======
>>>>>>> .merge_file_QRqSDH
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_ouDDRp
<<<<<<< .merge_file_2CVWfb
>>>>>>> .merge_file_DF2C6j
=======
>>>>>>> .merge_file_fWikIG
=======
>>>>>>> .merge_file_QRqSDH
qmd: "convenzioni namespace filament"
issues: []
discussions: []
---

# Convenzioni Namespace per Filament

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

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

<<<<<<< HEAD
- Per le regole generali e best practice consulta la doc del modulo [Xot](../../xot/project_docs/README.md).
=======
<<<<<<< HEAD
- Per le regole generali e best practice consulta la doc del modulo [Xot](../../xot/project_docs/readme.md).
=======
<<<<<<< .merge_file_nammGU
- Per le regole generali e best practice consulta la doc del modulo [Xot](../../Xot/docs/README.md).
=======
- Per le regole generali e best practice consulta la doc del modulo [Xot](../../xot/project_docs/README.md).
>>>>>>> .merge_file_SYrrp5
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

## Regole Tailwind CSS con Filament
- **IMPORTANTE:** Con Filament 3.x, usare solo `tailwindcss@3.x` (NO 4.x). Riferimento: [Filament Docs](https://filamentphp.com/project_docs/3.x/notifications/installation#installing-tailwind-css).
- Tutti i temi custom devono rispettare questa versione.

## Regole build/publish temi custom
- Per temi custom (es. Themes/One) la build e pubblicazione asset si fa SOLO dalla cartella del tema:
  ```sh
  npm run build
<<<<<<< .merge_file_ouDDRp
<<<<<<< .merge_file_2CVWfb
<<<<<<< .merge_file_JZEPoq
  # public_html/themes/<Tema> è un symlink a laravel/Themes/<Tema>/public: niente copia (Modules/Xot/docs/wiki/concepts/public-html-symlink-assets.md)
=======
=======
>>>>>>> .merge_file_fWikIG
=======
>>>>>>> .merge_file_QRqSDH
<<<<<<< HEAD
  # niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
<<<<<<< HEAD
  # niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
  # public_html/themes/<Tema> è un symlink a laravel/Themes/<Tema>/public: niente copia (Modules/Xot/docs/wiki/concepts/public-html-symlink-assets.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_ouDDRp
<<<<<<< .merge_file_2CVWfb
>>>>>>> .merge_file_DF2C6j
=======
>>>>>>> .merge_file_fWikIG
=======
>>>>>>> .merge_file_QRqSDH
  ```
- Non usare mai `vendor:publish` per asset dei temi custom.
- Vedi anche [README tema One](../../../../themes/one/README.md)

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
<<<<<<< HEAD
- [README.md](../../xot/project_docs/README.md) - Indice principale della documentazione
- [Struttura dei Moduli](../../xot/project_docs/module_structure.md) - Struttura standard dei moduli
- [Case Sensitivity delle Directory](../../xot/project_docs/directory-case-sensitivity.md) - Regole per la case sensitivity
- [Regole per i Namespace](../../xot/project_docs/namespace-rules.md) - Convenzioni per i namespace
=======
<<<<<<< HEAD
- [README.md](../../xot/project_docs/readme.md) - Indice principale della documentazione
- [Struttura dei Moduli](../../xot/project_docs/module_structure.md) - Struttura standard dei moduli
- [Case Sensitivity delle Directory](../../xot/project_docs/directory-case-sensitivity.md) - Regole per la case sensitivity
- [Regole per i Namespace](../../xot/project_docs/namespace-rules.md) - Convenzioni per i namespace
=======
<<<<<<< .merge_file_nammGU
- [README.md](../../Xot/docs/README.md) - Indice principale della documentazione
=======
- [README.md](../../xot/project_docs/README.md) - Indice principale della documentazione
>>>>>>> .merge_file_SYrrp5
- [Struttura dei Moduli](../../xot/project_docs/module_structure.md) - Struttura standard dei moduli
- [Case Sensitivity delle Directory](../../Xot/docs/directory-case-sensitivity.md) - Regole per la case sensitivity
- [Regole per i Namespace](../../Xot/docs/namespace-rules.md) - Convenzioni per i namespace
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

### Filament
- [Widget Filament](../../xot/project_docs/filament/widgets/xot-base-widget.md) - Documentazione su XotBaseWidget
- [Polling nei Widget](../../xot/project_docs/filament/widgets/filament_widgets_polling.md) - Implementazione del polling
- [Risorse Filament](../../xot/project_docs/filament-resources.md) - Struttura delle risorse Filament

### Moduli Correlati
<<<<<<< HEAD
- [Lang - Filament Translations](../../lang/project_docs/filament-translations.md) - Traduzioni in Filament
=======
<<<<<<< HEAD
- [Lang - Filament Translations](../../lang/project_docs/filament-translations.md) - Traduzioni in Filament
=======
- [Lang - Filament Translations](../../Lang/docs/filament-translations.md) - Traduzioni in Filament
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
- [UI - Form Filament Widgets](../../ui/project_docs/form_filament_widgets.md) - Widget per form Filament
- [User - Filament Best Practices](../../user/project_docs/filament_best_practices.md) - Best practices per Filament

### Documentazione Interna
- [README del modulo Cms](./README.md) - Indice principale del modulo Cms
- [Filament Widget Registrazione](./filament-widget-registrazione.md) - Widget di registrazione
- [Filament Widgets in Blade](./filament-widgets-in-blade.md) - Uso dei widget in Blade

---

<<<<<<< .merge_file_ouDDRp
<<<<<<< .merge_file_2CVWfb
<<<<<<< .merge_file_JZEPoq
=======
=======
>>>>>>> .merge_file_fWikIG
=======
>>>>>>> .merge_file_QRqSDH
title: "convenzioni namespace filament"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "convenzioni namespace filament"
issues: []
discussions: []
<<<<<<< .merge_file_ouDDRp
<<<<<<< .merge_file_2CVWfb
>>>>>>> .merge_file_DF2C6j
=======
>>>>>>> .merge_file_fWikIG
=======
>>>>>>> .merge_file_QRqSDH
> **Nota**: Questo documento è linkato anche dal README di Xot per garantire coerenza tra i moduli.
