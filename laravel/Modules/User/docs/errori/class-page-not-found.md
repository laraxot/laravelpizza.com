# Errore: Class Page Not Found in Cluster Pages

## Descrizione dell'Errore

```
Error - Internal Server Error
Class "Modules\User\Filament\Clusters\Appearance\Pages\Page" not found
```

Errore che si verifica quando il namespace di una classe importata non esiste.

## Causa Radice

### Violazione Doppia Regola Laraxot

**Errore #1**: Import errato di `Page`
```php
// ❌ ERRORE in alcuni file Cluster Pages
use Filament\Pages\Page;  // Viola regola: MAI estendere Filament direttamente!

class Colors extends Page  // ❌ Estensione diretta Filament
{
    //...
}
```

**Errore #2**: Cluster estende Filament direttamente
```php
// ❌ ERRORE in Appearance.php
use Filament\Clusters\Cluster;

class Appearance extends Cluster  // ❌ Viola regola XotBase!
{
    //...
}
```

## Files Affetti

Scansione effettuata:
```bash
grep -r "use Filament\\\\Pages\\\\Page" Modules/User/app/Filament/Clusters/Appearance/Pages/
```

**Files con violazioni**:
1. `Alignment.php` - use Filament\Pages\Page
2. `Colors.php` - use Filament\Pages\Page
3. `Background.php` - use Filament\Pages\Page

**Files corretti**:
1. ✅ `CustomCss.php` - use Modules\Xot\Filament\Pages\XotBasePage
2. ✅ `Favicon.php` - use Modules\Xot\Filament\Pages\XotBasePage
3. ✅ `Logo.php` - use Modules\Xot\Filament\Pages\XotBasePage

## Soluzione

### Correzione Cluster Pages

```php
// ❌ PRIMA (ERRATO)
<?php

namespace Modules\User\Filament\Clusters\Appearance\Pages;

use Filament\Pages\Page;  // ❌ Diretto!

class Colors extends Page  // ❌ Violazione!
{
    protected static ?string $cluster = Appearance::class;
}
```

```php
// ✅ DOPO (CORRETTO)
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Appearance\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;  // ✅ XotBase!

/**
 * ⚠️ IMPORTANTE: Estende XotBasePage, MAI Filament\Pages\Page direttamente!
 */
class Colors extends XotBasePage  // ✅ Corretto!
{
    protected static ?string $cluster = Appearance::class;
}
```

### Correzione Cluster

```php
// ❌ PRIMA (ERRATO)
<?php

namespace Modules\User\Filament\Clusters;

use Filament\Clusters\Cluster;  // ❌ Diretto!

class Appearance extends Cluster  // ❌ Violazione!
{
    //...
}
```

```php
// ✅ DOPO (CORRETTO)
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;  // ✅ XotBase!

/**
 * ⚠️ IMPORTANTE: Estende XotBaseCluster, MAI Filament\Clusters\Cluster!
 */
class Appearance extends XotBaseCluster  // ✅ Corretto!
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
}
```

## Cosa Sono i Clusters Filament 4

### Business Logic

**Clusters** = Raggruppamenti logici di Pages/Resources nel menu navigation.

**Scopo**: Organizzare interface complessa con molte sezioni.

**Esempio**:
```
Menu
├── Dashboard
├── 📁 Appearance (Cluster)
│   ├── Colors
│   ├── Logo
│   ├── Favicon
│   └── Custom CSS
├── 📁 Settings (Cluster)
│   ├── General
│   └── Advanced
└── Users (Resource)
```

### Gerarchia Corretta

```
Filament\Clusters\Cluster
    ↓ NO! VIETATO!
    ↓
Modules\Xot\Filament\Clusters\XotBaseCluster
    ↓ SI! CORRETTO!
    ↓
Modules\User\Filament\Clusters\Appearance
```

### Cluster Pages

**IMPORTANTE**: Le Pages dentro un Cluster sono **Standalone Pages** (NON Resource Pages)!

```php
// Cluster Page = Standalone Page + property $cluster
namespace Modules\User\Filament\Clusters\Appearance\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;  // ✅ Standalone!

class Colors extends XotBasePage
{
    protected static ?string $cluster = Appearance::class;  // ← Assegnata al cluster
    protected static ?string $navigationIcon = 'heroicon-o-swatch';
}
```

## Procedura di Correzione

### Step 1: Identificare Files Violazione

```bash
cd laravel

# Trova tutti i file che importano Page direttamente
grep -r "use Filament\\\\Pages\\\\Page" Modules/User/app/Filament/Clusters/ --include="*.php"

# Trova tutti i file che estendono Cluster direttamente
grep -r "extends Cluster" Modules/User/app/Filament/Clusters/ --include="*.php" | grep -v "XotBase"
```

### Step 2: Correggere Import

Per ogni file trovato:
1. Sostituire `use Filament\Pages\Page` con `use Modules\Xot\Filament\Pages\XotBasePage`
2. Aggiungere `declare(strict_types=1);`
3. Aggiungere PHPDoc warning
4. Verificare che esten da XotBasePage

### Step 3: Correggere Cluster

```php
// Modules/User/app/Filament/Clusters/Appearance.php
use Modules\Xot\Filament\Clusters\XotBaseCluster;

class Appearance extends XotBaseCluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
}
```

### Step 4: Pulire Cache

```bash
php artisan optimize:clear
```

### Step 5: Testare

```bash
# Verificare che le pagine siano accessibili
curl http://personale2022.prov.tv.local/user/admin/appearance/colors
```

## Mappatura Cluster Components

| Componente | ❌ NON Usare | ✅ Usare |
|------------|-------------|----------|
| **Cluster** | `Filament\Clusters\Cluster` | `Modules\Xot\Filament\Clusters\XotBaseCluster` |
| **Cluster Page** | `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |

**IMPORTANTE**: Cluster Pages sono **SEMPRE Standalone Pages**, mai Resource Pages!

## Prevenzione

### Checklist Cluster Pages

- [ ] Cluster estende `XotBaseCluster`
- [ ] Ogni Page estende `XotBasePage` (Standalone)
- [ ] Ogni Page ha `protected static ?string $cluster = MyCluster::class`
- [ ] Nessun import diretto di classi Filament
- [ ] Nessun uso di ->label() o ->tooltip()
- [ ] File in path: `Modules/[Module]/app/Filament/Clusters/[ClusterName]/Pages/`

### Script Validazione

```bash
#!/bin/bash
# Valida Cluster Pages

echo "🔍 Validazione Cluster Pages..."

# Check Clusters estendono XotBaseCluster
CLUSTER_VIOLATIONS=$(find Modules/*/app/Filament/Clusters -maxdepth 1 -name "*.php" -type f \
    -exec grep -l "extends Cluster" {} \; \
    | xargs grep -L "XotBaseCluster" \
    | wc -l)

if [ $CLUSTER_VIOLATIONS -gt 0 ]; then
    echo "❌ ERRORE: $CLUSTER_VIOLATIONS Clusters estendono Filament direttamente!"
fi

# Check Cluster Pages estendono XotBasePage
PAGE_VIOLATIONS=$(find Modules/*/app/Filament/Clusters/*/Pages -name "*.php" -type f \
    -exec grep -l "extends Page" {} \; \
    | xargs grep -L "XotBasePage" \
    | wc -l)

if [ $PAGE_VIOLATIONS -gt 0 ]; then
    echo "❌ ERRORE: $PAGE_VIOLATIONS Cluster Pages estendono Filament direttamente!"
fi

echo "✅ Validazione completata"
```

## Best Practice Clusters

### 1. Struttura Corretta

```
Modules/User/app/Filament/Clusters/
├── Appearance.php (extends XotBaseCluster)
└── Appearance/
    └── Pages/
        ├── Colors.php (extends XotBasePage + $cluster)
        ├── Logo.php (extends XotBasePage + $cluster)
        └── Favicon.php (extends XotBasePage + $cluster)
```

### 2. Template Cluster

```php
<?php

declare(strict_types=1);

namespace Modules\[Module]\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

class MyCluster extends XotBaseCluster
{
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    
    // NO navigationLabel hardcoded!
    // Gestito automaticamente da NavigationLabelTrait
}
```

### 3. Template Cluster Page

```php
<?php

declare(strict_types=1);

namespace Modules\[Module]\Filament\Clusters\MyCluster\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\[Module]\Filament\Clusters\MyCluster;

/**
 * ⚠️ IMPORTANTE: Estende XotBasePage (Standalone), MAI Filament\Pages\Page!
 * 
 * Cluster Pages sono SEMPRE Standalone Pages con property $cluster.
 */
class MyPage extends XotBasePage
{
    protected static ?string $cluster = MyCluster::class;
    protected string $view = '[module]::filament.clusters.my-cluster.pages.my-page';
}
```

## Collegamenti

### Documentazione Correlata
- [XotBase Architecture](../../Xot/docs/xotbase-architecture-complete.md)
- [Mai Estendere Filament Direttamente](../../Xot/docs/errori-critici/mai-estendere-filament-direttamente.md)
- [Standalone vs Resource Pages](../../Xot/docs/filament/standalone-vs-resource-pages.md)

### Clusters in Xot
- [XotBaseCluster](../../Xot/app/Filament/Clusters/XotBaseCluster.php)
- [Cluster Best Practices](../../Xot/docs/filament/clusters.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Severità**: Alta  
**Tipo Errore**: Import classe inesistente + Violazione regola XotBase  
**Files Affetti**: 3 Pages + 1 Cluster


