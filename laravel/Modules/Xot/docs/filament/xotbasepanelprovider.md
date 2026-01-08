# XotBasePanelProvider Pattern

## Panoramica
Il `XotBasePanelProvider` è una classe astratta che estende il `PanelProvider` di Filament e fornisce una base comune per tutti i pannelli amministrativi dei moduli. Questo pattern segue il principio DRY (Don't Repeat Yourself) centralizzando la configurazione comune dei pannelli.

## Caratteristiche Principali

### 1. Configurazione Modulare
- Ogni modulo deve dichiarare una proprietà `protected string $module` che identifica il nome del modulo
- Il namespace del modulo viene gestito automaticamente attraverso il metodo `getModuleNamespace()`
- Supporta la configurazione automatica dei percorsi basati sul nome del modulo

### 2. Funzionalità Base Predefinite
- Gestione automatica dei middleware essenziali
- Configurazione della navigazione (laterale o superiore)
- Supporto per la ricerca globale
- Gestione delle autorizzazioni
- Integrazione con il sistema di metatag

### 3. Discovery Automatica
Il provider configura automaticamente:
- Resources in `app/Filament/Resources`
- Pages in `app/Filament/Pages`
- Widgets in `app/Filament/Widgets`
- Clusters in `app/Filament/Clusters`
- Componenti Livewire in `app/Http/Livewire`

### 4. Personalizzazione
Ogni modulo può personalizzare:
- `$topNavigation`: bool - Attiva/disattiva la navigazione superiore
- `$globalSearch`: bool - Attiva/disattiva la ricerca globale
- `$navigation`: bool - Attiva/disattiva la navigazione

## Utilizzo

```php
namespace Modules\YourModule\Providers\Filament;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'YourModule';
    
    // Opzionale: personalizza le impostazioni
    protected bool $topNavigation = true;
    protected bool $globalSearch = true;
}
```

## Best Practices
1. Mantenere la coerenza dei namespace seguendo la convenzione `Modules\{ModuleName}\Providers\Filament`
2. Utilizzare il nome esatto del modulo nella proprietà `$module`
3. Documentare eventuali personalizzazioni specifiche del modulo
4. Seguire le convenzioni di naming di Filament per resources, pages e widgets

## Sicurezza
- I middleware essenziali sono già configurati (CSRF, autenticazione, ecc.)
- L'autenticazione è gestita attraverso il middleware `Filament\Http\Middleware\Authenticate`
- Le sessioni sono protette con middleware appropriati

## Estensibilità
Per estendere le funzionalità base:
1. Sovrascrivere il metodo `panel()` chiamando `parent::panel($panel)` prima delle personalizzazioni
2. Aggiungere middleware specifici del modulo
3. Configurare provider di autenticazione personalizzati se necessario

## Note Tecniche
- Il provider utilizza `strict_types=1`
- Supporta la configurazione dei metatag attraverso `MetatagData`
- Integra con il sistema di moduli Laravel attraverso la configurazione `modules.namespace` 