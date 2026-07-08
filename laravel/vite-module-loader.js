import fs from 'fs/promises';
import path from 'path';
import { pathToFileURL } from 'url';

async function collectModulePaths(modulesPath, moduleDir) {
  const viteConfigPath = path.join(modulesPath, moduleDir, 'vite.config.js');

  try {
    await fs.access(viteConfigPath);
    // Convert to a file URL for Windows compatibility
    const moduleConfigURL = pathToFileURL(viteConfigPath);

    // Import the module-specific Vite configuration
    const moduleConfig = await import(moduleConfigURL.href);

    return Array.isArray(moduleConfig.paths) ? moduleConfig.paths : [];
  } catch (error) {
    // vite.config.js does not exist, skip this module
    return [];
  }
}

async function collectModuleAssetsPaths(paths, modulesPath) {
  modulesPath = path.join(__dirname, modulesPath);

  const moduleStatusesPath = path.join(__dirname, 'modules_statuses.json');

  try {
    // Read module_statuses.json
    const moduleStatusesContent = await fs.readFile(moduleStatusesPath, 'utf-8');
    const moduleStatuses = JSON.parse(moduleStatusesContent);

    // Read module directories
    const moduleDirectories = await fs.readdir(modulesPath);

    for (const moduleDir of moduleDirectories) {
      if (moduleDir === '.DS_Store') {
        // Skip .DS_Store directory
        continue;
      }

      // Check if the module is enabled (status is true)
      if (moduleStatuses[moduleDir] !== true) {
        continue;
      }

      paths.push(...(await collectModulePaths(modulesPath, moduleDir)));
    }
  } catch (error) {
    console.error(`Error reading module statuses or module configurations: ${error}`);
  }

  return paths;
}

export default collectModuleAssetsPaths;
