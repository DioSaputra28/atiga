import { chromium } from 'playwright';

const BASE_URL = 'http://127.0.0.1:8000';
const LOGIN_EMAIL = 'admin@example.com';
const LOGIN_PASSWORD = 'password';

const results = {
  activitySlug: { status: 'pending', notes: '' },
  categorySlug: { status: 'pending', notes: '' },
  tagSlug: { status: 'pending', notes: '' },
  articleHelper: { status: 'pending', notes: '' },
  activityHelper: { status: 'pending', notes: '' },
  bannerHelper: { status: 'pending', notes: '' },
  categoryHelper: { status: 'pending', notes: '' },
  tagHelper: { status: 'pending', notes: '' }
};

async function runTests() {
  console.log('Launching browser...');
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext();
  const page = await context.newPage();

  try {
    // LOGIN
    console.log('\n=== LOGIN ===');
    await page.goto(`${BASE_URL}/admin/login`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(1000);
    
    await page.locator('input[type="email"]').first().fill(LOGIN_EMAIL);
    await page.locator('input[type="password"]').first().fill(LOGIN_PASSWORD);
    await page.locator('button[type="submit"]').first().click();
    await page.waitForTimeout(2000);
    console.log('Logged in');

    // 1. Activity Slug Test
    console.log('\n=== 1. ACTIVITY CREATE - SLUG ===');
    await page.goto(`${BASE_URL}/admin/activities/create`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const actTitle = page.locator('input[id*="title"], input[name*="title"]').first();
    const actSlug = page.locator('input[id*="slug"], input[name*="slug"]').first();
    
    if (await actTitle.count() > 0 && await actSlug.count() > 0) {
      await actTitle.fill('Test Activity');
      await page.waitForTimeout(500);
      await actTitle.blur();
      await page.waitForTimeout(4000); // Wait longer for Livewire
      
      const slugVal = await actSlug.inputValue().catch(() => '');
      console.log(`Activity slug value: "${slugVal}"`);
      
      if (slugVal && slugVal.includes('test')) {
        results.activitySlug.status = 'PASS';
        results.activitySlug.notes = `Slug auto-generated: "${slugVal}"`;
      } else {
        results.activitySlug.status = 'FAIL';
        results.activitySlug.notes = `Slug not populated. Value: "${slugVal}"`;
      }
    } else {
      results.activitySlug.status = 'FAIL';
      results.activitySlug.notes = 'Title or slug field not found';
    }

    // 2. Category Slug Test
    console.log('\n=== 2. CATEGORY MANAGE - SLUG ===');
    await page.goto(`${BASE_URL}/admin/categories`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    await page.locator('button:has-text("New"), button:has-text("Create")').first().click();
    await page.waitForTimeout(2000);
    
    const catName = page.locator('.fi-modal-content input[id*="name"], .fi-modal-content input[name*="name"]').first();
    const catSlug = page.locator('.fi-modal-content input[id*="slug"], .fi-modal-content input[name*="slug"]').first();
    
    if (await catName.count() > 0 && await catSlug.count() > 0) {
      await catName.fill('Test Category');
      await page.waitForTimeout(500);
      await catName.blur();
      await page.waitForTimeout(4000);
      
      const slugVal = await catSlug.inputValue().catch(() => '');
      console.log(`Category slug value: "${slugVal}"`);
      
      if (slugVal && slugVal.includes('test')) {
        results.categorySlug.status = 'PASS';
        results.categorySlug.notes = `Slug auto-generated: "${slugVal}"`;
      } else {
        results.categorySlug.status = 'FAIL';
        results.categorySlug.notes = `Slug not populated. Value: "${slugVal}"`;
      }
    } else {
      results.categorySlug.status = 'FAIL';
      results.categorySlug.notes = 'Name or slug field not found in modal';
    }

    // Close modal via Escape key
    await page.keyboard.press('Escape');
    await page.waitForTimeout(1000);

    // 3. Tag Slug Test
    console.log('\n=== 3. TAG MANAGE - SLUG ===');
    await page.goto(`${BASE_URL}/admin/tags`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    await page.locator('button:has-text("New"), button:has-text("Create")').first().click();
    await page.waitForTimeout(2000);
    
    const tagName = page.locator('.fi-modal-content input[id*="name"], .fi-modal-content input[name*="name"]').first();
    const tagSlug = page.locator('.fi-modal-content input[id*="slug"], .fi-modal-content input[name*="slug"]').first();
    
    if (await tagName.count() > 0 && await tagSlug.count() > 0) {
      await tagName.fill('Test Tag');
      await page.waitForTimeout(500);
      await tagName.blur();
      await page.waitForTimeout(4000);
      
      const slugVal = await tagSlug.inputValue().catch(() => '');
      console.log(`Tag slug value: "${slugVal}"`);
      
      if (slugVal && slugVal.includes('test')) {
        results.tagSlug.status = 'PASS';
        results.tagSlug.notes = `Slug auto-generated: "${slugVal}"`;
      } else {
        results.tagSlug.status = 'FAIL';
        results.tagSlug.notes = `Slug not populated. Value: "${slugVal}"`;
      }
    } else {
      results.tagSlug.status = 'FAIL';
      results.tagSlug.notes = 'Name or slug field not found in modal';
    }

    await page.keyboard.press('Escape');
    await page.waitForTimeout(1000);

    // 4. Article Helper Text
    console.log('\n=== 4. ARTICLE HELPER TEXT ===');
    await page.goto(`${BASE_URL}/admin/articles/create`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const pageText = await page.textContent('body').catch(() => '');
    if (pageText.includes('Judul artikel yang akan ditampilkan')) {
      results.articleHelper.status = 'PASS';
      results.articleHelper.notes = 'Helper text "Judul artikel yang akan ditampilkan" found';
    } else {
      results.articleHelper.status = 'FAIL';
      results.articleHelper.notes = 'Helper text not found in page content';
    }

    // 5. Activity Helper Text
    console.log('\n=== 5. ACTIVITY HELPER TEXT ===');
    await page.goto(`${BASE_URL}/admin/activities/create`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const actPageText = await page.textContent('body').catch(() => '');
    if (actPageText.includes('Masukkan judul kegiatan')) {
      results.activityHelper.status = 'PASS';
      results.activityHelper.notes = 'Helper text "Masukkan judul kegiatan" found';
    } else {
      results.activityHelper.status = 'FAIL';
      results.activityHelper.notes = 'Helper text not found';
    }

    // 6. Banner Helper Text
    console.log('\n=== 6. BANNER HELPER TEXT ===');
    await page.goto(`${BASE_URL}/admin/banners/create`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const banPageText = await page.textContent('body').catch(() => '');
    if (banPageText.includes('Masukkan judul banner')) {
      results.bannerHelper.status = 'PASS';
      results.bannerHelper.notes = 'Helper text "Masukkan judul banner" found';
    } else {
      results.bannerHelper.status = 'FAIL';
      results.bannerHelper.notes = 'Helper text not found';
    }

    // 7. Category Helper Text
    console.log('\n=== 7. CATEGORY HELPER TEXT ===');
    await page.goto(`${BASE_URL}/admin/categories`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    await page.locator('button:has-text("New"), button:has-text("Create")').first().click();
    await page.waitForTimeout(2000);
    
    const catModalText = await page.locator('.fi-modal-content, .fi-modal').first().textContent().catch(() => '');
    if (catModalText.includes('Nama kategori yang akan ditampilkan')) {
      results.categoryHelper.status = 'PASS';
      results.categoryHelper.notes = 'Helper text "Nama kategori yang akan ditampilkan" found in modal';
    } else {
      results.categoryHelper.status = 'FAIL';
      results.categoryHelper.notes = 'Helper text not found in modal';
    }

    await page.keyboard.press('Escape');
    await page.waitForTimeout(1000);

    // 8. Tag Helper Text
    console.log('\n=== 8. TAG HELPER TEXT ===');
    await page.goto(`${BASE_URL}/admin/tags`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    await page.locator('button:has-text("New"), button:has-text("Create")').first().click();
    await page.waitForTimeout(2000);
    
    const tagModalText = await page.locator('.fi-modal-content, .fi-modal').first().textContent().catch(() => '');
    if (tagModalText.includes('Nama tag untuk mengidentifikasi konten')) {
      results.tagHelper.status = 'PASS';
      results.tagHelper.notes = 'Helper text "Nama tag untuk mengidentifikasi konten" found in modal';
    } else {
      results.tagHelper.status = 'FAIL';
      results.tagHelper.notes = 'Helper text not found in modal';
    }

  } catch (error) {
    console.error('Error:', error.message);
  } finally {
    await browser.close();
  }

  // Print Results
  console.log('\n========================================');
  console.log('      TARGETED QA RESULTS');
  console.log('========================================\n');
  
  console.log('SLUG AUTOGENERATION:');
  console.log(`  1. Activity Create: ${results.activitySlug.status} - ${results.activitySlug.notes}`);
  console.log(`  2. Category Manage: ${results.categorySlug.status} - ${results.categorySlug.notes}`);
  console.log(`  3. Tag Manage:      ${results.tagSlug.status} - ${results.tagSlug.notes}`);
  
  console.log('\nHELPER TEXT VALIDATION:');
  console.log(`  4. Article:  ${results.articleHelper.status} - ${results.articleHelper.notes}`);
  console.log(`  5. Activity: ${results.activityHelper.status} - ${results.activityHelper.notes}`);
  console.log(`  6. Banner:   ${results.bannerHelper.status} - ${results.bannerHelper.notes}`);
  console.log(`  7. Category: ${results.categoryHelper.status} - ${results.categoryHelper.notes}`);
  console.log(`  8. Tag:      ${results.tagHelper.status} - ${results.tagHelper.notes}`);
  
  const passed = Object.values(results).filter(r => r.status === 'PASS').length;
  const failed = Object.values(results).filter(r => r.status === 'FAIL').length;
  
  console.log('\n----------------------------------------');
  console.log(`SUMMARY: ${passed}/8 PASS, ${failed}/8 FAIL`);
  console.log('========================================');
}

runTests();
