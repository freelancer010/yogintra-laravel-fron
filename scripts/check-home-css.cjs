const { chromium } = require(process.env.PLAYWRIGHT_PATH || 'playwright');
const fs = require('node:fs');
(async () => {
  const baseUrl = process.env.HOME_AUDIT_URL || 'http://127.0.0.1:8000/';
  const widths = (process.env.HOME_AUDIT_WIDTHS || '375,768,1440').split(',').map(Number);
  const browser = await chromium.launch({ channel: 'chrome', headless: true });
  for (const width of widths) {
    const results = [];
    for (const original of [true, false]) {
      const page = await browser.newPage({ viewport: { width, height: 900 }, reducedMotion: 'reduce' });
      if (original) await page.route('**/homepage.bundle.min.css*', route => route.fulfill({ contentType: 'text/css', body: fs.readFileSync('public/assets/front/css/frontend.bundle.min.css', 'utf8') }));
      await page.goto(baseUrl, { waitUntil: 'networkidle' });
      await page.evaluate(() => document.fonts.ready);
      // Database-backed images may be absent in a local checkout. Resolve every
      // lazy image before comparing geometry so request timing cannot look like
      // a CSS regression.
      await page.locator('img[loading="lazy"]').evaluateAll(images => images.forEach(image => { image.loading = 'eager'; }));
      await page.waitForLoadState('networkidle');
      await page.evaluate(async () => {
        for (let y = 0; y < document.documentElement.scrollHeight; y += 700) {
          window.scrollTo(0, y);
          await new Promise(resolve => setTimeout(resolve, 150));
        }
        window.scrollTo(0, 0);
      });
      await page.waitForTimeout(300);
      await page.addStyleTag({ content: '*,*::before,*::after{animation:none!important;transition:none!important}' });
      const snapshot = () => page.evaluate(() => [...document.querySelectorAll('header, #home, main > section, footer, #cookieBanner, #messagePopup, .menuzord-menu')].map(el => {
        const rect = el.getBoundingClientRect(), css = getComputedStyle(el);
        return { tag: el.id || el.tagName, width: Math.round(rect.width), height: Math.round(rect.height), display: css.display, color: css.color, background: css.backgroundColor };
      }));
      const closed = await snapshot();
      if (await page.locator('#cookieReject').isVisible()) await page.locator('#cookieReject').click();
      await page.locator('#messageIcon').click();
      const popup = await snapshot();
      await page.locator('#messagePopup .close-btn').click();
      if (width === 375) {
        const menu = page.locator('.showhide');
        if (await menu.isVisible()) await menu.click();
      }
      results.push({ closed, popup, menu: await snapshot() });
      await page.screenshot({ path: `storage/app/home-css-${width}-${original ? 'before' : 'after'}.png`, fullPage: true });
      await page.close();
    }
    if (JSON.stringify(results[0]) !== JSON.stringify(results[1])) {
      console.error('Layout mismatch at', width, JSON.stringify(results));
      process.exitCode = 1;
    } else console.log('PASS layout, popup and navigation:', width);
  }
  await browser.close();
})().catch(error => { console.error(error); process.exitCode = 1; });
