# Implementazione di Comune.php con Laravel Sushi

## 1. Cos'è Sushi (github.com/calebporzio/sushi)
- Sushi è un package Laravel che permette di creare Eloquent Model "virtuali" da array, file, API, config, senza tabelle DB reali.
- I dati vengono caricati in una tabella SQLite temporanea in memoria, e il model si comporta come un vero Eloquent Model (query, join, relazioni, morph, ecc.).
- Ideale per dataset statici, piccoli/medi, che non richiedono CRUD.
- Documentazione ufficiale: [https://github.com/calebporzio/sushi](https://github.com/calebporzio/sushi)

## 2. Come implementare Comune.php con Sushi

### Esempio pratico:
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Comune extends Model
{
    use Sushi;

    public function getRows(): array
    {
        $path = module_path('Geo', 'resources/json/comuni.json');
        $data = json_decode(file_get_contents($path), true);
        // Assicurarsi che ogni record abbia un 'id' unico e stabile
        return collect($data)->map(function ($row) {
            $row['id'] = $row['codice'] ?? md5($row['nome']);
            return $row;
        })->toArray();
    }

    // Esempio di scope Eloquent
    public function scopeByRegione($query, $regione)
    {
        return $query->where('regione->nome', $regione);
    }
}
```

### Note implementative:
- È fondamentale che ogni record abbia un campo `id` unico e stabile (meglio se il codice ISTAT del comune).
- Si possono definire scope, relazioni, query avanzate come in un normale Eloquent Model.
- I dati sono solo in lettura: nessun CRUD.
- Si può usare in Filament, query builder, relazioni, morph, ecc.

---

## 3. Vantaggi
- ✅ API Eloquent completa (join, relazioni, morph, query avanzate, scope, ecc.)
- ✅ Compatibilità totale con Filament/Eloquent
- ✅ Refactoring facile per chi già usa Eloquent
- ✅ Query più espressive e potenti
- ✅ Supporto a relazioni tra modelli Sushi
- ✅ Performance ottima per dataset piccoli/medi (<10-20k record)

## 4. Svantaggi
- ❌ Richiede estensione SQLite attiva su PHP
- ❌ Overhead di bootstrap (tabella temporanea in memoria)
- ❌ Più "magico" e meno trasparente rispetto a una Collection pura
- ❌ Id instabili se non definiti manualmente
- ❌ Non adatto a dataset molto grandi (>50k record)
- ❌ Dipendenza da un package esterno

---

## 5. Percentuali di preferenza (per il nostro caso d'uso)
- **GeoJsonModel:** 55% (preferito per trasparenza, semplicità, auditabilità, zero dipendenze)
- **Sushi:** 45% (preferito se serve API Eloquent completa, join, relazioni, morph, query avanzate)

### Ragionamento
- Se serve solo estrazione readonly e performance su <20k record, GeoJsonModel è più "zen", trasparente, DRY/KISS, auditabile e senza dipendenze.
- Se serve API Eloquent completa (join, relazioni, morph, query avanzate, compatibilità totale con Filament/Eloquent), Sushi è una scelta valida, ma introduce dipendenze e "magia" in più.
- In ambienti dove SQLite non è garantito, GeoJsonModel è più robusto.

---

## 6. Consigli pratici
- Usare Sushi solo se serve davvero la potenza di Eloquent (join, relazioni, morph, query avanzate).
- Definire sempre un campo `id` stabile e unico per ogni record.
- Testare la compatibilità su tutti gli ambienti (dev, staging, prod) e assicurarsi che SQLite sia abilitato.
- Documentare bene la dipendenza e la logica di caricamento dati.
- Se si migra da GeoJsonModel a Sushi, aggiornare tutti i riferimenti e i test.

---

## 7. Collegamenti
- [Sushi - usesushi.dev](https://usesushi.dev/)
- [geo-json-model.md](geo-json-model.md)
- [geo-sushi-comparison.md](geo-sushi-comparison.md)
- [comune-unificazione-analisi.md](comune-unificazione-analisi.md)
- [module_geo.md](module_geo.md)

---

## 8. Analisi e ragionamento sull'uso di SushiToJsons

### Cos'è SushiToJsons
- È un trait che estende Sushi e aggiunge la capacità di popolare i dati Sushi non da un array statico, ma da una serie di file JSON (uno per record) in una directory.
- Permette di avere CRUD "simulato" su file: ogni create/update/delete del model aggiorna il corrispondente file JSON.
- Usa uno schema per mappare i campi e serializza/deserializza i dati tra array e JSON.
- Si integra con un servizio Tenant per path multitenant.

### Vantaggi
- ✅ Permette di avere dati "dinamici" (modificabili) senza un vero database, ma con file JSON per ogni record.
- ✅ Si integra con Sushi, quindi mantiene API Eloquent completa.
- ✅ Supporta multitenancy tramite path dinamici.
- ✅ Ogni record è ispezionabile e versionabile come file.
- ✅ Può essere usato per dataset che devono essere modificabili ma non giustificano un DB.

### Limiti e svantaggi
- ❌ Più complesso rispetto a un semplice array o a Sushi puro.
- ❌ Performance limitata su grandi dataset (lettura di molti file JSON).
- ❌ Più fragile: dipende dalla coerenza dei file e dalla struttura delle directory.
- ❌ Non adatto a dati solo readonly (come comuni italiani statici): qui GeoJsonModel o Sushi puro sono più semplici e robusti.
- ❌ Richiede uno schema esplicito per ogni model.

### Applicabilità a Comune.php
- **Per dati statici come i comuni italiani, NON è necessario usare SushiToJsons:**
    - I dati non cambiano spesso, non serve CRUD su file.
    - Un unico file JSON (comuni.json) è più efficiente e semplice da gestire.
    - GeoJsonModel o Sushi puro sono più DRY/KISS e adatti.
- **SushiToJsons è utile solo se si vuole rendere i dati dei comuni modificabili a runtime senza DB** (caso raro per dati geografici ufficiali).
- **Per dataset statici, meglio evitare la complessità di SushiToJsons.**

### Consiglio pratico
- Usa SushiToJsons solo se hai bisogno di CRUD su file JSON per ogni record e multitenancy.
- Per dati statici, preferisci Sushi puro (come nell'esempio sopra) o GeoJsonModel.

---

**Ultimo aggiornamento:** {{date('Y-m-d')}}
Responsabile: Cascade AI 

## Policy aggiornata: niente trait per una sola classe
Non creare trait come ComuneSushiTrait se usati solo in un modello. I trait vanno creati solo se riutilizzati in più classi. Se la logica è specifica di un solo modello, va implementata direttamente nella classe. Motivazione: semplicità, KISS, manutenibilità, evitare complessità inutile. Collegamento a docs/xot.md.
