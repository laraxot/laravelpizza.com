# Checklist: Verifica Classi Base Xot

## 1. Import
- [ ] Non importare mai direttamente le classi Filament
- [ ] Usare sempre l'import da `Modules\Xot\Filament\Pages\XotBasePage`
- [ ] Rimuovere eventuali import non utilizzati

## 2. Estensione
- [ ] La classe estende `XotBasePage` invece di `Page`
- [ ] Non ci sono estensioni multiple
- [ ] L'ordine delle estensioni è corretto

## 3. Documentazione
- [ ] PHPDoc include `@extends XotBasePage`
- [ ] Documentate tutte le proprietà pubbliche
- [ ] Documentati tutti i metodi pubblici

## 4. Struttura
- [ ] La classe è nella directory corretta
- [ ] Il namespace è corretto
- [ ] Il nome del file corrisponde al nome della classe

## 5. Implementazione
- [ ] Non override di metodi base senza motivo
- [ ] Uso corretto dei trait
- [ ] Implementazione corretta delle interfacce

## 6. Best Practices
- [ ] Codice formattato secondo PSR-12
- [ ] Nomi di metodi e proprietà consistenti
- [ ] Gestione errori standardizzata

## Esempio di Verifica
```php
<?php

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Modules\Notify\Datas\SmsData;
use Illuminate\Support\Facades\Log;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;  // ✅ Import corretto
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Notify\Notifications\SmsNotification;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Filament\Notifications\Notification as FilamentNotification;

/**
 * @property ComponentContainer $smsForm
 * @extends XotBasePage  // ✅ Documentazione corretta
 */
class SendSMSPage extends XotBasePage implements HasForms  // ✅ Estensione corretta
{
    // ... implementazione
}
```

## Correzione Automatica
Per correggere automaticamente i file che non seguono queste convenzioni:

1. Rimuovere l'import di `Filament\Pages\Page`
2. Aggiungere l'import di `Modules\Xot\Filament\Pages\XotBasePage`
3. Cambiare l'estensione da `Page` a `XotBasePage`
4. Aggiornare la documentazione PHPDoc

## Note Importanti
- Verificare sempre la checklist prima di committare
- Mantenere aggiornata la documentazione
- Seguire le convenzioni di naming
- Usare gli strumenti di analisi statica 
