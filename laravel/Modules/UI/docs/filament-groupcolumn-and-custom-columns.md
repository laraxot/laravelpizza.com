# Guida all'utilizzo di GroupColumn e Colonne Custom

Questo documento spiega le cause e le soluzioni per un problema comune riscontrato con il componente custom `GroupColumn`: la mancata visualizzazione di dati provenienti da relazioni Eloquent (campi con notazione "dot notation").

**AGGIORNAMENTO**: Il componente `GroupColumn` è stato aggiornato per supportare nativamente la "dot notation". Le soluzioni manuali descritte di seguito sono ancora valide per scenari complessi ma non più necessarie per il caso d'uso standard. La corretta funzionalità è garantita da un test automatizzato.

## Soluzione Definitiva (Core-level Fix)

Il componente `GroupColumn` è stato modificato per utilizzare la funzione `data_get()` di Laravel, allineando il suo comportamento a quello dei componenti standard di Filament. Ora è possibile utilizzare la "dot notation" direttamente.

**Esempio corretto (ora supportato):**
```php
GroupColumn::make('valutatore_info')->schema([
    TextColumn::make('valutatore.nome_diri'), // <-- ORA FUNZIONA
    TextColumn::make('valutatore.email'),     // <-- ORA FUNZIONA
])
```

---

## Workaround Manuali (Legacy)

Le seguenti soluzioni erano necessarie prima dell'aggiornamento del componente e rimangono utili per logiche di visualizzazione custom.

### Il Problema: Campi relazionali vuoti

Quando si utilizza un `TextColumn` (o simile) per mostrare un campo da una relazione (es. `valutatore.nome_diri`) all'interno di uno schema di `GroupColumn`, il valore non viene visualizzato.


**Esempio problematico:**

```php
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Filament\Tables\Columns\TextColumn;

GroupColumn::make('valutatore_info')->schema([
    TextColumn::make('valutatore.nome_diri'), // <-- QUESTO NON FUNZIONA
    TextColumn::make('valutatore.email'),     // <-- E NEMMENO QUESTO
])
```

La stessa `TextColumn::make('valutatore.nome_diri')` funziona perfettamente se usata direttamente nella sezione `columns` di una tabella Filament.

## La Causa

Il problema risiede nell'implementazione del componente `GroupColumn`. A differenza delle tabelle standard di Filament che utilizzano internamente la funzione `data_get()` per risolvere la "dot notation" e navigare le relazioni Eloquent, la view associata a `GroupColumn` (`ui::filament.tables.columns.group`) accede alle proprietà direttamente dall'oggetto `$record`.

In pratica, cerca di accedere a `$record->{'valutatore.nome_diri'}`, che non è una proprietà valida sul modello. Il risultato è `null` e la colonna appare vuota.

## Soluzioni

Ci sono due modi principali per risolvere questo problema.

### 1. Usare una Closure (Soluzione Raccomandata)

Questa è la soluzione più pulita e flessibile. Si utilizza il metodo `state()` della colonna per definire una `Closure` che recupera manualmente il dato. La closure riceve l'intero record della riga, permettendo di navigare la relazione.

**Esempio corretto:**

```php
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

GroupColumn::make('valutatore_info')->schema([
    TextColumn::make('nome_valutatore') // Usiamo un nome descrittivo e univoco
        ->state(function (Model $record): ?string {
            // Naviga manualmente la relazione
            return $record->valutatore?->nome_diri;
        }),
    TextColumn::make('email_valutatore')
        ->state(function (Model $record): ?string {
            return $record->valutatore?->email;
        }),
])
```

**Vantaggi:**
- Non richiede modifiche ai modelli.
- Mantiene la logica di presentazione all'interno della definizione della UI.
- È esplicito e facile da capire.

### 2. Creare un Accessor sul Modello

Un'altra opzione è creare un "accessor" sul modello Eloquent per fornire una versione "piatta" del dato relazionale.

**Esempio (nel modello `Schede.php` o simile):**

```php
// In Schede.php
use Illuminate\Database\Eloquent\Casts\Attribute;

// ...

protected function valutatoreNomeDiri(): Attribute
{
    return Attribute::make(
        get: fn () => $this->valutatore?->nome_diri,
    );
}
```

Una volta definito l'accessor, puoi usarlo direttamente in `GroupColumn`:

```php
// Nella definizione della tabella
GroupColumn::make('valutatore_info')->schema([
    TextColumn::make('valutatore_nome_diri'), // Ora si riferisce all'accessor
])
```

**Vantaggi:**
- Riutilizzabile in altre parti dell'applicazione.

**Svantaggi:**
- Aggiunge logica di presentazione al modello, che potrebbe non essere desiderabile.
- Può portare a un numero elevato di accessor se ci sono molti campi di questo tipo.

---

In sintesi, **la soluzione con la Closure è quasi sempre da preferire** per la sua flessibilità e per mantenere la logica confinata allo strato di presentazione.
