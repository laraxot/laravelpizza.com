# Claude for Open Source — eligibility playbook

## Perché esiste questo documento

Anthropic offre **6 mesi di Claude Ultra** (piano top, include Claude Code) ai
maintainer/contributor open-source che superano **una** delle soglie ufficiali,
oppure via track discrezionale "ecosystem impact".

Fonte ufficiale: [Claude for Open Source](https://claude.com/contact-sales/claude-for-oss).

Questo playbook serve a:

1. misurare onestamente dove siamo;
2. scegliere la pista più realistica;
3. rendere **questa** repo una prova credibile di impatto OSS (non gaming).

## Requisiti di base (tutti)

- persona fisica, maggiorenne, paese supportato da Claude.ai;
- account GitHub **≥ 2 anni**, in buona fede;
- attività OSS pubblica negli ultimi **90 giorni**;
- almeno un progetto con licenza **OSI-approved** (qui: **MIT**);
- una sola subscription programma per persona.

`laraxot/laravelpizza.com` è pubblica, MIT, con attività recente: i requisiti
di base del progetto sono OK. La candidatura è **personale** (ogni maintainer
applica per sé).

## Soglie maintainer track (ne basta una)

| Pista | Soglia | Stato tipico di questa repo |
| --- | --- | --- |
| Dependents / packages | 500 repo dipendenti **o** 100 pacchetti | Non ancora (app starter, non libreria virale) |
| Downloads | 200k+/mese aggregati su registry | Non ancora (Packagist Laraxot << 200k) |
| Foundation committer | ruolo formale su progetto riconosciuto | Solo se il candidato lo ha altrove |
| Active contributor | **100+ PR merged** in repo **non** tuoi (12 mesi) | Misura sul profilo GitHub del candidato |
| Community builder | **20+ contributor esterni unici** con PR merged (12 mesi) | Gap principale da chiudere |
| OpenSSF criticality | score ≥ **0.4** | Improbabile a breve per un meetup starter |
| Ecosystem impact | narrativa + evidenze (discrezionale) | **Pista immediata** se spieghi bene Laraxot |

## Strategia business (DRY + KISS)

**Scopo del prodotto:** starter riusabile per meetup Laravel (Folio + Volt +
Filament + moduli Laraxot), non un e-commerce pizza.

**Politica OSS:** qualità e contribution reali battono vanity metrics. Anthropic
può scontare attività banale/automatizzata.

**Tre piste in parallelo:**

1. **Ora — Ecosystem impact**  
   Candidati con narrativa: piattaforma meetup chiavi-in-mano, 14 moduli
   PHPStan 10, tema Meetup, MIT, usato come base multi-tenant Laraxot.
2. **90 giorni — Community builder**  
   Obiettivo: ≥ 20 contributor esterni unici con **PR merged**.  
   Regola operativa: niente solo-push del maintainer per lavoro community;
   si accettano e mergiano PR da fork.
3. **Continuativo — Active contributor (personale)**  
   100+ PR merged su repo altrui (Laravel, Filament, upstream).  
   Indipendente da questa repo, ma vale per la stessa persona.

## Checklist repo (cosa deve essere vero prima di applicare)

- [x] LICENSE MIT in root
- [x] `CODE_OF_CONDUCT.md` in root
- [x] `SECURITY.md` con canale privato
- [x] `CONTRIBUTING.md` che spinge fork + PR
- [x] Issue templates + label `good first issue` / `help wanted`
- [x] Workflow OpenSSF Scorecard (`.github/workflows/openssf-scorecard.yml`)
- [x] Discussioni GitHub abilitate sul repo
- [x] Issue etichettate `good first issue` (parti da #585–#587 + label su #560/#574/#576)
- [ ] PR merged da contributor esterni (target: 20 unici in 12 mesi)
- [x] Attività pubblica recente sul repo (commit negli ultimi 90 giorni)

Misura lo stato con:

```bash
bash .github/scripts/claude-oss-eligibility-check.sh
# opzionale: passa login GitHub per la pista 100+ PR esterne
# bash .github/scripts/claude-oss-eligibility-check.sh laraxot/laravelpizza.com marco76tv
```

## Draft candidatura (max ~500 parole) — Ecosystem impact

Usa questo testo come base (personalizza numeri aggiornati dallo script):

> I maintain `laraxot/laravelpizza.com` (MIT), an open-source Laravel 12 starter
> for running real Laravel meetups: modular Laraxot architecture (14 modules),
> Filament 5 admin, Folio+Volt front office, PHPStan level 10, and a production
> Meetup theme. The goal is a replicable “meetup-in-a-box” for local PHP
> communities, not a toy demo.
>
> Why ecosystem impact: organizers and community builders need a opinionated,
> quality-gated Laravel stack that already encodes hard lessons (tenant theme
> resolution, localization, CMS blocks, XotBase Filament patterns). This repo
> packages those rules as runnable software + living docs in every module.
>
> How I will use Claude Ultra / Claude Code: triage community PRs faster, keep
> PHPStan 10 green across modules, write acceptance tests for Folio pages, and
> turn meetup organizer feedback into small merged contributions from newcomers
> (`good first issue` track).
>
> Evidence: public MIT repo, Code of Conduct, Security policy, Contributing
> guide that requires fork+PR, OpenSSF Scorecard workflow, and an active issue
> backlog labeled for external contributors.

Aggiungi link a: repo, CONTRIBUTING, 2–3 good first issue, Scorecard badge quando
disponibile, Packagist se rilevante.

## Cosa non fare

- Non inventare contributor o PR fake.
- Non contare bot/`claude` come contributor esterni umani.
- Non puntare solo alle stars: le soglie attuali non le usano.
- Non applicare due volte per “accelerare”: non aiuta.

## Deep dive: soluzioni (legittime → borderline → auto-disqualifica)

Snapshot empirico (2026-11-24) su `laraxot/laravelpizza.com`:

- umani con PR merged: `avaldivieso-meraki` (+ org members se aprono PR da fork);
- bot merged: `dependabot[bot]` (non conta per Anthropic);
- commit author `Claude <noreply@anthropic.com>`: **54** (già in history);
- AI apps già installate sull’org: `claude`, `cursor`, `google-labs-jules`,
  `devin-ai-integration`, `chatgpt-codex-connector`, `grok-by-xai`;
- forks: ~22, molti owner con pattern da account usa-e-getta (`*-bot`,
  `*-lab`, nomi generati) → **non** usarli come “community”;
- Packagist Laraxot: download mensili ~0 rilevanti (totali storici bassi);
- A3 (`marco76tv` PR merged fuori dal proprio user): ~0–1.

I termini Anthropic (riassunti da guide che citano i T&C ufficiali) dicono
esplicitamente che:

- attività **trivial / duplicativa / automated** può essere **scontata**;
- **inflating** dependents, downloads, contributions o contributor counts
  tramite **bots, exchanges o contribution-graph padding** è motivo di
  **refuse o revoke**.

Quindi “mettere fra i contributor tutti gli agenti AI” come *identità*
è la strategia che Anthropic è meglio attrezzata a smascherare (hanno
Claude[bot], vedono `noreply@anthropic.com`, filtrano `type=Bot`).

### Matrice strategie

| Tier | Idea | Serve A4 (20 contributor)? | Serve A3 (100 PR)? | Rischio revoke | Verdetto |
| --- | --- | --- | --- | --- | --- |
| L0 | Ecosystem impact **ora** con narrativa Laraxot + link | no | no | basso | **fai subito** |
| L1 | Meetup night: 20 umani, 1 PR merged a testa (anche docs) | sì | no | basso | **miglior path A4** |
| L1 | Org members (`Malebestia`, `dade1987`) aprono PR da **fork personale** | aiuta (+2) | no | basso/medio* | utile |
| L1 | Outreach ai fork **umani** veri (non account spam) | aiuta | no | basso | utile |
| L1 | A3 grind: 100 PR piccole ma utili su Laravel/Filament/nwidart/docs | no | sì | medio se typo-farm | forte se qualità |
| L2 | AI (Claude/Jules/Devin/Cursor) **scrive**, umano **firma** la PR | sì | sì | basso se PR sostanziale | **borderline utile** |
| L2 | Copilot/Jules/Claude aprono PR come `[bot]` e le mergi | no (scontati) | no | alto se li dichiari “20 contributor” | **non conta** |
| L2 | Dependabot/Renovate come “contributor” | no | no | alto in candidatura | **non conta** |
| L2 | `Co-Authored-By: Claude` su ogni commit | no (author=tu) | no | basso | irrilevante per A4 |
| L3 | 20 account sockpuppet / farm fork spam | finto sì | no | **revoke** | vietato |
| L3 | Download bombing Packagist / CI che fa `composer update` a loop | finto A1 | no | **revoke** | vietato |
| L3 | Contribution exchange (“tu 1 PR a me, io 1 PR a te”) | finto sì | finto sì | **revoke** | vietato |
| L3 | Dichiarare i bot AI come “unique external contributors” | finto sì | no | **revoke** + ironico | vietato |

\*Co-maintainer con `write` sull’org possono essere visti come “non external”.
Per massimizzare la lettura “external”, devono usare **fork + PR**, non push
diretto, e meglio se non sono admin della repo candidata.

### Perché “tutti gli AI come contributor” non chiude A4

1. **Tipo GitHub**: `dependabot`, `claude[bot]`, `devin-ai-integration[bot]`,
   Jules, Copilot coding agent → `Bot` o app identity. Filtrabili in 1 query.
2. **Anthropic è giudice e parte**: l’org ha già l’app `claude` installata;
   54 commit sono già firmati `Claude <noreply@anthropic.com>`. Contarli come
   “community umana” è autodichiarazione di padding.
3. **A4 chiede unique external con merged PR**, non “commit authors” né
   “Co-Authored-By”. Un agent che committa sul branch del maintainer **non**
   crea un nuovo login esterno.
4. Anche se il raw count salisse a 20 bot, i T&C autorizzano lo sconto e il
   revoke per inflation via bots.

### Borderline che funziona davvero (AI come moltiplicatore, non come persona)

Obiettivo: **20 login umani distinti** con ≥1 PR merged sostanziale.

Protocollo “AI-amplified humans” (grigio chiaro, difendibile):

1. Lista 25 umani reali: meetup Laravel, studenti, colleghi, contributor
   Filament, chi ha già forkatо per lavoro (non i fork spam).
2. Per ciascuno: issue `good first issue` assegnata + branch hint.
3. L’umano (o tu con il suo OK) fa girare Claude/Cursor/Jules **sul suo
   account / sul suo fork**.
4. La PR è **authored by human login**; opzionale
   `Co-Authored-By: Claude <noreply@anthropic.com>`.
5. Review umana (tu) + merge. Niente merge automatico di spazzatura.
6. Criterio qualità minimo: cambia comportamento osservabile o docs utili;
   no “fix typo in README” × 20.

Questo è borderline perché l’AI fa il grosso del lavoro, ma **non viola**
il divieto “bots as contributors”: il contributor legale resta una persona.

### A3 borderline (100 PR fuori dai tuoi repo)

- Usa Claude Code per aprire PR **piccole e utili** su upstream
  (docs Filament, nwidart/laravel-modules, Laravel localization, Pest).
- Ritmo sostenibile: ~2–3 PR/giorno buone → ~6–8 settimane.
- Evita typo-farm su 100 repo random: è il caso da manuale di “trivial
  activity may be discounted”.
- Conta solo `author:YOU` + `is:merged` + repo **non** tuoi / non org tua.
  Verifica con:
  `is:pr is:merged author:LOGIN -org:laraxot created:>YYYY-MM-DD`

### A1 / Packagist (lento, quasi mai gaming-safe)

- Pubblicare i moduli Filament/Laraxot come pacchetti Composer veri
  (`type: laravel-module`) può alzare dependents **solo** con adozione reale.
- Loop CI / mirror / self-require tra 100 meta-pacchetti = inflation → revoke.
- Oggi i download mensili Laraxot non sono vicini a 200k.

### Criticality ≥ 0.4 (quasi fuori portata a breve)

Pesi alti: `contributor_count` e `dependents_count`. Serve scala da progetto
ecosistemico, non da meetup starter. Non è la leva primaria.

### Piano operativo 30/60/90 (massima probabilità × minimo revoke)

**Giorno 0**

- Candidatura **Ecosystem Impact** (ogni maintainer umano separatamente:
  `marco76tv`, eventualmente `Malebestia` / `dade1987` se qualificano).
- Non menzionare bot/AI come prova di community.

**0–30 giorni — A4 sprint**

- 1 “LaravelPizza contribute night” (meetup o online): target 15–25 PR merged
  da login distinti.
- Pipeline AI-amplified humans sui `good first issue` (#585–#587 e seguenti).
- Org members: solo fork+PR, zero push diretto per queste contribution.
- Ignora i fork spam; non invitarli.

**30–90 giorni — A3 parallelo**

- Campagna PR upstream per il candidato principale fino a ≥100 merged
  fuori da `laraxot` / user proprio.
- Tieni un foglio con link pubblici a ogni PR (evidenza per il form).

**Sempre**

- Scorecard verde, SECURITY, CoC, niente download bombing.
- Se Anthropic chiede chiarezza: “usiamo AI tools; i contributor sono umani
  responsabili delle PR” — allineato ai T&C e a come Anthropic stessa
  promuove Claude Code.

### Anti-pattern da non confondere con “astuzia”

- Contare `Claude` (54 commit) + Dependabot + Jules + Devin + Cursor + Grok
  come “ecco i 20”.
- Mergiare 20 PR vuote generate da agent sullo stesso account.
- Usare i fork `*-bot` / account usa-e-getta già presenti nella network.
- Contribution exchange tra repo amiche solo per gonfiare A3/A4.

## Dopo l’approvazione

- Attiva il codice entro **90 giorni**.
- I 6 mesi partono dall’attivazione.
- Gli overage oltre Ultra possono essere a pagamento.
- A fine periodo la subscription non rinnova da sola.

## Collegamenti

- [Contributing (root)](../CONTRIBUTING.md)
- [Contributing (docs)](contributing.md)
- [Code of Conduct](../CODE_OF_CONDUCT.md)
- [Security](../SECURITY.md)
- [MCP / Claude Code config](mcp-claude-code-configuration.md)
