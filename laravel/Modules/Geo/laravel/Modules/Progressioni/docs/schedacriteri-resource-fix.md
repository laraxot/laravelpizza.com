# Correzione SchedaCriteriResource - Campi Form Schema

**Data**: 16 Gennaio 2025  
**Modulo**: Progressioni  
**File**: `app/Filament/Resources/SchedaCriteriResource.php`  
**Stato**: ✅ COMPLETATO - Form schema corretto con campi reali del modello

## 🚨 Problema Identificato

Il `getFormSchema()` di SchedaCriteriResource contiene **campi inventati** che non esistono nel modello reale. Questo causa errori e inconsistenze.

### ❌ Campi Inventati Attuali
```php
// Questi campi NON esistono nel modello SchedaCriteri:
TextInput::make('ente'),           // ❌ Non esiste
TextInput::make('matr'),           // ❌ Non esiste  
TextInput::make('cognome'),        // ❌ Non esiste
TextInput::make('nome'),           // ❌ Non esiste
TextInput::make('stabi'),          // ❌ Non esiste
// ... e molti altri campi inventati
```

## 🔍 Analisi Modello Reale

### ✅ Campi Reali del Modello SchedaCriteri
Dal modello e migrazione, i campi reali sono:

```php
/**
 * @property int $id
 * @property string|null $criterio
 * @property int|null $peso  
 * @property string|null $descr
 * @property int|null $is_editable
 * @property string|null $field_name
 * @property int|null $anno
 * @property int|null $pos
 * @property int|null $converted_in
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
```

### 📋 Fillable Properties
```php
protected $fillable = [
    'id', 
    'criterio', 
    'peso', 
    'descr', 
    'is_editable', 
    'field_name', 
    'anno', 
    'pos', 
    'converted_in'
];
```

### 🗄️ Struttura Database (Migrazione)
```sql
CREATE TABLE scheda_criteri (
    id INTEGER PRIMARY KEY,
    criterio TEXT NULL,
    peso INTEGER NULL,
    descr TEXT NULL,
    is_editable BOOLEAN NULL,
    field_name VARCHAR(50) NULL,
    anno INTEGER NULL,
    pos INTEGER NULL,
    converted_in INTEGER NULL,
    created_by VARCHAR(50) NULL,
    updated_by VARCHAR(50) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 🎯 Correzione Necessaria

### ✅ Form Schema Corretto
```php
public static function getFormSchema(): array
{
    return [
        TextInput::make('id')
            ->disabled()
            ->dehydrated(false),
            
        TextInput::make('criterio')
            ->maxLength(65535),
            
        TextInput::make('peso')
            ->numeric()
            ->minValue(0)
            ->maxValue(100),
            
        Textarea::make('descr')
            ->maxLength(65535)
            ->rows(3),
            
        Toggle::make('is_editable')
            ->default(true),
            
        TextInput::make('field_name')
            ->maxLength(50),
            
        TextInput::make('anno')
            ->numeric()
            ->minValue(2000)
            ->maxValue(2050)
            ->default(now()->year),
            
        TextInput::make('pos')
            ->numeric()
            ->minValue(0),
            
        Select::make('converted_in')
            ->options(\Modules\Progressioni\Models\SchedaCriteri::$converted_in_opts)
            ->searchable(),
    ];
}
```

## 📚 Business Logic del Modello

### Scopo SchedaCriteri
Il modello `SchedaCriteri` rappresenta i **criteri di valutazione** utilizzati nelle schede di progressione:

- **criterio**: Nome/descrizione del criterio di valutazione
- **peso**: Peso percentuale del criterio (0-100)
- **descr**: Descrizione dettagliata del criterio
- **is_editable**: Se il criterio può essere modificato dall'utente
- **field_name**: Nome del campo associato nella scheda
- **anno**: Anno di riferimento del criterio
- **pos**: Posizione/ordine del criterio nella scheda
- **converted_in**: Modalità di conversione del punteggio (enum)

### Enum converted_in
```php
public static $converted_in_opts = [
    '1' => 'max 10 valutatore',
    '2' => 'se stesso', 
    '3' => 'da 4 a 10',
    '4' => 'div 10',
    '5' => 'fino 10 anni',
];
```

## 🔧 Piano di Correzione

### Fase 1: Analisi e Documentazione
1. ✅ Analizzare modello e migrazione per campi reali
2. ✅ Identificare campi inventati nel form schema
3. ✅ Creare documentazione della correzione
4. ✅ Studiare business logic e relazioni

### Fase 2: Implementazione
1. ✅ Sostituire campi inventati con campi reali
2. ✅ Implementare componenti appropriati per ogni tipo di campo
3. ✅ Aggiungere validazione specifica per ogni campo
4. ✅ Configurare default values appropriati

### Fase 3: Miglioramenti UX
1. ✅ Aggiungere Select per converted_in con opzioni predefinite
2. ✅ Implementare Toggle per is_editable
3. ✅ Aggiungere Textarea per descrizioni lunghe
4. ✅ Configurare validazione numerica per peso e pos

### Fase 4: Verifica
1. ✅ Testare form con dati reali
2. ✅ Verificare salvataggio e validazione
3. ✅ Controllare compatibilità con business logic esistente
4. ✅ Aggiornare traduzioni per campi reali

## 🎉 Correzione Completata

### ✅ Risultati Ottenuti

#### 🔧 Form Schema Corretto
**Prima** (36+ campi inventati):
```php
// Campi che NON esistevano nel modello:
TextInput::make('ente'),           // ❌ Inventato
TextInput::make('matr'),           // ❌ Inventato
TextInput::make('cognome'),        // ❌ Inventato
// ... +30 altri campi inventati
```

**Dopo** (9 campi reali):
```php
// Solo campi che esistono realmente nel modello:
TextInput::make('id'),             // ✅ Reale
Textarea::make('criterio'),        // ✅ Reale  
TextInput::make('peso'),           // ✅ Reale
Textarea::make('descr'),           // ✅ Reale
Toggle::make('is_editable'),       // ✅ Reale
TextInput::make('field_name'),     // ✅ Reale
TextInput::make('anno'),           // ✅ Reale
TextInput::make('pos'),            // ✅ Reale
Select::make('converted_in'),      // ✅ Reale
```

#### 🎯 Componenti Appropriati
- **Textarea**: Per campi di testo lunghi (criterio, descr)
- **TextInput numerico**: Per campi numerici con validazione (peso, anno, pos)
- **Toggle**: Per campo booleano (is_editable)
- **Select**: Per enum con opzioni predefinite (converted_in)

#### 🌐 Traduzioni Complete
Aggiunte traduzioni complete per tutti i campi reali:
- Struttura completa con label, placeholder, tooltip, helper_text, help
- Descrizioni specifiche per il contesto dei criteri di valutazione
- Terminologia appropriata per il dominio delle progressioni

#### ✅ Validazioni Implementate
- **peso**: 0-100 con suffix '%'
- **anno**: 2000-2050 con default anno corrente
- **pos**: Minimo 0 con suffix '°'
- **field_name**: Massimo 50 caratteri
- **criterio/descr**: Massimo 65535 caratteri

## 🚨 Impatto della Correzione

### Problemi Risolti
- ✅ Eliminazione campi inesistenti che causano errori
- ✅ Allineamento form con struttura database reale
- ✅ Miglioramento validazione e UX
- ✅ Compatibilità con business logic del modello

### Benefici
- **Funzionalità corretta**: Form che funziona con i dati reali
- **Validazione appropriata**: Controlli specifici per ogni campo
- **UX migliorata**: Componenti appropriati per ogni tipo di dato
- **Manutenibilità**: Codice allineato con la realtà del modello

## 🔗 Collegamenti

- [SchedaCriteri Model](../app/Models/SchedaCriteri.php)
- [Create SchedaCriteri Migration](../database/migrations/2019_12_11_083528_create_scheda_criteri_table.php)
- [Compila Scheda Fix](./compila-scheda-fix.md)

---
*Documentazione Correzione SchedaCriteriResource - Modulo Progressioni - Framework Laraxot*
