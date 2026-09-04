# Changelog

All notable changes to HBMonv2 will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.1.1] - 2026-09-04

### Changed
- Dashboard pages are fluid below 1120px, with a compact mobile menu, touch-friendly forms/logs, and phone card views for live status, LastHeard, and talkgroup data; the 1100px desktop layout is unchanged
- Standalone and Docker configuration samples now share the `data/` layout, 28-day alias refresh, and disabled optional local aliases
- Installation, Docker, configuration, Talkgroup Manager, LastHeard, and System Info documentation now matches the shipped files

### Fixed
- The systemd service now runs the virtual-environment Python installed by `install.sh`
- The LastHeard rotation task handles a missing initial log and no longer rotates the same file twice

## [2.1.0] - 2026-09-03

### Added
- Talkgroup Info reads `talkgroup_ids.json`; Talkgroup Manager CRUD with CLI users
- Dashboard version is the `VERSION` file; footer Docker version is read from hblink3-docker-install when that stack is present
- Light SEO on by default: unique titles, description, generator/version, Open Graph, JSON-LD (SoftwareApplication; talkgroup ItemList on info.php). `SEO_INDEX` in config.php; Talkgroup Manager always noindex

### Changed
- Standalone installs omit the footer Docker version line
- Lastheard HTML is written next to the Jinja templates (not `PATH/templates/`)
- Lastheard CSV uses quoted callsign and name columns

### Fixed
- WebSocket client no longer crashes on pages missing table nodes; script loads only on live pages
- Monitor page remains log-only; Bridges page has navigation
- log.php finds Docker or standalone lastheard logs and no longer fatals if the file is missing
- Concurrent QSO lastheard used `sys_list.pop()` (wrong row); now removes the matched entry
- Invalid HTML (`<a><button>`, nested `<tr>`, `<font>`/`<center>`, 8-digit hex colours)
- Talkgroup HTTP fallback no longer uses `HTTP_HOST` (localhost JSON only)
- Footer Docker link points at ShaYmez/hblink3-docker-install

## [2.0.2] - 2025-12-14

### Added
- Comprehensive CHANGELOG.md to document all changes
- Viewport meta tag for improved mobile responsiveness across all pages
- Proper HTML5 semantic structure with centered content containers

### Changed
- **HTML5 Compliance**: Migrated all pages from XHTML 1.0 Transitional to HTML5 DOCTYPE
- **Modern HTML**: Replaced deprecated `<center>` tags with CSS-based centering using `margin: 0 auto`
- **Deprecated Tags Removed**: 
  - Replaced all `<font>` tags with CSS `<span>` elements with inline styles
  - Fixed deprecated `<p>` tags used as containers, replaced with proper `<div>` elements
  - Removed obsolete XHTML namespace declarations
  - Updated all table tags to lowercase (TR/TH/TD → tr/th/td)
- **Accessibility Improvements**:
  - Added descriptive alt text to all logo images ("HBlink Logo")
  - Added descriptive alt attributes to system info graphs (CPU Temperature, Disk Usage, Memory Usage, CPU Load, Network Traffic)
  - Improved semantic HTML structure
- **Security Enhancements**:
  - Added `htmlspecialchars()` escaping to all PHP output variables in log.php to prevent XSS attacks
  - Added `htmlspecialchars()` escaping to DASH and REPORT_NAME variables across all pages
- **Code Quality**:
  - Standardized CSS border-radius properties (removed redundant vendor prefixes where not needed)
  - Consolidated repeated border-radius declarations to single `border-radius` property
  - Changed `overflow-y: scroll` to `overflow-y: auto` for better UX (scrollbar only when needed)
  - Fixed invalid color values in CSS (removed trailing characters from rgba values)
  - Improved code consistency and formatting across all templates
- **Copyright Updates**: Updated copyright years from 2023 to 2025 across all files
- **Version Updates**: Updated version from 1.6.9 to 2.0.2

### Fixed
- Fixed missing closing tags and proper HTML nesting throughout all pages
- Fixed invalid HTML attributes (removed deprecated `align` attributes)
- Fixed duplicate CSS properties in inline styles
- Fixed improperly nested table elements
- Fixed broken link structure in footer (added proper quote marks around href URLs)
- Fixed color styling using modern CSS instead of deprecated HTML attributes
- Corrected CSS syntax errors in template files

### Improved
- Better code organization and readability
- Consistent styling across all pages
- Production-ready HTML/PHP code structure
- Cross-browser compatibility
- Performance optimizations through cleaner HTML

## [1.6.9] - 2024-06-14

### Previous Release
- Last version before 2.0.2 improvements
- Docker version by ShaYmez M0VUB
- Based on SP2ONG's HBMonv2

---

## Version History

- **2.1.1** (2026-09-04): Responsive dashboard, configuration alignment, and production documentation cleanup
- **2.1.0** (2026-09-03): Talkgroup manager/API, SEO, reliability fixes, and central VERSION file
- **2.0.2** (2025-12-14): HTML5 compliance, security improvements, code quality enhancements
- **1.6.9** (2024-06-14): Previous stable release
- **Original**: HBMonitor by N0MJS, further developed by KC1AWV, adapted by SP2ONG

---

## Notes

Existing deployments can retain their local `config.py` and
`html/include/config.php`. Review the annotated samples when creating a new
configuration. The release focuses on:

1. Code quality and modern standards compliance
2. Security hardening (XSS prevention)
3. Accessibility improvements
4. Performance optimization
5. Future maintainability

---

## Credits

- **Original Author**: Cortney T. Buffington (N0MJS)
- **HBMonitor3**: KC1AWV
- **HBMonv2**: SP2ONG (2019-2025)
- **Docker Version**: ShaYmez M0VUB (2020-2026)
