# Media Chaos Readiness - 2026-03-02

## Scope
- FFMpeg export flow resilience.

## Completed
- Reworked video conversion action to guard exporter API availability.
- Verified `Modules/Media` passes PHPStan.

## Next Chaos Steps
- Simulate unsupported exporter methods and assert controlled exception path.
- Add chaos test for broken media conversion format class.
