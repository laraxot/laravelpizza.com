# Risoluzione dinamica vs match esplicito in SmsActionFactory

## Contesto

Nel factory `SmsActionFactory`, invece di usare un `match` esplicito per risolvere la classe action in base al driver, si può calcolare dinamicamente il nome della classe action tramite una formula.

---

## 1. Esempio di match esplicito

```php
$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

---

## 2. Esempio di risoluzione dinamica tramite formula

```php
$driverStudly = Str::studly($driver); // es: smsfactor -> Smsfactor
$class = "Modules\\Notify\\Actions\\SMS\\Send{$driverStudly}SMSAction";
if (!class_exists($class)) {
    throw new Exception("Action class non trovata per driver: {$driver}");
}
$action = app($class);
```

---

## 3. Vantaggi della risoluzione dinamica
- **Scalabilità**: aggiungere un nuovo driver non richiede modifiche al factory, basta rispettare la convenzione di naming.
- **DRY**: elimina la duplicazione di codice e la necessità di aggiornare il match ad ogni nuovo driver.
- **Manutenzione**: meno punti di rottura, meno rischio di dimenticare un driver.
- **Coerenza**: forza l'adozione di una naming convention chiara e uniforme.

**Percentuale vantaggi:** 80%

---

## 4. Svantaggi della risoluzione dinamica
- **Errori silenziosi**: se il nome della classe non rispetta la convenzione, l'errore viene fuori solo a runtime.
- **Refactoring rischioso**: rinominare una classe senza aggiornare la formula può rompere il sistema.
- **Meno esplicito**: la lista dei driver supportati non è visibile a colpo d'occhio nel codice.
- **IDE e static analysis**: meno supporto per refactoring automatici e suggerimenti.

**Percentuale svantaggi:** 20%

---

## 5. Best practice consigliata
- Usare la risoluzione dinamica **solo se** la naming convention è rigorosamente rispettata e documentata.
- Aggiungere test automatici che verifichino la presenza della classe action per ogni driver configurato.
- Documentare chiaramente la formula e la convenzione di naming.
- In caso di driver "speciali" o legacy, prevedere un fallback o una mappa custom.

---

## 6. Formula consigliata

```php
$driverStudly = Str::studly($driver); // es: smsfactor -> Smsfactor
$class = "Modules\\Notify\\Actions\\SMS\\Send{$driverStudly}SMSAction";
if (!class_exists($class)) {
    throw new Exception("Action class non trovata per driver: {$driver}");
}
return app($class);
```

---

## 7. Conclusione

La risoluzione dinamica tramite formula è **più scalabile e manutenibile** rispetto al match esplicito, ma richiede disciplina nella naming convention e test automatici di coerenza. In progetti modulari e in crescita è la scelta preferibile, purché ben documentata e sorvegliata. 
