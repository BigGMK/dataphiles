# Dataphiles Elementor Website Template

A professional WordPress website template built for Dataphiles using Elementor Pro and the Hello theme. This template kit is designed to position Dataphiles as a B2B platform provider targeting integration partners and PMS vendors in the healthcare sector.

## 📋 Template Overview

This template kit includes:

### Pages
- **Homepage** - Hero section, value propositions, features, sectors, PatientComms showcase, and CTAs
- **Why Integrate** - Partnership benefits, integration process, and value propositions for PMS vendors
- **About Dataphiles** - Company story, mission, values, and team
- **Contact** - Contact form and information

### Templates
- **Header** - Fixed navigation with primary menu
- **Footer** - Multi-column footer with links, contact info, and legal

### Theme Assets
- **Global Settings** - Color palette, typography, and global styles
- **Custom CSS** - Additional styling and responsive design

## 🎨 Brand Colors

```
Primary Blue:    #0A2463
Secondary Blue:  #3E92CC
Accent Orange:   #FF6B35
Text Gray:       #5A6C7D
Light Gray:      #F8F9FA
White:           #FFFFFF
Dark Blue:       #051938
```

## 📦 Requirements

Before importing this template, ensure you have:

1. **WordPress** (version 6.0 or higher)
2. **Elementor Pro** (required for header/footer templates and forms)
3. **Hello Theme** (or Hello Elementor theme) - recommended base theme
4. **PHP** 7.4 or higher
5. **MySQL** 5.6 or higher

## 🚀 Installation Instructions

### Step 1: Install Required Plugins

1. Log into your WordPress admin panel
2. Navigate to **Plugins → Add New**
3. Install and activate:
   - **Elementor** (free version)
   - **Elementor Pro** (required - purchase license from elementor.com)
   - **Hello Theme** (or Hello Elementor)

### Step 2: Activate Hello Theme

1. Go to **Appearance → Themes**
2. Activate the **Hello** or **Hello Elementor** theme
3. This provides a clean base for Elementor customization

### Step 3: Import Global Settings

1. Go to **Elementor → Settings**
2. Navigate to the **Style** tab
3. Import the color scheme:
   - Open `theme/global-settings.json`
   - Manually add the colors from the "system_colors" section
   - Or use Elementor's color picker to add each brand color

### Step 4: Add Custom CSS

1. Go to **Appearance → Customize**
2. Navigate to **Additional CSS**
3. Copy and paste the contents of `assets/css/custom-styles.css`
4. Click **Publish** to save changes

### Step 5: Import Header Template

1. Go to **Templates → Theme Builder → Header**
2. Click **Add New**
3. Choose **Import Template**
4. Select `templates/header.json`
5. Set display conditions to **Entire Site**
6. Publish the header

**Important:** Replace the placeholder `[[LOGO_URL]]` in the header with your actual logo:
- Upload your logo to WordPress Media Library
- Edit the header template
- Update the logo image widget with your logo URL

### Step 6: Import Footer Template

1. Go to **Templates → Theme Builder → Footer**
2. Click **Add New**
3. Choose **Import Template**
4. Select `templates/footer.json`
5. Set display conditions to **Entire Site**
6. Publish the footer

### Step 7: Import Page Templates

#### Homepage
1. Go to **Pages → Add New**
2. Name it "Home"
3. Click the **Edit with Elementor** button
4. In Elementor, click the folder icon (Import Template)
5. Select `templates/homepage.json`
6. Insert the template
7. Go to **Settings → Reading** and set this page as your homepage

#### Why Integrate Page
1. Create a new page named "Why Integrate"
2. Edit with Elementor
3. Import `templates/why-integrate.json`
4. Publish

#### About Page
1. Create a new page named "About"
2. Edit with Elementor
3. Import `templates/about.json`
4. Publish

#### Contact Page
1. Create a new page named "Contact"
2. Edit with Elementor
3. Import `templates/contact.json`
4. Configure the contact form (see Form Configuration below)
5. Publish

### Step 8: Configure Navigation Menu

1. Go to **Appearance → Menus**
2. Create a new menu named "Primary Navigation"
3. Add the following pages in order:
   - Home
   - Why Integrate
   - PatientComms (create this page)
   - Success Stories (create this page)
   - Become a Partner (create this page)
   - About
   - Insights (create this page or link to blog)
   - Contact
4. Assign the menu to the "Primary Menu" location
5. Save the menu

## 📧 Contact Form Configuration

The contact form on the Contact page needs to be configured:

1. Edit the Contact page with Elementor
2. Click on the Form widget
3. Go to **Actions After Submit**
4. Configure email settings:
   - **Email To:** Your desired email address (e.g., info@dataphiles.com)
   - **Email Subject:** Customize as needed
   - **From Email:** Use a verified email from your domain
5. Optionally integrate with:
   - Mailchimp
   - HubSpot
   - ActiveCampaign
   - Or other CRM/email marketing tools

## 🎯 Additional Pages to Create

Based on the navigation structure, you should create:

1. **PatientComms** - Product showcase page
2. **Success Stories** - Case studies and testimonials
3. **Become a Partner** - Partnership application/inquiry page
4. **Insights** - Blog or news section (category archive)
5. **Terms & Conditions** - Legal page
6. **Privacy Policy** - Privacy policy page

## 🖼️ Image Placeholders

The templates use placeholder text where images should be added. You'll need to:

1. Upload professional images to your Media Library
2. Replace placeholder images in:
   - Homepage hero section
   - About page (team photos, office photos)
   - Success Stories page
   - PatientComms product screenshots

## ⚙️ Recommended Settings

### Permalink Structure
1. Go to **Settings → Permalinks**
2. Select **Post name** structure
3. Save changes

### Elementor Settings
1. Go to **Elementor → Settings**
2. **General:**
   - Container Width: 1200px
3. **Style:**
   - Import brand colors from global-settings.json
   - Set default fonts to Inter (or similar system font)

## 🔧 Customization Tips

### Changing Colors
1. Go to **Elementor → Site Settings → Global Colors**
2. Update the color values
3. Colors will automatically update throughout the site

### Changing Fonts
1. Go to **Elementor → Site Settings → Global Fonts**
2. Update typography settings
3. Recommended fonts: Inter, Roboto, Open Sans, or system fonts

### Editing Templates
1. All templates can be edited via **Elementor → My Templates**
2. Changes to header/footer will apply site-wide
3. Test changes on staging site first

## 📱 Mobile Responsiveness

All templates are designed to be fully responsive. To verify:

1. Edit any page with Elementor
2. Use the responsive mode switcher (bottom toolbar)
3. Test on Mobile, Tablet, and Desktop views
4. Adjust spacing and visibility as needed

## 🔌 Recommended Plugins

Consider installing these additional plugins:

- **Yoast SEO** - For search engine optimization
- **WP Rocket** - For caching and performance
- **Wordfence** - For security
- **UpdraftPlus** - For backups
- **Contact Form 7** - Alternative form solution
- **MonsterInsights** - For Google Analytics integration

## 📊 Performance Optimization

1. **Optimize Images:**
   - Use WebP format where possible
   - Compress images before upload
   - Install Smush or ShortPixel for automatic optimization

2. **Enable Caching:**
   - Install WP Rocket or similar caching plugin
   - Enable Elementor's built-in CSS optimization

3. **Use a CDN:**
   - Consider Cloudflare or similar CDN
   - Improves global load times

4. **Minimize Plugins:**
   - Only use essential plugins
   - Deactivate and delete unused plugins

## 🎓 Support & Resources

### Elementor Documentation
- [Elementor Getting Started](https://elementor.com/help/getting-started/)
- [Elementor Theme Builder](https://elementor.com/help/theme-builder/)
- [Elementor Tutorials](https://elementor.com/academy/)

### WordPress Resources
- [WordPress Codex](https://codex.wordpress.org/)
- [WordPress Support](https://wordpress.org/support/)

## 📝 Content Guidelines

Based on the Discovery Workshop summary, remember to:

1. **Primary Audience:** Integration partners and PMS vendors
2. **Key Messaging:** Focus on platform capabilities, not just features
3. **Brand Positioning:** Dataphiles as the specialist platform provider
4. **PatientComms:** Position as reference implementation, not the main product
5. **Tone:** Professional, partnership-focused, technically credible

## ✅ Post-Launch Checklist

- [ ] All pages created and published
- [ ] Navigation menu configured
- [ ] Contact form tested and working
- [ ] All images replaced (no placeholders)
- [ ] Logo uploaded and applied
- [ ] Mobile responsiveness verified
- [ ] Forms integrate with CRM/email
- [ ] SSL certificate installed
- [ ] Google Analytics added
- [ ] SEO plugin configured
- [ ] 404 page customized
- [ ] Favicon added
- [ ] Social media links added (if applicable)
- [ ] Legal pages added (T&Cs, Privacy Policy)
- [ ] Site backed up

## 🆘 Troubleshooting

### Templates Won't Import
- Ensure Elementor Pro is activated
- Check file permissions
- Try uploading as JSON instead of template file

### Colors Not Applying
- Clear Elementor cache: Elementor → Tools → Regenerate CSS
- Clear browser cache
- Check that global colors are properly defined

### Forms Not Sending
- Verify email settings in WordPress: Settings → General
- Check spam folder
- Configure SMTP plugin (WP Mail SMTP recommended)
- Test with different email address

### Layout Issues
- Regenerate CSS: Elementor → Tools → Regenerate Files
- Clear all caches (site, browser, CDN)
- Verify container width settings

## 📞 Need Help?

If you need assistance with:
- Custom development
- Additional pages
- Integration with third-party tools
- Performance optimization
- SEO configuration

Contact Highland Marketing or your web development team.

---

**Version:** 1.0
**Last Updated:** December 2025
**Created For:** Dataphiles Ltd
**Created By:** Highland Marketing / Claude AI Assistant

## 📜 License

This template is proprietary and created specifically for Dataphiles Ltd. All rights reserved.
