---
title: "FixDoubleEncodedUtf8Action: riparare il testo UTF-8 codificato due volte"
type: story
module: Xot
created: '2026-11-19'
updated: '2026-11-19'
status: review
related:
  - ../../../Quaeris/docs/stories/configurazione-automatica-question-chart.story.md
---

# FixDoubleEncodedUtf8Action: riparare il testo UTF-8 codificato due volte

Fase BMAD: dev.

## Perche'

Nei backup locali del 2026-10-23 (`geek_quaeris_backup_server_23_10_2025`, `quaeris_survey_23_10_2025`) i
testi sono codificati due volte: «Sì» e' salvato come `SÃ¬` (byte `53 C383 C2AC` invece di `53 C3AC`), in
colonne `utf8mb4` lette con connessione `utf8mb4`. E' la firma di un dump UTF-8 importato come `latin1`
(che in MySQL e' Windows-1252). Il primo consumatore che se ne accorge e' il pulsante «Configura i grafici»
di Quaeris: riconosce il Sì/No dal testo delle risposte e su `SÃ¬` non lo riconosce (story Quaeris
«configurazione-automatica-question-chart», 2026-11-19).

## Cosa fa

`Modules\Xot\Actions\String\FixDoubleEncodedUtf8Action::execute(string): string`.

1. Testo solo ASCII, o non valido UTF-8: torna com'e'.
2. Lo riporta ai byte Windows-1252 (l'inverso dell'errore di import). Windows-1252 e non ISO-8859-1: nei dati
   c'e' anche l'apostrofo tipografico rovinato `â€™`, e `€` e `™` esistono solo in Windows-1252.
3. Accetta il risultato **solo se** il passaggio e' senza perdite (riconvertito da Windows-1252 torna identico
   all'originale) **e** i byte ottenuti sono UTF-8 valido. Altrimenti torna il testo com'era.

Cosi' un testo pulito resta intatto: «Città» diventa il byte `E0` isolato, che non e' UTF-8 valido; un'emoji
non ha posto in Windows-1252 e il passaggio perde caratteri. In produzione, se i dati sono puliti, l'Action non
cambia niente.

I cinque byte che Windows-1252 non definisce (`81`, `8D`, `8F`, `90`, `9D`) mbstring li fa passare senza perdite
(verificato: «Á» rovinato, `C383 C281`, torna `C381`), quindi non lasciano buchi.

## Consumatori

- Quaeris `CreateMissingQuestionChartsAction`: testi di domande e risposte letti da LimeSurvey.
- Candidato, non toccato: Notify `MigrateNotifyThemesToMailTemplateCommand::decodeRichText()` fa una riparazione
  simile, privata e basata su ISO-8859-1 (non regge `â€™` e trasforma un'emoji in `?`).

## Test

`tests/Unit/Actions/String/FixDoubleEncodedUtf8ActionTest.php`: «SÃ¬» → «Sì», «QualitÃ  dell'acqua» →
«Qualità dell'acqua», «dellâ€™acqua» → «dell’acqua»; restano uguali ASCII, «Città», «Sì», un'emoji, una
stringa vuota e una non UTF-8.

Il test usa `XotBaseTestCase` e non `TestCase`: non serve il database, e `TestCase` apre una transazione sulla
connessione sqlite, il cui file in locale non esiste (`SQLiteDatabaseDoesNotExistException`, anche sul test
fratello `NormalizeDriverNameActionTest`, non toccato).

## Verifiche

```
DB_HOST=127.0.0.1 pest --no-coverage --test-directory=Modules/Xot/tests tests/Unit/Actions/String/FixDoubleEncodedUtf8ActionTest.php
 prima dell'Action: 10 failed (classe assente); dopo: 10 passed
phpstan analyse app/Actions/String      [OK] No errors
pint --test                             passed
tools/phpmd.sh <action> text cleancode,codesize,design      nessuna segnalazione
```

Verifica sui dati: nel pulsante di Quaeris, sul survey di prova 230, le cinque Sì/No `SÃ¬` tornano torte e i
titoli delle righe di griglia escono puliti (story Quaeris, sezione «2026-11-19 — Il pulsante ripara i testi
codificati due volte»).

## Acceptance criteria

- [x] Ripara `SÃ¬`, `QualitÃ `, `â€™`.
- [x] Lascia intatti testo ASCII, accenti puliti, emoji, testo non UTF-8.
- [x] Primo consumatore collegato (Quaeris).
