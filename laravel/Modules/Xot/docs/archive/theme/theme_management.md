# Gestione del Tema

## Principi Fondamentali

### 1. Separazione delle Responsabilità
Il tema è una componente separata dal brand, ma strettamente correlata:

```php
// ❌ ERRATO: Mescolanza di responsabilità
$metatag->getColors()
$metatag->getSettings()

// ✅ CORRETTO: Separazione chiara
$metatag->getThemeColors()
$metatag->getThemeSettings()
```

### 2. Coerenza dei Colori
I colori devono essere gestiti in modo coerente e semantico:

```php
// ❌ ERRATO: Accesso diretto ai colori
$metatag->color_primary
$metatag->color_title

// ✅ CORRETTO: Accesso semantico
$colors = $metatag->getThemeColors();
$settings = $metatag->getThemeSettings();
```

### 3. Astrazione dell'Implementazione
I dettagli di implementazione dei colori devono essere nascosti:

```php
class ThemeManager
{
    private function resolveColor(string $color): string
    {
        return match($color) {
            'primary' => $this->getPrimaryColor(),
            'title' => $this->getTitleColor(),
            default => throw new \InvalidArgumentException("Invalid color type")
        };
    }

    public function getThemeColor(string $type): string
    {
        return $this->resolveColor($type);
    }
}
```

## Best Practices

### 1. Naming Semantico
- Prefisso `getTheme` per tutti i metodi relativi al tema
- Nomi descrittivi per i colori
- Coerenza nella nomenclatura

### 2. Gestione dei Colori
- Supporto per colori personalizzati
- Validazione dei valori esadecimali
- Gestione della dark mode

### 3. Validazione
- Verifica dei valori dei colori
- Controllo della coerenza
- Gestione degli errori

## Esempi di Implementazione

### 1. Configurazione del Tema
```php
class ThemeConfigurator
{
    public function configureTheme(MetatagData $metatag): void
    {
        $colors = $metatag->getThemeColors();
        $settings = $metatag->getThemeSettings();
        
        $this->applyColors($colors);
        $this->applySettings($settings);
    }
    
    private function applyColors(array $colors): void
    {
        foreach ($colors as $type => $color) {
            $this->setColor($type, $color);
        }
    }
}
```

### 2. Validazione dei Colori
```php
class ColorValidator
{
    public function validateColors(array $colors): bool
    {
        foreach ($colors as $color) {
            if (!$this->isValidColor($color)) {
                return false;
            }
        }
        return true;
    }
    
    private function isValidColor(string $color): bool
    {
        return preg_match('/^#[a-f0-9]{6}$/i', $color) === 1;
    }
}
```

### 3. Gestione della Dark Mode
```php
class DarkModeManager
{
    public function getDarkModeColors(array $colors): array
    {
        return array_map(
            fn($color) => $this->adjustColorForDarkMode($color),
            $colors
        );
    }
    
    private function adjustColorForDarkMode(string $color): string
    {
        // Logica per adattare i colori alla dark mode
        return $this->darkenColor($color);
    }
}
```

## Vantaggi

1. **Manutenibilità**
   - Codice più organizzato
   - Cambiamenti più semplici
   - Meno accoppiamento

2. **Coerenza**
   - Colori uniformi
   - Comportamento prevedibile
   - API chiara

3. **Flessibilità**
   - Supporto per temi personalizzati
   - Facile estensione
   - Adattabilità

4. **Qualità**
   - Validazione robusta
   - Gestione errori migliorata
   - Testing più semplice

## Collegamenti
- [Brand Philosophy](../philosophy/brand_philosophy.md)
- [Semantic Methods](../philosophy/semantic_methods.md)
- [Best Practices](../best-practices.md)
- [Testing Guide](../testing/theme_testing.md) 
