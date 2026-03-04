# Struttura degli Indirizzi Italiani

## Peculiarità del Sistema di Indirizzi Italiano

Il sistema di indirizzi italiano presenta alcune peculiarità rispetto ad altri paesi, che richiedono una struttura specifica nel database. La corretta separazione tra regione e provincia è fondamentale per:

1. La corretta identificazione geografica
2. L'interoperabilità con sistemi nazionali (es. Anagrafe Nazionale)
3. L'allineamento con le normative fiscali
4. La gestione territoriale sanitaria

## Struttura Gerarchica Italiana

Gli indirizzi italiani seguono questa gerarchia amministrativa:

1. **Regione** (es. Lombardia, Lazio, Sicilia)
2. **Provincia** (es. Milano, Roma, Palermo)
3. **Comune/Città** (es. Milano, Cinisello Balsamo, Frascati)
4. **CAP** (Codice di Avviamento Postale)
5. **Via/Piazza/ecc.**
6. **Numero Civico**

## Implementazione nel Database

Per supportare correttamente gli indirizzi italiani, il modello `Address` include campi distinti e senza prefisso address_:

```php
$table->string('region', 100)->nullable()->comment('Regione');
$table->string('province', 100)->nullable()->comment('Provincia');
$table->string('province_short', 2)->nullable()->comment('Sigla provincia (es. MI)');
$table->string('locality', 100)->nullable()->comment('Comune/Città');
$table->string('street_address', 255)->nullable()->comment('Via/Piazza');
$table->string('street_number', 20)->nullable()->comment('Numero civico');
$table->string('postal_code', 20)->nullable()->comment('CAP');
$table->string('country', 2)->nullable()->comment('Codice paese ISO 3166-1 alpha-2');
```

### Mapping con Schema.org

| Campo Italiano   | Campo Schema.org | Descrizione          |
|------------------|------------------|----------------------|
| region           | addressRegion    | Regione              |
| province         | [non standard]   | Provincia            |
| province_short   | [non standard]   | Sigla provincia      |
| locality         | addressLocality  | Comune/Città         |
| street_address   | streetAddress    | Via/Piazza           |
| street_number    | [non standard]   | Numero civico        |
| postal_code      | postalCode       | CAP                  |
| country          | addressCountry   | Codice paese         |

**Nota:**
- I prefissi address_ sono stati rimossi per chiarezza e coerenza: se la tabella è `addresses`, i campi sono autoesplicativi.
- Il campo `street_number` è ora separato da `street_address` per una migliore normalizzazione e compatibilità con sistemi pubblici.

## Validazione degli Indirizzi Italiani

Per gli indirizzi italiani, è consigliato applicare regole di validazione specifiche:

```php
'region' => ['required_if:country,IT', 'string', 'max:100'],
'province' => ['required_if:country,IT', 'string', 'max:100'],
'province_short' => ['nullable', 'string', 'size:2'],
'locality' => ['required', 'string', 'max:100'],
'street_address' => ['required', 'string', 'max:255'],
'street_number' => ['nullable', 'string', 'max:20'],
'postal_code' => ['required_if:country,IT', 'regex:/^[0-9]{5}$/'],
'country' => ['required', 'string', 'size:2'],
```

## Relazioni con i Modelli Geografici

Il modello `Address` mantiene relazioni con i modelli geografici specifici per l'Italia:

```php
/**
 * Get the region relationship (for Italian addresses).
 */
public function region(): BelongsTo
{
    return $this->belongsTo(Region::class, 'address_region', 'name');
}

/**
 * Get the province relationship (for Italian addresses).
 */
public function provinceRelation(): BelongsTo
{
    return $this->belongsTo(Province::class, 'province', 'name');
}
```

## Formato di Visualizzazione

Il formato standard per la visualizzazione di un indirizzo italiano è:

```
Via/Piazza Nome Civico
CAP Comune (PROVINCIA)
REGIONE
ITALIA
```

Esempio:
```
Via Roma 123
20100 Milano (MI)
Lombardia
ITALIA
```

## Geocoding degli Indirizzi Italiani

Per il geocoding di indirizzi italiani si consiglia di utilizzare:

1. Le API di geocoding specifiche per l'Italia (come quelle dell'ISTAT)
2. Appendere "Italia" o "Italy" nelle query di geocoding per migliorare la precisione
3. Verificare la presenza di CAP validi (5 cifre numeriche)

## Considerazioni sulle Abbreviazioni

Per le province italiane, è comune utilizzare abbreviazioni di due lettere:

- Milano → MI
- Roma → RM
- Torino → TO

Per garantire interoperabilità, è consigliabile memorizzare:
- Il nome completo della provincia nel campo `province`
- L'abbreviazione ufficiale nel campo `province_short` o nell'`extra_data`
