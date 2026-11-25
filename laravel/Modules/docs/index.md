# Documentation Index

Elenco dei file markdown in questa directory.

## 📚 Core Documentation

| File | Description | Priority |
|------|-------------|----------|
| **[queueable-action-rule.md](queueable-action-rule.md)** | **Architecture Rule: Use QueueableAction (spatie), NEVER Services** | 🔴 **Critical** |
| **[tech-stack-no-bootstrap.md](tech-stack-no-bootstrap.md)** | Approved tech stack (Tailwind + Alpine + Lit + DaisyUI + Flowbite) | 🔴 **Critical** |
| **[blocks-folder-naming.md](blocks-folder-naming.md)** | Naming conventions from Flowbite/Tailwind UI | 🟡 **Important** |
| **[project-structure.md](project-structure.md)** | Project structure overview | 🟡 **Important** |
| **[documentation-index.md](documentation-index.md)** | Full documentation map | 🟢 **Reference** |

## 🎯 Quick Reference

### Architecture Rules (Must Follow)
1. **QueueableAction** - Use spatie/laravel-queueable-action for all business logic
2. **No Services** - Never create Service classes
3. **No Bootstrap** - Use TailwindCSS + DaisyUI instead
4. **No Controllers** - Use Filament, Folio, Actions, ViewModels

### Tech Stack
- **CSS**: TailwindCSS + DaisyUI (NO Bootstrap)
- **JS**: Alpine.js + Lit Web Components
- **PHP**: QueueableAction pattern (spatie/laravel-queueable-action)
- **UI**: Flowbite blocks + Tailwind UI

## 🔗 Navigation

- **Stories**: `../../../docs/stories/`
- **Chat**: `../../../docs/chat/`
- **Wiki**: `../../../docs/wiki/`
- **Theme Docs**: `../Themes/Sixteen/docs/`

---

**DRY Principle**: This index references other documentation. Always check linked files for complete information.
