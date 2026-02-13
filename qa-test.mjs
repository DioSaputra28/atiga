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
  const browser = await chromium.launch({
    headless: true,
    executablePath: '/home/dio/.cache/ms-playwright/chromium-1208/chrome-linux64/chrome'
  });
  
  try {
    const page = await browser.newPage();
    
    // 1. Navigate to admin and login
    console.log('=== STEP 1: LOGIN ===');
    await page.goto(`${BASE_URL}/admin/login`);
    await page.waitForTimeout(1000);
    
    // Check if login form exists
    const hasEmailField = await page.locator('input[type="email"], input[name="email"]').count() > 0;
    const hasPasswordField = await page.locator('input[type="password"]').count() > 0;
    
    console.log(`Email field: ${hasEmailField}`);
    console.log(`Password field: ${hasPasswordField}`);
    
    if (!hasEmailField || !hasPasswordField) {
      results.login.status = 'BLOCKED';
      results.login.notes.push('Login form not found - check if already logged in or different auth method');
      
      // Check current URL
      const currentUrl = page.url();
      console.log(`Current URL: ${currentUrl}`);
      
      if (currentUrl.includes('/admin') && !currentUrl.includes('login')) {
        results.login.status = 'PASS';
        results.login.notes.push('Already logged in or redirected to dashboard');
      } else {
        results.login.status = 'FAIL';
        results.login.notes.push('Cannot access admin - authentication required');
        console.log('\n=== QA RESULTS ===');
        console.log(JSON.stringify(results, null, 2));
        await browser.close();
        return;
      }
    } else {
      // Try to login - check for default credentials or test user
      results.login.status = 'INFO';
      results.login.notes.push('Login form found - manual credentials needed');
    }
    
    // 2. Test Articles List (Toggle Columns)
    console.log('\n=== STEP 2: ARTICLES LIST (Toggle Columns) ===');
    await page.goto(`${BASE_URL}/admin/articles`);
    await page.waitForTimeout(2000);
    
    const pageContent = await page.content();
    
    // Check for toggle columns - look for toggle input elements or toggle-related classes
    const hasToggleColumn = pageContent.includes('ToggleColumn') || 
                           pageContent.includes('toggle') ||
                           pageContent.includes('fi-ta-toggle');
    
    // Check for boolean columns in the table
    const tableHtml = await page.locator('table').first().innerHTML().catch(() => '');
    const hasToggleInTable = tableHtml.includes('fi-ta-toggle') || 
                             tableHtml.includes('role="switch"') ||
                             tableHtml.includes('toggle');
    
    console.log(`Toggle column detected: ${hasToggleColumn || hasToggleInTable}`);
    
    if (hasToggleColumn || hasToggleInTable) {
      results.articles.toggle.status = 'PASS';
      results.articles.toggle.notes.push('Toggle column elements found in articles table');
    } else {
      results.articles.toggle.status = 'FAIL';
      results.articles.toggle.notes.push('No toggle column elements found in articles table');
    }
    
    // 3. Test Articles Create Form (Slug + Helper Text)
    console.log('\n=== STEP 3: ARTICLES CREATE FORM ===');
    await page.goto(`${BASE_URL}/admin/articles/create`);
    await page.waitForTimeout(2000);
    
    // Check for slug field
    const slugField = await page.locator('input[name="slug"], input[data-field="slug"]').count() > 0;
    console.log(`Slug field present: ${slugField}`);
    
    // Check for title field to test slug autogeneration
    const titleField = await page.locator('input[name="title"], input[data-field="title"]').first();
    const hasTitleField = await titleField.count() > 0;
    console.log(`Title field present: ${hasTitleField}`);
    
    if (hasTitleField && slugField) {
      // Test slug autogeneration
      await titleField.fill('Test Article Title');
      await page.waitForTimeout(500);
      await titleField.blur();
      await page.waitForTimeout(1000);
      
      const slugValue = await page.locator('input[name="slug"], input[data-field="slug"]').inputValue().catch(() => '');
      console.log(`Slug value after title entry: ${slugValue}`);
      
      if (slugValue.includes('test-article-title') || slugValue.includes('test')) {
        results.articles.slug.status = 'PASS';
        results.articles.slug.notes.push(`Slug auto-generated: ${slugValue}`);
      } else {
        results.articles.slug.status = 'FAIL';
        results.articles.slug.notes.push(`Slug not auto-generated. Value: ${slugValue}`);
      }
    } else {
      results.articles.slug.status = 'FAIL';
      results.articles.slug.notes.push('Title or slug field not found');
    }
    
    // Check for helper text
    const helperText = await page.locator('.fi-fo-field-wrp-hint, .helper-text, [data-field-wrapper] .text-sm').first().innerText().catch(() => '');
    console.log(`Helper text found: ${helperText ? 'Yes' : 'No'} (${helperText.substring(0, 50)})`);
    
    const hasHelperText = await page.locator('.fi-fo-field-wrp-hint, .fi-fo-field-wrapper-description').count() > 0;
    if (hasHelperText || helperText) {
      results.articles.helper.status = 'PASS';
      results.articles.helper.notes.push('Helper text elements found in form');
    } else {
      results.articles.helper.status = 'FAIL';
      results.articles.helper.notes.push('No helper text found in form');
    }
    
    // 4. Test Activities List (Toggle Columns)
    console.log('\n=== STEP 4: ACTIVITIES LIST (Toggle Columns) ===');
    await page.goto(`${BASE_URL}/admin/activities`);
    await page.waitForTimeout(2000);
    
    const activitiesContent = await page.content();
    const activitiesTableHtml = await page.locator('table').first().innerHTML().catch(() => '');
    const activitiesHasToggle = activitiesContent.includes('ToggleColumn') || 
                                activitiesTableHtml.includes('fi-ta-toggle') ||
                                activitiesTableHtml.includes('role="switch"');
    
    console.log(`Toggle column in activities: ${activitiesHasToggle}`);
    
    if (activitiesHasToggle) {
      results.activities.toggle.status = 'PASS';
      results.activities.toggle.notes.push('Toggle column elements found in activities table');
    } else {
      results.activities.toggle.status = 'FAIL';
      results.activities.toggle.notes.push('No toggle column elements found in activities table');
    }
    
    // 5. Test Activities Create Form (Slug + Helper Text)
    console.log('\n=== STEP 5: ACTIVITIES CREATE FORM ===');
    await page.goto(`${BASE_URL}/admin/activities/create`);
    await page.waitForTimeout(2000);
    
    const activitySlugField = await page.locator('input[name="slug"], input[data-field="slug"]').count() > 0;
    const activityTitleField = await page.locator('input[name="title"], input[data-field="title"]').first();
    const hasActivityTitle = await activityTitleField.count() > 0;
    
    console.log(`Activity slug field: ${activitySlugField}, title field: ${hasActivityTitle}`);
    
    if (hasActivityTitle && activitySlugField) {
      await activityTitleField.fill('Test Activity Title');
      await page.waitForTimeout(500);
      await activityTitleField.blur();
      await page.waitForTimeout(1000);
      
      const activitySlugValue = await page.locator('input[name="slug"], input[data-field="slug"]').inputValue().catch(() => '');
      console.log(`Activity slug value: ${activitySlugValue}`);
      
      if (activitySlugValue.includes('test-activity-title') || activitySlugValue.includes('test')) {
        results.activities.slug.status = 'PASS';
        results.activities.slug.notes.push(`Slug auto-generated: ${activitySlugValue}`);
      } else {
        results.activities.slug.status = 'FAIL';
        results.activities.slug.notes.push(`Slug not auto-generated. Value: ${activitySlugValue}`);
      }
    } else {
      results.activities.slug.status = 'FAIL';
      results.activities.slug.notes.push('Title or slug field not found');
    }
    
    const activityHelper = await page.locator('.fi-fo-field-wrp-hint, .fi-fo-field-wrapper-description').count() > 0;
    if (activityHelper) {
      results.activities.helper.status = 'PASS';
      results.activities.helper.notes.push('Helper text elements found in form');
    } else {
      results.activities.helper.status = 'FAIL';
      results.activities.helper.notes.push('No helper text found in form');
    }
    
    // 6. Test Banners List (Toggle Columns)
    console.log('\n=== STEP 6: BANNERS LIST (Toggle Columns) ===');
    await page.goto(`${BASE_URL}/admin/banners`);
    await page.waitForTimeout(2000);
    
    const bannersTableHtml = await page.locator('table').first().innerHTML().catch(() => '');
    const bannersHasToggle = bannersTableHtml.includes('fi-ta-toggle') ||
                             bannersTableHtml.includes('role="switch"');
    
    console.log(`Toggle column in banners: ${bannersHasToggle}`);
    
    if (bannersHasToggle) {
      results.banners.toggle.status = 'PASS';
      results.banners.toggle.notes.push('Toggle column elements found in banners table');
    } else {
      results.banners.toggle.status = 'FAIL';
      results.banners.toggle.notes.push('No toggle column elements found in banners table');
    }
    
    // 7. Test Banners Create Form (Helper Text)
    console.log('\n=== STEP 7: BANNERS CREATE FORM (Helper Text) ===');
    await page.goto(`${BASE_URL}/admin/banners/create`);
    await page.waitForTimeout(2000);
    
    const bannerHelper = await page.locator('.fi-fo-field-wrp-hint, .fi-fo-field-wrapper-description').count() > 0;
    if (bannerHelper) {
      results.banners.helper.status = 'PASS';
      results.banners.helper.notes.push('Helper text elements found in form');
    } else {
      results.banners.helper.status = 'FAIL';
      results.banners.helper.notes.push('No helper text found in form');
    }
    
    // 8. Test Categories List (Toggle Columns)
    console.log('\n=== STEP 8: CATEGORIES LIST (Toggle Columns) ===');
    await page.goto(`${BASE_URL}/admin/categories`);
    await page.waitForTimeout(2000);
    
    const categoriesTableHtml = await page.locator('table').first().innerHTML().catch(() => '');
    const categoriesHasToggle = categoriesTableHtml.includes('fi-ta-toggle') ||
                                categoriesTableHtml.includes('role="switch"');
    
    console.log(`Toggle column in categories: ${categoriesHasToggle}`);
    
    if (categoriesHasToggle) {
      results.categories.toggle.status = 'PASS';
      results.categories.toggle.notes.push('Toggle column elements found in categories table');
    } else {
      results.categories.toggle.status = 'FAIL';
      results.categories.toggle.notes.push('No toggle column elements found in categories table');
    }
    
    // 9. Test Categories Create Form (Slug + Helper Text)
    console.log('\n=== STEP 9: CATEGORIES CREATE FORM ===');
    await page.goto(`${BASE_URL}/admin/categories/create`);
    await page.waitForTimeout(2000);
    
    const categorySlugField = await page.locator('input[name="slug"], input[data-field="slug"]').count() > 0;
    const categoryNameField = await page.locator('input[name="name"], input[data-field="name"]').first();
    const hasCategoryName = await categoryNameField.count() > 0;
    
    console.log(`Category slug field: ${categorySlugField}, name field: ${hasCategoryName}`);
    
    if (hasCategoryName && categorySlugField) {
      await categoryNameField.fill('Test Category Name');
      await page.waitForTimeout(500);
      await categoryNameField.blur();
      await page.waitForTimeout(1000);
      
      const categorySlugValue = await page.locator('input[name="slug"], input[data-field="slug"]').inputValue().catch(() => '');
      console.log(`Category slug value: ${categorySlugValue}`);
      
      if (categorySlugValue.includes('test-category-name') || categorySlugValue.includes('test')) {
        results.categories.slug.status = 'PASS';
        results.categories.slug.notes.push(`Slug auto-generated: ${categorySlugValue}`);
      } else {
        results.categories.slug.status = 'FAIL';
        results.categories.slug.notes.push(`Slug not auto-generated. Value: ${categorySlugValue}`);
      }
    } else {
      results.categories.slug.status = 'FAIL';
      results.categories.slug.notes.push('Name or slug field not found');
    }
    
    const categoryHelper = await page.locator('.fi-fo-field-wrp-hint, .fi-fo-field-wrapper-description').count() > 0;
    if (categoryHelper) {
      results.categories.helper.status = 'PASS';
      results.categories.helper.notes.push('Helper text elements found in form');
    } else {
      results.categories.helper.status = 'FAIL';
      results.categories.helper.notes.push('No helper text found in form');
    }
    
    // 10. Test Tags Create Form (Slug + Helper Text)
    console.log('\n=== STEP 10: TAGS CREATE FORM ===');
    await page.goto(`${BASE_URL}/admin/tags/create`);
    await page.waitForTimeout(2000);
    
    const tagSlugField = await page.locator('input[name="slug"], input[data-field="slug"]').count() > 0;
    const tagNameField = await page.locator('input[name="name"], input[data-field="name"]').first();
    const hasTagName = await tagNameField.count() > 0;
    
    console.log(`Tag slug field: ${tagSlugField}, name field: ${hasTagName}`);
    
    if (hasTagName && tagSlugField) {
      await tagNameField.fill('Test Tag Name');
      await page.waitForTimeout(500);
      await tagNameField.blur();
      await page.waitForTimeout(1000);
      
      const tagSlugValue = await page.locator('input[name="slug"], input[data-field="slug"]').inputValue().catch(() => '');
      console.log(`Tag slug value: ${tagSlugValue}`);
      
      if (tagSlugValue.includes('test-tag-name') || tagSlugValue.includes('test')) {
        results.tags.slug.status = 'PASS';
        results.tags.slug.notes.push(`Slug auto-generated: ${tagSlugValue}`);
      } else {
        results.tags.slug.status = 'FAIL';
        results.tags.slug.notes.push(`Slug not auto-generated. Value: ${tagSlugValue}`);
      }
    } else {
      results.tags.slug.status = 'FAIL';
      results.tags.slug.notes.push('Name or slug field not found');
    }
    
    const tagHelper = await page.locator('.fi-fo-field-wrp-hint, .fi-fo-field-wrapper-description').count() > 0;
    if (tagHelper) {
      results.tags.helper.status = 'PASS';
      results.tags.helper.notes.push('Helper text elements found in form');
    } else {
      results.tags.helper.status = 'FAIL';
      results.tags.helper.notes.push('No helper text found in form');
    }
    
  } catch (error) {
    console.error('Test error:', error.message);
  } finally {
    await browser.close();
  }
  
  // Output results
  console.log('\n\n========================================');
  console.log('          QA TEST RESULTS');
  console.log('========================================\n');
  
  console.log('Login:');
  console.log(`  Status: ${results.login.status}`);
  results.login.notes.forEach(note => console.log(`  - ${note}`));
  
  console.log('\n--- Toggle Columns (List Tables) ---');
  console.log(`Articles:    ${results.articles.toggle.status} - ${results.articles.toggle.notes[0] || ''}`);
  console.log(`Activities:  ${results.activities.toggle.status} - ${results.activities.toggle.notes[0] || ''}`);
  console.log(`Banners:     ${results.banners.toggle.status} - ${results.banners.toggle.notes[0] || ''}`);
  console.log(`Categories:  ${results.categories.toggle.status} - ${results.categories.toggle.notes[0] || ''}`);
  
  console.log('\n--- Slug Autogeneration (Create Forms) ---');
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
  
  console.log('\n========================================');
  
  // Summary
  const allChecks = [
    results.articles.toggle, results.activities.toggle, results.banners.toggle, results.categories.toggle,
    results.articles.slug, results.activities.slug, results.categories.slug, results.tags.slug,
    results.articles.helper, results.activities.helper, results.banners.helper, results.categories.helper, results.tags.helper
  ];
  
  const passed = allChecks.filter(c => c.status === 'PASS').length;
  const failed = allChecks.filter(c => c.status === 'FAIL').length;
  const pending = allChecks.filter(c => c.status === 'pending').length;
  
  console.log(`\nSUMMARY: ${passed} passed, ${failed} failed, ${pending} pending/untested`);
  
  return results;
}

runTests().catch(console.error);
