# Analisi dominio modelli Geo (`app/Models`)

**Scopo**: mappare responsabilità, sovrapposizioni e raccomandazioni operative senza duplicare guide già presenti su singoli modelli (es. vari file `comune-*.md` nella stessa cartella: vanno consolidati a livello di processo, non in questo documento).

**Riferimento codice**: `laravel/Modules/Geo/app/Models/`.

---

## 1. Panoramica rapida

| Modello | Natura | Ruolo dominante |
|--------|--------|------------------|
| `BaseModel` | Astratta | Connessione `geo`, cast data comuni |
| `BasePivot` / `BaseMorphPivot` | Astratta | Pivot modulo |
| `Address` | Eloquent tabella | Indirizzo **persistente** stile PostalAddress, `morphTo`, integrazione `Comune` per lookup amministrativi IT |
| `Location` | Eloquent tabella | Punto geografico + campi testo semplificati (`street`, `city`, `state`, `zip`), accessor `location` lat/lng, scope distanza |
| `Place` | Eloquent tabella | Snapshot **geocoding / Google Places** (molti campi `_short`), `HasGeolocation`, relazione opzionale verso `Address` |
| `Comune` | Sushi + JSON | **Fonte primaria** dati comuni IT da `resources/json/comuni.json` (trait `SushiToJson`) |
| `ComuneJson` | Non Eloquent | Legge lo stesso JSON via `GeoJsonModel`: API statica + cache, senza query builder |
| `GeoJsonModel` | Astratta non-ORM | Caricamento file JSON + cache forever |
| `Region`, `Province`, `Locality` | Sushi | Viste derivate sui dati di `Comune` (`getRows()`), gerarchia IT per form/select |
| `State`, `County` | Eloquent tabella | Modello **amministrativo USA** (stato federato, contea) — non sono regioni/province italiane |
| `PlaceType` | Eloquent | Tipologia luogo (catalogo) |
| `GeoNamesCap` | Eloquent | Tabella `geonames_cap`: classe **quasi vuota** (placeholder / estensione futura) |

---

## 2. Gruppi “doppi” o sovrapposti

### 2.1 `Address` vs `Location` vs `Place`

**Non sono tre modelli equivalenti.**

- **`Address`**: contratto ricco (Schema.org PostalAddress), `model_type` / `model_id`, tipo indirizzo, primario, coordinate, `place_id`, allineamento a gerarchia amministrativa e helper verso `Comune`. È il candidato **standard** per indirizzi di dominio (utenti, sedi, ticket) quando serve persistenza e regole.
- **`Location`**: modello più **snello** (lat/lng, stringhe `street`/`city`/`state`/`zip`, flag `processed`). Utile per punti su mappa o flussi legacy; **sovrappone semanticamente** parte di `Address` (coordinate + testo) ma senza lo stesso livello di normalizzazione e senza morph esplicito nella stessa forma.
- **`Place`**: orientato al **risultato di geocodifica** (componenti multipli, varianti brevi, URL Google). Può collegarsi a `Address`; non sostituisce l’indirizzo “di anagrafe” da solo.

**Raccomandazione**

- Per **nuove funzionalità** che richiedono indirizzo di entità italiana con vincoli e riuso: preferire **`Address`**.
- Usare **`Location`** solo dove serve esplicitamente il modello leggero (es. risorse già basate su `LocationResource` / widget mappa) o finché non si migra verso `Address`.
- Usare **`Place`** per memorizzare dettaglio **geocoder** collegato a un evento di ricerca mappa, non come duplicato concettuale di `Address` senza motivo.

### 2.2 `Comune` vs `ComuneJson`

**Stesso dominio dati** (comuni italiani da JSON), **due accessi**:

| Aspetto | `Comune` | `ComuneJson` |
|--------|----------|----------------|
| API | Eloquent (Sushi) | Metodi statici su `GeoJsonModel` |
| Query | `where`, relazioni ORM-like | Collection in memoria |
| Uso tipico | Filament, relazioni, codice che già usa `Comune::query()` | Lettura massiva / helper statici, cache applicativa |

**Raccomandazione**

- **Fonte di verità** per integrazione modulo: **`Comune`** (già usato da `Province`, `Locality`, `Region`, `Address`…).
- **`ComuneJson`**: utile come **facciata leggera** o per script; a lungo termine conviene **ridurre i punti d’ingresso** a uno solo per dominio (vedi i molti file `comune-*.md` nella cartella `docs/`: rischio documentale duplicato).

**Quale è “migliore”?** Per coerenza architetturale Laraxot/Eloquent: **`Comune`**. `ComuneJson` è secondario e va trattato come accessorio finché non viene assorbito o documentato come “solo legacy”.

### 2.3 `Region` / `Province` / `Locality` vs `Comune`

Non sono duplicati: **derivano** i loro `getRows()` da `Comune` (aggregazione distinta). Servono gerarchia normalizzata per select (regione → provincia → comune).

### 2.4 `State` / `County` vs `Region` / `Province`

**Ambiti geografici diversi.**

- `State` + `County`: modello **statunitense** (codice stato, contea).
- `Region` + `Province` + `Locality`: modello **italiano** da ISTAT/comuni.

Il nome inglese “State” può creare confusione con “stato nazione”: in codice va interpretato come **subdivisione USA**, non come “Regione italiana”.

**Raccomandazione**: non unificare i modelli; documentare nei PHPDoc il contesto (IT vs US) quando si aggiunge codice condiviso.

### 2.5 `GeoNamesCap`

Tabella dedicata ma classe **senza logica**: non è duplicato di `Comune`/`cap` nel JSON; è **estensione opzionale** (geonames). Valutare uso reale nel progetto prima di popolarla.

---

## 3. Trait e basi

- `Traits/HasAddress`, `HasPlaceTrait`, `GeoTrait`, `GeographicalScopes`, `SushiToJsons`: incapsulano comportamento condiviso; non sono “modelli doppi”.

---

## 4. Conclusione (zen)

- La molteplicità nasce da **evoluzione storica** (JSON statico vs Sushi vs indirizzo PostalAddress vs snapshot Places), non da tre copie dello stesso concetto senza ruolo.
- Priorità di consolidamento futuro: **`Address` + `Comune`** per il dominio italiano; **`Place`** per traccia geocoder; **`Location`** da deprecare gradualmente solo dove duplica `Address` senza motivo; **`ComuneJson`** da ridurre come superficie pubblica a favore di **`Comune`**.

---

## 5. Collegamenti

- [Indice modulo](./00-index.md)
- [Filosofia modulo](./module-philosophy.md)
- Documentazione storica su comuni (molti file con nomi simili): preferire un **unico** documento canonico in un refactor successivo della cartella `docs/`.
