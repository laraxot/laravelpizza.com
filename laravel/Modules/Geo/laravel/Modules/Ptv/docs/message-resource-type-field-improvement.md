# Miglioramento Campo Type - MessageResource Modulo Ptv

**Data**: 16 Gennaio 2025  
**Modulo**: Ptv  
**File**: `app/Filament/Resources/MessageResource.php`  
**Stato**: ✅ COMPLETATO - Campo type trasformato in Select con creazione dinamica

## 🎯 Obiettivo

Trasformare il campo 'type' da TextInput a Select che mostra tutti i tipi già utilizzati nel modello Message, con possibilità di aggiungere nuovi tipi dinamicamente.

## 📋 Analisi Modello Message

### Struttura Campo Type
- **Nome campo**: `type`
- **Tipo database**: `string` nullable
- **Mutator**: Converte automaticamente in slug con underscore
- **Utilizzo**: Categorizzazione dei messaggi

### Caratteristiche Attuali
```php
// Nel modello Message.php
public function getTypeAttribute(): string
{
    $value = $this->attributes['type'] ?? '';
    if ($value === Str::slug((string) $value, '_')) {
        return $value;
    }

    $sluggedValue = Str::slug((string) $value, '_');
    $this->attributes['type'] = $sluggedValue;
    $this->save();

    return $sluggedValue;
}
```

## 🎯 Requisiti Implementazione

### 1. Select con Opzioni Dinamiche
- Mostrare tutti i tipi già utilizzati nel database
- Permettere selezione da lista esistente
- Ordinamento alfabetico delle opzioni

### 2. Creazione Nuovi Tipi
- Pulsante "+" per aggiungere nuovo tipo
- Input per inserire nuovo tipo
- Validazione e conversione automatica in slug
- Aggiunta immediata alla lista delle opzioni

### 3. User Experience
- Ricerca/filtro nelle opzioni esistenti
- Placeholder descrittivo
- Tooltip e helper text informativi
- Validazione lato client e server

## 🔧 Implementazione Tecnica

### Componente Select con Creazione
```php
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions\Action;

'type' => Select::make('type')
    ->options(function () {
        return \Modules\Ptv\Models\Message::distinct()
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->pluck('type', 'type')
            ->sort()
            ->toArray();
    })
    ->searchable()
    ->allowHtml()
    ->createOptionForm([
        TextInput::make('new_type')
            ->label('Nuovo Tipo')
            ->placeholder('Inserisci nuovo tipo di messaggio')
            ->required()
            ->rules(['string', 'max:255'])
            ->live()
            ->afterStateUpdated(function ($state, $set) {
                if ($state) {
                    $slugged = Str::slug($state, '_');
                    $set('new_type', $slugged);
                }
            }),
    ])
    ->createOptionUsing(function (array $data) {
        $type = Str::slug($data['new_type'], '_');
        return $type;
    })
    ->createOptionAction(function (Action $action) {
        return $action
            ->modalHeading('Crea Nuovo Tipo Messaggio')
            ->modalSubmitActionLabel('Crea Tipo')
            ->modalCancelActionLabel('Annulla');
    }),
```

### Alternativa con CreateOptionModal
```php
'type' => Select::make('type')
    ->options(fn () => $this->getTypeOptions())
    ->searchable()
    ->preload()
    ->createOptionForm([
        TextInput::make('type')
            ->label('Nuovo Tipo')
            ->placeholder('es. notifica_importante')
            ->required()
            ->rules([
                'string',
                'max:255',
                'regex:/^[a-z0-9_]+$/',
                'unique:messages,type'
            ])
            ->helperText('Usa solo lettere minuscole, numeri e underscore')
            ->live()
            ->afterStateUpdated(function ($state, $set) {
                if ($state) {
                    $set('type', Str::slug($state, '_'));
                }
            }),
    ])
    ->createOptionUsing(function (array $data): string {
        return $data['type'];
    }),
```

## 🎯 Metodi Helper da Aggiungere

### Nel MessageResource
```php
/**
 * Ottiene le opzioni per il campo type.
 *
 * @return array<string, string>
 */
protected function getTypeOptions(): array
{
    $existingTypes = \Modules\Ptv\Models\Message::distinct()
        ->whereNotNull('type')
        ->where('type', '!=', '')
        ->pluck('type')
        ->sort()
        ->mapWithKeys(fn($type) => [$type => ucfirst(str_replace('_', ' ', $type))])
        ->toArray();

    // Tipi predefiniti comuni se il database è vuoto
    if (empty($existingTypes)) {
        return [
            'notifica' => 'Notifica',
            'avviso' => 'Avviso',
            'comunicazione' => 'Comunicazione',
            'promemoria' => 'Promemoria',
            'aggiornamento' => 'Aggiornamento',
        ];
    }

    return $existingTypes;
}
```

## 📚 Vantaggi dell'Implementazione

### 1. User Experience Migliorata
- **Consistenza**: Utilizzo di tipi già esistenti
- **Efficienza**: Selezione rapida da lista
- **Flessibilità**: Creazione nuovi tipi al volo
- **Validazione**: Controllo formato e unicità

### 2. Data Quality
- **Standardizzazione**: Tipi uniformi nel database
- **Prevenzione errori**: Riduzione typo e inconsistenze
- **Categorizzazione**: Migliore organizzazione dei messaggi

### 3. Manutenibilità
- **Riutilizzo**: Tipi esistenti facilmente riutilizzabili
- **Evoluzione**: Facile aggiunta nuovi tipi
- **Controllo**: Visibilità su tutti i tipi utilizzati

## 🔧 Piano di Implementazione

### Fase 1: Preparazione
1. ✅ Analizzare modello Message e campo type
2. ✅ Studiare struttura database e mutator esistente
3. ✅ Creare documentazione implementazione
4. ✅ Definire UX per creazione nuovi tipi

### Fase 2: Implementazione
1. ✅ Sostituire TextInput con Select
2. ✅ Implementare caricamento dinamico opzioni
3. ✅ Aggiungere form per creazione nuovi tipi
4. ✅ Implementare validazione e conversione slug

### Fase 3: Testing
1. ✅ Testare selezione tipi esistenti
2. ✅ Testare creazione nuovi tipi
3. ✅ Verificare mutator e slug conversion
4. ✅ Testare UX e usabilità

## 🎉 Implementazione Completata

### ✅ Funzionalità Implementate

#### 🔧 Campo Type Migliorato
- **Select dinamico**: Carica automaticamente tutti i tipi esistenti dal database
- **Opzioni predefinite**: Se database vuoto, mostra tipi comuni (notifica, avviso, comunicazione, etc.)
- **Ricerca**: Campo searchable per trovare rapidamente il tipo desiderato
- **Preload**: Opzioni caricate immediatamente per migliore UX

#### ➕ Creazione Nuovi Tipi
- **Form integrato**: Modal per inserire nuovo tipo senza lasciare la pagina
- **Validazione**: Controllo formato e lunghezza del nuovo tipo
- **Conversione automatica**: Slug conversion in tempo reale (es. "Notifica Importante" → "notifica_importante")
- **Integrazione immediata**: Nuovo tipo disponibile subito nella lista

#### 🌐 Traduzioni Complete
- **Campo type**: Struttura completa con label, placeholder, tooltip, helper_text, help
- **Azioni**: Traduzioni per modal di creazione nuovo tipo
- **Messaggi**: Success/error per feedback utente

### 🎯 Metodo Helper Implementato
```php
protected static function getTypeOptions(): array
{
    // Carica tipi esistenti dal database con etichette leggibili
    // Fallback su tipi predefiniti se database vuoto
    // Ordinamento alfabetico automatico
}
```

## 🔗 Collegamenti

- [MessageResource](../app/Filament/Resources/MessageResource.php)
- [Message Model](../app/Models/Message.php)
- [Filament Resources](./filament-resources.md)

---
*Documentazione Miglioramento MessageResource - Modulo Ptv - Framework Laraxot*
