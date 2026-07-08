# MCP Servers - Module Context

**Module**: Xot (Base Framework)  
**Last Updated**: 2026-04-09

## Master Documentation

**See [Project MCP Servers](../../../docs/MCP_SERVERS.md)** for complete server list, configuration, and usage examples.

This document provides Xot-specific MCP usage guidelines only.

## Xot-Specific MCP Usage

### sqlite
- **DB Path**: `../../laravel/database/database.sqlite`
- **Use**: Query Xot base tables, verify module discovery
- **Example**: 
  ```sql
  SELECT * FROM modules WHERE name = 'Xot';
  SELECT COUNT(*) FROM users WHERE created_by IS NOT NULL;
  ```

### memory
- **Use**: Store Xot patterns, conventions, base class decisions
- **Examples**:
  - "All models MUST extend XotBaseModel"
  - "Service providers MUST extend XotBaseServiceProvider"
  - "Xot module discovery pattern"

### context7
- **Use**: Look up Laravel, Nwidart, Laraxot documentation
- **Example Queries**:
  - "Laravel 12 service provider best practices"
  - "Nwidart modules composer merge-plugin"
  - "Laravel package development patterns"

### sequential-thinking
- **Use**: Base architecture decisions, pattern analysis
- **Example**: Evaluating new base class patterns

### supermemory
- **Container Tag**: `fixcity`
- **Use**: Store Xot architectural decisions, evolution history
- **Example**: Store reasoning behind XotBaseModel design

### filesystem
- **Scope**: Xot module directory
- **Use**: Explore base class structure, trait patterns
- **Example**: Find all `*Base*.php` files in Xot

### git
- **Scope**: Xot module evolution
- **Use**: Track base class changes, find when patterns were introduced
- **Example**: `git blame Modules/Xot/app/Base/XotBaseModel.php`

## Xot MCP Patterns

### Pattern Discovery
Use MCP servers to discover and document Xot patterns:
1. `filesystem` → Find all base classes
2. `sqlite` → Query usage across modules
3. `memory` → Store discovered patterns
4. `context7` → Validate against Laravel best practices

### Module Validation
Use MCP to validate module compliance:
1. `filesystem` → Check module structure
2. `sqlite` → Verify model inheritance
3. `memory` → Compare against Xot conventions

## Cross-References

- **Master MCP Docs**: [Project MCP Servers](../../../docs/MCP_SERVERS.md)
- **Theme MCP**: [Sixteen Theme MCP](../../Themes/Sixteen/docs/MCP_SERVERS.md)
- **Laravel Boost**: [Laravel Boost Guidelines](../../../docs/CLAUDE.md)
- **Xot Documentation**: [Xot Docs Index](README.md)

---

*This document follows DRY+KISS principles. Server list and configuration are in the master doc.*
