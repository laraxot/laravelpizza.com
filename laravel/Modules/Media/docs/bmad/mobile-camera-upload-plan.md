# BMAD Plan: reliable mobile camera uploads

Status: implementation gate
Owner: `Modules/Media`
Related investigation: `mobile-camera-upload-investigation.md`
Coordination story: `../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md`

The Fixcity story is the cross-module BMAD coordination record; this plan owns
only the Media boundary and its evidence.

## Goal

Make camera photos reliable on mobile while preserving the existing Filament 5,
Livewire and Spatie Media Library contracts, all supported locales, and the
current JPEG/PNG/PDF security allowlist.

## Plan order

### Step 1: establish the contract

- Confirm the real Fixcity field state path, temporary-upload rules, collection
  MIME rules, and current infrastructure limits.
- Record failure responses for an ordinary JPEG, a large JPEG, a HEIC/HEIF file,
  and a file whose browser MIME is empty.
- Add focused tests before changing shared Media code.

Exit criterion: each failure is attributable to browser normalization,
Livewire/PHP transport, or permanent persistence.

### Step 2: implement the smallest shared fix

- Keep camera acquisition in the front-office field/theme, because camera and
  permission APIs are browser concerns.
- Keep reusable file normalization, bounded JPEG output and trusted MIME/size
  checks in the Media boundary if more than one caller needs them.
- Make the conversion deterministic and awaited before `$wire.upload()`.
- Ensure generated JPEG dimensions and quality keep normal camera files below
  the configured transport ceiling without changing existing user translations.
- Keep the server collection allowlist unchanged and reject unsafe formats at
  the trust boundary.

### Step 3: verify deployment constraints

- Configure PHP and the web server with multipart headroom above the 10 MB field
  limit.
- Verify secure-context requirements for camera APIs on LAN/mobile URLs.
- Do not claim that `.user.ini` changes an already-running built-in server;
  restart/reconfigure the actual FPM/Apache/Nginx process.

### Step 4: evaluate chunking only if required

Uppy-style chunked upload is a fallback for infrastructure that cannot accept a
single bounded request. It is out of the first patch because it changes routes,
authorization, cleanup, storage ownership, translations and the Filament field
contract. Adopt it only with a separate design decision and end-to-end tests.

## Acceptance criteria

- A JPEG from a mobile camera reaches temporary Livewire state and appears in
  the current wizard summary.
- HEIC/HEIF is converted to an allowed JPEG before server validation, or fails
  with a translated and actionable message when conversion is unavailable.
- The same field supports normal file selection and does not depend on
  `capture` being honored.
- Cancellation and replacement leave no stale client item or orphaned
  temporary record visible to the user.
- MIME, extension, size, count, authorization and permanent collection rules
  remain enforced server-side.
- No UI strings are hardcoded; Italian, English, German and Spanish assertions
  cover all new messages.
- The flow works at 375 px, 768 px and 1440 px without layout or accessibility
  regressions.

## Files/callers/tests in scope

- `Modules/Media`: shared temporary-upload/normalization contracts and tests.
- `Modules/Fixcity`: ticket schema, custom upload view and wizard tests.
- `Themes/Sixteen`: camera adapter and compiled asset manifest.
- `public_html`/deployment configuration: PHP and request-size limits.

## Verification commands

Run PHP/Filament tests from `laravel/`; run Sixteen asset checks from
`laravel/Themes/Sixteen`. Minimum gate:

```text
php artisan test Modules/Media/tests Modules/Fixcity/tests/Feature/Filament
npm run lint
npm run build
graphify update .
```

Browser gate: authenticated mobile emulation, camera/file fixture, request
failure capture, translated error assertions, and viewport checks at 375/768/
1440 px.