# Guida alla Conversione Filament 3 → Filament 4

## Panoramica

Questa guida documenta il processo di conversione del progetto PTVX da Filament 3 a Filament 4, seguendo le best practices Laraxot e garantendo la compatibilità con PHPStan livello 10.

## Requisiti Pre-Conversione

### Requisiti di Sistema
- **PHP**: 8.2+ (attualmente il progetto supporta PHP 8.1+, necessario upgrade)
- **Laravel**: 11.28+ (attualmente v10.x, necessario upgrade)
- **Composer**: 2.x
- **PHPStan**: Livello 10 (nessun errore tollerato)

### Preparazione Ambiente
1. **Backup completo** del progetto
2. **Commit** di tutti i cambiamenti in corso
3. **Branch dedicato** per la conversione
4. **Test suite** completa funzionante

## Breaking Changes Principali

### 1. Architettura Panel
- **Prima (v3)**: Configurazione in `config/filament.php`
- **Dopo (v4)**: Panel Provider dedicato in `app/Providers/Filament/`

### 2. Resource Structure
- **Prima (v3)**: Metodi diretti nelle Resource
- **Dopo (v4)**: Struttura più modulare con Pages separate

### 3. Widget System
- **Prima (v3)**: Widget registrati globalmente
- **Dopo (v4)**: Widget associati a Panel specifici

### 4. Form Components & Infolists
- **Prima (v3)**: Component misti, alcuni deprecati
- **Dopo (v4)**: Tre sistemi distinti (Forms, Infolists, Tables)
- **Infolists**: Nuovo sistema per visualizzazione readonly
- **TextEntry**: Deprecato in Forms, raccomandato in Infolists
- **Placeholder**: Valido in Forms, NON deprecato

## Processo di Conversione

### Fase 1: Upgrade Laravel
```bash
# 1. Aggiorna Laravel 10 → 11
composer require laravel/framework:"^11.0" --update-with-all-dependencies

# 2. Pubblica e aggiorna le configurazioni
php artisan vendor:publish --tag=laravel-assets --ansi --force

# 3. Aggiorna le dipendenze
composer update
```

### Fase 2: Installazione Filament 4
```bash
# 1. Installa il tool di upgrade
composer require filament/upgrade:"^4.0" -W --dev

# 2. Esegui lo script di conversione automatica
vendor/bin/filament-v4

# 3. Aggiorna Filament alla v4
composer require filament/filament:"^4.0" --with-all-dependencies
```

### Fase 3: Conversione Manuale Moduli

#### Moduli da Convertire
1. **Xot** (base, priorità massima)
2. **User** (autenticazione)
3. **UI** (componenti base)
4. **Tenant** (multi-tenancy)
5. Altri moduli in ordine di dipendenza

#### Pattern di Conversione per ogni Modulo

**1. Service Provider**
```php
// Prima (v3)
class ModuleServiceProvider extends XotBaseServiceProvider
{
    // Configurazione diretta
}

// Dopo (v4) - Se necessario Panel Provider
class ModulePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('module')
            ->path('/module')
            ->colors([...])
            ->resources([...])
            ->widgets([...]);
    }
}
```

**2. Resources**
```php
// Prima (v3)
class ResourceClass extends XotBaseResource
{
    public static function form(Form $form): Form { ... }
    public static function table(Table $table): Table { ... }
}

// Dopo (v4) - Struttura mantenuta ma verificare API changes
class ResourceClass extends XotBaseResource
{
    // Stessa struttura, ma con eventuali aggiornamenti API
    public static function form(Form $form): Form { ... }
    public static function table(Table $table): Table { ... }
}
```

**3. Widgets**
```php
// Prima (v3)
class WidgetClass extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
}

// Dopo (v4) - Verificare nuove API
class WidgetClass extends BaseWidget
{
    // Possibili cambiamenti nelle API dei widget
}
```

### Fase 4: Aggiornamento XotBase Classes

Le classi base del modulo Xot devono essere aggiornate per supportare Filament 4:

1. **XotBaseResource**
2. **XotBaseServiceProvider**
3. **XotBaseRelationManager**
4. **BaseCalendarWidget** (UI module)

### Fase 5: Verifica Traduzioni

Mantenere la struttura espansa delle traduzioni:
```php
// Struttura mantenuta
'fields' => [
    'nome_campo' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder',
        'help' => 'Testo di aiuto'
    ]
]
```

## Checklist di Conversione

### Pre-Conversione
- [ ] Backup completo progetto
- [ ] Branch dedicato creato
- [ ] Test suite verde
- [ ] Documentazione letta e compresa

### Durante Conversione
- [ ] Laravel aggiornato a 11.28+
- [ ] PHP aggiornato a 8.2+
- [ ] Filament upgrade tool eseguito
- [ ] Filament 4 installato
- [ ] Moduli convertiti uno per uno
- [ ] XotBase classes aggiornate

### Post-Conversione
- [ ] PHPStan analyse senza errori
- [ ] Test suite completamente verde
- [ ] Funzionalità critiche verificate
- [ ] Performance testing
- [ ] Documentazione aggiornata

## Errori Comuni e Soluzioni

### 1. Namespace Changes
**Problema**: Cambiamenti nei namespace di Filament
**Soluzione**: Aggiornare tutti gli import e use statements

### 2. Deprecated Methods
**Problema**: Metodi deprecati in v3 rimossi in v4
**Soluzione**: Sostituire con nuove API equivalenti

### 3. Configuration Changes
**Problema**: Struttura configurazione cambiata
**Soluzione**: Migrare da config file a Panel Provider

### 4. Widget Registration
**Problema**: Sistema di registrazione widget cambiato
**Soluzione**: Associare widget ai Panel specifici

## Compatibilità PHPStan

Tutti i cambiamenti devono mantenere compatibilità PHPStan livello 10:

```bash
# Verifica dopo ogni modifica
./vendor/bin/phpstan analyse Modules --level=10

# Nessun errore deve essere ignorato
# Tutti gli errori devono essere corretti
```

## Testing Strategy

### 1. Unit Tests
- Testare ogni modulo individualmente
- Verificare funzionalità base

### 2. Integration Tests
- Testare interazione tra moduli
- Verificare flussi completi

### 3. Feature Tests
- Testare funzionalità end-to-end
- Verificare UI e UX

### 4. Performance Tests
- Verificare che le performance non siano degradate
- Monitorare memoria e tempo di esecuzione

## Rollback Plan

In caso di problemi critici:

1. **Immediato**: Revert al branch precedente
2. **Medio termine**: Fix incrementali
3. **Lungo termine**: Conversione graduale modulo per modulo

## Documentazione Correlata

### Root Documentation
- `../architecture/filament-integration.md`
- `../development/upgrade-procedures.md`
- `../best-practices/coding-standards.md`

### Module Documentation
- `../laravel/Modules/Xot/docs/filament-4-changes.md`
- `../laravel/Modules/UI/docs/component-updates.md`
- `../laravel/Modules/User/docs/auth-changes.md`

## Note Finali

La conversione a Filament 4 è un'operazione complessa che richiede:
- **Attenzione ai dettagli**
- **Test approfonditi**
- **Documentazione accurata**
- **Rispetto delle convenzioni Laraxot**

Ogni modifica deve essere documentata e tutti gli errori PHPStan devono essere corretti prima di considerare la conversione completata.

---
*Ultimo aggiornamento: Dicembre 2024*
*Autore: Sistema di Conversione Automatizzato*
*Revisione: In corso*

