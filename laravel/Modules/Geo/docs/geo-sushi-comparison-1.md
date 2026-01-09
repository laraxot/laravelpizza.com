# Confronto: GeoJsonModel (readonly JSON) vs Laravel Sushi

## 1. Descrizione degli approcci

### GeoJsonModel (readonly JSON)
- Modello astratto che carica dati statici (regioni, province, città, ecc.) da file JSON versionato.
- I dati sono letti, cache-izzati e restituiti come Collection Laravel.
- Nessuna tabella/migration, nessun database coinvolto.
- Ispirato a Squire.

### Laravel Sushi
- Pacchetto che permette di creare Eloquent Model da array/config/API senza database.
- I dati sono caricati in una tabella SQLite temporanea in memoria.
- Query Eloquent complete, join, where, order, ecc.
- Supporta anche dati dinamici (API, config, ecc.)

---

## 2. Vantaggi e svantaggi

### GeoJsonModel
**Vantaggi:**
- ✅ Semplicità massima (KISS): nessun DB, nessuna migration, solo file JSON.
- ✅ Versionamento e audit dei dati semplicissimo (git).
- ✅ Performance ottima per dataset piccoli/medi (fino a ~10k record): 90% dei casi d'uso geografici.
- ✅ Facilmente ispezionabile e modificabile.
- ✅ Zero dipendenze esterne.
- ✅ Cache Laravel nativa.
- ✅ Ideale per dati "immutabili" (es. regioni, province, comuni, cap, codici fiscali, ecc.)
- ✅ Facilmente integrabile in CI/CD.
- ✅ 100% compatibile con policy di trasparenza e audit.

**Svantaggi:**
- ❌ Non è un vero Eloquent Model: niente join, niente query avanzate, niente relazioni.
- ❌ Non adatto a dataset molto grandi (>50k record): la Collection viene caricata tutta in memoria.
- ❌ Non adatto a dati "mutabili" o soggetti a CRUD.
- ❌ Meno flessibile per query complesse (solo metodi Collection).
- ❌ Non supporta eager loading, relazioni, morph, ecc.

### Laravel Sushi
**Vantaggi:**
- ✅ Eloquent completo: join, where, order, relazioni, morph, ecc.
- ✅ Supporta dati da array, config, API, CSV, ecc.
- ✅ Performance ottima per dataset piccoli/medi (fino a ~10k record): 90% dei casi d'uso statici.
- ✅ Nessuna migration, nessun DB persistente.
- ✅ Query avanzate e compatibilità con tutto l'ecosistema Eloquent.
- ✅ Possibilità di usare relazioni tra modelli Sushi.
- ✅ Supporta anche dati dinamici (API, config, ecc.)

**Svantaggi:**
- ❌ Richiede estensione SQLite attiva su PHP (non sempre disponibile in ambienti limitati).
- ❌ I dati sono caricati in una tabella temporanea: overhead di bootstrap.
- ❌ Non adatto a dataset molto grandi (>50k record): la tabella viene creata in memoria.
- ❌ Più "magico" e meno trasparente rispetto a un file JSON puro.
- ❌ Versionamento dati meno immediato (se i dati sono hardcoded nel model).
- ❌ Se i dati cambiano, gli id possono cambiare (se non definiti manualmente).

---

## 3. Percentuali di preferenza (per casi d'uso geografici statici)
- GeoJsonModel: **70%** (preferito per dati statici, trasparenza, semplicità, audit, versionamento)
- Laravel Sushi: **30%** (preferito solo se servono query Eloquent avanzate, join, relazioni, morph, ecc.)

---

## 4. Considerazioni finali
- Per dati geografici statici (regioni, province, città, cap, ecc.) **GeoJsonModel è la scelta migliore**: semplice, trasparente, versionabile, auditabile, zero dipendenze, performance ottima fino a 10-20k record.
- Sushi è ottimo se serve la potenza di Eloquent (join, relazioni, morph, query avanzate) ma introduce dipendenze e "magia" in più, e richiede SQLite attivo.
- Per dati mutabili o dataset molto grandi (>50k record) valutare una tabella DB vera con migration e indicizzazione.
- Entrambi gli approcci sono DRY, KISS e adatti a CI/CD, ma GeoJsonModel è più "zen" e trasparente.

---

## 5. Collegamenti e approfondimenti
- [Geo/project_docs/geo-json-model.md](geo-json-model.md)
- [Sushi - usesushi.dev](https://usesushi.dev/)
- [Squire PHP](https://github.com/squirephp/squire)
- [Xot/project_docs/module-structure.md](../../Xot/project_docs/module-structure.md)
- [<main module>/project_docs/geo-integration.md](../../<main module>/project_docs/geo-integration.md)

---

**Ultimo aggiornamento:** {{date('Y-m-d')}}
Responsabile: Cascade AI
