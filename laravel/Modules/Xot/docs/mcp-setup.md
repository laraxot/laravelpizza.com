# Model Context Protocol (MCP) Setup Guide

## Overview

Model Context Protocol (MCP) is a system that enables AI-powered development assistance by providing contextual information about your codebase, database, and project structure. This guide explains how MCP is configured and used in the Laraxot framework.

## MCP Configuration

The MCP system is configured in the `mcp.json` file located in the Laravel root directory:

```json
{
  "mcpServers": {
    "mysql": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-mysql",
<<<<<<< .merge_file_PN5oKo
        "marco:marco@localhost:3306/healthcare_app_survey"
=======
        "marco:marco@localhost:3306/ptvx_survey"
>>>>>>> .merge_file_Y0j5yE
      ]
    },
    "fetch": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-fetch"
      ]
    },
    "memory": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-memory"
      ]
    },
    "filesystem": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-filesystem",
<<<<<<< .merge_file_PN5oKo
        "/var/www/_bases/base_healthcare_app_fila5_mono/laravel"
=======
        "/var/www/_bases/base_ptvx_fila5_mono/laravel"
>>>>>>> .merge_file_Y0j5yE
      ]
    },
    "git": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-git"
      ]
    },
    "laravel-boost": {
      "command": "php",
      "args": [
        "artisan",
        "boost:mcp"
      ]
    }
  }
}
```

## MCP Servers

### 1. MySQL Server
- Provides access to database schemas and data
- Used for understanding table relationships and content
- Configuration includes database connection string

### 2. Filesystem Server
- Allows AI to explore project files
- Reads source code, documentation, and configuration files
- Root path set to Laravel project directory

### 3. Memory Server
- Maintains conversation context
- Stores temporary information during sessions
- Helps with continuity across interactions

### 4. Git Server
- Provides version control context
- Shows commit history and changes
- Helps understand code evolution

### 5. Laravel Boost Server
- Laravel-specific AI commands
- Provides framework-aware assistance
- Integrates with Laravel Artisan commands

## Installation

MCP dependencies are included as part of the Laraxot framework:

```bash
# Install Laravel Boost package
composer require laravel/boost --dev

# Install Laravel MCP package
composer require laravel/mcp --dev
```

## Usage

### Starting MCP Services

```bash
# Start MCP using Laravel Boost
php artisan boost:mcp

# Start specific MCP server
php artisan mcp:start --handle=laravel-boost

# Open MCP Inspector for debugging
php artisan mcp:inspector
```

### MCP Commands

The system provides several helpful commands:

```bash
# Generate documentation
mcp__laravel-boost__generate-docs ModelName

# Analyze code
mcp__laravel-boost__analyze-code Modules\Xot\Models\XotBaseModel

# Search documentation
mcp__laravel-boost__search-docs "Filament resources"

# Get application info
mcp__laravel-boost__application-info
```

## Integration with Laraxot Modules

### Module-Specific MCP Usage

Each module can leverage MCP for:

- **Code Analysis**: Understanding complex relationships
- **Documentation**: Generating and maintaining docs
- **Query Optimization**: Analyzing database queries
- **Architecture Understanding**: Explaining system design

### Example: Limesurvey Module

The Limesurvey module uses MCP to understand:

- Dynamic table structures (`lime_survey_{id}`)
- Complex relationships between survey elements
- Localization systems
- ETL processes

## Best Practices

### 1. Security
- Limit MCP access to necessary files only
- Review MCP configuration for sensitive information
- Monitor MCP usage and access logs

### 2. Performance
- Be mindful of large file analysis
- Use MCP efficiently for complex queries
- Cache MCP results when appropriate

### 3. Configuration
- Keep mcp.json updated with current settings
- Test MCP connectivity regularly
- Document custom MCP servers

## Troubleshooting

### Common Issues

1. **Connection Problems**
   - Verify database connection strings
   - Check file permissions
   - Ensure MCP servers are accessible

2. **Performance Issues**
   - Large databases may slow MCP analysis
   - Wide tables (like LimeSurvey responses) need special handling
   - Monitor resource usage

3. **File Access Issues**
   - Verify filesystem paths are correct
   - Check that MCP can read necessary files
   - Ensure proper directory permissions

### Debugging Commands

```bash
# Test MCP configuration
php artisan mcp:start --handle=laravel-boost

# List available MCP servers
php artisan list | grep mcp

# Check MCP status
php artisan mcp:inspector
```

## Advanced Configuration

### Custom MCP Servers

You can create custom MCP servers for specific functionality:

```bash
# Create new MCP server
php artisan make:mcp-server CustomServer

# Create MCP tool
php artisan make:mcp-tool CustomTool

# Create MCP resource
php artisan make:mcp-resource CustomResource
```

### Environment-Specific Configuration

MCP configuration can be adjusted per environment:

- Development: Full access for maximum assistance
- Staging: Limited access for testing
- Production: Minimal or no MCP access for security

## Future Enhancements

### Planned Features

1. **Enhanced Database Analysis**
   - Better understanding of complex relationships
   - Automated query optimization suggestions

2. **Module-Specific AI Models**
   - Trained on Laraxot architecture patterns
   - Specialized in Filament and Laravel integration

3. **Real-time Collaboration**
   - Multiple developers sharing MCP context
   - Synchronized development assistance

## Additional Resources

- [Laravel Boost Documentation](https://github.com/laravel/boost)
- [MCP Protocol Specification](https://github.com/modelcontextprotocol)
- [Laraxot Development Guidelines](laravel-boost-guidelines.md)
- [Module Development Best Practices](module-development-best-practices.md)