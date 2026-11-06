---
title: "Audit globale del contratto SettingPage/ConfigData"
type: story
status: in-progress
module: Xot
tags: [bmad, settings, tenant, contract, audit]
qmd: "SettingPage ConfigData schema tenant audit contract all modules"
---

# Audit globale del contratto SettingPage/ConfigData

## Obiettivo

Ogni `SettingPage` deve esporre solo impostazioni tenant realmente persistibili dal
`ConfigData` corrispondente. Ogni impostazione dichiarata dal `ConfigData` deve avere
un campo nella pagina oppure una ragione documentata per essere infrastrutturale,
segreta o non modificabile.

## Criteri verificati

- il file tenant letto da `ConfigData` coincide con quello scritto da `BaseSettingPage`;
- i campi della pagina sono compatibili con le proprietà pubbliche del `ConfigData`;
- i valori non vengono duplicati tra moduli quando condividono `xra.php`;
- un campo viene mantenuto solo se ha un lettore runtime o una responsabilità esplicita.

## Finding iniziali

- Cms non deve duplicare `primary_lang`: la chiave appartiene a Xot anche se vive in `xra.php`;
- Gdpr non deve esporre `enabled` finché non esiste un lettore tenant di quel flag;
- Media non deve trattare `name` come impostazione: è metadato del modulo;
- Restaurant deve allineare la pagina alle impostazioni operative dichiarate dal suo Data,
  evitando una pagina che salva soltanto un interruttore generico.

La story resta aperta finché il controllo statico e i test dei moduli interessati non
sono verdi.
