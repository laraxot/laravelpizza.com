# Filosofia del Brand nel Sistema

## Principi Fondamentali

### 1. Identità Semantica
Il brand è un'entità semantica che rappresenta l'identità del sistema. Ogni aspetto del brand deve essere espresso attraverso metodi che riflettono il suo scopo semantico:

```php
// ❌ ERRATO: Espone dettagli di implementazione
$metatag->title
$metatag->getLogoHeader()
$metatag->getLogoHeight()

// ✅ CORRETTO: Riflette l'identità semantica
$metatag->getBrandName()
$metatag->getBrandLogo()
$metatag->getBrandLogoHeight()
```

### 2. Coerenza Visiva
Il brand deve mantenere una coerenza visiva in tutte le sue manifestazioni:

```php
// ❌ ERRATO: Gestione frammentata
$panel->brandName($metatag->title)
      ->brandLogo($metatag->getLogoHeader())
      ->darkModeBrandLogo($metatag->getLogoHeaderDark())

// ✅ CORRETTO: Approccio coerente
$panel->brandName($metatag->getBrandName())
      ->brandLogo($metatag->getBrandLogo())
      ->darkModeBrandLogo($metatag->getDarkModeBrandLogo())
```

### 3. Astrazione dell'Implementazione
I dettagli di implementazione devono essere nascosti dietro un'API semantica:

```php
class MetatagData
{
    // Implementazione di base (privata)
    private function resolveLogoPath(string $path): string
    {
        return app(AssetAction::class)->execute($path);
    }

    // API pubblica semantica
    public function getBrandLogo(): string
    {
        return $this->resolveLogoPath($this->logo_header);
    }
}
```

### 4. Gestione del Tema
Il brand include anche la gestione del tema e dei colori:

```php
// ❌ ERRATO: Accesso diretto ai colori
$metatag->color_primary
$metatag->color_title

// ✅ CORRETTO: Accesso semantico al tema
$metatag->getThemeColors()
$metatag->getThemeSettings()
```

## Best Practices

### 1. Naming Semantico
- Prefisso `getBrand` per tutti i metodi relativi al brand
- Prefisso `getTheme` per tutti i metodi relativi al tema
- Evitare riferimenti a posizioni o dettagli tecnici
- Mantenere coerenza nei suffissi

### 2. Gestione delle Varianti
- Supporto esplicito per dark mode
- Gestione coerente delle dimensioni
- Mantenimento delle proporzioni
- Gestione coerente dei colori del tema

### 3. Validazione e Sicurezza
- Verifica dell'esistenza dei file
- Sanitizzazione dei percorsi
- Gestione degli errori
- Validazione dei colori

## Esempi di Implementazione

### 1. Configurazione del Panel
```php
$panel
    ->brandName($metatag->getBrandName())
    ->brandLogo($metatag->getBrandLogo())
    ->darkModeBrandLogo($metatag->getDarkModeBrandLogo())
    ->brandLogoHeight($metatag->getBrandLogoHeight())
    ->favicon($metatag->getFavicon());
```

### 2. Gestione delle Immagini
```php
class BrandImageManager
{
    public function getBrandImage(string $type): string
    {
        return match($type) {
            'logo' => $this->getBrandLogo(),
            'dark' => $this->getDarkModeBrandLogo(),
            'favicon' => $this->getFavicon(),
            default => throw new \InvalidArgumentException("Invalid brand image type")
        };
    }
}
```

### 3. Gestione del Tema
```php
class ThemeManager
{
    public function applyTheme(MetatagData $metatag): void
    {
        $colors = $metatag->getThemeColors();
        $settings = $metatag->getThemeSettings();
        
        $this->applyColors($colors);
        $this->applySettings($settings);
    }
}
```

### 4. Validazione del Brand
```php
class BrandValidator
{
    public function validateBrand(MetatagData $metatag): bool
    {
        return $this->validateLogo($metatag->getBrandLogo())
            && $this->validateDarkLogo($metatag->getDarkModeBrandLogo())
            && $this->validateName($metatag->getBrandName())
            && $this->validateTheme($metatag->getThemeColors());
    }
}
```

## Vantaggi

1. **Manutenibilità**
   - Codice più facile da capire
   - Cambiamenti interni più semplici
   - Meno accoppiamento con l'implementazione

2. **Coerenza**
   - API più prevedibile
   - Pattern di naming uniformi
   - Migliore documentazione

3. **Flessibilità**
   - Possibilità di cambiare l'implementazione
   - Supporto per diverse strategie
   - Adattabilità a nuovi requisiti

4. **Qualità**
   - Validazione robusta
   - Gestione errori migliorata
   - Testing più semplice

## Collegamenti
- [Semantic Methods](./semantic_methods.md)
- [MetatagData](../datas/metatag-data.md)
- [ApplyMetatagToPanelAction](../actions/applymetatagtopanelaction.md)
- [Best Practices](../best-practices.md)
- [Theme Management](../theme/theme_management.md) 
