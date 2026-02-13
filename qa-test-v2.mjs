import { chromium } from 'playwright';

const BASE_URL = 'http://127.0.0.1:8000';

const results = {
  login: { status: 'pending', notes: [] },
  articles: { toggle: { status: 'pending', notes: [] }, slug: { status: 'pending', notes: [] }, helper: { status: 'pending', notes: [] } },
  activities: { toggle: { status: 'pending', notes: [] }, slug: { status: 'pending', notes: [] }, helper: { status: 'pending', notes: [] } },
  banners: { toggle: { status: 'pending', notes: [] }, helper: { status: 'pending', notes: [] } },
  categories: { toggle: { status: 'pending', notes: [] }, slug: { status: 'pending', notes: [] }, helper: { status: 'pending', notes: [] } },
  tags: { slug: { status: 'pending', notes: [] }, helper: { status: 'pending', notes: [] } }
};

async function runTests() {
  console.log('Launching browser...');
  const browser = await chromium.launch({
    headless: true,
    executablePath: '/home/dio/.cache/ms-playwright/chromium-1208/chrome-linux64/chrome'
  });
  
  const context = await browser.newContext();
  const page = await context.newPage();
  
  try {
    // 1. Navigate to admin and check login
    console.log('\n=== STEP 1: CHECK LOGIN PAGE ===');
    await page.goto(`${BASE_URL}/admin/login`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(1500);
    
    const hasEmail = await page.locator('input#form.email, input[type="email"]').count() > 0;
    const hasPassword = await page.locator('input[type="password"]').count() > 0;
    console.log(`Email field: ${hasEmail}, Password field: ${hasPassword}`);
    
    if (hasEmail && hasPassword) {
      results.login.status = 'INFO';
      results.login.notes.push('Login form present - requires manual authentication');
    } else {
      results.login.status = 'CHECK';
      results.login.notes.push('Login form structure may differ');
    }
    
    // 2. Test Articles List - Check for toggle columns
    console.log('\n=== STEP 2: ARTICLES LIST - TOGGLE COLUMNS ===');
    await page.goto(`${BASE_URL}/admin/articles`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    // Take snapshot for debugging
    const articlesHtml = await page.content();
    const hasToggleArticles = articlesHtml.includes('ToggleColumn') || 
                               articlesHtml.includes('fi-ta-toggle') ||
                               articlesHtml.includes('fi-ta-cell') && articlesHtml.includes('role="switch"');
    
    // Check table headers and cells for toggle-related content
    const tableContent = await page.locator('.fi-ta-content, table').innerHTML().catch(() => '');
    const toggleInTable = tableContent.includes('toggle') || tableContent.includes('switch');
    
    console.log(`Toggle in articles table HTML: ${hasToggleArticles}`);
    console.log(`Toggle content in table: ${toggleInTable}`);
    
    if (hasToggleArticles || toggleInTable) {
      results.articles.toggle.status = 'PASS';
      results.articles.toggle.notes.push('Toggle column elements detected');
    } else {
      results.articles.toggle.status = 'FAIL';
      results.articles.toggle.notes.push('No toggle column elements detected in table');
    }
    
    // 3. Test Articles Create Form
    console.log('\n=== STEP 3: ARTICLES CREATE FORM ===');
    await page.goto(`${BASE_URL}/admin/articles/create`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    // Find title field using Filament v5 wire:model attributes
    const titleInput = page.locator('input[wire\\:model="data.title"], input[id*="title"]').first();
    const slugInput = page.locator('input[wire\\:model="data.slug"], input[id*="slug"]').first();
    
    const hasTitle = await titleInput.count() > 0;
    const hasSlug = await slugInput.count() > 0;
    
    console.log(`Title input: ${hasTitle}, Slug input: ${hasSlug}`);
    
    if (hasTitle && hasSlug) {
      // Test slug autogeneration
      await titleInput.fill('Test Article Title');
      await page.waitForTimeout(1000);
      await titleInput.blur();
      await page.waitForTimeout(1500);
      
      const slugValue = await slugInput.inputValue().catch(() => '');
      console.log(`Slug value: "${slugValue}"`);
      
      if (slugValue && (slugValue.includes('test') || slugValue.includes('article'))) {
        results.articles.slug.status = 'PASS';
        results.articles.slug.notes.push(`Slug auto-generated: "${slugValue}"`);
      } else {
        results.articles.slug.status = 'FAIL';
        results.articles.slug.notes.push(`Slug not auto-generated. Value: "${slugValue}"`);
      }
    } else {
      results.articles.slug.status = 'FAIL';
      results.articles.slug.notes.push(`Title: ${hasTitle}, Slug: ${hasSlug}`);
    }
    
    // Check for helper text
    const helperSelector = '.fi-fo-field-wrp-description, .fi-fo-field-wrapper-description, [class*="hint"], [class*="description"]';
    const helperElements = await page.locator(helperSelector).count();
    console.log(`Helper text elements: ${helperElements}`);
    
    if (helperElements > 0) {
      results.articles.helper.status = 'PASS';
      results.articles.helper.notes.push(`${helperElements} helper text element(s) found`);
    } else {
      results.articles.helper.status = 'FAIL';
      results.articles.helper.notes.push('No helper text elements found');
    }
    
    // 4. Test Activities List
    console.log('\n=== STEP 4: ACTIVITIES LIST ===');
    await page.goto(`${BASE_URL}/admin/activities`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const activitiesHtml = await page.content();
    const activitiesToggle = activitiesHtml.includes('ToggleColumn') || 
                              activitiesHtml.includes('fi-ta-toggle');
    console.log(`Toggle in activities: ${activitiesToggle}`);
    
    if (activitiesToggle) {
      results.activities.toggle.status = 'PASS';
      results.activities.toggle.notes.push('Toggle column elements detected');
    } else {
      results.activities.toggle.status = 'FAIL';
      results.activities.toggle.notes.push('No toggle column elements detected');
    }
    
    // 5. Test Activities Create Form
    console.log('\n=== STEP 5: ACTIVITIES CREATE FORM ===');
    await page.goto(`${BASE_URL}/admin/activities/create`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const activityTitle = page.locator('input[wire\\:model="data.title"], input[id*="title"]').first();
    const activitySlug = page.locator('input[wire\\:model="data.slug"], input[id*="slug"]').first();
    
    if (await activityTitle.count() > 0 && await activitySlug.count() > 0) {
      await activityTitle.fill('Test Activity Title');
      await page.waitForTimeout(1000);
      await activityTitle.blur();
      await page.waitForTimeout(1500);
      
      const slugVal = await activitySlug.inputValue().catch(() => '');
      console.log(`Activity slug: "${slugVal}"`);
      
      if (slugVal && slugVal.includes('test')) {
        results.activities.slug.status = 'PASS';
        results.activities.slug.notes.push(`Slug: "${slugVal}"`);
      } else {
        results.activities.slug.status = 'FAIL';
        results.activities.slug.notes.push(`No slug auto-generated: "${slugVal}"`);
      }
    } else {
      results.activities.slug.status = 'FAIL';
      results.activities.slug.notes.push('Title or slug field not found');
    }
    
    const activityHelpers = await page.locator('.fi-fo-field-wrp-description, .fi-fo-field-wrapper-description').count();
    if (activityHelpers > 0) {
      results.activities.helper.status = 'PASS';
      results.activities.helper.notes.push(`${activityHelpers} helper(s) found`);
    } else {
      results.activities.helper.status = 'FAIL';
      results.activities.helper.notes.push('No helper text found');
    }
    
    // 6. Test Banners List
    console.log('\n=== STEP 6: BANNERS LIST ===');
    await page.goto(`${BASE_URL}/admin/banners`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const bannersHtml = await page.content();
    const bannersToggle = bannersHtml.includes('ToggleColumn') || bannersHtml.includes('fi-ta-toggle');
    console.log(`Toggle in banners: ${bannersToggle}`);
    
    if (bannersToggle) {
      results.banners.toggle.status = 'PASS';
      results.banners.toggle.notes.push('Toggle column elements detected');
    } else {
      results.banners.toggle.status = 'FAIL';
      results.banners.toggle.notes.push('No toggle column elements detected');
    }
    
    // 7. Test Banners Create Form
    console.log('\n=== STEP 7: BANNERS CREATE FORM ===');
    await page.goto(`${BASE_URL}/admin/banners/create`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const bannerHelpers = await page.locator('.fi-fo-field-wrp-description, .fi-fo-field-wrapper-description').count();
    console.log(`Banner helpers: ${bannerHelpers}`);
    if (bannerHelpers > 0) {
      results.banners.helper.status = 'PASS';
      results.banners.helper.notes.push(`${bannerHelpers} helper(s) found`);
    } else {
      results.banners.helper.status = 'FAIL';
      results.banners.helper.notes.push('No helper text found');
    }
    
    // 8. Test Categories List
    console.log('\n=== STEP 8: CATEGORIES LIST ===');
    await page.goto(`${BASE_URL}/admin/categories`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const categoriesHtml = await page.content();
    const categoriesToggle = categoriesHtml.includes('ToggleColumn') || categoriesHtml.includes('fi-ta-toggle');
    console.log(`Toggle in categories: ${categoriesToggle}`);
    
    if (categoriesToggle) {
      results.categories.toggle.status = 'PASS';
      results.categories.toggle.notes.push('Toggle column elements detected');
    } else {
      results.categories.toggle.status = 'FAIL';
      results.categories.toggle.notes.push('No toggle column elements detected');
    }
    
    // 9. Test Categories Create Form
    console.log('\n=== STEP 9: CATEGORIES CREATE FORM ===');
    await page.goto(`${BASE_URL}/admin/categories/create`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const catName = page.locator('input[wire\\:model="data.name"], input[id*="name"]').first();
    const catSlug = page.locator('input[wire\\:model="data.slug"], input[id*="slug"]').first();
    
    if (await catName.count() > 0 && await catSlug.count() > 0) {
      await catName.fill('Test Category Name');
      await page.waitForTimeout(1000);
      await catName.blur();
      await page.waitForTimeout(1500);
      
      const catSlugVal = await catSlug.inputValue().catch(() => '');
      console.log(`Category slug: "${catSlugVal}"`);
      
      if (catSlugVal && catSlugVal.includes('test')) {
        results.categories.slug.status = 'PASS';
        results.categories.slug.notes.push(`Slug: "${catSlugVal}"`);
      } else {
        results.categories.slug.status = 'FAIL';
        results.categories.slug.notes.push(`No slug auto-generated: "${catSlugVal}"`);
      }
    } else {
      results.categories.slug.status = 'FAIL';
      results.categories.slug.notes.push('Name or slug field not found');
    }
    
    const catHelpers = await page.locator('.fi-fo-field-wrp-description, .fi-fo-field-wrapper-description').count();
    if (catHelpers > 0) {
      results.categories.helper.status = 'PASS';
      results.categories.helper.notes.push(`${catHelpers} helper(s) found`);
    } else {
      results.categories.helper.status = 'FAIL';
      results.categories.helper.notes.push('No helper text found');
    }
    
    // 10. Test Tags Create Form
    console.log('\n=== STEP 10: TAGS CREATE FORM ===');
    await page.goto(`${BASE_URL}/admin/tags/create`, { waitUntil: 'networkidle' });
    await page.waitForTimeout(2000);
    
    const tagName = page.locator('input[wire\\:model="data.name"], input[id*="name"]').first();
    const tagSlug = page.locator('input[wire\\:model="data.slug"], input[id*="slug"]').first();
    
    if (await tagName.count() > 0 && await tagSlug.count() > 0) {
      await tagName.fill('Test Tag Name');
      await page.waitForTimeout(1000);
      await tagName.blur();
      await page.waitForTimeout(1500);
      
      const tagSlugVal = await tagSlug.inputValue().catch(() => '');
      console.log(`Tag slug: "${tagSlugVal}"`);
      
      if (tagSlugVal && tagSlugVal.includes('test')) {
        results.tags.slug.status = 'PASS';
        results.tags.slug.notes.push(`Slug: "${tagSlugVal}"`);
      } else {
        results.tags.slug.status = 'FAIL';
        results.tags.slug.notes.push(`No slug auto-generated: "${tagSlugVal}"`);
      }
    } else {
      results.tags.slug.status = 'FAIL';
      results.tags.slug.notes.push('Name or slug field not found');
    }
    
    const tagHelpers = await page.locator('.fi-fo-field-wrp-description, .fi-fo-field-wrapper-description').count();
    if (tagHelpers > 0) {
      results.tags.helper.status = 'PASS';
      results.tags.helper.notes.push(`${tagHelpers} helper(s) found`);
    } else {
      results.tags.helper.status = 'FAIL';
      results.tags.helper.notes.push('No helper text found');
    }
    
  } catch (error) {
    console.error('Test error:', error.message);
    results.login.notes.push(`Error: ${error.message}`);
  } finally {
    await browser.close();
  }
  
  // Print results
  console.log('\n\n========================================');
  console.log('          QA TEST RESULTS');
  console.log('========================================\n');
  
  console.log('Login:');
  console.log(`  Status: ${results.login.status}`);
  results.login.notes.forEach(n => console.log(`  - ${n}`));
  
  console.log('\n--- Toggle Columns (List Tables) ---');
  console.log(`Articles:    ${results.articles.toggle.status} - ${results.articles.toggle.notes[0] || ''}`);
  console.log(`Activities:  ${results.activities.toggle.status} - ${results.activities.toggle.notes[0] || ''}`);
  console.log(`Banners:     ${results.banners.toggle.status} - ${results.banners.toggle.notes[0] || ''}`);
  console.log(`Categories:  ${results.categories.toggle.status} - ${results.categories.toggle.notes[0] || ''}`);
  
  console.log('\n--- Slug Autogeneration ---');
  console.log(`Articles:    ${results.articles.slug.status} - ${results.articles.slug.notes[0] || ''}`);
  console.log(`Activities:  ${results.activities.slug.status} - ${results.activities.slug.notes[0] || ''}`);
  console.log(`Categories:  ${results.categories.slug.status} - ${results.categories.slug.notes[0] || ''}`);
  console.log(`Tags:        ${results.tags.slug.status} - ${results.tags.slug.notes[0] || ''}`);
  
  console.log('\n--- Helper Text (Forms) ---');
  console.log(`Articles:    ${results.articles.helper.status} - ${results.articles.helper.notes[0] || ''}`);
  console.log(`Activities:  ${results.activities.helper.status} - ${results.activities.helper.notes[0] || ''}`);
  console.log(`Banners:     ${results.banners.helper.status} - ${results.banners.helper.notes[0] || ''}`);
  console.log(`Categories:  ${results.categories.helper.status} - ${results.categories.helper.notes[0] || ''}`);
  console.log(`Tags:        ${results.tags.helper.status} - ${results.tags.helper.notes[0] || ''}`);
  
  // Summary
  const checks = [
    results.articles.toggle, results.activities.toggle, results.banners.toggle, results.categories.toggle,
    results.articles.slug, results.activities.slug, results.categories.slug, results.tags.slug,
    results.articles.helper, results.activities.helper, results.banners.helper, results.categories.helper, results.tags.helper
  ];
  const passCount = checks.filter(c => c.status === 'PASS').length;
  const failCount = checks.filter(c => c.status === 'FAIL').length;
  const pendingCount = checks.filter(c => c.status === 'pending').length;
  
  console.log('\n========================================');
  console.log(`SUMMARY: ${passCount} passed, ${failCount} failed, ${pendingCount} pending`);
  console.log('========================================');
  
  return results;
}

runTests().catch(err => {
  console.error('Fatal error:', err);
  process.exit(1);
});
