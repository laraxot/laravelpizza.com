# Guida Completa: Upgrade Filament 5 + Livewire 4 - Modulo Xot

**Ultimo aggiornamento:** [DATE]

## 📋 Sommario

Questa guida documenta l'upgrade da Filament 4.x + Livewire 3.x a Filament 5.x + Livewire 4.x per il progetto Laraxot, con particolare focus sul modulo Xot e le sue classi base.

---

## 🎯 Informazioni Chiave

### Requisiti per Filament 5

- **PHP**: `>= 8.2` ✅ (Il progetto ha 8.3.6)
- **Laravel**: `>= 11.28` ⚠️ (Da verificare)
- **Livewire**: `>= 4.0` ⚠️ (Attualmente 3.7.6)
- **Tailwind CSS**: `>= 4.0` ⚠️ (Da verificare)

### Stato Attuale del Progetto

- **Filament**: v4.6.3
- **Livewire**: v3.7.6
- **Obiettivo**: Filament v5.x + Livewire v4.x

### Punti Fondamentali

1. **Filament 5 esiste principalmente per supportare Livewire 4**
2. **Non ci sono breaking changes funzionali tra Filament 4 e 5** (oltre a Livewire v4)
3. **L'upgrade è considerato a basso rischio**
4. **Nuove features continueranno per entrambe le versioni**

---

## 🔍 Breaking Changes: Livewire 3 → 4

### 1. Config File Updates (CRITICO)

Le chiavi di configurazione sono state rinominate in Livewire 4:

#### Chiavi Rinominate

```php
// ❌ Livewire 3
'layout' => 'components.layouts.app',
'lazy_placeholder' => 'livewire.placeholder',

// ✅ Livewire 4
'component_layout' => 'layouts::app',
'component_placeholder' => 'livewire.placeholder',
```

#### Nuovi Default

```php
// Livewire 4 default (era false in v3)
'smart_wire_keys' => true,
```

#### Nuove Opzioni di Configurazione

```php
// Posizioni componenti
'component_locations' => [
    resource_path('views/components'),
    resource_path('views/livewire'),
],

// Namespace componenti
'component_namespaces' => [
    'layouts' => resource_path('views/layouts'),
    'pages' => resource_path('views/pages'),
],

// Default comando make
'make_command' => [
    'type' => 'sfc',  // 'sfc', 'mfc', o 'class'
    'emoji' => true,   // Prefisso emoji ⚡
],

// Modalità CSP-safe
'csp_safe' => false,
```

### 2. Routing Changes

Per componenti full-page, l'approccio consigliato è cambiato:

```php
// ❌ Livewire 3 (ancora supportato ma non raccomandato)
Route::get('/dashboard', Dashboard::class);

// ✅ Livewire 4 (raccomandato)
Route::livewire('/dashboard', Dashboard::class);

// Per componenti view-based
Route::livewire('/dashboard', 'pages::dashboard');
```

### 3. `wire:model` Behavior Change (IMPORTANTE)

In Livewire 4, `wire:model` **non ascolta più gli eventi dei figli** di default:

```php
// ❌ Livewire 3 - ascoltava eventi figli
<div wire:model="value">
    <input type="text">
</div>

// ✅ Livewire 4 - usa .deep per ripristinare comportamento vecchio
<div wire:model.deep="value">
    <input type="text">
</div>
```

**Nota:** Questo influenza solo usi non-standard di `wire:model` su elementi contenitore. I binding standard (input, select, textarea) non sono influenzati.

### 4. `wire:model` Modifiers Control Sync Timing

In Livewire 4, i modificatori `.blur` e `.change` controllano quando lo stato client-side viene sincronizzato:

```php
// Livewire 3
<input wire:model.blur="title">

// Livewire 4 equivalente
<input wire:model.live.blur="title">
```

| Livewire 3 | Livewire 4 Equivalente |
|-------------|------------------------|
| `wire:model.blur` | `wire:model.live.blur` |
| `wire:model.change` | `wire:model.live.change` |

**Nota:** `.lazy` rimane compatibile senza modifiche.

### 5. `wire:transition` Uses View Transitions API

In Livewire 4, `wire:transition` usa la View Transitions API nativa del browser:

```php
// ✅ Ancora funzionante
<div wire:transition>...</div>

// ❌ Modificatori non più supportati
<div wire:transition.opacity>...</div>
<div wire:transition.scale.origin.top>...</div>
<div wire:transition.duration.500ms>...</div>
```

### 6. Component Tags Must Be Closed

In Livewire 4, i tag dei componenti devono essere correttamente chiusi:

```php
// ❌ Livewire 3 - tag non chiuso
<livewire:component-name>

// ✅ Livewire 4 - self-closing
<livewire:component-name />

// ✅ Livewire 4 - con chiusura esplicita
<livewire:component-name>
    <!-- slot content -->
</livewire:component-name>
```

### 7. `wire:scroll` → `wire:navigate:scroll`

```php
// ❌ Livewire 3
<div class="overflow-y-scroll" wire:scroll>
    <!-- ... -->
</div>

// ✅ Livewire 4
<div class="overflow-y-scroll" wire:navigate:scroll>
    <!-- ... -->
</div>
```

### 8. Method Signature Changes

#### Streaming

```php
// ❌ Livewire 3
$this->stream(to: '#container', content: 'Hello', replace: true);

// ✅ Livewire 4
$this->stream(content: 'Hello', replace: true, el: '#container');
```

#### Component Mounting

```php
// ❌ Livewire 3
public function mount($name, $params = [], $key = null)

// ✅ Livewire 4
public function mount($name, $params = [], $key = null, $slots = [])
```

---

## 🆕 Nuove Features Livewire 4

### 1. Single-File and Multi-File Components

```bash
# Single-file (default)
php artisan make:livewire create-post

# Multi-file
php artisan make:livewire create-post --mfc

# Convertire tra formati
php artisan livewire:convert create-post
```

### 2. Slots and Attribute Forwarding

I componenti ora supportano slots e forwarding automatico degli attributi:

```blade
{{-- Componente --}}
<div {{ $attributes }}>
    {{ $slot }}
</div>

{{-- Uso --}}
<livewire:my-component class="bg-blue-500">
    Content here
</livewire:my-component>
```

### 3. JavaScript in View-Based Components

```blade
<div>
    <!-- Template -->
</div>

<script>
    // $wire è automaticamente bindato come 'this'
    this.count++  // Stesso di $wire.count++

    // $wire è ancora disponibile
    $wire.save()
</script>
```

### 4. Islands

Regioni isolate che si aggiornano indipendentemente:

```blade
@island(name: 'stats', lazy: true)
    <div>{{ $this->expensiveStats }}</div>
@endisland
```

### 5. Loading Improvements

```blade
<!-- Deferred loading (dopo il caricamento pagina) -->
<livewire:revenue defer />

<!-- Bundled loading -->
<livewire:revenue lazy.bundle />
<livewire:expenses defer.bundle />
```

### 6. Async Actions

```php
<!-- Modificatore .async -->
<button wire:click.async="logActivity">Track</button>

<!-- Oppure attributo #[Async] -->
#[Async]
public function logActivity()
{
    // ...
}
```

### 7. New Directives and Modifiers

#### `wire:sort` - Drag-and-Drop

```blade
<ul wire:sort="updateOrder">
    @foreach ($items as $item)
        <li wire:sort:item="{{ $item->id }}" wire:key="{{ $item->id }}">
            {{ $item->name }}
        </li>
    @endforeach
</ul>
```

#### `wire:intersect` - Viewport Intersection

```blade
<!-- Basic -->
<div wire:intersect="loadMore">...</div>

<!-- Con modificatori -->
<div wire:intersect.once="trackView">...</div>
<div wire:intersect:leave="pauseVideo">...</div>
<div wire:intersect.half="loadMore">...</div>
<div wire:intersect.full="startAnimation">...</div>
```

#### `wire:ref` - Element References

```blade
<div wire:ref="modal">
    <!-- Modal content -->
</div>

<button wire:click="$js.scrollToModal">Scroll to modal</button>

<script>
    this.$js.scrollToModal = () => {
        this.$refs.modal.scrollIntoView()
    }
</script>
```

#### Nuovi Modificatori

```php
<!-- Renderless - salta re-rendering -->
<button wire:click.renderless="trackClick">Track</button>

<!-- Preserve scroll -->
<button wire:click.preserve-scroll="loadMore">Load More</button>

<!-- Data-loading attribute automatico -->
<button wire:click="save" class="data-loading:opacity-50">
    Save Changes
</button>
```

---

## 🔄 Breaking Changes: Filament 4 → 5

### Punti Chiave

1. **Filament 5 non introduce breaking changes funzionali** rispetto a Filament 4
2. **L'unico motivo per l'upgrade è il supporto a Livewire 4**
3. **API Filament rimangono compatibili**
4. **Script di upgrade automatico disponibile**

### Cosa NON Cambia

- **Resources**: `XotBaseResource` continua a funzionare senza modifiche
- **Pages**: `XotBaseListRecords`, `XotBaseEditRecord`, etc. rimangono compatibili
- **Widgets**: `XotBaseWidget` e subclassi non richiedono modifiche
- **Actions**: `XotBaseAction`, `XotBaseTableAction`, `XotBaseBulkAction` rimangono validi
- **Forms**: Schema-based forms continuano a funzionare
- **Tables**: Colonne e filtri non richiedono cambiamenti
- **Infolists**: Schema-based infolists rimangono compatibili

### Cosa Cambia (Livewire 4)

Tutti i cambiamenti sono legati alla migrazione a Livewire 4:

1. **Configurazione Livewire** da aggiornare
2. **Routing Livewire** da aggiornare
3. **wire:model behavior** da verificare
4. **Tag componenti** devono essere chiusi
5. **wire:transition** senza modificatori
6. **JavaScript hooks** deprecati

---

## 📝 Procedure di Upgrade

### Fase 1: Preparazione

#### 1.1 Backup

```bash
cp -r /var/www/_bases/base_laravelpizza/laravel \
      /var/www/_bases/base_laravelpizza_backup_$(date +%Y%m%d)
```

#### 1.2 Risolvere Conflitti Git

Il progetto ha conflitti git da risolvere prima dell'upgrade:

```bash
cd /var/www/_bases/base_laravelpizza

# Verifica stato git
git status

# Risolvi conflitti (es. SsoProviderResource.php)
git add .
git commit -m "Risolto conflitti git prima upgrade Filament 5"
```

### Fase 2: Aggiornamento Livewire Config

#### 2.1 Aggiorna `config/livewire.php`

```php
// ❌ DA RIMUOVERE/LIVELLARE
'layout' => 'components.layouts.app',
'lazy_placeholder' => null,
'smart_wire_keys' => false,

// ✅ DA AGGIUNGERE/MODIFICARE
'component_layout' => 'layouts::app',
'component_placeholder' => null,
'smart_wire_keys' => true,

// Nuove opzioni (aggiungi se necessario)
'component_locations' => [
    resource_path('views/components'),
    resource_path('views/livewire'),
],

'component_namespaces' => [
    'layouts' => resource_path('views/layouts'),
    'pages' => resource_path('views/pages'),
],

'make_command' => [
    'type' => 'class',  // Mantieni comportamento v3
    'emoji' => false,
],

'csp_safe' => false,
```

### Fase 3: Upgrade Filament

#### 3.1 Installa Script di Upgrade

```bash
cd /var/www/_bases/base_laravelpizza/laravel

composer require filament/upgrade:"^5.0" -W --dev
```

#### 3.2 Esegui Script di Upgrade

```bash
vendor/bin/filament-v5
```

Lo script:
- Analizzerà il codice del progetto
- Applicherà refactor automatici
- Suggerirà comandi specifici per il progetto

#### 3.3 Applica Comandi Suggeriti

Segui i comandi output dallo script (esempio tipico):

```bash
composer require filament/filament:"^5.0" -W --no-update
composer update
```

#### 3.4 Rimuovi Script di Upgrade

```bash
composer remove filament/upgrade --dev
```

### Fase 4: Aggiornamento Livewire

#### 4.1 Aggiorna Livewire a v4

```bash
composer require livewire/livewire:^4.0 -W
```

#### 4.2 Pulisci Cache

```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

### Fase 5: Verifiche e Fix Manuali

#### 5.1 Verifica wire:model Usage

Cerca usi non-standard di `wire:model`:

```bash
grep -r "wire:model" Modules/*/resources/views --include="*.blade.php"
```

Se trovi `wire:model` su elementi contenitore (non input/select/textarea), aggiungi `.deep`:

```blade
<!-- Aggiungi .deep se il contenitore ha input figli -->
<div wire:model.deep="value">
    <input type="text">
</div>
```

#### 5.2 Verifica wire:transition

Cerca modificatori non supportati:

```bash
grep -r "wire:transition\." Modules/*/resources/views --include="*.blade.php"
```

Rimuovi i modificatori:

```blade
<!-- ❌ Rimuovi modificatori -->
<div wire:transition.opacity>...</div>

<!-- ✅ Usa solo base -->
<div wire:transition>...</div>
```

#### 5.3 Verifica wire:scroll

Cerca e sostituisci:

```bash
grep -r "wire:scroll" Modules/*/resources/views --include="*.blade.php"
```

Sostituisci con `wire:navigate:scroll`:

```blade
<!-- ❌ -->
<div wire:scroll>...</div>

<!-- ✅ -->
<div wire:navigate:scroll>...</div>
```

#### 5.4 Verifica Component Tags

Assicurati che tutti i tag componenti siano chiusi:

```blade
<!-- ❌ -->
<livewire:component-name>

<!-- ✅ -->
<livewire:component-name />

<!-- ✅ Oppure con contenuto -->
<livewire:component-name>
    Content
</livewire:component-name>
```

### Fase 6: Build e Test

#### 6.1 Build Frontend

```bash
npm run build
# Oppure per dev
npm run dev
```

#### 6.2 Verifica Filament Panel

```bash
php artisan serve
```

Naviga al pannello Filament e verifica:
- [ ] Login funziona
- [ ] Resources si caricano
- [ ] Forms funzionano
- [ ] Tables si caricano
- [ ] Actions funzionano
- [ ] Widgets si caricano

#### 6.3 Test PHPStan

```bash
./vendor/bin/phpstan analyse Modules/Xot --level=10
```

#### 6.4 Test Applicazione

Esegui test funzionali e manuali su tutte le funzionalità chiave.

---

## 🧩 Compatibilità Plugin Filament

### Plugin da Verificare

Nel progetto Laraxot, verifica i seguenti plugin:

#### 1. `filament/spatie-laravel-media-library-plugin`

Verifica compatibilità v5:
```bash
composer show filament/spatie-laravel-media-library-plugin
```

Se non compatibile:
- Disabilita temporaneamente
- Cerca alternativa v5-compatibile
- Attendi aggiornamento

#### 2. Plugin Custom

Verifica tutti i plugin custom nei moduli:
- `Modules/Xot/packages/coolsam/panel-modules`
- Altri plugin definiti nei composer.json dei moduli

### Strategia per Plugin Non Compatibili

1. **Documentare** il plugin e la sua funzionalità
2. **Disabilitare temporaneamente** rimuovendo dal composer.json
3. **Cercare alternative** v5-compatibili
4. **Creare fork** e aggiornare se open-source
5. **Contattare autore** per aggiornamento

---

## 📚 Aggiornamento Documentazione Moduli

### Ogni Modulo Deve Aggiornare

Per ogni modulo che usa Filament:

#### 1. Crea/Aggiaorna Documento Upgrade

```
Modules/ModuleName/docs/filament-5-upgrade.md
```

#### 2. Struttura Minima

```markdown
# Filament 5 Upgrade - Modulo ModuleName

## Panoramica
Breve descrizione di cosa fa il modulo con Filament

## Versioni
- Filament: 4.x → 5.x
- Livewire: 3.x → 4.x

## Files Modificati
- Elenco file con brevi descrizioni

## Breaking Changes Risolti
- Lista di breaking changes risolti

## Nuove Features Implementate
- Nuove features di Livewire 4 utilizzate

## Checklist
- [ ] Config Livewire aggiornato
- [ ] wire:model verificato
- [ ] wire:transition aggiornato
- [ ] Component tags chiusi
- [ ] Test completati

## Note
Qualsiasi nota importante o problema riscontrato
```

#### 3. Collega a Documento Xot

Aggiungi link nel documento locale:

```markdown
Vedi anche: [Guida Completa Xot](../Xot/docs/filament-5-livewire-4-complete-guide.md)
```

---

## ✅ Checklist Completa Upgrade

### Pre-Upgrade
- [ ] Backup creato
- [ ] Conflitti git risolti
- [ ] Commit delle modifiche attuali
- [ ] Documentazione esistente letta

### Config Updates
- [ ] `config/livewire.php` aggiornato (layout → component_layout)
- [ ] `config/livewire.php` aggiornato (lazy_placeholder → component_placeholder)
- [ ] `smart_wire_keys` impostato a `true`

### Filament Upgrade
- [ ] `filament/upgrade` installato (dev)
- [ ] `vendor/bin/filament-v5` eseguito
- [ ] Comandi script applicati
- [ ] `filament/filament` aggiornato a `^5.0`
- [ ] `composer update` completato senza errori
- [ ] `filament/upgrade` rimosso

### Livewire Upgrade
- [ ] `livewire/livewire` aggiornato a `^4.0`
- [ ] Cache pulita (`optimize:clear`, `config:clear`, `cache:clear`)

### Code Updates
- [ ] `wire:model` non-standard aggiornati (aggiunto `.deep`)
- [ ] `wire:transition` modificatori rimossi
- [ ] `wire:scroll` → `wire:navigate:scroll`
- [ ] Component tags chiusi correttamente
- [ ] Routing Livewire aggiornato (`Route::livewire()`)

### Plugin Verification
- [ ] `filament/spatie-laravel-media-library-plugin` compatibile
- [ ] Tutti i plugin custom verificati
- [ ] Plugin non compatibili documentati/disabilitati

### Build & Test
- [ ] `npm run build` completato
- [ ] Filament panel accessibile
- [ ] Login funziona
- [ ] Resources caricate
- [ ] Forms funzionanti
- [ ] Tables funzionanti
- [ ] Actions funzionanti
- [ ] Widgets funzionanti
- [ ] PHPStan livello 10 senza errori
- [ ] Test applicazione completati

### Documentation
- [ ] Documento Xot aggiornato (questo file)
- [ ] Documento rules aggiornato (`filament-5-laraxot-rules.md`)
- [ ] Documento upgrade aggiornato (`filament-5-upgrade-guide.md`)
- [ ] Tutti i moduli hanno doc upgrade
- [ ] README moduli aggiornati

---

## 🔧 Risoluzione Problemi Comuni

### Problema: Errore dopo `composer update`

**Sintomo:** Conflitti di dipendenze o versioni

**Soluzione:**
```bash
composer update --no-write
composer install
composer dump-autoload
```

### Problema: wire:model non funziona come prima

**Sintomo:** Input in contenitori non aggiornano lo stato

**Soluzione:** Aggiungi `.deep`:
```blade
<div wire:model.deep="value">
    <input type="text">
</div>
```

### Problema: wire:transition non funziona

**Sintomo:** Transizioni non funzionano o danno errore

**Soluzione:** Rimuovi modificatori:
```blade
<!-- ❌ -->
<div wire:transition.opacity.duration.200ms>

<!-- ✅ -->
<div wire:transition>
```

### Problema: Componente non renderizza

**Sintomo:** Tag componente vuoto o non renderizza

**Soluzione:** Chiudi il tag:
```blade
<!-- ❌ -->
<livewire:my-component>

<!-- ✅ -->
<livewire:my-component />
```

### Problema: Filament panel non carica

**Sintomi:** 500 error, blank page, o errors in console

**Soluzioni:**
1. Pulisci cache: `php artisan optimize:clear`
2. Verifica config Livewire
3. Controlla log: `storage/logs/laravel.log`
4. Verifica plugin compatibili
5. Disabilita plugin problematici

### Problema: PHPStan errors

**Sintomo:** PHPStan trova nuovi errori dopo upgrade

**Soluzione:**
1. Verifica se errori sono reali o false-positive
2. Aggiorna phpstan-baseline se necessario
3. Verifica compatibilità tipo-safe functions
4. Controlla namespace imports

---

## 📖 Risorse

### Documentazione Ufficiale

- [Filament 5 Upgrade Guide](https://filamentphp.com/docs/5.x/upgrade-guide)
- [Filament 5 Documentation](https://filamentphp.com/docs/5.x)
- [Livewire 4 Upgrade Guide](https://livewire.laravel.com/docs/4.x/upgrading)
- [Livewire 4 Documentation](https://livewire.laravel.com/docs/4.x)

### Articoli e News

- [Laravel News: Filament 5 Released](https://laravel-news.com/filament-5)
- [Filament Releases](https://github.com/filamentphp/filament/releases)

### Community

- [Filament Discord](https://discord.com/invite/filament)
- [Filament GitHub Discussions](https://github.com/filamentphp/filament/discussions)
- [Laracasts Forum](https://laracasts.com/discuss/channels/filament)

---

## 🔄 Timeline Suggerita

### Giorno 1: Preparazione (2-3 ore)
- [ ] Backup e commit
- [ ] Risoluzione conflitti git
- [ ] Studio documentazione
- [ ] Aggiornamento documentazione Xot

### Giorno 2: Config e Script (1-2 ore)
- [ ] Aggiornamento config Livewire
- [ ] Installazione script upgrade
- [ ] Esecuzione script e comandi
- [ ] Aggiornamento Livewire

### Giorno 3: Code Updates (2-3 ore)
- [ ] Verifica e fix wire:model
- [ ] Verifica e fix wire:transition
- [ ] Verifica e fix wire:scroll
- [ ] Verifica component tags
- [ ] Build frontend

### Giorno 4: Test e Documentazione (3-4 ore)
- [ ] Test completi applicazione
- [ ] Verifica plugin
- [ ] Aggiornamento documentazione moduli
- [ ] PHPStan e linting

---

## 📝 Note Finali

### Punti Chiave da Ricordare

1. **Filament 5 = Filament 4 + Livewire 4**
2. **Nessun breaking change funzionale Filament**
3. **Tutti i cambiamenti sono Livewire 4**
4. **Upgrade a basso rischio**
5. **Documentazione completa essenziale**

### Raccomandazioni

1. **Testa su ambiente staging prima di produzione**
2. **Esegui backup completo prima di iniziare**
3. **Documenta ogni passo e problema riscontrato**
4. **Aggiorna la documentazione di ogni modulo**
5. **Testa tutte le funzionalità critiche**

### Supporto

Se incontri problemi:
1. Controlla log Laravel
2. Verifica documentazione ufficiale
3. Cerca in Discord/GitHub Discussions
4. Apri issue se necessario

---

*Documento mantenuto da: Marco Sottana*
*Ultimo aggiornamento: [DATE]*
*Progetto: Laraxot / base_laravelpizza*