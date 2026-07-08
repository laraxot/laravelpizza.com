# Filament Resources nel Modulo Ptv

**Versione**: 3.0 - Filament v5
**Data**: 2026-02-18
**Filament Version**: v5.x (aggiornamento completato)

---

## 🚀 Upgrade Filament v5 - Status PTV

### ✅ Cambiamenti Applicati
- **ViewMyLog migliorato**: Rimosso `->label()` hardcoded per conformità v5
- **Schema infolist aggiornato**: Uso corretto `Filament\Schemas\Components`
- **Traduzioni automatiche**: Nessun metodo manuale per label/tooltip
- **Type hints**: Migliorati per compatibilità v5

### 🔄 Compatibilità Moduli Figli
- **IndennitaResponsabilita**: Eredita `MyLogResource` da PTV
- **Altri moduli**: Possono beneficiare automaticamente degli upgrade

### 📋 Checklist Upgrade PTV
- [x] ViewMyLog conforme v5 (no hardcoded labels)
- [x] Schema infolist aggiornato
- [x] Test funzionalità post-upgrade
- [ ] Verifica impatto moduli ereditanti
- [ ] Documentazione API aggiornata

### ⚠️ Note per Moduli Ereditanti

I moduli figli **non** estendono le classi concrete Ptv (`MessageResource`, `CriteriEsclusioneResource`, …): estendono le `Base*` astratte in `Modules\Ptv\Filament\Resources\`.

Vedi [filament-resource-base-inheritance.md](./filament-resource-base-inheritance.md) e [audit](./filament-resource-base-inheritance-audit.md).

Poiché `MyLogResource` di PTV è ereditato da altri moduli:

- **Benefici automatici**: Miglioramenti performance v4
- **Controlli necessari**: Verificare che moduli figli non abbiano override incompatibili
- **Testing**: Test completo flusso ereditarietà

---

## Panoramica
Il modulo Ptv è configurato come modulo di destinazione per la generazione automatica delle Filament Resources tramite i comandi di Laraxot.

## Risorse Esistenti

### MyLogResource

**Modello**: `Modules\Ptv\Models\MyLog`  
**Scopo**: Sistema di logging per tracciamento operazioni e attività  
**Pagine**: `ListMyLogs`, `ViewMyLog`  
**Status**: ✅ Implementato e conforme LARAXOT

**Campi Principali**:
- `id` - Identificativo univoco
- `tbl` - Nome tabella correlata
- `id_tbl` - ID record correlato
- `note` - Note/descrizione azione
- `obj` - Oggetto dell'operazione
- `act` - Tipo di azione eseguita
- `data` - Dati serializzati (JSON)
- `created_at/created_by` - Audit trail

**Caratteristiche**:
- Estende `XotBaseResource` (conforme LARAXOT)
- Pagine `ListMyLogs` e `ViewMyLog` implementate
- Filtri per tabella e tipo azione
- Schema infolist completo per visualizzazione readonly
- Ordinamento decrescente per data creazione
- Nessun uso di `->label()` (traduzioni automatiche)

**Utilizzo**: Tracciamento automatico delle operazioni critiche nel sistema PTV.

### UserResource

**Modello**: configurato tramite `XotData::make()->getUserClass()`  
**Scopo**: gestione utenti per il modulo PTV  
**Pagine**: `ListUsers`, `CreateUser`, `EditUser`  
**Status**: ✅ Implementato e conforme LARAXOT

**Campi Principali**:
- `name` - Nome utente
- `email` - Email utente
- `password` - Password (hashing automatico)

**Caratteristiche**:
- Estende `XotBaseResource` (conforme LARAXOT)
- Pagine basate su `XotBase*` (no classi Filament dirette)
- Nessun uso di `->label()` (traduzioni automatiche)

## Comandi Disponibili

### Comando Standard Filament
```bash
php artisan make:filament-resource ResourceName
```
**Destinazione**: `Modules\Ptv\Filament\Resources\{ResourceName}Resource`

### Comando Personalizzato Laraxot
```bash
php artisan filament:generate-resources ModuleName
```
**Funzionalità**: Genera automaticamente resources per tutti i modelli di un modulo specifico.

## Struttura delle Resources Generate

### Posizionamento Standard
```
Modules/Ptv/Filament/Resources/
├── {ResourceName}Resource/
│   ├── Pages/
│   │   ├── Create{ResourceName}.php
│   │   ├── Edit{ResourceName}.php
│   │   └── List{ResourceName}s.php
│   └── {ResourceName}Resource.php
└── ...
```

### Convenzioni di Naming
- **Resource Class**: `{ModelName}Resource`
- **Pages**: `{Action}{ModelName}.php`
- **Namespace**: `Modules\Ptv\Filament\Resources`

## Configurazione

### ServiceProvider
Il modulo Ptv è configurato per ricevere le resources generate tramite:
- **Panel**: Configurazione Filament standard
- **Auto-discovery**: Rilevamento automatico delle resources
- **Namespace**: `Modules\Ptv\Filament\Resources`

### Estensione delle Classi Base
Tutte le resources generate estendono le classi base di Xot:
- **Resources**: `XotBaseResource`
- **Pages**: `XotBaseCreateRecord`, `XotBaseEditRecord`, `XotBaseListRecords`

## Utilizzo

### 1. Generazione Singola Resource
```bash
cd laravel
php artisan make:filament-resource MyResource
```

### 2. Generazione per Modulo Completo
```bash
cd laravel
php artisan filament:generate-resources User
```

### 3. Personalizzazione
Dopo la generazione, le resources possono essere personalizzate:
- Modificare lo schema del form
- Aggiungere azioni personalizzate
- Configurare filtri e colonne
- Implementare logica di business specifica

## Best Practices

### 1. Organizzazione
- Mantenere resources correlate nello stesso namespace
- Utilizzare convenzioni di naming consistenti
- Documentare resources complesse

### 2. Personalizzazione
- Estendere sempre le classi base Xot
- Utilizzare i file di traduzione per le label
- Implementare validazione appropriata

### 3. Performance
- Utilizzare eager loading per le relazioni
- Implementare caching quando appropriato
- Ottimizzare le query del database

## Esempi di Utilizzo

### Resource Base
```php
<?php

namespace Modules\Ptv\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;
    
    protected function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

### Page Personalizzata
```php
<?php

namespace Modules\Ptv\Filament\Resources\MyResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateMyResource extends XotBaseCreateRecord
{
    protected static string $resource = MyResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
```

## Troubleshooting

### Problemi Comuni
1. **Resource non visibile**: Verificare la registrazione nel panel
2. **Errori di namespace**: Controllare la configurazione del modulo
3. **Permessi**: Verificare le policy e i gate

### Log e Debug
- Utilizzare `php artisan filament:list` per vedere le resources registrate
- Controllare i log di Laravel per errori di caricamento
- Verificare la configurazione del panel in `config/filament.php`

## Collegamenti

- [XotBaseResource Documentation](../../Xot/docs/readme.md)
- [Filament Resource Creation Fix](../../Xot/docs/filament-resource-creation-fix.md)
- [Documentazione Filament](https://filamentphp.com/docs)

## Aggiornamenti Recenti

### 22 Gennaio 2025
- ✅ **Creazione View TestPage**: Creata view mancante per il cluster Test
  - **Problema**: View `ptv::filament.clusters.test.pages.test` non trovata
  - **Soluzione**: Creata view Blade seguendo convenzioni Laraxot
  - **File creati**: `resources/views/filament/clusters/test/pages/test.blade.php`
  - **Traduzioni**: Aggiunte traduzioni in `lang/it/test.php`
  - **Pattern**: Utilizzato `<x-filament::page>` come wrapper principale
- ✅ **Rimozione TestResource**: Rimossa Resource di test con modello inesistente
  - **Problema**: Resource cercava `App\Models\Test` che non esiste
  - **Soluzione**: Rimozione completa della Resource e delle sue dipendenze
  - **File rimossi**: `Tests/TestResource.php`, Pages, Schemas, Tables
  - **Cache pulita**: Filament cache rimossa per evitare riferimenti obsoleti
  - **Documentazione**: Creato `testresource-removal-fix.md`

### 16 Gennaio 2025
- ✅ **Miglioramento MessageResource**: Trasformato campo 'type' da TextInput a Select dinamico
  - **Select dinamico**: Carica automaticamente tipi esistenti dal database
  - **Creazione nuovi tipi**: Modal integrato per aggiungere nuovi tipi al volo
  - **Validazione**: Conversione automatica in slug con validazione
  - **Traduzioni complete**: Struttura espansa per campo type e azioni
  - **UX migliorata**: Ricerca, preload e opzioni predefinite
  - **Documentazione**: Creato `message-resource-type-field-improvement.md`

*Ultimo aggiornamento: gennaio 2025*
