# Analisi: Comune.php come modello Laravel Sushi

## 1. Contesto attuale
- Attualmente `Comune.php` estende `GeoJsonModel` e legge i dati da `comuni.json` come Collection Laravel, readonly, senza DB.
- Tutta la logica di estrazione (regioni, province, città, cap, ecc.) è implementata tramite metodi statici.

## 2. Ipotesi: Implementare Comune.php con Laravel Sushi
- Laravel Sushi permette di creare un Eloquent Model "virtuale" da array/config/json/API, senza tabelle DB reali.
- I dati verrebbero caricati in una tabella SQLite temporanea in memoria, con API Eloquent completa (query, join, relazioni, morph, ecc.).
- Possibile implementazione: caricare i dati da `comuni.json` in `getRows()` e usare il trait Sushi.

---

## 3. Vantaggi di Sushi rispetto a GeoJsonModel
- ✅ **API Eloquent completa**: join, where, order, relazioni, morph, query avanzate.
- ✅ **Compatibilità Filament/Eloquent**: si comporta come un vero Model, integrabile ovunque serva Eloquent.
- ✅ **Query più espressive**: si possono usare query builder, scope, relazioni, ecc.
- ✅ **Performance ottima per dataset piccoli/medi** (fino a ~10k record): query su SQLite in memoria.
- ✅ **Facile refactoring**: chi già usa Eloquent può migrare senza cambiare API.
- ✅ **Supporto a relazioni tra modelli Sushi** (es: relazione tra Comune e altri modelli statici).

---

## 4. Svantaggi di Sushi rispetto a GeoJsonModel
- ❌ **Richiede estensione SQLite attiva su PHP** (non sempre disponibile in ambienti limitati o server shared).
- ❌ **Overhead di bootstrap**: i dati vengono caricati in una tabella temporanea ad ogni deploy/cache clear.
- ❌ **Più "magico" e meno trasparente**: meno ispezionabile rispetto a una Collection pura.
- ❌ **Versionamento dati meno immediato** (se i dati sono hardcoded nel model).
- ❌ **Id instabili**: se non definiti manualmente, gli id possono cambiare se cambia l'ordine dei dati.
- ❌ **Non adatto a dataset molto grandi** (>50k record): la tabella viene creata in memoria.
- ❌ **Dipendenza da un package esterno** (calebporzio/sushi).

---

## 5. Percentuali di preferenza (per il nostro caso d'uso)
- **GeoJsonModel:** **60%** (preferito per trasparenza, semplicità, auditabilità, zero dipendenze)
- **Sushi:** **40%** (preferito se serve API Eloquent completa, join, relazioni, morph, query avanzate)

### Motivazione
- Se serve solo estrazione readonly e performance su <20k record, GeoJsonModel è più "zen", trasparente, DRY/KISS, auditabile e senza dipendenze.
- Se serve API Eloquent completa (join, relazioni, morph, query avanzate, compatibilità totale con Filament/Eloquent), Sushi è una scelta valida, ma introduce dipendenze e "magia" in più.
- In ambienti dove SQLite non è garantito, GeoJsonModel è più robusto.

---

## 6. Raccomandazioni finali
- **Consigliato**: Restare su GeoJsonModel se la logica è solo di estrazione/filtraggio e non servono join/relazioni.
- **Valutare Sushi** solo se si prevede di dover fare query Eloquent avanzate, join, morph, relazioni, o se serve compatibilità totale con componenti che richiedono Eloquent puro.
- Se si passa a Sushi, documentare bene la dipendenza, gestire manualmente gli id, e testare la compatibilità su tutti gli ambienti.

---

## 7. Collegamenti
- [geo-json-model.md](geo-json-model.md)
- [geo-sushi-comparison.md](geo-sushi-comparison.md)
- [comune-unificazione-analisi.md](comune-unificazione-analisi.md)
- [Sushi - usesushi.dev](https://usesushi.dev/)
- [module_geo.md](module_geo.md)

---

**Ultimo aggiornamento:** {{date('Y-m-d')}}
Responsabile: Cascade AI 
