# Organizzazione dei Namespace Filament nel Modulo Xot

## Problema Identificato: Duplicazione di Classi Base

È stata identificata una duplicazione di classi base nel modulo Xot che causa confusione e potenziali errori durante l'estensione. Questo documento definisce la struttura corretta dei namespace e delle classi base per evitare questi problemi in futuro.

## Struttura Corretta dei Namespace

Nel modulo Xot, le classi base per Filament seguono questa organizzazione:

```
Modules\Xot\Filament\
  ├── Pages\                       # Classi base per pagine standalone
  │   └── XotBasePage.php          # Estende Filament\Pages\Page
  │
  ├── Resources\                   # Classi base relative alle risorse
  │   ├── XotBaseResource.php      # Estende Filament\Resources\Resource
  │   │
  │   └── Pages\                   # Classi base per pagine di risorse
  │       ├── XotBaseCreateRecord.php  # Estende Filament\Resources\Pages\CreateRecord
  │       ├── XotBaseEditRecord.php    # Estende Filament\Resources\Pages\EditRecord
  │       ├── XotBaseListRecords.php   # Estende Filament\Resources\Pages\ListRecords
  │       ├── XotBaseResourcePage.php  # Estende Filament\Resources\Pages\Page
  │       └── XotBaseViewRecord.php    # Estende Filament\Resources\Pages\ViewRecord
  │
  └── Widgets\                     # Classi base per widget
      └── XotBaseWidget.php        # Estende Filament\Widgets\Widget
```

## Distinzione Chiara

1. **XotBasePage** (in `Modules\Xot\Filament\Pages`):
   - Estende `Filament\Pages\Page`
   - Utilizzato per pagine **standalone** che non sono legate a risorse specifiche
   - Esempi: dashboard, pagine di impostazioni, wizard

2. **XotBaseResourcePage** (in `Modules\Xot\Filament\Resources\Pages`):
   - Estende `Filament\Resources\Pages\Page`
   - Utilizzato per pagine **legate a risorse** che non rientrano nelle operazioni CRUD standard
   - Esempi: pagine di analisi dati per una risorsa, visualizzazioni personalizzate di una risorsa

## Regole di Utilizzo

1. **Scegliere la classe base corretta**:
   - Per pagine standalone → estendere `Modules\Xot\Filament\Pages\XotBasePage`
   - Per pagine legate a risorse → estendere le classi in `Modules\Xot\Filament\Resources\Pages\*`

2. **Evitare ambiguità**:
   - Non creare nuove classi con prefisso `XotBase*` al di fuori del modulo Xot
   - Non modificare le firme dei metodi nelle classi che estendono le classi base di Filament

3. **Non trasformare metodi statici in non statici (o viceversa)**:
   - I metodi mantengono la stessa natura (statica o non statica) della classe genitore
   - Errori comuni: `getView()` (non statico), `getNavigationLabel()` (statico)

## Messaggi di Errore Comuni

```
Cannot make non static method Filament\Pages\BasePage::getView() static in class Modules\Xot\Filament\Pages\XotBasePage
```

Questo errore indica che un metodo è stato erroneamente definito come statico quando nella classe genitore è non statico (o viceversa).

## Collegamenti

- [Documentazione Filament](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/filament/filament_best_practices.md)
- [XotBasePage](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/filament/pages/xotbasepage.md)
- [Linee Guida per l'Ereditarietà](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/filament/filament_inheritance_guidelines.md)
