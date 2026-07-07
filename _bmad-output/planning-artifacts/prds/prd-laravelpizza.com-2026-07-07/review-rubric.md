# PRD Quality Review — prd-laravelpizza.com-2026-07-07

## Overall verdict
This PRD is honest about its own uncertainty (assumptions indexed, real open questions, an explicit dual thesis) and has a coherent product/showcase thesis that its Success Metrics actually track. Its weakest point is Done-ness: only 3 of 21 FRs carry testable consequences, which will force story creation to re-derive acceptance criteria the PRD should have supplied. A secondary risk is a glossary/protagonist slip (Visitatore vs Utente, an unnamed UJ-3 protagonist) that will cause friction if UX/architecture read sections in isolation.

## Decision-readiness — adequate
Real decisions are stated as decisions (v1 is web-only, email/password only, no payments — §2.2, §5) rather than hedged as considerations. The `[NOTE FOR PM]` at §6.2 sits at a genuine tension (public speaker/organizer profiles could get pulled forward by community pressure) rather than a safe checkpoint, which is the right place for it. §8's Open Questions are genuinely unresolved — Q1 (who owns the pilot meetup) and Q2 (hosting/deploy plan) are things nobody in this document has answered, not rhetorical setups.

What's missing: trade-offs are named as exclusions ("non costruiamo X") but rarely as "we gave up Y to get Z." E.g., choosing Filament-admin-only iscrizione management (FR-4) over any self-service participant view is a real trade-off (organizers get full control, participants get zero visibility into their own registration status) that's never surfaced as a trade-off — it just reads as scope.

### Findings
- **medium** Trade-offs stated as omissions, not as costs (§5, §6.2) — Non-Goals read as a feature checklist rather than "we chose X at the cost of Y." *Fix:* For at least the highest-stakes exclusion (no participant-facing registration status/management), add one sentence naming what a participant loses.

## Substance over theater — adequate
The Vision (§1) is specific to this project — it names the actual architectural constraints (PHPStan L10, zero controllers, one-migration-per-table) as part of the value proposition, not generic "best-in-class platform" language, so it clears the Vision-theater bar. NFRs in §4.6 are concrete (WCAG 2.1 AA, JSON-LD, cookie consent before non-essential cookies) rather than "must be secure/scalable" boilerplate. Personas/JTBDs (§2.1) sit at 4, one flagged `[ASSUMPTION]` (Sviluppatore Laravel esterno) — borderline but each JTBD maps to a Feature section, so none are pure decoration.

UJ-3 (§2.3) is the one soft spot: it's a JTBD given full UJ treatment (with an "edge case"-free narrative) but doesn't drive any FR the way UJ-1 and UJ-2 do — Features 4.4–4.6 (CMS, i18n, compliance) exist independent of whether a contributor ever reads the repo. It reads as added for completeness rather than because it changed a decision.

### Findings
- **low** UJ-3 doesn't drive a decision (§2.3, §4) — no FR is scoped, added, or shaped by the "external contributor" journey; it documents a hoped-for outcome (SM-2) rather than a product journey. *Fix:* Either cut UJ-3 and let SM-2 stand on its own as an aspiration, or tie it explicitly to a concrete FR (e.g., a documentation/README requirement) so it earns its place as a UJ.

## Strategic coherence — strong
The thesis is explicit and unusual: this PRD bets on the product being simultaneously a working community tool and a public architectural demonstration (§1, restated in SM-2). Feature prioritization follows from it — compliance/SEO (§4.6) and CMS-driven pages (§4.4) matter as much for the "credible public showcase" leg of the thesis as for the "community tool" leg. SM-1 (a real meetup group completes the full loop) and SM-2 (external repo interest) map cleanly onto the two halves of the thesis, and a counter-metric (SM-C1, don't inflate CMS page/block count) is present and directly guards against gaming SM-3. This is not a backlog with headings — the MVP scope (§6.1) is legible as "the minimum needed to make both halves of the thesis testable."

## Done-ness clarity — thin
This is the dimension that needs the most work before story creation. Only FR-1, FR-9, and FR-11 (3 of 21) carry a "Consequences (testable)" block. The other 18 — including consequential ones like FR-4 (Iscrizioni export/management), FR-15/16 (locale rendering/selector), FR-19 (WCAG 2.1 AA), FR-20/21 (SEO/JSON-LD) — state the capability but not what verifying it looks like. For FR-19 in particular, "rispettano lo standard WCAG 2.1 AA" (§4.6) is a bound in name only: WCAG 2.1 AA is itself a large checklist, and the FR doesn't say whether "AA" means an automated audit threshold, a manual audit, or specific success criteria in scope. FR-3 ("dashboard con numero di Eventi... e Iscrizioni per Evento") is concrete enough to be testable as written, but wasn't marked as such — suggesting the Consequences block was applied inconsistently rather than deliberately scoped to only the highest-risk FRs.

### Findings
- **high** Consequences blocks present on only 3/21 FRs (§4.1–§4.6) — FR-4, FR-15–FR-21 in particular describe capabilities without a verifiable condition, leaving "done" to be invented downstream. *Fix:* Add at least one testable consequence per FR, prioritizing FR-19 (define which WCAG 2.1 AA success criteria / audit method), FR-20/21 (which structured-data fields are required), and FR-4 (what "gestire" the iscritti list includes — export format, edit permissions).
- **medium** FR-19's bound is a standard name, not a testable threshold (§4.6) — "WCAG 2.1 AA" without specifying audit method (automated tool, manual, specific SC subset) or scope (whole site vs public pages only) leaves QA to define done. *Fix:* State the audit method and whether admin/Filament pages are in scope or only public CMS pages.

## Scope honesty — strong
Non-Goals (§5) are explicit and given rationale by reference (`.planning/REQUIREMENTS.md`). §6.2 goes further than a simple exclusion list — it distinguishes "excluded with a v2 plan" (payments, profiles) from "excluded, no v2 planned" (chat, native app, OAuth), which is more honest than most Out-of-Scope sections. The `[NOTE FOR PM]` at §6.2 flags a real de-scoping risk (community pressure could pull profiles forward) instead of pretending the scope line is permanent. The Assumptions Index (§9) has 3 entries and all 3 round-trip to inline `[ASSUMPTION]` tags (§2.1, §2.3, §7) — no orphaned index entries, no untagged inline assumptions found. Given the hybrid internal/launch stakes and small team, an open-items count of 3 Open Questions + 3 Assumptions + 1 NOTE FOR PM is proportionate, not alarming.

## Downstream usability — thin
FR IDs (FR-1–FR-21) are contiguous and unique, and UJ IDs (UJ-1–UJ-3) resolve to the Features that cite them ("Realizza UJ-1/UJ-2"). The Glossary (§3) is otherwise disciplined — but it doesn't fully hold under FR-level use. The Glossary defines Iscrizione as a link "tra un Visitatore (o Utente registrato)" — implying two categories — but FR-9 uses "Visitatore" and FR-10 immediately switches to "L'Utente" for what should be the same actor completing the same flow, with nothing in the Glossary or FRs clarifying whether "Utente" here means "Visitatore who just registered" or a pre-existing "Utente registrato." Since JTBD 2.2 explicitly promises no complex account creation, this drift matters: a downstream reader pulling FR-10 alone could reasonably build a "registered user" gate that JTBD 2.2 rules out.

UJ-3's protagonist is unnamed ("Uno sviluppatore Laravel," "un contributore esterno" — §2.3), unlike UJ-1 (Marco) and UJ-2 (Giulia), which breaks the pattern the other two UJs establish and makes UJ-3 read as a floating journey.

### Findings
- **medium** Visitatore/Utente drift between FR-9 and FR-10 (§4.3) — the Glossary's "Utente registrato" distinction isn't applied consistently, so FR-10 is ambiguous about whether email confirmation implies an account exists. *Fix:* Either add "Utente" as a Glossary term distinct from "Visitatore," or replace "L'Utente" in FR-10 with "Il Visitatore" to match FR-9 and JTBD 2.2's no-account promise.
- **low** UJ-3 has no named protagonist (§2.3), unlike UJ-1/UJ-2 — breaks the established pattern and reinforces the UJ-3-as-filler finding above. *Fix:* Name the protagonist if UJ-3 is kept, or cut it (see Substance finding).

## Shape fit — adequate
This is a hybrid internal/launch-stakes PRD for a small team, and the shape mostly matches: named-protagonist UJs are appropriate because the public-facing side (discovery, registration) has real UX stakes, while the admin side is correctly left as a capability spec (§4.1) without forcing a UJ for every Filament CRUD action. The dual product/showcase thesis is unusual but the PRD doesn't over-formalize it — it doesn't invent a fourth "showcase" Feature section, it just lets SM-2 and the Vision carry that half. The one shape mismatch is UJ-3, discussed above: giving the "external contributor" JTBD a full narrative UJ (with the same structural weight as UJ-1/UJ-2) slightly over-formalizes a JTBD that the PRD itself later treats as aspirational (SM-2, not an FR).

## Mechanical notes
- Glossary drift: "Visitatore" vs "Utente" (see Downstream usability finding above) is the one substantive drift found. "Amministratore" / "Amministratore della piattaforma" are used interchangeably but unambiguously — not flagged as an issue.
- ID continuity: FR-1–FR-21 contiguous, no gaps or duplicates. UJ-1–UJ-3 contiguous. SM-1–SM-4 plus SM-C1 contiguous and distinguishable (primary/secondary/counter clearly labeled).
- Assumptions Index roundtrip: clean. All 3 inline `[ASSUMPTION]` tags (§2.1, §2.3, §7) appear in the §9 index; no index entries lack an inline source.
- UJ protagonist naming: UJ-1 (Marco) and UJ-2 (Giulia) are named; UJ-3 is not (see finding above).
- Required sections: all present for the agreed hybrid internal/launch stakes — Scope, Non-Goals, Success Metrics with counter-metric, Open Questions, Assumptions Index. No missing section headers.
