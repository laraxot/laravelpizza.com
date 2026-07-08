# Documentation Index

Elenco dei file markdown in questa directory.

## 📚 Core Documentation

| File | Description | Priority |
|------|-------------|----------|
| **[QUEUEABLE-ACTION-RULE.md](QUEUEABLE-ACTION-RULE.md)** | **Architecture Rule: Use QueueableAction (spatie), NEVER Services** | 🔴 **Critical** |
| **[TECH-STACK-NO-BOOTSTRAP.md](TECH-STACK-NO-BOOTSTRAP.md)** | Approved tech stack (Tailwind + Alpine + Lit + DaisyUI + Flowbite) | 🔴 **Critical** |
| **[BLOCKS-FOLDER-NAMING.md](BLOCKS-FOLDER-NAMING.md)** | Naming conventions from Flowbite/Tailwind UI | 🟡 **Important** |
| **[PROJECT-STRUCTURE.md](PROJECT-STRUCTURE.md)** | Project structure overview | 🟡 **Important** |
| **[DOCUMENTATION_INDEX.md](DOCUMENTATION_INDEX.md)** | Full documentation map | 🟢 **Reference** |

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
