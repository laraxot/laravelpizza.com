---
qmd: "xotbasemanagerelatedrecords convention over configuration brainstorm"
issues: []
discussions: []
title: "Convenzione e delega: due decisioni separate"
type: architecture
status: discussion
implementation_status: needs-followup
created: 2026-09-11
updated: 2026-09-11
tags: [bmad, second-brain, filament, dry, kiss]
---

# Convenzione e delega: due decisioni separate

Direzione aggiornata: riusare form(Schema) e table(Table) della Resource correlata. La precedente proposta di centralizzare solo getFormSchema/getTableColumns è insufficiente come architettura finale richiesta dall'utente. Non viene riproposta nei trait globali.

**Risoluzione** significa scegliere la Resource corretta. **Delega** significa applicarne l'intera configurazione. Una selezione automatica sbagliata non diventa corretta perché la delega è completa; viceversa una selezione esplicita può restare DRY usando i resolver Xot della Resource scelta.

Il censimento testuale corrente trova 9 dichiarazioni dirette: 8 pagine applicative e 1 fixture. Non equivale a 8 pagine registrate, montabili o convertibili. Le precedenti percentuali su 7/8 pagine mescolavano registrazione, riuso parziale e presunta sicurezza: sono ritirate come guida alla nuova architettura.

| Consumer applicativo censito | Punto da verificare nella futura migrazione |
|---|---|
| ManageContacts | Resource Contact distinta da owner SurveyPdf; import/associate contestuali |
| ManagePdfStyle | Configurazione condivisa e relazione specifica |
| ManageQuestionCharts | Resource annidata esplicita e possibili alternative per il medesimo modello |
| ManageNotifyThemes | Registrazione e routing cross-pannello |
| ManageMailTemplates | Eccezione di routing documentata nel sorgente; modali e azioni locali |
| ManageCharts | Comportamento di associazione e disponibilità nel pannello |
| ManageSurveyPdfQuestionCharts | Verificare registrazione e necessità prima di pianificare migrazione |
| ManageRolePermissions | Pivot e azioni specifiche |

La presenza del modello in un modulo diverso non prova da sola che debba restare manuale per sempre. La selezione esplicita della Resource UI è possibile da valutare; abilitarne automaticamente le rotte tramite relatedResource è una decisione ulteriore. Le verifiche tinker riportate nelle prime stesure non sono state rieseguite in questa revisione: non sono dichiarate validazione runtime corrente.

[Contratto canonico A/B](xotbasemanagerelatedrecords-form-table-delegation-feasibility.md), [rimozione trait](xotbasemanagerelatedrecords-remove-traits-addendum.md), [story di ricognizione](../stories/11.1.manage-related-records-convention-over-configuration.story.md). Nessun fallback silenzioso a schema vuoto proposto come soluzione generale.

**Aggiornamento 2026-09-11 (piu' tardi)**: il link "story di ricognizione"
sopra e' rotto (il file con prefisso `11.1.` non esiste in `stories/`).
Proposta corrente, non implementata: [XotBaseManageRelatedRecords.php.md](../app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php.md),
sezioni "quinta direzione". Story reale: [xotbasemanagerelatedrecords-convention-over-configuration.story.md](../stories/xotbasemanagerelatedrecords-convention-over-configuration.story.md).

**ERRORE CRITICO TROVATO (2026-09-11)**: GetRelatedResourceClassAction fallisce
con "Nessuna Resource correlata risolvibile per ManageContacts". Probabile
causa: ambiguità tra le due ContactResource (Quaeris e Notify) o mancanza
di form/table class. Analisi completa in
[XotBaseManageRelatedRecords.php.md](../app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php.md)
sezione "ERRORE CRITICO TROVATO". Story riaperta come 'needs-followup'.

