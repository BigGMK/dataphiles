# Dataphiles Website - Import Checklist

Use this checklist to track your progress during the WordPress import process.

## Pre-Import Setup

- [ ] WordPress 6.0+ installed and accessible
- [ ] WordPress admin credentials confirmed
- [ ] Hosting environment meets requirements (PHP 7.4+, MySQL 5.6+)
- [ ] SSL certificate installed (https://)
- [ ] Backup of existing site created (if applicable)

## Plugin Installation

- [ ] Elementor (free version) installed
- [ ] Elementor Pro installed and license activated
- [ ] Hello Theme (or Hello Elementor) installed
- [ ] Hello Theme activated as current theme

## Global Settings Configuration

- [ ] Custom CSS added (`Appearance → Customize → Additional CSS`)
- [ ] Brand colors added to Elementor global colors
- [ ] Default container width set to 1200px
- [ ] Typography settings configured

## Theme Builder Templates

### Header
- [ ] Header template imported (`templates/header.json`)
- [ ] Logo uploaded to Media Library
- [ ] Logo URL replaced in header (change `[[LOGO_URL]]`)
- [ ] Header display condition set to "Entire Site"
- [ ] Header published and verified

### Footer
- [ ] Footer template imported (`templates/footer.json`)
- [ ] Footer display condition set to "Entire Site"
- [ ] Footer links verified
- [ ] Contact information updated with actual details
- [ ] Footer published and verified

## Page Templates Import

### Homepage
- [ ] New page created: "Home"
- [ ] Template imported (`templates/homepage.json`)
- [ ] Content reviewed and customized
- [ ] Images/placeholders replaced
- [ ] Page published
- [ ] Set as site homepage (`Settings → Reading`)

### Why Integrate
- [ ] New page created: "Why Integrate"
- [ ] Template imported (`templates/why-integrate.json`)
- [ ] Content reviewed
- [ ] Page published
- [ ] Added to navigation menu

### About Dataphiles
- [ ] New page created: "About" or "About Dataphiles"
- [ ] Template imported (`templates/about.json`)
- [ ] Team photos uploaded and added
- [ ] Company information verified
- [ ] Statistics/numbers updated if needed
- [ ] Page published
- [ ] Added to navigation menu

### Contact
- [ ] New page created: "Contact"
- [ ] Template imported (`templates/contact.json`)
- [ ] Form email address configured
- [ ] Contact information updated (address, email, phone)
- [ ] Office hours verified
- [ ] Form tested (send test submission)
- [ ] Page published
- [ ] Added to navigation menu

### Become a Partner
- [ ] New page created: "Become a Partner"
- [ ] Template imported (`templates/become-a-partner.json`)
- [ ] Partnership form email address configured
- [ ] Form fields reviewed and customized if needed
- [ ] Form tested (send test submission)
- [ ] Page published
- [ ] Added to navigation menu

### PatientComms
- [ ] New page created: "PatientComms"
- [ ] Template imported (`templates/patientcomms.json`)
- [ ] Product screenshots added
- [ ] Statistics verified/updated
- [ ] Feature list reviewed
- [ ] Page published
- [ ] Added to navigation menu

## Navigation Menu Setup

- [ ] Primary navigation menu created
- [ ] Menu items added in correct order:
  - [ ] Home
  - [ ] Why Integrate
  - [ ] PatientComms
  - [ ] Success Stories (placeholder page created)
  - [ ] Become a Partner
  - [ ] About
  - [ ] Insights (placeholder page created)
  - [ ] Contact
- [ ] Menu assigned to "Primary Menu" location
- [ ] Menu tested on desktop
- [ ] Menu tested on mobile

## Content Customization

### Replace All Placeholders
- [ ] Company logo uploaded and applied
- [ ] `[[LOGO_URL]]` replaced in header
- [ ] Team photos added to About page
- [ ] Product screenshots added to PatientComms
- [ ] Any demo images replaced with actual photos
- [ ] Company address verified in footer
- [ ] Contact email addresses verified
- [ ] Phone numbers added (if applicable)

### Review All Text Content
- [ ] Homepage messaging reviewed
- [ ] About page company info verified
- [ ] Contact page information accurate
- [ ] Partnership form fields appropriate
- [ ] Footer links all working
- [ ] No "lorem ipsum" or placeholder text remains

## Form Configuration

### Contact Form
- [ ] Email recipient address set
- [ ] Email subject line customized
- [ ] Success message reviewed
- [ ] Error message reviewed
- [ ] Test submission sent and received
- [ ] Spam protection configured (if using plugin)

### Partnership Form
- [ ] Email recipient address set (partnerships@dataphiles.com or similar)
- [ ] Email subject line customized
- [ ] Success message reviewed
- [ ] Form fields appropriate for lead qualification
- [ ] Test submission sent and received
- [ ] GDPR consent checkbox present

### Optional Form Integrations
- [ ] CRM integration configured (HubSpot, Salesforce, etc.)
- [ ] Email marketing tool connected (Mailchimp, ActiveCampaign)
- [ ] Lead notification workflow set up
- [ ] Auto-responder emails configured

## Pages to Create (Future)

- [ ] Success Stories page created
- [ ] Insights/Blog section set up
- [ ] Terms & Conditions page created
- [ ] Privacy Policy page created
- [ ] Cookie Policy page created (if needed for GDPR)

## SEO Configuration

- [ ] Yoast SEO or similar plugin installed
- [ ] Site title set
- [ ] Site tagline set
- [ ] Default meta description added
- [ ] XML sitemap generated
- [ ] Google Search Console verified
- [ ] Google Analytics installed and tracking
- [ ] Page titles optimized for each page
- [ ] Meta descriptions added to all pages
- [ ] Focus keywords identified and applied

## Technical Configuration

### Permalinks
- [ ] Permalink structure set to "Post name"
- [ ] Permalinks saved

### Media Settings
- [ ] Image sizes configured
- [ ] Media library organized

### Elementor Settings
- [ ] Container width: 1200px
- [ ] Content width: 1200px
- [ ] Space between widgets: 20px
- [ ] CSS regenerated (`Elementor → Tools → Regenerate CSS`)

## Testing & Quality Assurance

### Desktop Testing
- [ ] Homepage displays correctly
- [ ] All navigation links work
- [ ] All pages load without errors
- [ ] Forms submit successfully
- [ ] No console errors in browser
- [ ] Images load properly
- [ ] Colors match brand guidelines

### Mobile Testing (or use Chrome DevTools)
- [ ] Homepage responsive on mobile
- [ ] Navigation menu works on mobile
- [ ] All pages readable on mobile
- [ ] Forms usable on mobile
- [ ] Touch targets large enough
- [ ] Images scale appropriately

### Cross-Browser Testing
- [ ] Chrome - working
- [ ] Firefox - working
- [ ] Safari - working
- [ ] Edge - working

### Performance Testing
- [ ] Page load speed under 3 seconds
- [ ] Images optimized
- [ ] Caching plugin installed (WP Rocket or similar)
- [ ] Lazy loading enabled for images
- [ ] Minification enabled
- [ ] Google PageSpeed Insights score acceptable

### Accessibility Testing
- [ ] Color contrast sufficient
- [ ] Alt text added to all images
- [ ] Form labels present and clear
- [ ] Keyboard navigation works
- [ ] Screen reader friendly

## Security & Maintenance

- [ ] Security plugin installed (Wordfence or similar)
- [ ] Backup plugin installed (UpdraftPlus or similar)
- [ ] First backup created
- [ ] Automatic backup schedule configured
- [ ] SSL/HTTPS working throughout site
- [ ] WordPress updated to latest version
- [ ] All plugins updated
- [ ] Strong admin password set
- [ ] Admin username changed from "admin"
- [ ] Two-factor authentication enabled (optional but recommended)

## Legal & Compliance

- [ ] Privacy Policy page created and linked in footer
- [ ] Terms & Conditions page created and linked in footer
- [ ] Cookie consent banner added (if required)
- [ ] GDPR compliance verified (for UK/EU visitors)
- [ ] Form consent checkboxes present
- [ ] Data retention policies documented

## Launch Preparation

### Pre-Launch
- [ ] All checklist items above completed
- [ ] Stakeholder review completed
- [ ] Content approved by management
- [ ] Final backup created
- [ ] Maintenance mode disabled
- [ ] Launch date scheduled

### Launch Day
- [ ] DNS pointed to new site (if changing hosting)
- [ ] Site live and accessible
- [ ] SSL certificate working
- [ ] Forms tested on live site
- [ ] Analytics tracking verified
- [ ] Team notified of launch
- [ ] Social media updated with new website link

### Post-Launch (Week 1)
- [ ] Monitor form submissions
- [ ] Check analytics data flowing
- [ ] Review any 404 errors
- [ ] Monitor site performance
- [ ] Respond to any user feedback
- [ ] Create first blog post (Insights)

## Support Contacts

**Web Development Issues:**
- Highland Marketing
- Your hosting provider support

**Elementor Questions:**
- Elementor documentation: https://elementor.com/help/
- Elementor support (with Pro license)

**WordPress Issues:**
- WordPress support forums: https://wordpress.org/support/
- Your hosting provider support

## Notes & Customizations

Use this space to note any customizations or changes made during import:

```
[Add your notes here]
```

---

**Checklist Version:** 1.0
**Last Updated:** December 10, 2025
**Estimated Completion Time:** 2-4 hours for basic setup, 1-2 weeks for full customization
