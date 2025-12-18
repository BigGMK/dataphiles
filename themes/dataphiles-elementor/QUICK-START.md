# Dataphiles Website - Quick Start Guide

Get your Dataphiles website up and running in under 2 hours!

## ⚡ Prerequisites (5 minutes)

✅ WordPress 6.0+ installed
✅ Elementor Pro license activated
✅ Hello Theme installed

## 🚀 Installation Steps

### 1. Install & Activate (10 minutes)

```
Plugins → Add New
```

Install and activate:
- ✅ Elementor (free)
- ✅ Elementor Pro (license required)
- ✅ Hello Theme

### 2. Import Global Settings (10 minutes)

**Add Custom CSS:**
1. `Appearance → Customize → Additional CSS`
2. Copy/paste from `assets/css/custom-styles.css`
3. Publish

**Add Brand Colors:**
1. `Elementor → Site Settings → Global Colors`
2. Add these colors:

```
Primary Blue:    #0A2463
Secondary Blue:  #3E92CC
Accent Orange:   #FF6B35
Text Gray:       #5A6C7D
Light Gray:      #F8F9FA
```

### 3. Import Header & Footer (15 minutes)

**Header:**
1. `Templates → Theme Builder → Header → Add New`
2. Import `templates/header.json`
3. Replace `[[LOGO_URL]]` with your logo
4. Set condition: Entire Site
5. Publish

**Footer:**
1. `Templates → Theme Builder → Footer → Add New`
2. Import `templates/footer.json`
3. Set condition: Entire Site
4. Publish

### 4. Import Pages (30 minutes)

For each page:
1. `Pages → Add New`
2. Name the page
3. Click "Edit with Elementor"
4. Click folder icon → Import Template
5. Select the JSON file
6. Publish

**Import these pages:**
- ✅ Homepage (`templates/homepage.json`)
- ✅ Why Integrate (`templates/why-integrate.json`)
- ✅ About (`templates/about.json`)
- ✅ Contact (`templates/contact.json`)

### 5. Set Homepage (2 minutes)

```
Settings → Reading → A static page → Select "Home"
```

### 6. Create Navigation Menu (10 minutes)

```
Appearance → Menus → Create New Menu
```

Add pages in this order:
1. Home
2. Why Integrate
3. PatientComms (create page)
4. Success Stories (create page)
5. Become a Partner (create page)
6. About
7. Insights (create page)
8. Contact

Assign to "Primary Menu" → Save

### 7. Configure Contact Form (5 minutes)

1. Edit Contact page with Elementor
2. Click Form widget
3. Set "Email To" address
4. Configure email settings
5. Update

### 8. Replace Placeholder Content (30 minutes)

- Upload your logo
- Add team photos to About page
- Add product screenshots
- Replace placeholder text as needed

## ✅ Final Checks

- [ ] Logo displays correctly
- [ ] All menu links work
- [ ] Contact form sends emails
- [ ] Mobile view looks good
- [ ] All images loaded
- [ ] No placeholder text remains

## 🎯 Next Steps

Create these high-priority pages:
1. **PatientComms** - Product page
2. **Success Stories** - Case studies
3. **Become a Partner** - Partnership form

## 🆘 Common Issues

**Templates won't import?**
→ Ensure Elementor Pro is activated

**Colors not applying?**
→ Elementor → Tools → Regenerate CSS

**Form not sending?**
→ Check email settings or install WP Mail SMTP

## 📚 Full Documentation

See `README.md` for complete instructions and customization options.

---

**Need Help?** Contact Highland Marketing or your web development team.
