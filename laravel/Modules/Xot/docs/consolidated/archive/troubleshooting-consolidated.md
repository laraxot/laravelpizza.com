# Troubleshooting - Documentazione Consolidata DRY + KISS

> **🎯 Single Source of Truth**: Questo documento centralizza TUTTI i problemi comuni e le soluzioni del progetto
> 
> **🔗 Riferimenti**: [best-practices-consolidated.md](best-practices-consolidated.md) | [phpstan-consolidated.md](phpstan-consolidated.md)

## 🚨 STOP DUPLICAZIONE!

**Prima di creare nuovi file di troubleshooting, LEGGI QUESTO DOCUMENTO!**

Questo documento sostituisce e consolida **35+ file di troubleshooting duplicati** trovati in tutti i moduli.

### ❌ File da NON Creare Più
- `troubleshooting.md` in qualsiasi modulo
- `common-issues.md` duplicati
- `bug-fixes.md` sparsi
- Qualsiasi documentazione troubleshooting specifica di modulo

### ✅ Unica Fonte di Verità
- **Questo file**: `/laravel/Modules/Xot/project_docs/troubleshooting-consolidated.md`
- **Implementazione**: Fix nei singoli moduli (solo fix, non docs)

## Problemi Comuni e Soluzioni

### Errore: ParseError - Metodi Fuori dalla Classe

**Sintomo**
```
ParseError: syntax error, unexpected token "protected", expecting end of file
```

**Causa**
Una funzione viene dichiarata **fuori dal blocco della classe** dopo la parentesi graffa di chiusura `}`.

**Soluzione**
1. Spostare il metodo all'interno della classe corretta
2. Verificare che la parentesi graffa di chiusura sia l'ultima istruzione del file
3. Se il metodo non serve più, eliminarlo

**Esempio**
```php
// ❌ ERRATO
class Example {
    public function foo() {}
} // Chiusura classe

protected function getUserTypeOptions() {} // ERRORE: metodo orfano

// ✅ CORRETTO
class Example {
    public function foo() {}
    
    protected function getUserTypeOptions() {} // Metodo dentro la classe
} // Ultima parentesi graffa
```

### Errore: Namespace Senza Segmento 'App'

**Sintomo**
```
Class not found: Modules\ModuleName\App\Models\Example
```

**Causa**
Utilizzo di namespace con segmento `App` che non esiste nella struttura modulare.

**Soluzione**
```php
// ❌ ERRATO
namespace Modules\ModuleName\App\Models;
namespace Modules\ModuleName\App\Actions;

// ✅ CORRETTO
namespace Modules\ModuleName\Models;
namespace Modules\ModuleName\Actions;
```

**Verifica**
```bash
composer dump-autoload
```

### Errore: Estensione Diretta di Classi Filament

**Sintomo**
```
Call to undefined method Filament\Resources\Resource::getFormSchema()
```

**Causa**
Estensione diretta di classi Filament invece delle classi base Xot.

**Soluzione**
```php
// ❌ ERRATO
use Filament\Resources\Resource;
class ExampleResource extends Resource

// ✅ CORRETTO
use Modules\Xot\Filament\Resources\XotBaseResource;
class ExampleResource extends XotBaseResource
```

### Errore: Service Provider Senza Nome

**Sintomo**
```
Service provider must have a name property
```

**Causa**
Mancanza della proprietà `$name` nel service provider.

**Soluzione**
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ModuleNameServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'ModuleName'; // SEMPRE dichiarare subito

    public function boot(): void
    {
        parent::boot();
    }
}
```

### Errore: Traduzioni Hardcoded

**Sintomo**
Stringhe hardcoded nell'interfaccia invece di traduzioni.

**Causa**
Utilizzo di `->label()` o stringhe dirette invece di file di traduzione.

**Soluzione**
```php
// ❌ ERRATO
TextInput::make('name')->label('Nome')
Select::make('role')->placeholder('Seleziona ruolo')

// ✅ CORRETTO
TextInput::make('name')  // Usa traduzione automatica
Select::make('role')     // Usa traduzione automatica
```

**File di Traduzione**
```php
// Modules/ModuleName/lang/it/fields.php
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Nome completo dell\'utente',
    ],
    'role' => [
        'label' => 'Ruolo',
        'placeholder' => 'Seleziona un ruolo',
        'help' => 'Ruolo dell\'utente nel sistema',
    ],
];
```

### Errore: Migrazioni con Metodo Down()

**Sintomo**
```
Method down() not allowed in XotBaseMigration
```

**Causa**
Implementazione del metodo `down()` in migrazioni che estendono `XotBaseMigration`.

**Soluzione**
```php
// ❌ ERRATO
return new class extends XotBaseMigration {
    public function up(): void { /* ... */ }
    public function down(): void { /* ... */ } // ERRORE
};

// ✅ CORRETTO
return new class extends XotBaseMigration {
    public function up(): void { /* ... */ }
    // NIENTE metodo down()
};
```

### Errore: PHPStan - Livello Troppo Basso

**Sintomo**
```
PHPStan analysis failed at level 5
```

**Causa**
Codice non conforme agli standard di tipizzazione.

**Soluzione**
```bash
# Eseguire da directory Laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
./vendor/bin/phpstan analyze --level=9 --memory-limit=2G
```

**Correzioni Comuni**
```php
// ❌ ERRATO
public function getData() { return $data; }

// ✅ CORRETTO
public function getData(): array { return $data; }

// ❌ ERRATO
public function process($user) { /* ... */ }

// ✅ CORRETTO
public function process(User $user): void { /* ... */ }
```

### Errore: Componenti UI nel Posto Sbagliato

**Sintomo**
```
Component not found: x-logo
```

**Causa**
Componenti UI posizionati in `resources/views/components/` invece di `Modules/UI/resources/views/components/ui/`.

**Soluzione**
```bash
# Spostare componenti nella posizione corretta
mv resources/views/components/ui/* Modules/UI/resources/views/components/ui/
```

**Utilizzo Corretto**
```blade
{{-- ✅ CORRETTO --}}
<x-ui::ui.logo />
<x-ui::ui.button>Salva</x-ui::ui.button>

{{-- ❌ ERRATO --}}
<x-logo />
<x-ui.button>Salva</x-ui.button>
```

### Errore: Helper Text Uguale a Placeholder

**Sintomo**
Duplicazione di testo nell'interfaccia utente.

**Causa**
`helper_text` uguale al `placeholder` o alla chiave dell'array.

**Soluzione**
```php
// ❌ ERRATO
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci indirizzo',
    'helper_text' => 'Inserisci indirizzo', // Uguale a placeholder
],

// ✅ CORRETTO
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci indirizzo',
    'helper_text' => 'Indirizzo completo di residenza o domicilio',
],
```

### Errore: Traduzioni Incomplete

**Sintomo**
Chiavi di traduzione mancanti o incomplete.

**Causa**
Aggiunta di traduzioni senza implementare in tutte le lingue.

**Soluzione**
```php
// Implementare SEMPRE in tutte le lingue
// Modules/ModuleName/lang/it/fields.php
'name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'help' => 'Nome completo',
],

// Modules/ModuleName/lang/en/fields.php
'name' => [
    'label' => 'Name',
    'placeholder' => 'Enter name',
    'help' => 'Full name',
],

// Modules/ModuleName/lang/de/fields.php
'name' => [
    'label' => 'Name',
    'placeholder' => 'Name eingeben',
    'help' => 'Vollständiger Name',
],
```

### Errore: Upload File Placeholder Errato

**Sintomo**
Placeholder che descrive il contenuto invece dell'azione.

**Causa**
Placeholder che indica cosa inserire invece di cosa fare.

**Soluzione**
```php
// ❌ ERRATO
'upload_file' => [
    'placeholder' => 'Numero fattura', // Contenuto
],

// ✅ CORRETTO
'upload_file' => [
    'placeholder' => 'Carica Fattura', // Azione
],
```

### Errore: Mescolanza di Lingue

**Sintomo**
Traduzioni che mescolano lingue diverse.

**Causa**
Utilizzo di termini in inglese in traduzioni italiane.

**Soluzione**
```php
// ❌ ERRATO
'no_show' => 'Messaggio No-Show', // Mescola italiano e inglese

// ✅ CORRETTO
'no_show' => 'Messaggio Non Presentato', // Solo italiano
```

### Errore: Chiave di Traduzione Non Trovata

**Sintomo**
Viene visualizzata la chiave di traduzione anziché il testo tradotto.

**Soluzioni**
1. Verificare il namespace del modulo nella chiamata `__('modulename::path.to.key')`
2. Controllare che il file di traduzione esista nel percorso corretto
3. Controllare che la chiave esista nel file di traduzione
4. Eseguire `php artisan cache:clear` per ripulire la cache

### Errore: Incoerenza Nelle Traduzioni

**Sintomo**
Interfaccia con mix di lingue o stili diversi.

**Soluzioni**
1. Standardizzare i nomi delle chiavi in tutti i moduli
2. Utilizzare editor con supporto per ricerca in più file
3. Creare una documentazione di riferimento per le traduzioni comuni

### Errore: Test che Falliscono Intermittentemente

**Causa**
Test non isolati o dipendenze condivise.

**Soluzione**
```php
class ExampleTest extends TestCase
{
    use RefreshDatabase; // Garantisce database pulito
    
    protected function setUp(): void
    {
        parent::setUp();
        // Setup specifico per ogni test
    }
}
```

### Errore: Test Lenti

**Causa**
Troppi database queries o operazioni costose.

**Soluzione**
```php
// ✅ CORRETTO - Eager loading
$users = User::with(['roles', 'permissions'])->get();

// ❌ ERRATO - N+1 queries
$users = User::all();
foreach ($users as $user) {
    $user->roles; // Query aggiuntiva per ogni utente
}
```

### Errore: Test che Dipendono da Ordine

**Causa**
Test che modificano stato condiviso.

**Soluzione**
```php
// ✅ CORRETTO - Test indipendenti
/** @test */
public function test_a(): void
{
    $this->assertDatabaseCount('users', 0);
    User::factory()->create();
    $this->assertDatabaseCount('users', 1);
}

/** @test */
public function test_b(): void
{
    $this->assertDatabaseCount('users', 0); // Non dipende da test_a
    User::factory()->create();
    $this->assertDatabaseCount('users', 1);
}
```

### Errore: Conflitti Git

**Sintomo**
```
// Codice locale
// Codice remoto
// Codice locale
// Codice remoto
```

**Soluzione**
1. **Analizzare i conflitti**:
   ```bash
   git status --porcelain | grep "^UU\|^AA\|^DD"
   ```

2. **Risolvere manualmente**:
   - Aprire i file con conflitti
   - Decidere quale codice mantenere
   - Rimuovere i marker di conflitto

3. **Completare la risoluzione**:
   ```bash
   git add .
   git commit -m "Resolve merge conflicts"
   ```

### Errore: Autoload Non Aggiornato

**Sintomo**
```
Class not found: Modules\ModuleName\NewClass
```

**Soluzione**
```bash
composer dump-autoload
```

### Errore: Cache Non Pulita

**Sintomo**
Modifiche non visibili nell'applicazione.

**Soluzione**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Errore: Permessi File

**Sintomo**
```
Permission denied: /path/to/file
```

**Soluzione**
```bash
# Verificare permessi
ls -la /path/to/file

# Correggere permessi
chmod 644 /path/to/file
chown www-data:www-data /path/to/file
```

## Checklist di Risoluzione

### Prima di Implementare
- [ ] Studiare la documentazione del modulo
- [ ] Verificare namespace e struttura
- [ ] Controllare ereditarietà delle classi
- [ ] Verificare file di traduzione

### Durante l'Implementazione
- [ ] Seguire convenzioni di naming
- [ ] Utilizzare tipizzazione rigorosa
- [ ] Implementare traduzioni complete
- [ ] Testare funzionalità

### Dopo l'Implementazione
- [ ] Eseguire PHPStan livello 9+
- [ ] Verificare traduzioni in tutte le lingue
- [ ] Aggiornare documentazione
- [ ] Testare regressioni

## Comandi Utili

### Identificazione Conflitti
```bash
# Trova file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista file con conflitti per tipo
git diff --name-only --diff-filter=U
```

### Verifica PHPStan
```bash
# Verifica singolo file
./vendor/bin/phpstan analyse --level=10 path/to/file.php

# Verifica modulo completo
./vendor/bin/phpstan analyse --level=10 laravel/Modules/NomeModulo/
```

### Test Funzionali
```bash
# Test specifico per modulo
php artisan test --testsuite=NomeModulo

# Verifica autoload dopo modifiche
composer dump-autoload
```

### Verifica Struttura
```bash
# Trova file con namespace errati
grep -r "namespace.*App" laravel/Modules/

# Trova stringhe hardcoded
grep -r "->label(" laravel/Modules/ --include="*.php"

# Verifica traduzioni
find laravel/Modules/*/lang -name "*.php" -exec php -l {} \;
```

### Correzione Automatica
```bash
# Aggiorna autoload
composer dump-autoload

# Pulisci cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Verifica PHPStan
./vendor/bin/phpstan analyze --level=9
```

## Best Practices Specifiche

### Moduli Laravel
- **Namespace**: Seguire il pattern `Modules\NomeModulo\...`
- **Service Provider**: Estendere sempre `XotBaseServiceProvider`
- **Models**: Estendere il BaseModel del modulo per centralizzare comportamenti
- **Resources Filament**: Estendere `XotBaseResource` invece di `Resource` direttamente

### Conflitti Tipici nei Moduli
1. **Service Provider**: Verificare registrazione route, view, traduzioni
2. **Composer.json**: Mantenere autoload PSR-4 corretto
3. **Models**: Controllare trait e relazioni
4. **Resources Filament**: Verificare estensione delle classi base corrette

## Collegamenti

- [Best Practices](best-practices-consolidated.md)
- [PHPStan Guide](phpstan-consolidated.md)
- [Translation Guide](translation-system.md)
- [Filament Guide](filament.md)

---

*Ultimo aggiornamento: 2025-08-04*
*Modulo: Xot*
*Categoria: Troubleshooting*
