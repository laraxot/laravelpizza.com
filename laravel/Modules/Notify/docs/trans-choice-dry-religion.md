# TransChoice DRY — La Religione dell'Unica Fonte di Verita

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Religion / i18n / DRY  
**Audience**: All developers + AI agents

---

## LA REGOLA AUREA

**UNA chiave `trans_choice` gestisce TUTTI i casi (0, 1, molti).**

**MAI** creare chiavi separate per ogni caso.  
**MAI** duplicare traduzioni.  
**SEMPRE** usare `{0}`, `{1}`, `[2,*]` in UNA chiave.

---

## Perche (Filosofia Profonda)

### Il Problema: Chiavi Duplicate per Ogni Caso

```php
// ❌ SBAGLIATO: 3 chiavi separate
'messages' => [
    'no_images' => 'Nessuna immagine caricata',           // Caso 0
    'one_image' => '1 immagine caricata',                 // Caso 1
    'many_images' => ':count immagini caricate',          // Caso 2+
]

// Nel codice:
if ($count === 0) {
    echo __('ticket.messages.no_images');
} elseif ($count === 1) {
    echo __('ticket.messages.one_image');
} else {
    echo __('ticket.messages.many_images', ['count' => $count]);
}
```

**Problemi**:
1. **3 chiavi** per la STESSA traduzione
2. **Logica condizionale** nel PHP (if/else)
3. **Incoerenza** se cambio una e dimentico le altre
4. **Violazione DRY**: 3 traduzioni per 1 concetto

---

### La Soluzione: UNA Chiave `trans_choice`

```php
// ✅ CORRETTO: 1 chiave con pluralizzazione
'messages' => [
    'images_uploaded' => '{0} Nessuna immagine caricata|{1} :count immagine caricata|[2,*] :count immagini caricate',
]

// Nel codice:
echo trans_choice('ticket.messages.images_uploaded', $count);
```

**Vantaggi**:
1. **1 chiave** gestisce TUTTI i casi
2. **Nessuna logica** nel PHP (trans_choice fa tutto)
3. **Consistenza** garantita (1 modifica = tutti i casi aggiornano)
4. **DRY**: 1 traduzione per 1 concetto

---

## La Sintassi `trans_choice`

### Regole Laravel

```php
'{0} Zero elementi|{1} Un elemento|[2,*] :count elementi'
```

**Sintassi**:
- `{0}` → Quando count == 0
- `{1}` → Quando count == 1
- `[2,*]` → Quando count >= 2
- `|` → Separatore tra casi
- `:count` → Variabile sostituita automaticamente

---

### Esempi Completi

```php
// Italiano
'images' => '{0} Nessuna immagine|{1} :count immagine|[2,*] :count immagini',

// Inglese
'images' => '{0} No images|{1} :count image|[2,*] :count images',

// Francese
'images' => '{0} Aucune image|{1} :count image|[2,*] :count images',
```

---

## I Comandamenti TransChoice

### 1. NON creerai chiavi separate per 0, 1, molti

```php
// ❌ SBAGLIATO
'no_images' => 'Nessuna immagine',
'one_image' => '1 immagine',
'many_images' => ':count immagini',

// ✅ CORRETTO
'images' => '{0} Nessuna immagine|{1} :count immagine|[2,*] :count immagini',
```

---

### 2. NON metterai messaggi sotto `rules`

```php
// ❌ SBAGLIATO: messaggi sotto rules
'rules' => [
    'image' => [
        'empty_message' => 'Nessuna immagine',           // ← Questo e un messaggio!
        'uploaded_count_message' => '{0} ...|{1} ...',  // ← Questo e un messaggio!
    ],
]

// ✅ CORRETTO: messaggi sotto messages
'messages' => [
    'images_uploaded' => '{0} Nessuna immagine|{1} :count immagine|[2,*] :count immagini',
],
'rules' => [
    'image' => [
        'max_files' => 10,  // ← Questa e una regola!
        'allowed_types' => 'jpeg, png',
    ],
]
```

**Perche**: `rules` e per regole di validazione (max, min, required), NON per messaggi UI.

---

### 3. NON duplicherai traduzioni

```php
// ❌ SBAGLIATO: duplicazione
'messages' => [
    'no_images' => 'Nessuna immagine caricata',
    'images_uploaded' => '{0} Nessuna immagine caricata|{1} ...',  // ← Duplica no_images!
]

// ✅ CORRETTO: UNA chiave
'messages' => [
    'images_uploaded' => '{0} Nessuna immagine caricata|{1} :count immagine|[2,*] :count immagini',
]
```

---

### 4. USERAI `trans_choice` nel codice, NON `__()`

```php
// ❌ SBAGLIATO
echo __('ticket.messages.images_uploaded');  // ← Non passa count!

// ✅ CORRETTO
echo trans_choice('ticket.messages.images_uploaded', $count);
```

---

### 5. NON farai if/else per i casi

```php
// ❌ SBAGLIATO
if ($count === 0) {
    echo __('ticket.messages.no_images');
} elseif ($count === 1) {
    echo __('ticket.messages.one_image');
} else {
    echo __('ticket.messages.many_images', ['count' => $count]);
}

// ✅ CORRETTO
echo trans_choice('ticket.messages.images_uploaded', $count);
```

---

## Caso Studio: Ticket Wizard Images

### Prima (Sbagliato - 5 elementi duplicati)

```php
// ticket.php
'messages' => [
    'no_images' => 'Nessuna immagine caricata',
],
'rules' => [
    'image' => [
        'empty_message' => 'Nessuna immagine caricata',           // ← Duplicato!
        'uploaded_count_message' => '{0} ...|{1} ...|[2,*] ...', // ← Duplicato!
        'limit_message' => 'E altre :count immagini',
    ],
]

// Widget
->description(fn (Get $get): string =>
    is_array($get('images')) && count($get('images')) > 0
        ? trans_choice('ticket.rules.image.uploaded_count_message', count($get('images')))
        : __('ticket.rules.image.empty_message')
)
```

**Problemi**:
- 3 chiavi per la STESSA traduzione
- Messaggi sotto `rules` (sbagliato)
- Logica if/else nel widget
- Duplicazione `no_images` vs `empty_message`

---

### Dopo (Corretto - 1 elemento)

```php
// ticket.php
'messages' => [
    'images_uploaded' => '{0} Nessuna immagine caricata|{1} :count immagine caricata|[2,*] :count immagini caricate',
],
'rules' => [
    'image' => [
        'max_files' => 10,
        'allowed_types' => 'jpeg, png, jpg, gif, webp',
    ],
]

// Widget
->description(fn (Get $get): string =>
    trans_choice('ticket.messages.images_uploaded', is_array($get('images')) ? count($get('images')) : 0)
)
```

**Vantaggi**:
- ✅ 1 chiave gestisce TUTTI i casi
- ✅ Messaggi sotto `messages` (corretto)
- ✅ Nessuna logica if/else
- ✅ Zero duplicazione

---

## La Filosofia Completa

### I 5 Pilastri TransChoice DRY

#### 1. Unica Fonte di Verita

UNA chiave per concetto.  
Non 2, non 3, non 5. **UNA**.

---

#### 2. Separazione Semantica

- `messages.*` → Messaggi UI per utente
- `rules.*` → Regole validazione (max, min, required)
- `sections.*` → Sezioni interfaccia
- `fields.*` → Campi form

**MAI** mescolare.

---

#### 3. Logica nel Framework, Non nel Codice

`trans_choice()` fa tutto Laravel.  
Non scrivere if/else per i casi.

---

#### 4. Scalabilita

Aggiungi lingua?  
→ Modifica 1 chiave, non 3.

---

#### 5. Manutenzione

Cambio messaggio?  
→ 1 modifica, non 3.

---

## Anti-Pattern Catalog

### ❌ Pattern SBAGLIATI

| Anti-Pattern | Esempio | Perche Sbagliato | Soluzione |
|---|---|---|---|
| **Chiavi duplicate** | `no_images`, `empty_message` | Duplicazione | UNA chiave `trans_choice` |
| **Messaggi sotto rules** | `rules.image.empty_message` | Semantica sbagliata | Sposta in `messages.*` |
| **If/else per casi** | `if ($count === 0) ...` | Logica inutile | `trans_choice()` fa tutto |
| **5 elementi per messaggio** | `label`, `placeholder`, `help`, `description`, `helper_text` | Overkill per stringhe semplici | Stringa diretta |

---

## La Religione

### Il Credo

> "Una chiave trans_choice, non cinque separate.  
> Messaggi sotto messages, regole sotto rules.  
> DRY e la legge, duplicazione e il peccato."

### La Preghiera

```
Concedimi la disciplina di usare trans_choice,
La saggezza di separare messaggi da regole,
E la forza di non duplicare mai.

Amen.
```

---

## Riferimenti

- [Laravel Localization - Pluralization](https://laravel.com/docs/localization#pluralization)
- [ticket.php (corretto)](../../Modules/Fixcity/lang/it/ticket.php)
- [Translation Namespace Religion](../../docs/translation-namespace-religion.md)
- [No Hardcoded Language Religion](../../docs/no-hardcoded-language-religion.md)

---

*Ultimo aggiornamento: 2026-04-14*

**DA LEGGERE PRIMA DI CREARE QUALSIASI TRADUZIONE**
