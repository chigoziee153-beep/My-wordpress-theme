# NYDLA Custom v0.4.1 — Elementor compatibility only

This update is based on the exact supplied v0.4.0 ZIP. The visual design,
CSS, JavaScript, Gutenberg blocks, WordPress Customizer settings, menus,
animations, and existing content were not changed.

## Supported editing methods

- Gutenberg remains available for all existing blocks and normal pages.
- WordPress Customizer settings and navigation menus remain available.
- Elementor Free can create/edit **page content** (About NYDLA, new pages,
  and an intentionally converted Home page) without the default theme's
  fixed-width text container interfering.
- Elementor's own **Full Width** page layout retains the site header and footer.
  **Canvas** intentionally removes them. Elementor supplies these page layouts.
- If Elementor Pro is installed, its Theme Builder can replace header, footer,
  single or archive layouts *only when the administrator explicitly assigns*
  corresponding Elementor templates. Otherwise the original NYDLA templates
  render without changes.

## IMPORTANT: Existing home content is not converted

The existing homepage is made from editable NYDLA Gutenberg blocks and/or
Customizer settings. Those blocks remain Gutenberg blocks, **not** Elementor
widgets. For an Elementor homepage, intentionally switch the Home page to the
Elementor editor and build its content using Elementor; back up first, as
changing editing modes on an existing page can overwrite editor data. To keep
existing homepage editing intact, only use Elementor for new/other pages.

## Installation & safe live testing

1. Back up Hostinger staging and retain v0.4.0 for rollback.
2. Upload v0.4.1 from Appearance > Themes > Add New > Upload Theme and replace
   the existing NYDLA Custom theme if WordPress offers to replace it.
3. Ensure **Elementor** is installed, activated, current, and has adequate PHP
   memory. No Elementor plugin files are bundled with the theme.
4. Elementor > Settings: ensure Pages are enabled under post types (and Posts
   if you intend to edit posts).
5. Test on a new temporary page before touching the existing Home page.
   Go to Pages > Add New, then Edit with Elementor, add a Heading and Image,
   save/publish, and verify the frontend. If needed, choose Elementor Full Width
   in Elementor's Page Settings to retain the NYDLA header/footer.
6. Open About NYDLA > Edit with Elementor, add/modify a widget, save, verify
   frontend; confirm full width works without `.prose` max-width limits.
7. Confirm the existing Gutenberg Home page, NYDLA custom blocks, menus,
   animations, Customizer, and mobile styling are unchanged.
8. Check Elementor Canvas and Elementor Full Width using a disposable test page.
9. If the Elementor editor still fails, use Elementor > Tools > Regenerate CSS
   and Data, disable any caching/optimization, review browser console and server
   errors, and confirm plugin/version and hosting PHP memory requirements.
10. Submit actual screenshots/video and findings to Basecamp after each
    genuine work session. Request independent verification before checking off.

## Implementation details

Only Elementor-specific PHP integration changes were made. The key conditions:

- The Elementor content template is used for a post when the Elementor plugin
  is loaded and the post has been explicitly built in Elementor, or when an
  authorized Elementor editing preview is active.
- Legacy Gutenberg pages and the home template follow their prior paths.
- The original site preloader and interaction scripts are suppressed **only
  in an authorized Elementor editing preview** (not on live pages).
- Elementor Pro core theme locations use original template fallbacks unless
  a Pro template is deliberately assigned.

This package was statically checked for PHP syntax and verified against the
original ZIP. Full WordPress/Elementor runtime functionality must be verified
on staging because we do not have access to the running WP administrator.
