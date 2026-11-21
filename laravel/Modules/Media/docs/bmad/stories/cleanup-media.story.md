# Story: Cleanup Media Module

## BMAD Method Applied
- **Scale**: Feature/module (Media)
- **Impact**: Media module, assets pipeline, Image, Video, Audio handling
- **Quality Gates**: PHPStan, Pint, Media-specific quality checks

## Tasks
1. **Understand** — Review Media module structure, assets pipeline, image/video handling
2. **Plan** — Identify and fix duplicate assets, missing metadata, optimize pipeline
3. **Implement** — Clean up unused assets, fix metadata, optimize caching
4. **Verify** — Run `phpstan analyse Modules/Media`, `pint`, `phpmd`
5. **Document** — Update sprint-status.yaml, add to docs/bmad-stories

## References
- Media/docs/architecture.md
- Media/docs/INDEX.md
- Media/Assets pipeline configuration
