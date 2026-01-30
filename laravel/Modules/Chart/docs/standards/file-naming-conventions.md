# Convenzioni di Naming per File di Documentazione

## Regole Fondamentali

1. **README.md**: SEMPRE con lettere maiuscole (README.md)
   - Questo è l'unico file che deve avere lettere maiuscole nel nome
   - Presente nella root di ogni modulo e nella cartella docs di ogni modulo
   - Serve come punto di ingresso principale alla documentazione

2. **Altri file di documentazione**: SEMPRE con lettere minuscole
   - Esempi: `bottlenecks.md`, `roadmap.md`, `structure.md`, ecc.
   - Mai usare maiuscole come `BOTTLENECKS.md` o `Roadmap.md`

3. **Cartelle di documentazione**: SEMPRE con lettere minuscole
   - Esempi: `performance`, `roadmap`, `standards`, ecc.

## Motivazioni

1. **Coerenza**: Facilita la navigazione e la manutenzione del codice
2. **Standard GitHub**: README.md in maiuscolo è lo standard di GitHub e viene automaticamente visualizzato quando si accede a una directory
3. **Convenzioni Open Source**: Segue le convenzioni della comunità open source
4. **Chiarezza**: Distingue chiaramente il file principale (README.md) dagli altri file di documentazione

## Esempi Corretti

```
Modules/ModuleName/
├── README.md                  # ✅ CORRETTO (maiuscolo)
├── docs/
│   ├── README.md              # ✅ CORRETTO (maiuscolo)
│   ├── bottlenecks.md         # ✅ CORRETTO (minuscolo)
│   ├── roadmap.md             # ✅ CORRETTO (minuscolo)
│   └── performance/
│       └── bottlenecks.md     # ✅ CORRETTO (minuscolo)
```

## Esempi Errati

```
Modules/ModuleName/
├── Readme.md                  # ❌ ERRATO (prima lettera maiuscola)
├── readme.md                  # ❌ ERRATO (tutto minuscolo)
├── docs/
│   ├── readme.md              # ❌ ERRATO (tutto minuscolo)
│   ├── BOTTLENECKS.md         # ❌ ERRATO (tutto maiuscolo)
│   └── Roadmap.md             # ❌ ERRATO (prima lettera maiuscola)
```

## Implementazione

Quando si trovano file che non seguono queste convenzioni, devono essere rinominati:

1. Per file README.md con nome errato:
   ```bash
   mv /path/to/module/docs/readme.md /path/to/module/docs/README.md
   ```

2. Per altri file di documentazione con maiuscole:
   ```bash
   mv /path/to/module/docs/BOTTLENECKS.md /path/to/module/docs/bottlenecks.md
   ```

3. Aggiornare tutti i riferimenti nei file che puntano ai file rinominati.

## Impatto

Seguire queste convenzioni garantisce:
- Coerenza in tutto il progetto
- Facilità di navigazione
- Conformità agli standard della comunità
- Migliore manutenibilità del codice

## Collegamenti Bidirezionali

- [Indice Documentazione](../INDEX.md) - Indice principale della documentazione
- [README Principale](../README.md) - Panoramica del progetto
- [Regole di Documentazione](../regole-documentazione.md) - Linee guida generali per la documentazione
- [Convenzioni Generali](../conventions.md) - Altre convenzioni e standard del progetto

## Vedi Anche
- [Xot Documentazione](../../laravel/Modules/Xot/docs/README.md) - Linee guida generali del modulo Xot
- [Cms Documentazione](../../laravel/Modules/Cms/docs/README.md) - Documentazione del modulo Cms
- [Regole Collegamenti](../regole_collegamenti_documentazione.md) - Regole per i collegamenti nella documentazione
- [Linee Guida Documentazione](../linee-guida-documentazione.md) - Linee guida complete per la documentazione
