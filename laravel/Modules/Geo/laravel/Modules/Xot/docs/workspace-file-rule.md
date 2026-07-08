# Workspace File Naming Rule

## Rule

**Every module MUST have exactly ONE `.code-workspace` file.**

The file MUST be named: `_<module_name_in_snake_case>.code-workspace`

## Examples

| Module | Correct Filename | Incorrect Filenames |
|--------|-----------------|---------------------|
| `Xot` | `_xot.code-workspace` | `_activity.code-workspace`, `_xot_base.code-workspace` |
| `Activity` | `_activity.code-workspace` | `_xot.code-workspace`, `_activity_base.code-workspace` |
| `CertFisc` | `_cert_fisc.code-workspace` | `_cert.code-workspace`, `_fisc.code-workspace` |
| `IndennitaCondizioniLavoro` | `_indennita_condizioni_lavoro.code-workspace` | `_indennita.code-workspace`, `_icl.code-workspace` |

## Rationale

1. **Consistency**: One module = one workspace file with predictable naming
2. **Discoverability**: Developers can immediately find the workspace file for any module
3. **IDE Configuration**: Each module's VSCode workspace settings are contained in a single, clearly-identified file
4. **Version Control**: Prevents confusion about which workspace file is authoritative

## Common Mistakes

### ❌ Wrong: Multiple workspace files in one module

```
Modules/Xot/
  _xot.code-workspace       # ✓ Correct
  _activity.code-workspace  # ✗ Wrong - belongs to Activity module
```

### ❌ Wrong: Workspace file with wrong name

```
Modules/Job/
  _job_base.code-workspace  # ✗ Wrong
  _job_workspace.code-workspace  # ✗ Wrong
```

### ✅ Correct

```
Modules/Job/
  _job.code-workspace  # ✓ Correct
```

## Cross-Module Dependencies

Some modules may reference other modules' workspace files for development workflows, but each module's directory should contain ONLY its own workspace file.

Example: A developer might have a root workspace that includes multiple modules, but that file belongs in the project root, not inside individual module directories.

## Enforcement

- Check for multiple `.code-workspace` files during code review
- Use `find Modules -name "*.code-workspace"` to audit compliance
- Remove any workspace files that don't match the naming convention

## Related Documentation

- [Module Structure Standards](module-structure.md)
- [Development Environment Setup](development-environment.md)
