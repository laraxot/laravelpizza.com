# Model Context Protocol

## Configuration

- `laravel/.mcp.json`

## Tools

When direct access fails, use MCP equivalents:

- `mcp file_get_contents path/to/file.php`
- `mcp file_put_contents path/to/file.php "content"`
- `mcp glob "Modules/**/*.php"`
- `mcp phpstan analyse path/to/file.php`
- `mcp artisan module:make ModuleName`

## MCP-Specific Workflows

### PHPStan with MCP
When PHPStan access is limited:
1. Use `mcp phpstan analyse path/to/file.php --memory-limit=-1`
2. Reference `laravel/.mcp.json` for configuration
3. Apply fixes using MCP tools
4. Verify changes with standard tools when possible

### Filament Development with MCP
When working with protected Filament files:
1. Use MCP to read/write Filament resource files
2. Apply XotBase patterns through MCP tools
3. Test component functionality after MCP-based changes

### Module Development with MCP
When module creation/update is restricted:
1. Use `mcp artisan module:make ModuleName`
2. Create module files using MCP file operations
3. Follow standard Laraxot patterns even with MCP
4. Verify module functionality after creation

## Safe Operations

MCP provides safe versions of potentially unsafe operations:
- `SafeFileGetContentsAction` for file reading
- `SafeJsonDecodeAction` for JSON operations
- `SafeShellExecAction` for shell commands

## Links

- [Claude docs index](./context.md)
- [General docs index](../../docs/README.md)
- [Claude config](../README.md)
- [MCP config](../mcp.json)
