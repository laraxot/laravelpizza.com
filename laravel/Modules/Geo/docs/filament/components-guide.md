# Filament Components Guide - PTVX

## 📋 Overview

Questa guida copre tutti i componenti Filament utilizzati in PTVX, con particolare attenzione alle differenze tra Forms, Infolists e Tables.

## 🎯 Component Categories

### 1. **Forms** - Per input utente
Componenti per raccogliere dati dagli utenti attraverso form interattivi.

### 2. **Infolists** - Per visualizzazione readonly
Componenti per mostrare dati strutturati in modo readonly, come pagine di dettaglio.

### 3. **Tables** - Per elenchi dati
Componenti per visualizzare dati in formato tabulare con funzionalità di ricerca e ordinamento.

---

## 📝 Forms Components

### ✅ Placeholder (Raccomandato)
```php
use Filament\Forms\Components\Placeholder;

Placeholder::make('info')
    ->label('Informazione')
    ->content('Questo è un testo informativo readonly')
```

**Quando usare**: Per mostrare testo informativo statico nei form.

**Vantaggi**:
- Non deprecato
- Supportato in tutte le versioni
- Perfetto per testi informativi

### ❌ TextEntry in Forms (DEPRECATO)
```php
// NON USARE - Deprecato in Filament v4
TextEntry::make('field')
    ->state('valore')
```

---

## 📖 Infolists Components

### ✅ TextEntry in Infolists (Raccomandato)
```php
use Filament\Infolists\Components\TextEntry;

TextEntry::make('nome')
    ->label('Nome')
    // Mostra il valore del campo 'nome' del record
```

**Quando usare**: Per mostrare valori di campi del database in pagine di dettaglio.

**Vantaggi**:
- Ottimizzato per visualizzazione
- Supporta formattazione avanzata
- Parte integrante degli Infolists

### ✅ Section negli Infolists
```php
use Filament\Infolists\Components\Section;

Section::make('Informazioni Personali')
    ->schema([
        TextEntry::make('nome'),
        TextEntry::make('cognome'),
        TextEntry::make('email'),
    ])
```

---

## 📊 Tables Components

### ✅ TextColumn
```php
use Filament\Tables\Columns\TextColumn;

TextColumn::make('nome')
    ->label('Nome')
    ->searchable()
    ->sortable()
```

**Quando usare**: Per mostrare dati in colonne di tabella.

---

## 🔄 Migration Guide: Forms → Infolists

### Scenario: Sostituire Placeholder deprecato

**❌ Vecchio approccio (Forms con Placeholder):**
```php
// In un Form
Placeholder::make('summary')
    ->label('Riepilogo')
    ->content('Totale: ' . $this->getTotal())
```

**✅ Nuovo approccio (Infolists con TextEntry):**
```php
// In un Infolist
TextEntry::make('total')
    ->label('Totale')
    ->state(fn ($record) => '€' . number_format($record->total, 2))
    ->color('success')
```

### Scenario: Pagina di dettaglio

**❌ Non fare:**
```php
// Usare Form per mostrare dati readonly
public static function form(Form $form): Form
{
    return $form->schema([
        Placeholder::make('info')->content('Dati readonly'),
    ]);
}
```

**✅ Corretto:**
```php
// Usare Infolist per mostrare dati readonly
public static function infolist(Infolist $infolist): Infolist
{
    return $infolist->schema([
        Section::make('Dettagli')
            ->schema([
                TextEntry::make('nome'),
                TextEntry::make('email'),
                TextEntry::make('created_at')
                    ->label('Creato il')
                    ->dateTime(),
            ]),
    ]);
}
```

---

## 📋 Checklist Migrazione

### Per ogni Form che mostra dati readonly:

- [ ] Identificare se è una pagina di dettaglio o visualizzazione
- [ ] Se sì, convertire da `Form` a `Infolist`
- [ ] Sostituire `Placeholder::make()->content()` con `TextEntry::make()->state()`
- [ ] Usare `Section` per organizzare i dati
- [ ] Testare la visualizzazione

### Esempio completo di conversione:

**Prima:**
```php
class ViewUser extends Page
{
    public function mount($userId)
    {
        $this->user = User::find($userId);
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('User Details')
                ->schema([
                    Placeholder::make('name')
                        ->label('Name')
                        ->content($this->user->name),
                    Placeholder::make('email')
                        ->label('Email')
                        ->content($this->user->email),
                ]),
        ];
    }
}
```

**Dopo:**
```php
class ViewUser extends Page implements HasInfolists
{
    public User $user;

    public function mount($userId)
    {
        $this->user = User::find($userId);
    }

    public function userInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->user)
            ->schema([
                Section::make('User Details')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),
                    ]),
            ]);
    }
}
```

---

## 🚨 Errori Comuni da Evitare

### 1. Usare Form per dati readonly
```php
// ❌ SBAGLIATO
public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('name')->disabled(), // Non è readonly vero
    ]);
}
```

### 2. Usare Placeholder in Infolists
```php
// ❌ SBAGLIATO
Infolist::make([
    Placeholder::make('info')->content('Testo'), // Non esiste in Infolists
])
```

### 3. Mischiare Forms e Infolists
```php
// ❌ SBAGLIATO
public function schema(): array
{
    return [
        TextInput::make('name'), // Form component
        TextEntry::make('email'), // Infolist component - NON COMPATIBILE
    ];
}
```

---

## 📚 Riferimenti

- [Filament Forms Documentation](https://filamentphp.com/docs/4.x/forms)
- [Filament Infolists Documentation](https://filamentphp.com/docs/4.x/infolists)
- [Filament Tables Documentation](https://filamentphp.com/docs/4.x/tables)
- [TextEntry in Infolists](https://filamentphp.com/docs/4.x/infolists/text-entry)

---

## ✅ Best Practices PTVX

1. **Usa Infolists per dati readonly** - Miglior UX e performance
2. **Organizza con Section** - Struttura chiara e navigabile
3. **Formattazione avanzata** - Usa le opzioni di TextEntry per colori, icone, etc.
4. **Lazy loading** - Carica dati pesanti solo quando necessario
5. **Test di visualizzazione** - Verifica che tutti i dati siano mostrati correttamente

---

*Ultimo aggiornamento: Dicembre 2025*
*Basato su Filament v4.2.4*
