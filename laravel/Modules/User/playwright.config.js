import { defineConfig } from '@playwright/test';

export default defineConfig({
    testDir: './tests/Playwright',
    use: {
        baseURL: process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8000',
        headless: true,
        actionTimeout: 15000,
    },
    timeout: 60000,
    workers: 1,
    retries: 0,
});
