const http = require('http');
const fs = require('fs');
const path = require('path');

const server = http.createServer((req, res) => {
  res.setHeader('Content-Type', 'application/json');
  
  const response = {
    name: 'laravelpizza-mcp',
    version: '1.0.0',
    description: 'MCP server for LaravelPizza project',
    capabilities: {
      fileSearch: true,
      fileNavigation: true,
      phpAnalysis: true,
      frontendDevelopment: true,
      databaseManagement: true,
      gitIntegration: true,
      testingSupport: true,
      documentationGeneration: true,
      securityAnalysis: true,
      performanceMonitoring: true,
      debugSupport: true
    },
    config: {
      includePatterns: [
        '**/*.php',
        '**/*.blade.php',
        '**/*.css',
        '**/*.js',
        '**/*.json',
        '**/*.md',
        '**/*.env'
      ],
      excludePatterns: [
        '**/vendor/**',
        '**/node_modules/**',
        '**/storage/**',
        '**/bootstrap/cache/**',
        '**/tests/**',
        '**/docs/**',
        '**/.git/**'
      ]
    }
  };
  
  res.writeHead(200);
  res.end(JSON.stringify(response, null, 2));
});

const PORT = process.env.MCP_PORT || 8080;
server.listen(PORT, () => {
  console.log(`LaravelPizza MCP server running on port ${PORT}`);
});
