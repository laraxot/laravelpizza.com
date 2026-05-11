const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const page = await browser.newPage();
  
  console.log('=== Homepage Analysis ===\n');
  
  await page.setViewportSize({ width: 1920, height: 1080 });
  await page.goto('http://127.0.0.1:8000/');
  await page.waitForLoadState('networkidle');
  await page.waitForTimeout(3000);
  
  // Get page structure
  const structure = await page.evaluate(() => {
    const body = document.body;
    const html = body.innerHTML;
    
    // Find main sections
    const sections = Array.from(document.querySelectorAll('section')).map(s => ({
      class: s.className,
      id: s.id,
      tag: s.tagName
    }));
    
    // Find header
    const headers = Array.from(document.querySelectorAll('header')).map(h => ({
      class: h.className,
      id: h.id
    }));
    
    return {
      bodyClass: body.className,
      sectionsCount: sections.length,
      sections: sections.slice(0, 10),
      headersCount: headers.length,
      headers
    };
  });
  
  console.log('Page structure:', JSON.stringify(structure, null, 2));
  
  // Check if there's any content
  const content = await page.evaluate(() => document.body.innerText.substring(0, 500));
  console.log('\nPage text (first 500 chars):', content.substring(0, 500));
  
  await page.screenshot({ path: '/tmp/homepage-analyze.png', fullPage: true });
  console.log('\nScreenshot saved');
  
  await browser.close();
})();