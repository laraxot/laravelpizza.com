# ContactColumn - Implementazione DRY/KISS Centralizzata

## 🎯 Obiettivo
Implementare `ContactColumn.php` come colonna Filament riutilizzabile che utilizza `ContactTypeEnum` per il rendering centralizzato dei contatti seguendo i principi DRY e KISS.

## 🚨 **PROBLEMA CRITICO IDENTIFICATO** (2025-08-01)
**ICONE NON VISIBILI**: La sintassi `@svg()` nel template Blade non è compatibile con Filament 3.x
- 📋 **Analisi Completa**: [contact-column-icon-issue-analysis.md](./contact-column-icon-issue-analysis.md)
- 🛠️ **Soluzione**: Sostituire `@svg()` con `<x-filament::icon>`
- ⚡ **Priorità**: ALTA (Funzionalità core non funzionante)

## ✅ **COMPLETATO**: Refactor DRY/KISS
- [x] Integrazione ContactTypeEnum per icone/colori/etichette centralizzate
- [x] Eliminazione duplicazione codice (da 79 a 46 righe PHP)
- [x] Pattern unificato per tutti i tipi di contatto
- [x] Single source of truth per proprietà UI
- [ ] **PENDING**: Fix icone non visibili (Filament 3.x compatibility)

## 🏗️ Architettura della Soluzione

### **Pattern Centralizzato**
- **ContactColumn**: Classe Filament personalizzata per rendering contatti
- **ContactTypeEnum**: Single source of truth per icone, colori, etichette  
- **Translation Files**: Localizzazione centralizzata
- **Helper Methods**: Logica di rendering e formattazione

### **Vantaggi Architetturali**

#### **1. DRY (Don't Repeat Yourself)**
- ✅ **Single Source**: Tutte le proprietà UI nell'enum
- ✅ **Zero Duplicazione**: Logica di rendering centralizzata
- ✅ **Riutilizzabilità**: Utilizzabile in qualsiasi risorsa Filament

#### **2. KISS (Keep It Simple, Stupid)**
- ✅ **API Semplice**: `ContactColumn::make('contacts')`
- ✅ **Configurazione Minima**: Funziona out-of-the-box
- ✅ **Logica Unificata**: Un metodo per tutti i tipi di contatto

## 📊 **Metriche di Miglioramento**

| Aspetto | Prima | Dopo | Miglioramento |
|---------|-------|------|---------------|
| **Righe PHP** | 79 | 46 | **-42%** |
| **Duplicazione** | 6 blocchi | 1 loop | **-83%** |
| **Manutenibilità** | 6 punti modifica | 1 punto modifica | **-83%** |
| **Riutilizzabilità** | Solo TechPlanner | Qualsiasi modulo | **+100%** |
'verified_at',    // Data di verifica
'user_id',        // ID utente associato
```

### Campi Aggiuntivi
```php
// Attributi dinamici
'attribute_1' to 'attribute_14',  // Attributi personalizzabili
'sms_sent_at',    // Data invio SMS
'mail_sent_at',   // Data invio email
'sms_count',      // Conteggio SMS inviati
'mail_count',     // Conteggio email inviate
'token',          // Token per verifica
```

## 🎯 Implementazione ContactColumn

### Obiettivi
1. **Visualizzazione Unificata**: Mostrare tutti i tipi di contatto in una colonna
2. **Icone Appropriate**: Icone diverse per ogni tipo di contatto
3. **Stato di Verifica**: Indicare se il contatto è verificato
4. **Statistiche**: Mostrare conteggi di invio SMS/Email
5. **Responsive**: Layout adattivo per dispositivi mobili

### Struttura Proposta
```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Modules\Notify\Models\Contact;

class ContactColumn extends TextColumn
{
    protected string $view = 'notify::filament.tables.columns.contact';

    public static function make(string $name = 'contact'): static
    {
        return parent::make($name)
            ->label('Contatto')
            ->formatStateUsing(function (Contact $record): string {
                return static::formatContact($record);
            })
            ->html()
            ->wrap()
            ->searchable(['contact_type', 'value', 'email', 'mobile_phone', 'first_name', 'last_name'])
            ->sortable(['contact_type', 'value', 'created_at'])
            ->tooltip(fn (Contact $record): string => static::getContactTooltip($record));
    }

    protected static function formatContact(Contact $record): string
    {
        $contactInfo = [];
        
        // Nome completo
        if ($record->first_name || $record->last_name) {
            $fullName = trim($record->first_name . ' ' . $record->last_name);
            if ($fullName) {
                $contactInfo[] = '<span class="font-medium text-gray-900">' . $fullName . '</span>';
            }
        }
        
        // Tipo di contatto con icona
        $contactType = $record->contact_type ?? 'unknown';
        $value = $record->value ?? $record->email ?? $record->mobile_phone ?? '';
        
        if ($value) {
            $icon = static::getContactTypeIcon($contactType);
            $color = static::getContactTypeColor($contactType);
            $contactInfo[] = '<span class="flex items-center ' . $color . '">' . $icon . ' ' . $value . '</span>';
        }
        
        // Stato di verifica
        if ($record->verified_at) {
            $contactInfo[] = '<span class="text-green-600 text-xs">✓ Verificato</span>';
        }
        
        // Statistiche
        $stats = [];
        if ($record->sms_count > 0) {
            $stats[] = '<span class="text-blue-600 text-xs">📱 ' . $record->sms_count . ' SMS</span>';
        }
        if ($record->mail_count > 0) {
            $stats[] = '<span class="text-green-600 text-xs">📧 ' . $record->mail_count . ' Email</span>';
        }
        
        if (!empty($stats)) {
            $contactInfo[] = '<div class="flex gap-2 mt-1">' . implode('', $stats) . '</div>';
        }
        
        return empty($contactInfo) 
            ? '<span class="text-gray-400">Nessun contatto</span>' 
            : implode('<br class="my-1">', $contactInfo);
    }

    protected static function getContactTypeIcon(string $contactType): string
    {
        return match ($contactType) {
            'email' => '<i class="heroicon-o-envelope w-4 h-4 inline mr-1" title="Email"></i>',
            'phone', 'mobile' => '<i class="heroicon-o-phone w-4 h-4 inline mr-1" title="Telefono"></i>',
            'mobile_phone' => '<i class="heroicon-o-device-phone-mobile w-4 h-4 inline mr-1" title="Cellulare"></i>',
            'whatsapp' => '<i class="fab fa-whatsapp w-4 h-4 inline mr-1" title="WhatsApp"></i>',
            'telegram' => '<i class="fab fa-telegram w-4 h-4 inline mr-1" title="Telegram"></i>',
            'sms' => '<i class="heroicon-o-chat-bubble-left-right w-4 h-4 inline mr-1" title="SMS"></i>',
            default => '<i class="heroicon-o-user w-4 h-4 inline mr-1" title="Contatto"></i>',
        };
    }

    protected static function getContactTypeColor(string $contactType): string
    {
        return match ($contactType) {
            'email' => 'text-blue-600 hover:text-blue-800',
            'phone', 'mobile' => 'text-green-600 hover:text-green-800',
            'mobile_phone' => 'text-purple-600 hover:text-purple-800',
            'whatsapp' => 'text-green-600 hover:text-green-800',
            'telegram' => 'text-blue-500 hover:text-blue-700',
            'sms' => 'text-orange-600 hover:text-orange-800',
            default => 'text-gray-600 hover:text-gray-800',
        };
    }

    protected static function getContactTooltip(Contact $record): string
    {
        $tooltip = [];
        
        if ($record->contact_type) {
            $tooltip[] = 'Tipo: ' . ucfirst($record->contact_type);
        }
        
        if ($record->verified_at) {
            $tooltip[] = 'Verificato: ' . $record->verified_at->format('d/m/Y H:i');
        }
        
        if ($record->sms_count > 0) {
            $tooltip[] = 'SMS inviati: ' . $record->sms_count;
        }
        
        if ($record->mail_count > 0) {
            $tooltip[] = 'Email inviate: ' . $record->mail_count;
        }
        
        return implode(' | ', $tooltip);
    }
}
```

## 🎨 View Blade Proposta

```blade
{{-- resources/views/filament/tables/columns/contact.blade.php --}}
@php
    $contact = $getState();
    $record = $getRecord();
@endphp

<div class="flex flex-col space-y-1">
    @if($record->first_name || $record->last_name)
        <div class="font-medium text-gray-900">
            {{ trim($record->first_name . ' ' . $record->last_name) }}
        </div>
    @endif
    
    @if($record->value || $record->email || $record->mobile_phone)
        <div class="flex items-center text-sm">
            @php
                $contactType = $record->contact_type ?? 'unknown';
                $value = $record->value ?? $record->email ?? $record->mobile_phone;
                $icon = match ($contactType) {
                    'email' => 'heroicon-o-envelope',
                    'phone', 'mobile' => 'heroicon-o-phone',
                    'mobile_phone' => 'heroicon-o-device-phone-mobile',
                    'whatsapp' => 'fab fa-whatsapp',
                    'telegram' => 'fab fa-telegram',
                    'sms' => 'heroicon-o-chat-bubble-left-right',
                    default => 'heroicon-o-user',
                };
                $color = match ($contactType) {
                    'email' => 'text-blue-600',
                    'phone', 'mobile' => 'text-green-600',
                    'mobile_phone' => 'text-purple-600',
                    'whatsapp' => 'text-green-600',
                    'telegram' => 'text-blue-500',
                    'sms' => 'text-orange-600',
                    default => 'text-gray-600',
                };
            @endphp
            
            <x-filament::icon 
                :name="$icon" 
                class="w-4 h-4 mr-1 {{ $color }}" 
            />
            <span class="{{ $color }}">{{ $value }}</span>
        </div>
    @endif
    
    @if($record->verified_at)
        <div class="text-green-600 text-xs flex items-center">
            <x-filament::icon 
                name="heroicon-o-check-circle" 
                class="w-3 h-3 mr-1" 
            />
            Verificato
        </div>
    @endif
    
    @if($record->sms_count > 0 || $record->mail_count > 0)
        <div class="flex gap-2 text-xs">
            @if($record->sms_count > 0)
                <span class="text-blue-600 flex items-center">
                    <x-filament::icon 
                        name="heroicon-o-chat-bubble-left-right" 
                        class="w-3 h-3 mr-1" 
                    />
                    {{ $record->sms_count }} SMS
                </span>
            @endif
            
            @if($record->mail_count > 0)
                <span class="text-green-600 flex items-center">
                    <x-filament::icon 
                        name="heroicon-o-envelope" 
                        class="w-3 h-3 mr-1" 
                    />
                    {{ $record->mail_count }} Email
                </span>
            @endif
        </div>
    @endif
</div>
```

## 📋 Caratteristiche Implementate

### 1. **Visualizzazione Unificata**
- Nome completo del contatto
- Tipo di contatto con icona appropriata
- Valore del contatto (email, telefono, etc.)

### 2. **Stato di Verifica**
- Indicatore visivo se il contatto è verificato
- Data di verifica nel tooltip

### 3. **Statistiche di Invio**
- Conteggio SMS inviati
- Conteggio email inviate
- Icone appropriate per ogni tipo

### 4. **Responsive Design**
- Layout flessibile
- Icone scalabili
- Testo adattivo

### 5. **Ricerca e Ordinamento**
- Ricerca su tutti i campi contatto
- Ordinamento per tipo e data creazione
- Tooltip informativo

## 🔄 Utilizzo

### In una Resource Filament
```php
use Modules\Notify\Filament\Tables\Columns\ContactColumn;

public function getTableColumns(): array
{
    return [
        'contact' => ContactColumn::make('contact'),
        // altre colonne...
    ];
}
```

### In un RelationManager
```php
use Modules\Notify\Filament\Tables\Columns\ContactColumn;

public function table(Table $table): Table
{
    return $table
        ->columns([
            ContactColumn::make('contact'),
            // altre colonne...
        ]);
}
```

## 📚 Best Practices

### 1. **Performance**
- Eager loading delle relazioni necessarie
- Caching dei dati di contatto
- Ottimizzazione delle query

### 2. **Accessibilità**
- Tooltip informativi
- Icone con alt text
- Contrasto colori appropriato

### 3. **Manutenibilità**
- Codice centralizzato e riutilizzabile
- Configurazione flessibile
- Documentazione completa

## 🎯 Prossimi Passi

1. **Implementare** la ContactColumn completa
2. **Creare** la view Blade corrispondente
3. **Testare** la funzionalità
4. **Documentare** l'utilizzo
5. **Aggiornare** le regole e memorie

*Ultimo aggiornamento: 2025-01-06* 