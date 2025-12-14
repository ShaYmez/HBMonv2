# Changelog

All notable changes to HBMonv2 will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

- **2.0.2** (2025-12-14): HTML5 compliance, security improvements, code quality enhancements
- **1.6.9** (2024-06-14): Previous stable release
- **Original**: HBMonitor by N0MJS, further developed by KC1AWV, adapted by SP2ONG

---

## Notes

This version maintains **100% backward compatibility** with existing configurations and installations. No breaking changes have been introduced. All improvements are focused on:

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
- **Docker Version**: ShaYmez M0VUB (2020-2025)
