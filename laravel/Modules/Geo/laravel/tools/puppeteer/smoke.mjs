import puppeteer from 'puppeteer';

const baseUrl = process.env.PUPPETEER_BASE_URL ?? process.env.PLAYWRIGHT_BASE_URL ?? 'http://ptvx.local';

const browser = await puppeteer.launch({
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox'],
});

try {
    const page = await browser.newPage();
    const response = await page.goto(`${baseUrl}/it/auth/login`, {
        waitUntil: 'domcontentloaded',
        timeout: 30000,
    });

    if (! response || response.status() >= 500) {
        throw new Error(`Smoke test fallito: status ${response?.status() ?? 'unknown'} su ${baseUrl}/it/auth/login`);
    }

    const title = await page.title();
    console.log(`Puppeteer smoke OK — ${baseUrl}/it/auth/login (${response.status()}) title="${title}"`);
} finally {
    await browser.close();
}
