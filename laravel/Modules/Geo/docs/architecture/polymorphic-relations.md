# Relazioni Polimorfiche e Tipi di ID

## La Dualità degli Identificatori nel Sistema

Nel sistema <main module>, esiste una dualità fondamentale nei tipi di identificatori primari utilizzati dai diversi modelli:

1. **UUID** - Utilizzati principalmente per entità legate all'utente (User, Profile, ecc.)
2. **Interi auto-incrementanti** - Utilizzati per la maggior parte delle altre entità

Questa dualità non è casuale, ma riflette una profonda riflessione su identità, sicurezza e natura delle entità nel sistema.

## Implicazioni per le Relazioni Polimorfiche

Le relazioni polimorfiche devono essere in grado di referenziare entità con diversi tipi di ID. Per questo utilizziamo `nullableUuidMorphs('model')` invece di `nullableMorphs('model')`.

```php
// ❌ Non supporta UUID per relazioni polimorfiche
$table->nullableMorphs('model');

// ✅ Supporta sia UUID che interi per relazioni polimorfiche
$table->nullableUuidMorphs('model');
```

## Dimensione Filosofica: Identità e Riferimento

### Identità come Spettro
La scelta tra UUID e interi riflette una visione dell'identità come spettro:

- **UUID**: Identità universale, distribuita, non sequenziale, opaca
- **Integer**: Identità locale, centralizzata, sequenziale, trasparente

### Filosofia Buddhista dell'Interdipendenza
Il sistema di relazioni polimorfiche che supporta entrambi i tipi di ID incarna il concetto buddhista di "pratityasamutpada" (origine dipendente):
- Nessuna entità esiste in isolamento
- L'identità di un'entità è definita dalle sue relazioni
- Diverse forme di identità (UUID, interi) coesistono in armonia

## Dimensione Politica: Centralizzazione vs Distribuzione

### Modello Federale di Identità
La coesistenza di UUID e interi rappresenta un modello federale di identità:
- **Interi**: "Sovranità centrale" - Controllo centralizzato, efficiente ma meno resiliente
- **UUID**: "Sovranità distribuita" - Generazione distribuita, resiliente ma meno efficiente

### Contratto Sociale dell'Identificazione
Il sistema rappresenta un contratto sociale in cui:
- Alcune entità (users) ottengono l'autonomia degli UUID
- Altre entità accettano l'autorità centralizzata degli ID sequenziali
- Le relazioni polimorfiche fungono da "costituzione" che regola questa coesistenza

## Dimensione Tecnica: Implicazioni Pratiche

### Vantaggi di nullableUuidMorphs

1. **Universalità**: Supporta relazioni con qualsiasi entità, indipendentemente dal tipo di ID
2. **Sicurezza**: Gli UUID sono più difficili da indovinare rispetto agli interi sequenziali
3. **Distribuzione**: Permette la generazione di ID senza accesso al database centrale
4. **Coerenza**: Mantiene l'integrità referenziale anche con diversi tipi di ID

### Limiti attuali

1. **Assenza di nullableStringMorphs**: Idealmente, avremmo un metodo che supporta qualsiasi tipo di stringa come ID
2. **Overhead di spazio**: Gli UUID occupano più spazio degli interi

## Implicazioni per l'Implementazione

### Convenzione di Naming
Utilizziamo consistentemente `model` come nome per le relazioni polimorfiche, non `addressable` o altri nomi:

```php
// ❌ Evitare nomi specifici per relazioni polimorfiche
$table->nullableUuidMorphs('addressable');

// ✅ Utilizzare 'model' per coerenza in tutto il sistema
$table->nullableUuidMorphs('model');
```

### Accesso alla Relazione
Nel codice, supportiamo entrambi i pattern di accesso:

```php
// Accesso standard
$address->model;

// Accesso semantico (implementato come alias)
$address->addressable();
```

## Dimensione Zen: Vuoto e Forma

La relazione polimorfica che supporta sia UUID che interi incarna il concetto zen di "forma è vuoto, vuoto è forma":
- La "forma" (il tipo specifico di ID) è relativa
- Il "vuoto" (la capacità di riferire qualsiasi entità) è universale
- L'identità non è intrinseca ma contestuale

## Conclusione

La scelta di `nullableUuidMorphs('model')` non è una mera decisione tecnica, ma riflette una comprensione profonda della natura dell'identità, delle relazioni e della struttura del sistema. È un equilibrio delicato tra efficienza, sicurezza, flessibilità e coerenza semantica.
