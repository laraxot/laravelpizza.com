# Testing del Tema

## Principi di Testing

### 1. Test Semantici
I test devono verificare il comportamento semantico del tema, non i dettagli di implementazione:

```php
class ThemeTest extends TestCase
{
    public function test_theme_colors_are_semantically_correct(): void
    {
        $metatag = MetatagData::make();
        
        $this->assertEquals(
            $metatag->getThemeColors(),
            $this->getExpectedColors()
        );
    }
}
```

### 2. Test di Coerenza
Verificare che tutti gli aspetti del tema siano coerenti:

```php
class ThemeConsistencyTest extends TestCase
{
    public function test_theme_elements_are_consistent(): void
    {
        $metatag = MetatagData::make();
        
        $this->assertNotEmpty($metatag->getThemeColors());
        $this->assertNotEmpty($metatag->getThemeSettings());
        $this->assertValidColors($metatag->getThemeColors());
    }
}
```

### 3. Test di Validazione
Verificare che i colori siano validi e coerenti:

```php
class ThemeValidationTest extends TestCase
{
    public function test_theme_colors_are_valid(): void
    {
        $metatag = MetatagData::make();
        $validator = new ColorValidator();
        
        $this->assertTrue(
            $validator->validateColors($metatag->getThemeColors())
        );
    }
}
```

## Best Practices

### 1. Test Unitari
- Testare ogni metodo semantico
- Verificare la gestione degli errori
- Testare i casi limite

### 2. Test di Integrazione
- Verificare l'interazione con il brand
- Testare il caricamento dei colori
- Verificare la coerenza visiva

### 3. Test di Regressione
- Verificare la retrocompatibilità
- Testare i metodi deprecati
- Verificare le migrazioni

## Esempi di Test

### 1. Test del Tema
```php
class ThemeConfigurationTest extends TestCase
{
    public function test_theme_configuration(): void
    {
        $metatag = MetatagData::make();
        $configurator = new ThemeConfigurator();
        
        $configurator->configureTheme($metatag);
        
        $this->assertEquals(
            $metatag->getThemeColors(),
            $configurator->getAppliedColors()
        );
    }
}
```

### 2. Test dei Colori
```php
class ColorTest extends TestCase
{
    public function test_colors_are_valid(): void
    {
        $metatag = MetatagData::make();
        
        foreach ($metatag->getThemeColors() as $color) {
            $this->assertColorIsValid($color);
        }
    }
    
    private function assertColorIsValid(string $color): void
    {
        $this->assertMatchesRegularExpression(
            '/^#[a-f0-9]{6}$/i',
            $color
        );
    }
}
```

### 3. Test della Dark Mode
```php
class DarkModeTest extends TestCase
{
    public function test_dark_mode_colors(): void
    {
        $metatag = MetatagData::make();
        $manager = new DarkModeManager();
        
        $darkColors = $manager->getDarkModeColors(
            $metatag->getThemeColors()
        );
        
        foreach ($darkColors as $color) {
            $this->assertColorIsDarkMode($color);
        }
    }
    
    private function assertColorIsDarkMode(string $color): void
    {
        $this->assertLessThan(
            128,
            $this->getColorBrightness($color)
        );
    }
}
```

## Vantaggi

1. **Affidabilità**
   - Verifica automatica del tema
   - Prevenzione di regressioni
   - Documentazione vivente

2. **Manutenibilità**
   - Test come documentazione
   - Facile individuazione di problemi
   - Supporto per refactoring

3. **Qualità**
   - Verifica della coerenza
   - Test di performance
   - Validazione dei colori

4. **Sicurezza**
   - Validazione dei valori
   - Prevenzione di errori
   - Gestione degli edge case

## Collegamenti
- [Theme Management](../theme/theme_management.md)
- [Brand Philosophy](../philosophy/brand_philosophy.md)
- [Semantic Methods](../philosophy/semantic_methods.md)
- [Best Practices](../best-practices.md)
- [Testing Guide](../testing.md) 
