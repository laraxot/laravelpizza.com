const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const page = await browser.newPage();
  
  console.log('=== Homepage Wave 2: Header & Hero Analysis ===\n');
  
  // Test desktop
  await page.setViewportSize({ width: 1920, height: 1080 });
  await page.goto('http://127.0.0.1:8000/');
  await page.waitForLoadState('networkidle');
  await page.waitForTimeout(2000);
  
  await page.screenshot({ path: '/tmp/homepage-desktop.png', fullPage: true });
  console.log('Desktop screenshot saved');
  
  // Analyze header
  const headerInfo = await page.evaluate(() => {
    const header = document.querySelector('.it-header-wrapper');
    const nav = document.querySelector('.nav-main');
    return {
      headerExists: !!header,
      navExists: !!nav,
      headerPadding: header ? window.getComputedStyle(header).padding : 'N/A',
      navMargin: nav ? window.getComputedStyle(nav).marginTop : 'N/A'
    };
  });
  console.log('Header analysis:', headerInfo);
  
  // Analyze hero section
  const heroInfo = await page.evaluate(() => {
    const hero = document.querySelector('.hero-section, .it-hero-section, [class*="hero"]');
    return {
      heroExists: !!hero,
      heroPadding: hero ? window.getComputedStyle(hero).paddingTop : 'N/A',
      heroMinHeight: hero ? window.getComputedStyle(hero).minHeight : 'N/A'
    };
  });
  console.log('Hero analysis:', heroInfo);
  
  // Check featured topics gradient
  const featuredInfo = await page.evaluate(() => {
    const featured = document.querySelector('[class*="featured"], [class*="topics"], section[class*="emerald"], section[class*="green"]');
    return {
      featuredExists: !!featured,
      background: featured ? window.getComputedStyle(featured).background : 'N/A'
    };
  });
  console.log('Featured topics:', featuredInfo);
  
  await browser.close();
  console.log('\nAnalysis complete');
})();