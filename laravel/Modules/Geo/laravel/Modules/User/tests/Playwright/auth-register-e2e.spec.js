import { test, expect } from '@playwright/test';

const STRONG_PASSWORD = 'Password1!Secure';

test.describe('FO auth register e2e', () => {
    test.beforeEach(async ({ page }) => {
        await page.goto('/it/auth/register', { waitUntil: 'networkidle' });
        await expect(page.locator('#auth-register-heading')).toBeVisible({ timeout: 15000 });
    });

    test('loads register form fields', async ({ page }) => {
        await expect(page.locator('input[autocomplete="given-name"]')).toBeVisible();
        await expect(page.locator('input[autocomplete="family-name"]')).toBeVisible();
        await expect(page.locator('input[autocomplete="email"]')).toBeVisible();
        await expect(page.locator('input[autocomplete="new-password"]').first()).toBeVisible();
    });

    test('shows validation for empty submit', async ({ page }) => {
        await page.locator('form[wire\\:submit="submit"] button[type="submit"]').click();
        await page.waitForTimeout(800);
        const errors = page.locator('[role="alert"], .text-danger, .fi-fo-field-wrp-error-message');
        await expect(errors.first()).toBeAttached({ timeout: 10000 });
    });

    test('can fill register form and submit without server error', async ({ page }) => {
        const unique = Date.now();
        const email = `e2e-register-${unique}@example.test`;

        await page.locator('input[autocomplete="given-name"]').fill('E2E');
        await page.locator('input[autocomplete="family-name"]').fill('Register');
        await page.locator('input[autocomplete="email"]').fill(email);
        const passwordFields = page.locator('input[autocomplete="new-password"]');
        await passwordFields.nth(0).fill(STRONG_PASSWORD);
        await passwordFields.nth(1).fill(STRONG_PASSWORD);

        const responsePromise = page.waitForResponse(
            (res) => res.url().includes('/livewire') && res.request().method() === 'POST',
            { timeout: 30000 },
        );

        await page.locator('form[wire\\:submit="submit"] button[type="submit"]').click();
        const response = await responsePromise;

        expect(response.status()).toBeLessThan(500);

        const body = await response.text();
        expect(body).not.toContain('Class "standard" not found');
        expect(body).not.toContain('Internal Server Error');
    });
});
