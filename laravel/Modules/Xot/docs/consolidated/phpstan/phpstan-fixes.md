# Correzioni PHPStan - 6 Gennaio 2025

## Errori Risolti

### 1. Chart/app/Datas/AnswersChartData.php

**Problema**: Errori `argument.type` e `offsetAccess.nonOffsetAccessible`
- Linee 208, 254: `count()` su mixed
- Linee 450, 460, 492, 496: Accesso offset su mixed

**Soluzione**:
- Aggiunto controllo `\is_array()` prima di `count()`
- Aggiunto controllo esistenza `$options['plugins']` prima dell'accesso
- Utilizzato variabile intermedia per evitare chiamate multiple

### 2. Chart/app/Models/Chart.php

**Problema**: Linea 187 - Tipo di ritorno errato
- Metodo `getSettings()` doveva restituire `array<string, mixed>` ma restituiva `array<int, array<mixed>>`

**Soluzione**:
- Corretto tipo di ritorno a `array<string, array<string, mixed>>`
- Aggiunto cast esplicito con `@var` per il risultato

### 3. Job/app/Actions/GetTaskFrequenciesAction.php

**Problema**: Linea 21 - Tipo di ritorno errato
- Metodo doveva restituire `array<string, mixed>` ma restituiva `array<mixed, mixed>`

**Soluzione**:
- Aggiunto cast esplicito `@var array<string, mixed>` al risultato

### 4. <nome progetto>/app/States/Appointment/ReportPending.php

**Problema**: Linea 27 - Tipo di ritorno errato
- Metodo doveva restituire `array<string, Component>` ma restituiva `array<int|string, Component>`

**Soluzione**:
- Aggiunto PHPDoc con tipo di ritorno corretto
- Aggiunto cast esplicito al risultato

### 5. User/app/Console/Commands/ChangeTypeCommand.php

**Problema**: Linea 80 - Accesso proprietà su mixed
- `$item->value` e `$item->getLabel()` su mixed

**Soluzione**:
- Aggiunto controllo `is_object($item) && method_exists($item, 'getLabel')`
- Gestito caso fallback per valori sconosciuti

### 6. Xot/app/Models/Traits/HasExtraTrait.php

**Problema**: Linea 62 - Tipo di ritorno errato
- Metodo doveva restituire tipo specifico ma restituiva `array<mixed, mixed>`

**Soluzione**:
- Aggiunto tipo di ritorno esplicito al metodo
- Aggiunto cast esplicito con `@var` al risultato

### 7. Xot/app/Services/ModuleService.php

**Problema**: Linea 112 - Tipo di ritorno errato
- Metodo doveva restituire `array<int, string>` ma restituiva `array<string, class-string>`

**Soluzione**:
- Corretto tipo di ritorno PHPDoc a `array<string, class-string>`

### 8. Xot/app/States/Transitions/XotBaseTransition.php

**Problema**: Linea 39 - Tipo parametro errato
- `sendRecipientNotification()` aspettava `UserContract|null` ma riceveva `Model|null`

**Soluzione**:
- Separato controllo per `UserContract` e `null`
- Chiamate esplicite per ogni tipo

## Pattern Comuni Identificati

1. **Array Types**: Sempre specificare tipi degli array con `array<key, value>`
2. **Mixed Handling**: Controllare tipi prima dell'uso con `is_array()`, `is_object()`
3. **Offset Access**: Verificare esistenza chiavi prima dell'accesso
4. **Return Types**: Usare cast espliciti `@var` quando necessario
5. **Union Types**: Separare logica per ogni tipo possibile

## Regole Applicate

- **REGOLA ASSOLUTA**: Non modificare `phpstan.neon`
- Specificare sempre tipi degli array: `array<string, mixed>` per associativi
- Utilizzare controlli di tipo prima dell'uso
- Aggiungere PHPDoc completi per tutti i metodi
- Cast espliciti quando necessario per compatibilità PHPStan

## Collegamenti

- [PHPStan Critical Rules](./phpstan-critical-rules.md)
- [Array Types Fixes](./phpstan-array-types-fixes.md)
- [PHPStan Level 10 Guidelines](./phpstan-level10-guidelines.md)

*Ultimo aggiornamento: 6 Gennaio 2025*
