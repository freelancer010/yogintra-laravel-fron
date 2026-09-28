const { chromium } = require(process.env.PLAYWRIGHT_PATH || 'playwright');

(async () => {
  const browser = await chromium.launch({ channel: 'chrome', headless: true });
  const page = await browser.newPage({ viewport: { width: 390, height: 844 } });
  await page.goto('http://127.0.0.1:8000/', { waitUntil: 'load' });
  await page.waitForSelector('.owl-carousel-4col.owl-loaded', { timeout: 10000 });
  await page.waitForSelector('.owl-carousel-3col.owl-loaded', { timeout: 10000 });

  const state = () => page.evaluate(() => ['.owl-carousel-4col', '.owl-carousel-3col'].map(selector => {
    const carousel = window.jQuery(selector).data('owl.carousel');
    return { autoplay: carousel.settings.autoplay, position: carousel.relative(carousel.current()) };
  }));

  const initial = await state();
  await page.waitForTimeout(5000);
  const later = await state();
  if (initial.some(item => item.autoplay !== false)) throw new Error('Autoplay is still enabled.');
  if (initial.some((item, index) => item.position !== later[index].position)) throw new Error('A carousel moved without user input.');

  await page.locator('.owl-carousel-4col .owl-next').click();
  await page.waitForTimeout(500);
  const afterClick = await state();
  if (afterClick[0].position === later[0].position) throw new Error('Trainer carousel did not respond to user navigation.');

  console.log('PASS: trainers and testimonials remain still; manual trainer navigation works.');
  await browser.close();
})().catch(error => { console.error(error); process.exitCode = 1; });
