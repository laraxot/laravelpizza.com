# BMAD Investigation: mobile camera uploads

Status: ready for implementation review
Owner: `Modules/Media`
Scope: FixCity ticket attachments, shared temporary-upload and normalization boundaries

## User impact

On a mobile device, a photo selected from the camera can fail before it reaches
the ticket wizard. The expected contract is that a supported camera photo is
available in the Livewire temporary-upload state, can be removed/replaced, and
is persisted only when the ticket is submitted.

## Evidence already verified

| Grade | Evidence | Consequence |
| --- | --- | --- |
| A | The Fixcity field uses a custom Blade view and calls `$wire.upload()` directly. | The failure is in the browser/Livewire temporary-upload boundary, not only in Spatie Media Library persistence. |
| A | The accepted server types are JPEG, PNG and PDF; mobile cameras may return HEIC/HEIF. | HEIC must be normalized before Livewire validation or rejected with a translated message. |
| A | The Sixteen adapter previously loaded through an asynchronous, non-awaited import. | A fast tap could start normalization before the adapter existed. |
| A | The application field allows 10 MB while the active PHP runtime reported 2 MB `upload_max_filesize` and 8 MB `post_max_size`. | Large camera files can be rejected before Livewire receives them. |
| A | Livewire temporary uploads are signed, validated and stored before the component property is set. | A Media-library-only fix cannot repair request-size or temporary-upload failures. |
| B | The custom input has `capture="environment"`, but browser support and camera output formats vary. | `capture` is only a hint; robust handling must also support normal file selection and camera APIs where appropriate. |

## External research synthesis

- Filament discussion #11974 and AnswerOverflow converge on adding native
  `capture` input attributes for simple mobile capture, while noting that the
  FilePond/FileUpload abstraction does not provide a universal camera API.
- The Take Picture Field plugin uses `getUserMedia()`, a video preview, canvas
  capture, JPEG output, maximum dimensions and quality controls. This avoids
  sending a device-native HEIC file and provides a predictable payload, but it
  requires a secure context and camera permission.
- The Uppy plugin uses a dedicated upload endpoint, chunked requests and a
  webcam/image-editor/compressor plugin set. This addresses request-size and
  resumability problems, but introduces a new upload pipeline and UI contract.
- The Medium links were not retrievable in this environment (Cloudflare and
  anonymous-access restrictions); they are not treated as evidence.

## Ranked hypotheses

1. **High — transport ceiling.** PHP/web-server request limits can reject a
   high-resolution camera image before Livewire sees it.
2. **High — format/normalization boundary.** HEIC/HEIF and missing MIME values
   need deterministic client normalization before the server allowlist.
3. **Medium — lifecycle/UI race.** A custom `wire:ignore` upload list can drift
   from Livewire state if cancellation, navigation or replacement is not
   serialized.
4. **Low — permanent Media Library storage.** This is downstream of the
1. **High: transport ceiling.** PHP/web-server request limits can reject a
   high-resolution camera image before Livewire sees it.
2. **High: format/normalization boundary.** HEIC/HEIF and missing MIME values
   need deterministic client normalization before the server allowlist.
3. **Medium: lifecycle/UI race.** A custom `wire:ignore` upload list can drift
   from Livewire state if cancellation, navigation or replacement is not
   serialized.
4. **Low: permanent Media Library storage.** This is downstream of the

   temporary upload and is not the first failure reported by the browser.

## Non-goals

- Do not broaden the permanent collection to arbitrary `image/*`.
- Do not add a second upload system or a remote companion service unless tests
  prove the existing Livewire path cannot meet the ticket contract.
- Do not add English/Italian UI text in JavaScript or Blade; all messages use
  module/theme translation keys.

## Decision requested from the implementation plan

Use the existing custom field and shared Media boundary first: normalize camera
images to bounded JPEG before `$wire.upload()`, align infrastructure limits,
and add a Media-owned reusable conversion/validation contract only where it
removes duplication. Escalate to Uppy/chunked transport only if a verified
production constraint remains after this path is tested.