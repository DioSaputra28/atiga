const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({
    headless: true,
    executablePath: '/home/dio/.cache/ms-playwright/chromium-1208/chrome-linux64/chrome'
  });
  const page = await browser.newPage();
  
  // Navigate to admin login
  await page.goto('http://127.0.0.1:8000/admin/login');
  console.log('Current URL:', await page.url());
  console.log('Page title:', await page.title());
  
  // Get page content
  const content = await page.content();
  console.log('Page has login form:', content.includes('login') || content.includes('password') || content.includes('email'));
  
  await browser.close();
})();
