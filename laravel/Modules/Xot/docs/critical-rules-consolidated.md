# 🎯 CRITICAL RULES CONSOLIDATED - Laraxot Architecture

## 🚨 REGOLE ASSOLUTE DA RISPETTARE

### 1. ❌ DATABASE CONFIGURATION RULE
**MAI** aggiungere definizioni manuali di connessioni modulari in `config/database.php`

```php
// ❌ ERRATO - Questo file non deve contenere connessioni manuali
'gdpr' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'database' => env('DB_DATABASE_GDPR', 'laravel_gdpr'),
    'username' => env('DB_USERNAME_GDPR', 'marco'),
    'password' => env('DB_PASSWORD_GDPR', 'marco'),
    // ... altre configurazioni
],
```

✅ **CORRETTO**: Solo connessione base `mysql` nel file `config/database.php`

### 2. ✅ DATABASE.PHP FILSOFIA LARAVEL 12.x
- Singola connessione `mysql` principale
- Multi-tenant tramite database/schema separati
- Nessuna connessione modulare nel file database.php
- `TenantServiceProvider` gestisce automaticamente tutte le connessioni

### 3. ✅ DATABASE.PHP STRUCTURE
```php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'sqlite' => [...], // SOLO per sviluppo
        'mysql' => [       // SOLO connessione base
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'database' => env('DB_DATABASE', 'laravelpizza_data'),
            'username' => env('DB_USERNAME', 'marco'),
            'password' => env('DB_PASSWORD', 'marco'),
            // ... configurazione base
        ],
        // ❌ MAI definire connessioni modulari qui
    ],
];
```

## 📋 REGOLE ASSOLUTE PER TUTTI GLI AGENTI AI

### ❌ MAI FARE MAI MAI:
1. Aggiungere definizioni manuali di connessioni modulari in `config/database.php`
2. Modificare il sistema di gestione automatica delle connessioni
3. Creare duplicati delle connessioni database
4. Scrivere route() per le pagine nel front office (usare solo Folio)
5. **Semplificare codice dominio-specifico** (vedi sotto)

### ✅ SEMPRE FARE SEMPRE:
1. Lasciare `config/database.php` con solo la connessione base `mysql`
2. Lasciare che `TenantServiceProvider` gestisca automaticamente le connessioni
3. Usare `LaravelLocalization::localizeURL()` per le rotte localizzate
4. Usare `route('logout')` solo per il logout (route di Laravel standard)
5. MAI usare Livewire puro nel front office (solo widget di Filament)

## 🔴 REGOLA DOMINIO: MAI SEMPLIFICARE

### Custom Columns - Usare per DRY/KISS con chiavi stringa:
```php
// ❌ ERRATO - manca la chiave stringa
WorkerColumn::make('lavoratore'),

// ✅ CORRETTO - chiave stringa + WorkerColumn (DRY/KISS)
'lavoratore' => WorkerColumn::make('lavoratore'),
```

**NOTA**: `WorkerColumn` NON è una relazione! È un `GroupColumn` che mostra campi raggruppati (matr, cognome, nome, email).

### getTableColumns() - Array con chiavi stringa OBBLIGATORIO:
```php
// ❌ ERRATO - array senza chiavi
return [
    WorkerColumn::make('lavoratore'),
    TextColumn::make('nome'),
];

// ✅ CORRETTO - array con chiavi stringa
return [
    'lavoratore' => WorkerColumn::make('lavoratore'),
    'nome' => TextColumn::make('nome'),
];
```

### Action Return Types - Actions che generano PDF/file devono restituire StreamedResponse:
```php
// ❌ ERRATO - return type void e senza return
->action(function (): void {
    $tableFilters = is_array($this->tableFilters) ? $this->tableFilters : [];
    app(MakePdf::class)->execute($data);
}),

// ✅ CORRETTO - return type StreamedResponse e return
->action(function (): StreamedResponse {
    $tableFilters = is_array($this->tableFilters) ? $this->tableFilters : [];
    return app(MakePdf::class)->execute($tableFilters);
}),
```

### Infolists vs Disabled Forms - Usare Infolists per informazioni di sola lettura:
```php
// ❌ ERRATO - usare TextInput disabled per informazioni di sola lettura
Section::make('Informazioni Generali')
    ->schema([
        TextInput::make('matr')->disabled(),
        TextInput::make('cognome')->disabled(),
    ])

// ✅ CORRETTO - usare Infolist per informazioni di sola lettura
public function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->record($this->record)
        ->schema([
            Section::make('Informazioni Generali')
                ->columns(4)
                ->schema([
                    TextEntry::make('matr')->label('Matricola'),
                    TextEntry::make('cognome')->label('Cognome'),
                ]),
        ]);
}
```

**PERCHÉ**: 
- `TextInput disabled` è per campi di INPUT temporaneamente disabilitati
- `Infolist/TextEntry` è per visualizzare INFORMAZIONI di sola lettura
- Separazione netta tra edit e display

### Options/Years - MAI rimuovere opzioni
### Array Keys - MAI cambiare chiavi nominali in indici
### Actions - MAI cancellare getHeaderActions()
### Blade Includes - MAI sostituire @include con codice inline
### Traits - MAI rimuovere traits dai modelli

**REGOLA D'ORO**: In caso di dubbio, PRESERVARE il codice esistente. Chiedere prima di semplificare.
6. MAI usare controller per le pagine pubbliche (solo Folio + Volt)

## 🔄 VERIFICA DELLA CONFIGURAZIONE

### ✅ Verifica che la connessione 'gdpr' sia stata rimossa:
```bash
grep -n "gdpr" laravel/config/database.php
# Dovrebbe restituire errore (nessun risultato)
```

### ✅ Verifica che la configurazione sia corretta:
```bash
php artisan config:clear
php artisan optimize:clear
```

## 🎯 WORKFLOW CORRETTO

### 1. Configurazione ambiente:
```bash
# .env o .env.testing
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=laravelpizza_data
DB_USERNAME=marco
DB_PASSWORD=marco
```

### 2. TenantServiceProvider gestisce automaticamente:
- `laravel_gdpr` → connessione per modulo GDPR
- `laravel_user` → connessione per modulo User
- `laravel_geo` → connessione per modulo Geo
- ecc.

### 3. Verifica funzionamento:
```bash
php artisan optimize:clear
php artisan config:clear
```

## 🚨 AVVERTENZA CRITICA

### ERRORE GRAVE IDENTIFICATO:
Il file `laravel/config/database.php` conteneva una definizione manuale della connessione 'gdpr' che è un errore critico. Questo è stato corretto immediatamente.

### CONSEGUENZE:
- Violazione dell'architettura Laraxot
- Duplicazione pericolosa delle connessioni
- Problemi di manutenzione e scalabilità

### PREVENZIONE:
Questa regola DEVE essere sempre rispettata da tutti gli agenti AI. Non deve MAI più accadere.

## 📚 DOCUMENTAZIONE RELATIVA

- `laravel/Modules/Xot/docs/database-configuration-rule.md` - Documentazione dettagliata
- `laravel/Modules/Xot/docs/critical-rules-consolidated.md` - Questo file

## 🔄 REGOLE AGGIORNATE

### REGOLA DATABASE AGGIORNATA:
IL FILE `/var/www/_bases/base_laravelpizza/laravel/config/database.php` DEVE SEGUIRE LA FILOSOFIA LARAVEL 12.x CON SINGOLA CONNESSIONE 'mysql' E MULTI-TENANT TRAMITE DATABASE/SCHEMA SEPARATI. NON DEVE AVERE CONNESSIONI MODULARI PERCHÉ QUESTE VENGONO GESTITE AUTOMATICAMENTE DAL TenantServiceProvider.

### REGOLA DATABASE AGGIORNATA:
CRITICAL DATABASE ERROR IDENTIFIED: Il file `/var/www/_bases/base_laravelpizza/laravel/config/database.php` conteneva una definizione manuale della connessione 'gdpr' che è un errore GRAVE. Il TenantServiceProvider gestisce automaticamente tutte le connessioni database tramite il metodo registerDB() che crea copie della connessione mysql per ogni modulo. Aggiungere definizioni manuali in database.php viola l'architettura Laraxot e causa duplicazioni pericolose. Questo errore non deve mai più accadere.

---

**Versione**: 1.0  
**Data**: [DATE]  
**Importanza**: Fondamentale per l'architettura Laraxot