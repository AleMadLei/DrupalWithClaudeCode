# Claude Development Memory

## Project Context
- **Project**: Drupal CMS 1.2.0 (Drupal 11-based)
- **Environment**: DDEV local development
- **URL**: https://drupal-claude-code.ddev.site/new-editor-page
- **Working Directory**: `/work/DrupalWithClaudeCode/web/`

## Key Commands & Tools
```bash
# Drush commands (always use ddev prefix)
ddev drush cache:rebuild
ddev drush en [module_name] -y
ddev drush pm:uninstall [module_name] -y

# Testing URL content
curl -k -s https://drupal-claude-code.ddev.site/new-editor-page | grep -n "pattern"

# Git workflow
git add [file]
git commit -m "message"
```

## Current Module Status
- **Style Options Module**: Enabled and working
- **Custom Display Selector Module**: Built but uninstalled (code preserved in `/modules/custom/`)
- **Current Implementation**: Using Property plugin with component-specific configurations

## Active Configuration Files
1. **Theme Style Options**: `/themes/contrib/drupal_cms_olivero/drupal_cms_olivero.style_options.yml`
   - Component A: Options A, B, C (`component_a_display`)
   - Component B: Options D, E, F (`component_b_display`)
   - Plugin: `property` with `option_id: 'data-display'`

## Known Issues & Limitations
- **Property Plugin**: UI works but doesn't output data attributes to HTML (tested on lines 249, 261, 279)
- **CSS Class Plugin**: Works for classes but not data attributes
- **Context Overrides**: Cannot override `options` array in Style Options contexts
- **Solution**: Custom module needed for data attributes + CSS classes combination

## Architecture Learnings
- **Style Options Plugins**: css_class, property, background_color, background_image, display_selector (custom)
- **Configuration**: `*.style_options.yml` files in theme/module root
- **Plugin Development**: Extend `StyleOptionPluginBase`, use annotations
- **Dependencies Format**: `module_name:module_name` in .info.yml

## File Locations
```
/web/
├── modules/custom/style_options_custom_display_selector/ (preserved)
├── themes/contrib/drupal_cms_olivero/drupal_cms_olivero.style_options.yml (active)
├── SUMMARY.md (session documentation)
└── CLAUDE.md (this file)
```

## Best Practices Established
1. Always clear cache after configuration changes
2. Test output on actual URL with line numbers
3. Use separate option definitions per component (not context overrides)
4. Follow Drupal coding standards with strict types and docblocks
5. Use DDEV for all Drush commands

## For Next Session
- **If needing data attributes**: Re-enable custom module
- **If only CSS classes**: Use built-in css_class plugin
- **If testing**: Always verify on https://drupal-claude-code.ddev.site/new-editor-page
- **Remember**: Property plugin limitations for attribute output