# Testing del Brand

## Principi di Testing

### 1. Test Semantici
I test devono verificare il comportamento semantico del brand, non i dettagli di implementazione:

```php
class BrandTest extends TestCase
{
    public function test_brand_name_is_semantically_correct(): void
    {
        $metatag = MetatagData::make();
        
        $this->assertEquals(
            $metatag->getBrandName(),
            $metatag->title
        );
    }
}
```

### 2. Test di Coerenza
Verificare che tutti gli aspetti del brand siano coerenti:

```php
class BrandConsistencyTest extends TestCase
{
    public function test_brand_elements_are_consistent(): void
    {
        $metatag = MetatagData::make();
        
        $this->assertNotEmpty($metatag->getBrandName());
        $this->assertNotEmpty($metatag->getBrandLogo());
        $this->assertNotEmpty($metatag->getDarkModeBrandLogo());
        $this->assertNotEmpty($metatag->getBrandLogoHeight());
    }
}
```

### 3. Test di Validazione
Verificare che i file del brand esistano e siano validi:

```php
class BrandValidationTest extends TestCase
{
    public function test_brand_files_exist(): void
    {
        $metatag = MetatagData::make();
        
        $this->assertFileExists(
            public_path($metatag->getBrandLogo())
        );
        
        $this->assertFileExists(
            public_path($metatag->getDarkModeBrandLogo())
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
- Verificare l'interazione con Filament
- Testare il caricamento delle immagini
- Verificare la coerenza visiva

### 3. Test di Regressione
- Verificare la retrocompatibilità
- Testare i metodi deprecati
- Verificare le migrazioni

## Esempi di Test

### 1. Test del Panel
```php
class PanelBrandTest extends TestCase
{
    public function test_panel_brand_configuration(): void
    {
        $panel = new Panel();
        $action = new ApplyMetatagToPanelAction();
        $metatag = MetatagData::make();
        
        $panel = $action->execute($panel);
        
        $this->assertEquals(
            $metatag->getBrandName(),
            $panel->getBrandName()
        );
        
        $this->assertEquals(
            $metatag->getBrandLogo(),
            $panel->getBrandLogo()
        );
    }
}
```

### 2. Test delle Immagini
```php
class BrandImageTest extends TestCase
{
    public function test_brand_images_are_valid(): void
    {
        $metatag = MetatagData::make();
        
        $this->assertImageIsValid(
            $metatag->getBrandLogo()
        );
        
        $this->assertImageIsValid(
            $metatag->getDarkModeBrandLogo()
        );
    }
    
    private function assertImageIsValid(string $path): void
    {
        $this->assertFileExists($path);
        $this->assertNotEmpty(getimagesize($path));
    }
}
```

### 3. Test di Performance
```php
class BrandPerformanceTest extends TestCase
{
    public function test_brand_loading_performance(): void
    {
        $start = microtime(true);
        
        $metatag = MetatagData::make();
        $metatag->getBrandLogo();
        $metatag->getDarkModeBrandLogo();
        
        $end = microtime(true);
        
        $this->assertLessThan(
            0.1, // 100ms
            $end - $start
        );
    }
}
```

## Vantaggi

1. **Affidabilità**
   - Verifica automatica del brand
   - Prevenzione di regressioni
   - Documentazione vivente

2. **Manutenibilità**
   - Test come documentazione
   - Facile individuazione di problemi
   - Supporto per refactoring

3. **Qualità**
   - Verifica della coerenza
   - Test di performance
   - Validazione delle immagini

## Collegamenti
- [Brand Philosophy](../philosophy/brand_philosophy.md)
- [Semantic Methods](../philosophy/semantic_methods.md)
- [Best Practices](../best-practices.md)
- [Testing Guide](../testing.md) 
