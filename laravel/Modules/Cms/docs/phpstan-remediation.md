# PHPStan Remediation Plan – 23 Dic 2025

## Contesto

- `./vendor/bin/phpstan analyse Modules/Cms` produce 109 errori di livello 10 (log in `laravel/phpstan-Modules-Cms.json`).
- Gli errori si concentrano in due aree:
  1. **Script legacy** (`analyze_business_logic.php`, `generate_business_data.php`, `generate_test_data.php`, `populate_database_comprehensive.php`) che istanziano classi attraverso `app()->make()` su input `mixed`.
  2. **View composer** (`resources/views/Composers/ThemeComposer.php`) che passa parametri errati al componente `Modules\UI\View\Components\Render\Blocks`.

## Errori principali e fix pianificati

### 1. Script legacy con mixed e chiamate dinamiche

- **Problema**: gli script costruiscono nomi di modelli/factory partendo da input non validati e chiamano metodi (`bootstrap`, `make`, `create`) su variabili `mixed`, generando decine di errori.
- **Soluzione proposta**:
  - Portare la logica utile in `Modules\Cms\Actions\*` typed, dichiarando signature esplicite (`string $moduleName`, `class-string<Model> $modelClass`).
  - Sostituire `app()->make($class?)` con factory o service locator typed (es. `resolve(ModelFactoryContract::class)`).
  - Validare ogni input con `Webmozart\Assert` e, dove possibile, usare enum per le liste di modelli/supportate.
  - Deprecare gli script standalone: spostare la generazione dati in seeders/test factory ufficiali oppure eliminarli se non più usati.

### 2. ThemeComposer → Blocks constructor

- **Problema**: PHPStan segnala parametri mancanti (`$view`) e sconosciuti (`$tpl`) perché il costruttore di `Blocks` aspetta la signature `Blocks(array $blocks = [], ?Model $model = null, string $view = 'ui::components.render.blocks.v1')`. Il composer passa argomenti come named parameters non previsti.
- **Soluzione proposta**:
  - Verificare la definizione attuale di `Modules\UI\View\Components\Render\Blocks`. Adottare i parametri reali (se usa named parameters `blocks`, `model`, `tpl` con default, mantenere allineati).
  - Aggiornare tutti i `new Blocks(...)` nel composer usando **named parameters corretti** e fornendo sempre il parametro richiesto (`view` oppure `tpl`, in base alla classe concreta di UI).
  - Aggiornare i PHPDoc del composer: `getMenu(): array<string, mixed>|null`, `getMenuUrl(array<string, mixed>): string`, ecc., per ridurre i `array<mixed, mixed>`.

## Strategia operativa

1. **Censire utilizzi reali** degli script legacy (grep in CronJob/bashes). Se obsoleti → archiviarli in `docs/archive/legacy-scripts.md`, altrimenti refactor.
2. **Creare Actions dedicate**:

   ```php
   final class AnalyzeBusinessLogicAction
   {
       public function __invoke(string $moduleName, class-string<Model> $modelClass): BusinessLogicReport { ... }
   }
   ```

   - Le action verranno chiamate da comandi Artisan, con input validato.
3. **Aggiornare ThemeComposer**:
   - Applicare named parameters coerenti col `Blocks` reale.
   - Restituire `array<string, mixed>` tramite `Assert::isArrayAccessible`.
4. **Quality Gate continuo**:
   - Dopo ogni step, rieseguire `phpstan`, `phpmd`, `phpinsights` su `Modules/Cms`.

## Da migliorare (DRY + KISS)

- Introdurre un documento unico “CMS Data Generators” che descriva come generare contenuti fake senza script duplicati.
- Standardizzare l’uso delle `Data` (es. `FooterData`, `HeadernavData`) come fonte unica per i composer, evitando logica duplicata.
- Automatizzare, via bashscript quality, un check che impedisca script PHP fuori da `app/` senza namespace/autoload nel modulo CMS.
