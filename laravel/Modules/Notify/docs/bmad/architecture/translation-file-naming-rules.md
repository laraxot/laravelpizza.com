---
title: "Regole di Naming per i File di Traduzione"
type: rule
tags: [translation, file, naming, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-file-naming-rules-1 regole di naming per i file di traduzione"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Regole di Naming per i File di Traduzione

## Principi Fondamentali per il Naming dei File

Le seguenti regole si applicano a tutti i file di traduzione nel modulo Notify:

1. **Snake Case Obbligatorio**
   - Tutti i nomi dei file devono utilizzare snake_case (lettere minuscole separate da underscore)
   - Esempio: `send_email.php`, `mail_template.php`

2. **Termini Composti e Acronimi**
   - Gli acronimi (SMS, AWS, ecc.) devono essere trattati come parole singole
   - I termini composti come "WhatsApp" devono essere trattati come una singola parola
   - ✅ CORRETTO: `send_whatsapp.php`, `send_sms.php`, `send_aws_email.php`
   - ❌ ERRATO: `send_whats_app.php`, `send_s_m_s.php`, `sendWhatsApp.php`

3. **Coerenza con il Namespace**
   - Il nome del file deve rispecchiare il namespace o la risorsa a cui si riferisce
   - Per pagine di invio: `send_[provider].php` (es. `send_telegram.php`)
   - Per risorse generali: `[resource].php` (es. `whatsapp.php`, `telegram.php`)

## Verifica della Conformità

Prima di aggiungere nuovi file di traduzione, verificare:
1. Che il nome rispetti i principi snake_case
2. Che i termini composti siano trattati correttamente
3. Che sia coerente con gli altri file dello stesso tipo

## Correzione dei File Non Conformi

Se si identifica un file con naming non conforme:
1. Creare una nuova versione con il nome corretto
2. Assicurarsi che tutti i riferimenti nel codice siano aggiornati
3. Rimuovere il file con naming errato

## Riferimenti
- [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
- [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)