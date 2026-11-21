---
title: "database model coverage"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "database model coverage"
issues: []
discussions: []
---

# Lang — Copertura Model / Migration / Seeder / Factory

Stato: colmato il gap su `LanguageLine` (mancavano factory e seeder). Documentati gli skip su
`TranslationFile` (Sushi, no tabella) e sulle classi base astratte.

## Modelli concreti (`app/Models/`)

| Modello | Tabella | Migration | Factory | Seeder |
|---|---|---|---|---|
| `LanguageLine` | `language_lines` | OK | `LanguageLineFactory` (nuovo) | `LanguageLineSeeder` (nuovo) |
| `Translation` | `translations` | OK | `TranslationFactory` | `TranslationSeeder` |
| `Post` | `posts` | OK | `PostFactory` | `PostSeeder` |
| `TranslationFile` | nessuna (Sushi) | SKIP (vedi sotto) | `TranslationFileFactory` | `TranslationFileSeeder` |

`LangDatabaseSeeder` ora orchestra i seeder via `$this->call([...])`:
`LanguageLineSeeder`, `TranslationSeeder`, `PostSeeder`, `TranslationFileSeeder`.
`LanguageLineSeeder` è idempotente su `(group, key, locale)` con chiavi reali di framework
(`auth`, `pagination`), non inventate.

## Skip motivati

| Elemento | Tipo | Motivo skip |
|---|---|---|
| `TranslationFile` | modello **Sushi** (read-only da filesystem lang) | nessuna migration/tabella DB: le righe derivano dai file di traduzione via `GetAllTranslationAction`. Factory/seeder esistono come stub (contratto di scaffolding) ma non popolano una tabella. |
| `BaseModel`, `BaseModelLang`, `BaseMorphPivot` | classi astratte | non istanziabili, nessuna tabella propria |
| `Contracts/`, `Policies/`, `Traits/` | interfacce/policy/trait | non sono modelli concreti |
| `Post.php.fixed`, `post.php.fixed` | file `.fixed` (backup, non caricati dall'autoloader) | non sono classi PHP attive |

## Note

- `LanguageLine` è l'override DB delle traduzioni (spatie/laravel-translation-loader); la tabella
  `language_lines` ha unique `(group, key, locale)` e colonna `text` JSON.
- Namespace: `Modules\Lang\Database\Seeders`, `Modules\Lang\Database\Factories`.
