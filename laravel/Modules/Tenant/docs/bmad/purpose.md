---
title: "Tenant: scopo del modulo e come raggiungerlo meglio"
type: concept
created: 2026-09-02
tags: [tenant, purpose, multi-tenancy, dominio, configurazione, sushi]
qmd: "tenant scopo modulo multi tenancy dominio configurazione sushi json tenantservice filepath"
updated: 2026-09-02
issues:
  # DA CREARE: `gh` non autenticato: mai numeri inventati.
  # gh issue create --repo provtv/module_tenant_fila5 --title "<argomento del file>"
  - "https://github.com/provtv/module_tenant_fila5/issues/"
discussions:
  # DA CREARE: vedi sopra.
  - "https://github.com/provtv/module_tenant_fila5/discussions/"
status: superseded
superseded_by: ../purpose.md
---

# Tenant: perche' esiste

## Lo scopo in una frase

**Tenant permette a una sola installazione di servire piu' enti senza che nessuno veda
i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## L'evidenza

- `Domain`, `TenantDomain`: il tenant si riconosce **dall'URL**: e' la strategia meno
  invasiva e la meno fragile.
- `TenantSetting`: cio' che varia fra enti e' un dato.
- `DatabaseConfig`: isolamento che puo' arrivare fino a basi dati separate.
- `TenantSubscription`: un tenant ha un ciclo di vita.
- `BaseModelJsons`, `TestSushiModel`: configurazione da file JSON letta come se fosse
  una tabella (Sushi).
- Solo 52 file PHP: **la potenza sta nella posizione, non nel volume**. E' attraversato
  da ogni richiesta.

## La regola che conta piu' di tutte

**`TenantService::filePath()` non e' `base_path()`.**

`base_path()` restituisce la radice dell'applicazione e ignora il tenant. Usarlo dove
serve un percorso per-tenant fa leggere e scrivere all'ente A i file dell'ente B: e
non produce nessun errore: il file esiste, il codice funziona, i dati sono di un altro.

E' il tipo di errore peggiore che questo progetto conosca: **muto**. La stessa famiglia
di `public_path()` che deve puntare a `public_html/`.

Il trait `SushiToJsons` implementa gia' `getJsonFile()` **correttamente**, usando
`TenantService::filePath()`. Ci sono precedenti documentati di modelli che lo hanno
riscritto con `base_path()`, rompendo il multi-tenancy in silenzio. La regola operativa
e' quindi: **prima di scrivere un metodo in un modello, leggere i trait che il modello
gia' usa.**

## Come raggiungerlo **meglio**

### 1. `base_path()` va vietato dove serve il tenant, con un test

**Azione:** un test che fallisca se `base_path(` compare in un percorso di dati dentro i
moduli. Poche righe, e chiude una classe intera di bug silenziosi.

### 2. Serve un test di isolamento, non solo la fiducia nello scope

La promessa del modulo e' "A non vede B". Una promessa cosi' va dimostrata.

**Azione:** un test che, con due tenant popolati, verifichi che ogni query sui modelli
tenant-aware restituisca solo le righe del tenant attivo. E' il test piu' importante
del modulo e oggi manca.

### 3. Un tenant non riconosciuto deve fallire, non ripiegare su un default

Se il dominio non corrisponde a nessun tenant e il sistema sceglie il primo o il
predefinito, si serve un ente con i dati di un altro.

**Azione:** dominio sconosciuto → errore esplicito. Mai un fallback silenzioso.

### 4. La configurazione da JSON va validata all'avvio

Sushi legge JSON come fossero tabelle. Un JSON malformato o con una chiave mancante si
manifesta lontano dal punto in cui e' stato scritto.

**Azione:** validazione di schema al caricamento, con messaggio che dica **quale file** e
**quale chiave**.

### 5. Il README (287 righe) e' fra i migliori: va tenuto sincronizzato

E' il secondo piu' esteso del progetto ed e' una buona base. Il rischio non e' la
scarsita', e' l'invecchiamento.

## Confini: cosa **non** appartiene a Tenant

- I **permessi dentro** un ente: User.
- Le **regole di dominio** che variano fra enti: modulo di dominio, che le legge da
  `TenantSetting`.
- L'**infrastruttura Filament**: Xot.

## Collegamenti

- `docs/wiki/memories/public-path-is-public-html.md`: la stessa famiglia di errori muti
- `bashscripts/ai/.agents/rules/common/laravel-traits.md`: leggere i trait prima di scrivere
