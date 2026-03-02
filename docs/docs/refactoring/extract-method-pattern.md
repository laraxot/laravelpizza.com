# 🧘 Pattern: Extract Method (Clean Code)

**Status**: ✅ Pattern Consolidato  
**Modulo**: Notify  
**Filosofia**: Clean Code, SRP, Leggibilità

## 🕉️ Filosofia

Il pattern **"Extract Method"** è uno dei refactoring fondamentali di Clean Code. Quando un metodo diventa troppo lungo o complesso (>10-15 righe, complexity > 8), estrarre porzioni di logica in metodi privati dedicati migliora:

- **Leggibilità**: Metodi più corti sono più facili da capire
- **Testabilità**: Metodi piccoli sono più facili da testare
- **SRP**: Ogni metodo ha una singola responsabilità
- **Manutenibilità**: Modifiche localizzate e sicure

## 🛠️ Pattern di Estrazione

### Quando Estrarre un Metodo

Estrarre un metodo quando:
1. Un metodo supera **15-20 righe**
2. Un metodo ha **complessità ciclomatica > 8**
3. Una porzione di codice ha un **nome descrittivo naturale** (es. `getChannelsFromValues`, `notifyResults`)
4. Una porzione di codice è **riutilizzabile** o **testabile** separatamente

### Pattern Corretto

**Prima** (metodo troppo lungo, bassa leggibilità):
```php
private function processNotifications(Collection $records, array $data): void
{
    $mailTemplateSlug = (string) $data['mail_template_slug'];
    $selectedChannels = (array) $data['channels'];

    if (empty($selectedChannels)) {
        Notification::make()
            ->danger()
            ->title(__('notify::actions.send_notification_bulk.notifications.warning.title'))
            ->body(__('notify::actions.send_notification_bulk.notifications.warning.no_channels_selected'))
            ->send();
        return;
    }

    $channelsEnum = [];
    foreach ($selectedChannels as $channelValue) {
        if (!is_string($channelValue)) {
            continue;
        }
        $channelEnum = ChannelEnum::tryFrom($channelValue);
        if ($channelEnum !== null) {
            $channelsEnum[] = $channelEnum;
        }
    }

    $totalSent = 0;
    $totalFailed = 0;

    foreach ($records as $record) {
        try {
            app(SendRecordNotificationAction::class)->execute($record, $mailTemplateSlug, $channelsEnum);
            $totalSent++;
        } catch (Throwable $e) {
            $totalFailed++;
            report($e);
        }
    }

    if ($totalSent > 0) {
        Notification::make()
            ->success()
            ->title(__('notify::actions.send_notification_bulk.notifications.success.title'))
            ->body(__('notify::actions.send_notification_bulk.notifications.success.body', ['count' => $totalSent]))
            ->send();
    }

    if ($totalFailed > 0) {
        Notification::make()
            ->warning()
            ->title(__('notify::actions.send_notification_bulk.notifications.partial_success.title'))
            ->body(__('notify::actions.send_notification_bulk.notifications.partial_success.body', ['failed_count' => $totalFailed]))
            ->send();
    }
}
```

**Dopo** (metodi estratti, alta leggibilità):
```php
private function processNotifications(Collection $records, array $data): void
{
    $mailTemplateSlug = (string) $data['mail_template_slug'];
    /** @var array<string> $selectedChannels */
    $selectedChannels = (array) $data['channels'];

    if (empty($selectedChannels)) {
        $this->sendNoChannelsNotification();
        return;
    }

    /** @var array<int, ChannelEnum> $channelsEnum */
    $channelsEnum = $this->getChannelsFromValues($selectedChannels);

    $totalSent = 0;
    $totalFailed = 0;

    foreach ($records as $record) {
        try {
            app(SendRecordNotificationAction::class)->execute($record, $mailTemplateSlug, $channelsEnum);
            $totalSent++;
        } catch (Throwable $e) {
            $totalFailed++;
            report($e);
        }
    }

    $this->notifyResults($totalSent, $totalFailed);
}

/**
 * Convert channel values to ChannelEnum.
 *
 * @param array<string> $values
 * @return array<int, ChannelEnum>
 */
private function getChannelsFromValues(array $values): array
{
    $channelsEnum = [];
    foreach ($values as $value) {
        $enum = ChannelEnum::tryFrom($value);
        if ($enum !== null) {
            $channelsEnum[] = $enum;
        }
    }
    return $channelsEnum;
}

/**
 * Notify the final results.
 */
private function notifyResults(int $sent, int $failed): void
{
    if ($sent > 0) {
        Notification::make()
            ->success()
            ->title(__('notify::actions.send_notification_bulk.notifications.success.title'))
            ->body(__('notify::actions.send_notification_bulk.notifications.success.body', ['count' => $sent]))
            ->send();
    }

    if ($failed > 0) {
        Notification::make()
            ->warning()
            ->title(__('notify::actions.send_notification_bulk.notifications.partial_success.title'))
            ->body(__('notify::actions.send_notification_bulk.notifications.partial_success.body', ['failed_count' => $failed]))
            ->send();
    }
}

/**
 * Send warning when no channels are selected.
 */
private function sendNoChannelsNotification(): void
{
    Notification::make()
        ->danger()
        ->title(__('notify::actions.send_notification_bulk.notifications.warning.title'))
        ->body(__('notify::actions.send_notification_bulk.notifications.warning.no_channels_selected'))
        ->send();
}
```

## 📈 Benefici del Pattern

### 1. Leggibilità Migliorata

**Prima**: Metodo di 50+ righe, difficile da seguire  
**Dopo**: Metodo principale di 20 righe, logica chiaramente separata

```php
// ✅ DOPO: Il metodo principale racconta una storia chiara
private function processNotifications(Collection $records, array $data): void
{
    // 1. Valida input
    if (empty($selectedChannels)) {
        $this->sendNoChannelsNotification();
        return;
    }

    // 2. Converti formati dati
    $channelsEnum = $this->getChannelsFromValues($selectedChannels);

    // 3. Processa records
    // ... loop ...

    // 4. Notifica risultati
    $this->notifyResults($totalSent, $totalFailed);
}
```

### 2. Single Responsibility Principle (SRP)

Ogni metodo estratto ha una responsabilità unica e ben definita:

- **`getChannelsFromValues()`**: Converte array string in ChannelEnum[]
- **`notifyResults()`**: Notifica risultati finali all'utente
- **`sendNoChannelsNotification()`**: Notifica warning quando non ci sono canali

### 3. Testabilità

Metodi piccoli e focalizzati sono più facili da testare:

```php
// ✅ Testabile indipendentemente
test('getChannelsFromValues converts valid channel strings to ChannelEnum', function () {
    $action = new SendRecordsNotificationBulkAction();
    $values = ['mail', 'sms', 'whatsapp'];
    
    $reflection = new ReflectionClass($action);
    $method = $reflection->getMethod('getChannelsFromValues');
    $method->setAccessible(true);
    
    $result = $method->invoke($action, $values);
    
    expect($result)->toHaveCount(3);
    expect($result[0])->toBeInstanceOf(ChannelEnum::class);
});
```

### 4. Manutenibilità

Modifiche localizzate e sicure:

- Modificare logica conversione canali → solo `getChannelsFromValues()`
- Modificare formato notifiche → solo `notifyResults()` o `sendNoChannelsNotification()`

## 🎯 Criteri per Estrarre Metodi

### ✅ DO - Quando Estrarre

1. **Blocchi logici con nome naturale**
   - Se puoi dare un nome descrittivo (es. `getChannelsFromValues`, `notifyResults`), estrai

2. **Codice duplicato o simile**
   - Se la stessa logica appare in più punti, estrai in un metodo riutilizzabile

3. **Complessità ciclomatica alta**
   - Se un metodo ha molti `if/else`, loop annidati, estrai parti in metodi dedicati

4. **Commenti esplicativi**
   - Se un blocco di codice necessita un commento lungo, probabilmente merita un metodo dedicato

### ❌ DON'T - Quando NON Estrarre

1. **Metodi troppo piccoli** (< 3 righe)
   - L'estrazione deve migliorare la leggibilità, non peggiorarla

2. **Legami troppo stretti con il contesto**
   - Se il metodo estratto richiede troppi parametri o dipendenze, potrebbe essere prematuro

3. **Estrazione solo per "ordine"**
   - Non estrarre solo per seguire una regola astratta, estrai se migliora comprensione

## 📋 Convenzioni per Metodi Privati

### Naming

- **Verbi descrittivi**: `getChannelsFromValues()`, `notifyResults()`, `sendNoChannelsNotification()`
- **Nomi che descrivono intento**: Non "processData()" ma "convertChannelsToEnum()"
- **CamelCase**: Standard PHP, non snake_case

### Documentazione

Ogni metodo privato estratto deve avere:
- **PHPDoc completo**: `@param`, `@return`, descrizione
- **Descrizione chiara**: Cosa fa, non come lo fa (se il codice è già chiaro)

```php
/**
 * Convert channel values to ChannelEnum.
 *
 * Filters invalid values and converts valid string channel identifiers
 * (e.g., 'mail', 'sms') to their corresponding ChannelEnum instances.
 *
 * @param array<string> $values Channel value strings from form data
 * @return array<int, ChannelEnum> Array of valid ChannelEnum instances
 */
private function getChannelsFromValues(array $values): array
{
    // ...
}
```

### Tipizzazione

- **Tipi espliciti**: Tutti i parametri e return types devono essere tipizzati
- **PHPDoc generics**: Per array e Collection, usare generics (`array<string>`, `Collection<int, Model>`)
- **Type narrowing**: Nei metodi privati, usare type narrowing per garantire type safety

## 🔄 Pattern Applicato in SendRecordsNotificationBulkAction

### Metodi Estratti

1. **`getChannelsFromValues(array $values): array`**
   - **Responsabilità**: Converte array di string in array di ChannelEnum
   - **Input**: `['mail', 'sms', 'whatsapp']`
   - **Output**: `[ChannelEnum::Mail, ChannelEnum::Sms, ChannelEnum::WhatsApp]`
   - **Complessità**: Bassa (O(n))
   - **Testabilità**: Alta (input/output chiari)

2. **`notifyResults(int $sent, int $failed): void`**
   - **Responsabilità**: Notifica risultati finali all'utente
   - **Input**: Contatori successi/errori
   - **Output**: Notifiche Filament (success/warning)
   - **Complessità**: Media (condizioni multiple)
   - **Testabilità**: Media (verifica notifiche inviate)

3. **`sendNoChannelsNotification(): void`**
   - **Responsabilità**: Notifica warning quando nessun canale è selezionato
   - **Input**: Nessuno (usa stato della classe se necessario)
   - **Output**: Notifica Filament (danger)
   - **Complessità**: Bassa
   - **Testabilità**: Alta

## 🎨 Pattern Generale per Filament Actions

### Struttura Consigliata

```php
class MyBulkAction extends XotBaseBulkAction
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->label(...)
            ->action(function (Collection $records, array $data): void {
                $this->processRecords($records, $data);
            })
            ->schema([...]);
    }

    /**
     * Main processing method (orchestration).
     */
    private function processRecords(Collection $records, array $data): void
    {
        // 1. Validate input
        if (!$this->validateInput($data)) {
            return;
        }

        // 2. Transform data
        $processedData = $this->transformData($data);

        // 3. Process each record
        $results = $this->processEachRecord($records, $processedData);

        // 4. Notify results
        $this->notifyResults($results);
    }

    /**
     * Validate input data.
     */
    private function validateInput(array $data): bool
    {
        // Validation logic
    }

    /**
     * Transform form data to business objects.
     */
    private function transformData(array $data): ProcessedData
    {
        // Transformation logic
    }

    /**
     * Process each record individually.
     */
    private function processEachRecord(Collection $records, ProcessedData $data): Results
    {
        // Loop and process
    }

    /**
     * Notify final results to user.
     */
    private function notifyResults(Results $results): void
    {
        // Notification logic
    }
}
```

## 🧘 Filosofia e Principi

### DRY (Don't Repeat Yourself)

> "Non duplicare logica. Se la stessa conversione/validazione appare in più punti, estrai in un metodo privato riutilizzabile."

### KISS (Keep It Simple, Stupid)

> "Metodi piccoli sono semplici. Metodi lunghi sono complessi. Estrai per semplificare."

### Single Responsibility Principle (SRP)

> "Ogni metodo deve fare una cosa sola, e farla bene. Se un metodo fa più cose, estrai."

### Clean Code

> "Un metodo dovrebbe essere leggibile come un romanzo breve, non come un manuale tecnico. Se un blocco di codice necessita commento lungo, estrai in un metodo con nome descrittivo."

## 📊 Metriche di Qualità

### Prima del Refactoring

- **Lines of Code**: 50+ righe nel metodo principale
- **Cyclomatic Complexity**: ~12 (alto)
- **Leggibilità**: Bassa (metodo monolitico)
- **Testabilità**: Bassa (difficile testare parti isolate)

### Dopo il Refactoring

- **Lines of Code**: 20 righe metodo principale + 3 metodi privati (~10 righe ciascuno)
- **Cyclomatic Complexity**: ~4 metodo principale, ~2 metodi privati (bassa)
- **Leggibilità**: Alta (metodo principale racconta storia chiara)
- **Testabilità**: Alta (ogni metodo testabile separatamente)

## ✅ Checklist Pre-Refactoring

Prima di estrarre metodi:

- [ ] Il metodo supera 15-20 righe?
- [ ] La complessità ciclomatica > 8?
- [ ] Posso dare un nome descrittivo al blocco da estrarre?
- [ ] Il blocco ha una responsabilità unica?
- [ ] L'estrazione migliorerà la leggibilità?
- [ ] Il metodo estratto sarà testabile?

## 🔗 Riferimenti

- [Clean Code - Extract Method](https://refactoring.guru/extract-method) - Refactoring Guru
- [SendRecordsNotificationBulkAction](../../app/Filament/Actions/SendRecordsNotificationBulkAction.php) - Implementazione esempio
- [DRY Composition Pattern](./dry-composition-pattern.md) - Pattern composizione Actions
- [Actions Calling Actions Pattern](./actions-calling-actions-pattern.md) - Pattern per chiamate Actions

---

**Ultimo aggiornamento**: 19 Dicembre 2025  
**Filosofia**: *"Small methods, clear names, single responsibility - the path to maintainable code"*  
**Pattern**: Extract Method (Clean Code Refactoring)
