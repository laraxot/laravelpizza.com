---
name: 'Adversarial Review — LaravelPizza Architecture Spine'
type: review
target: _bmad-output/planning-artifacts/architecture/architecture-laravelpizza.com-2026-07-07/ARCHITECTURE-SPINE.md
method: adversarial-two-builders
created: '2026-07-07'
---

# Adversarial Review — ARCHITECTURE-SPINE.md

## Method

For each pair of ADs, I constructed two independent builders (or two future stories) who each read the spine, each obey every AD-1..AD-8 to the letter, and asked: can they still produce code that collides — same entity owned twice, incompatible DTO/state shapes, a mutation path that bypasses another mutation path's invariants, or a boundary (module or trust) that is honored in letter but violated in spirit? Six holes found below, each with a concrete scenario and a named fix.

---

## Finding 1 — AD-3 does not say who owns an entity's invariant, so two Actions can enforce it differently

**Scenario:** AD-3 requires every state mutation to be an `Action` with `execute()`, throwing domain exceptions for violated invariants (example given: "evento pieno"). It says nothing about which single Action (or which single method) is the *authoritative* check for that invariant.

- Builder A implements `RegisterAttendeeToEventAction` and checks "is event full" by `EventUser::where('event_id', ...)->count() >= $event->capacity`.
- Builder B, working the "waitlist" story independently, implements `PromoteFromWaitlistAction` and checks the same invariant by decrementing a cached `events.seats_left` column.

Both are AD-3-compliant (Action, `execute()`, domain exception on violation). Both compile, both pass PHPStan level 10, both get reviewed independently as "correct." In production the two counting strategies drift (row count vs. cached column), and the event silently over-books or under-books depending on which Action ran last — a classic split-brain invariant, invisible to any of the ADs as written.

**Fix — tighten AD-3:** add a clause: "For any invariant shared by more than one Action against the same entity (e.g. capacity, status transitions), the invariant check MUST live on the model or a dedicated domain service owned by the module that owns the entity (e.g. `Event::hasAvailableSeats()`), and every Action MUST call that single method — never re-derive the invariant from raw queries or duplicated counters." Optionally list the known shared invariants per entity (Event capacity, EventUser status) as a companion doc so future stories don't have to rediscover the seam.

---

## Finding 2 — AD-4's dependency graph doesn't cover the support modules, so two stories can wire a cycle through them

**Scenario:** AD-4 pins the graph only for `Xot, User, Activity, Gdpr, Tenant, Cms, Meetup`. `Geo, Job, Lang, Media, Notify, Seo, UI` are listed in the repo structure but never placed in the dependency rule.

- Story A (SEO meta tags for event pages) adds `Modules\Meetup\Actions\Event\CreateEventAction` calling `Modules\Seo\Actions\GenerateSlugAction`, i.e. `Meetup → Seo`.
- Story B (structured-data / sitemap generation) adds `Modules\Seo\...` code that needs the event title/date, so it type-hints `Modules\Meetup\Models\Event`, i.e. `Seo → Meetup`.

Neither story violates any written rule in AD-4 — `Seo` is simply absent from the graph, so both directions look "permitted by omission." The result is a real circular dependency (`Meetup ↔ Seo`) that AD-4 was explicitly written to prevent for the named modules, silently reintroduced through an unnamed one.

**Fix — extend AD-4:** add an explicit default rule for every module *not* named in the graph: "Support modules (`Geo, Job, Lang, Media, Notify, Seo, UI`) may depend only on `Xot`. Domain modules (`Meetup`, and any future domain module) may depend on support modules; support modules must never depend on a domain module. Any module added to the codebase must be placed in this graph in the same PR that introduces its first cross-module `use`." This closes the "absence = permission" loophole.

---

## Finding 3 — AD-5's trust boundary is a documentation promise, not a gate, so an AD-2-compliant admin feature can silently invalidate it

**Scenario:** AD-5 says the `view` key in a content-block JSON is trusted and rendered directly, "solo finché" the JSON is editable only by filesystem/deploy access. AD-2 (independently) says any Filament admin surface must extend XotBase — it says nothing about *what data* a Filament resource is allowed to write.

- Builder A, satisfying a PRD ask for "let the marketing person edit the homepage copy without a deploy," builds a fully AD-2-compliant `XotBaseResource` (`ContentPageResource`) that edits the same JSON files under `config/local/{tenant}/database/content/pages/*.json`, including the `content_blocks[].view` field, via a plain text input.
- Builder B, on the Cms rendering side, keeps relying on AD-5 exactly as written: `view()->exists($view)` then render — no whitelist, because "no one edits this JSON except deploy."

Both builders are individually AD-compliant. Together, a non-technical Filament user (who now has UI access, not filesystem access) can set `view` to any Blade view resolvable in the app (`filament::pages.dashboard`, or a view under `resources/views/vendor/...` with side effects), achieving arbitrary view inclusion — exactly the trust-model flip AD-5 flags as its own trigger for a registry, but nothing stops Builder A from crossing that trigger unnoticed since AD-2 doesn't reference it.

**Fix — cross-link and gate:** (a) add to AD-2 or as a new AD: "Any Filament resource that writes to `config/local/{tenant}/database/content/pages/*.json` (or any file AD-5 currently treats as trusted) MUST NOT be introduced without simultaneously implementing the type→view registry described in AD-5's Deferred section — the two changes ship in the same PR, never independently." (b) In AD-5 itself, replace "finché il JSON resta editabile esclusivamente da chi ha accesso a filesystem/deploy" with a falsifiable, checkable condition, e.g. "no Filament resource, Livewire component, or API route may target this JSON path" — something a reviewer can grep for, not just recall.

---

## Finding 4 — AD-3's "business logic" carve-out is ambiguous for Filament's native record mutation, so audit trails can fork

**Scenario:** AD-3 bans "business logic inline in Volt/Livewire/Filament." Filament's idiomatic pattern for simple field edits (`EditRecord`, table bulk actions) is `$record->update([...])` with no Action involved — this is standard, XotBase-sanctioned (AD-2) Filament usage, not obviously "business logic."

- Builder A treats "mark attendee as attended" as a trivial CRUD toggle and lets the Filament bulk action call `$record->update(['status' => 'attended'])` directly on `EventUser` — AD-2 compliant, and arguably AD-3 compliant since it's "just a field update," not obviously an "invariant."
- Builder B, working the front-office check-in flow, wraps the identical mutation in `MarkAttendeeAttendedAction`, which additionally fires `activity('event')->log(...)` per the AD-3 example pattern.

Both are individually defensible readings of AD-3. In production, the same `status` transition on the same entity (`EventUser`) now has two live paths — one logged, one silent — and any downstream code (reporting, GDPR data-export, activity-based notifications) that assumes "every status change is in the activity log" (a reasonable inference from AD-3's own example) is wrong for admin-originated changes.

**Fix — tighten AD-3 with a bright line:** enumerate the "invariant-bearing entities" (starting with `Event`, `EventUser`) and state explicitly: "Any create/update/delete touching an invariant-bearing entity's business-meaningful fields (status, capacity, dates, relations) MUST go through an Action, including from Filament's native `EditRecord`/bulk actions (override `handleRecordUpdate()` to delegate to the Action) — there is no 'trivial CRUD' exemption for these entities. Exemption applies only to pure admin-metadata models with no domain invariant (e.g. free-text descriptions, ordering)."

---

## Finding 5 — AD-7 defines tenant resolution only for the HTTP/boot path, leaving queue/console contexts an open seam

**Scenario:** AD-7 states the single tenant-resolution point is `TenantServiceProvider::boot()` → `GetTenantNameAction`, deriving tenant from `config('app.url')`/`SERVER_NAME`. It does not say what happens when there is no HTTP request — e.g. a queued job (`Modules\Job`) or a scheduled console command.

- Builder A (event reminder emails) dispatches a queued job that, when it runs on the worker, re-invokes `GetTenantNameAction` inside the job's `handle()` because "that's the one true resolution point per AD-7" — but on a worker process `SERVER_NAME` is unset/wrong, so it silently resolves to the wrong tenant (or the first `config/local/*` folder found), sending Tenant B's reminder emails using Tenant A's branding/config.
- Builder B (a different queued job, GDPR data export) instead captures the tenant name at dispatch time (inside the HTTP request where it's correctly resolved) and passes it explicitly in the job payload, restoring it manually in `handle()`.

Both builders believe they're following AD-7 ("the only resolution point is `TenantServiceProvider::boot()`"); they arrive at incompatible integration patterns (re-resolve vs. pass-through), and Builder A's version is a live correctness bug that AD-7 doesn't rule out because it never addresses non-HTTP entrypoints.

**Fix — extend AD-7:** add: "For non-HTTP entrypoints (queued jobs, `artisan` commands, scheduled tasks), tenant identity MUST be captured at dispatch/enqueue time from the already-resolved HTTP context and carried explicitly (e.g. a `tenant` field on the job/command), never re-derived from `SERVER_NAME`/`config('app.url')` inside the worker process, since no HTTP request exists there to resolve it correctly."

---

## Finding 6 — No AD pins ownership of cross-module status/enum shapes, so Meetup and Gdpr can each invent a different vocabulary for the same concept

**Scenario:** AD-3 mandates Actions take DTOs (`Spatie\LaravelData\Data`, per the Consistency Conventions table), but nothing says who owns the *shape* of a status/enum field shared conceptually across modules.

- Story A, in `Meetup`, defines `EventData`/attendee status as strings `'confirmed' | 'cancelled'`.
- Story B, in `Gdpr` (consent withdrawal cancels a registration per data-subject rights), defines its own `ConsentWithdrawalData` with status `'active' | 'revoked'`, and its Action calls into `Meetup`'s cancellation Action passing a translated value it invents ad hoc (`'revoked' → 'cancelled'`) — a mapping that lives only in Gdpr's head, undocumented, and easily inverted or forgotten by a third story.

Both stories are AD-3-compliant (Action + DTO + domain exceptions) and AD-4-compliant (`Gdpr` doesn't depend on `Meetup`, direction is fine per the graph — actually this reveals a second issue: AD-4 says Meetup depends on Gdpr, not the reverse, so Gdpr calling into a Meetup Action would itself violate AD-4, and a builder might "fix" this by duplicating the cancellation logic inside Gdpr instead — reintroducing Finding 1's split-brain invariant problem across a module boundary this time).

**Fix — add a new AD (or extend AD-3):** "Status/enum vocabularies for a shared entity are owned by the module that owns the entity (Event/EventUser status → owned by `Meetup`) and exposed as a public PHP enum in that module's `app/Enums/`; dependent modules (per the AD-4 graph direction) import and reuse that enum, never redeclare an equivalent one with different string values. If a dependent module needs to trigger a mutation on an entity it doesn't own, it must do so by depending in the correct AD-4 direction and calling the owning module's Action — it must never reimplement the mutation locally to route around the dependency direction."

---

## Summary Table

| # | Colliding pair | Root ambiguity | Fix target |
| --- | --- | --- | --- |
| 1 | Two Actions, same entity invariant | AD-3 doesn't assign invariant ownership | Tighten AD-3 |
| 2 | Two support-module dependencies | AD-4 graph omits support modules | Extend AD-4 |
| 3 | AD-2 Filament resource vs. AD-5 trust model | AD-5 condition isn't a checkable gate | Cross-link AD-2/AD-5, new AD |
| 4 | Filament native update vs. Action-wrapped update | AD-3's "business logic" carve-out is fuzzy | Tighten AD-3 with entity list |
| 5 | Queued job re-resolving vs. passing tenant | AD-7 silent on non-HTTP contexts | Extend AD-7 |
| 6 | Meetup vs. Gdpr status vocabularies | No AD assigns enum/DTO shape ownership | New AD or extend AD-3 |
