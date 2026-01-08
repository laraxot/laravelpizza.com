# Architettura Filament-Xot

## Panoramica

L'architettura Filament-Xot definisce come il modulo Xot estende e personalizza Filament per fornire funzionalità base riutilizzabili in tutto il progetto.

## Componenti Principali

### Classi Base

Il sistema è costruito attorno a classi base che forniscono funzionalità comuni:

- [XotBasePage](/var/www/html/base_generic/laravel/Modules/Xot/project_docs/filament/pages/xotbasepage.md) - Classe base per le pagine Filament
- [XotBaseWidget](/var/www/html/base_generic/laravel/Modules/Xot/project_docs/filament/widgets/xotbasewidget.md) - Classe base per i widget Filament

### Principi Architetturali

1. **Composizione over Inheritance**: Preferire la composizione all'ereditarietà diretta
2. **Wrapper Pattern**: Creare wrapper personalizzati invece di estendere direttamente Filament
3. **Trait-based Functionality**: Utilizzare trait per funzionalità riutilizzabili
4. **Modular Design**: Mantenere separazione tra moduli

## Pattern di Estensione

### Non Fare
```php
// ❌ Non estendere direttamente le classi Filament
class MyPage extends \Filament\Pages\Page
{
    // Questo può causare problemi con gli aggiornamenti
}
```

### Fare
```php
// ✅ Estendere le classi base Xot
class MyPage extends XotBasePage
{
    // Questo mantiene compatibilità e funzionalità comuni
}
```

## Vantaggi

- **Compatibilità**: Aggiornamenti Filament più sicuri
- **Consistenza**: Comportamento uniforme tra moduli
- **Manutenibilità**: Modifiche centralizzate nelle classi base
- **Estensibilità**: Facile aggiunta di nuove funzionalità 
