# Migrazione al Nuovo Sistema Brand

## Panoramica

Questo documento descrive come migrare dal vecchio sistema di gestione del brand al nuovo sistema semantico.

## Cambiamenti Principali

### 1. Metodi Deprecati
I seguenti metodi sono stati deprecati in favore di alternative semantiche:

```php
// ❌ VECCHIO: Metodi deprecati
$metatag->getLogoHeader()
$metatag->getLogoHeaderDark()
$metatag->getLogoHeight()

// ✅ NUOVO: Metodi semantici
$metatag->getBrandLogo()
$metatag->getDarkModeBrandLogo()
$metatag->getBrandLogoHeight()
```

### 2. Accesso alle Proprietà
L'accesso diretto alle proprietà è stato sostituito da metodi semantici:

```php
// ❌ VECCHIO: Accesso diretto
$metatag->title
$metatag->sitename

// ✅ NUOVO: Metodi semantici
$metatag->getBrandName()
$metatag->getBrandTitle()
```

## Guida alla Migrazione

### 1. Aggiornamento del Codice

#### Panel Configuration
```php
// ❌ VECCHIO
$panel
    ->brandName($metatag->title)
    ->brandLogo($metatag->getLogoHeader())
    ->darkModeBrandLogo($metatag->getLogoHeaderDark())
    ->brandLogoHeight($metatag->getLogoHeight());

// ✅ NUOVO
$panel
    ->brandName($metatag->getBrandName())
    ->brandLogo($metatag->getBrandLogo())
    ->darkModeBrandLogo($metatag->getDarkModeBrandLogo())
    ->brandLogoHeight($metatag->getBrandLogoHeight());
```

#### Template Views
```php
// ❌ VECCHIO
<img src="{{ $metatag->getLogoHeader() }}" alt="{{ $metatag->title }}">

// ✅ NUOVO
<img src="{{ $metatag->getBrandLogo() }}" alt="{{ $metatag->getBrandName() }}">
```

### 2. Aggiornamento dei Test

#### Test Unitari
```php
// ❌ VECCHIO
public function test_logo_header(): void
{
    $metatag = MetatagData::make();
    $this->assertEquals('logo.svg', $metatag->getLogoHeader());
}

// ✅ NUOVO
public function test_brand_logo(): void
{
    $metatag = MetatagData::make();
    $this->assertEquals('logo.svg', $metatag->getBrandLogo());
}
```

#### Test di Integrazione
```php
// ❌ VECCHIO
public function test_panel_configuration(): void
{
    $panel = new Panel();
    $action = new ApplyMetatagToPanelAction();
    $metatag = MetatagData::make();
    
    $panel = $action->execute($panel);
    
    $this->assertEquals(
        $metatag->title,
        $panel->getBrandName()
    );
}

// ✅ NUOVO
public function test_panel_configuration(): void
{
    $panel = new Panel();
    $action = new ApplyMetatagToPanelAction();
    $metatag = MetatagData::make();
    
    $panel = $action->execute($panel);
    
    $this->assertEquals(
        $metatag->getBrandName(),
        $panel->getBrandName()
    );
}
```

### 3. Aggiornamento della Documentazione

#### Commenti nel Codice
```php
// ❌ VECCHIO
/**
 * Get the header logo URL.
 * @return string
 */
public function getLogoHeader(): string

// ✅ NUOVO
/**
 * Get the brand logo URL.
 * This method reflects the semantic purpose of getting the brand logo,
 * rather than exposing implementation details about where the logo is used.
 * @return string
 */
public function getBrandLogo(): string
```

#### Documentazione
```markdown
// ❌ VECCHIO

# Logo Header
The logo header is used in the top navigation bar.

// ✅ NUOVO

# Brand Logo
The brand logo represents the visual identity of the application.
It is used consistently across the interface to maintain brand recognition.
```

## Best Practices per la Migrazione

### 1. Approccio Graduale
- Migrare un metodo alla volta
- Mantenere la retrocompatibilità
- Testare dopo ogni modifica

### 2. Documentazione
- Aggiornare i commenti nel codice
- Documentare i cambiamenti
- Mantenere la documentazione sincronizzata

### 3. Testing
- Verificare la retrocompatibilità
- Testare i nuovi metodi
- Validare la coerenza visiva

## Vantaggi della Migrazione

1. **Semantica**
   - Codice più chiaro e intuitivo
   - Migliore manutenibilità
   - API più coerente

2. **Manutenibilità**
   - Meno accoppiamento
   - Più facile da testare
   - Più facile da estendere

3. **Qualità**
   - Codice più robusto
   - Migliore documentazione
   - Più facile da debuggare

## Collegamenti
- [Brand Philosophy](../philosophy/brand_philosophy.md)
- [Semantic Methods](../philosophy/semantic_methods.md)
- [Testing Guide](../testing/brand_testing.md)
- [Best Practices](../best-practices.md) 
