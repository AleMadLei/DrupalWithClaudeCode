# Style Options: Custom Display Selector

This module extends the Style Options module with a custom display selector plugin that allows users to select from predefined display options configured in YML files.

## Requirements

- Drupal 10.5+ or Drupal 11.2+
- Style Options module

## Features

- **Display Selector Plugin**: A new Style Options plugin that provides a dropdown selector for display options
- **YML Configuration**: Options are defined in YML files and can vary per component
- **Multiple Selection Support**: Can be configured to allow single or multiple selections
- **Flexible Output**: Supports both CSS classes and HTML attributes
- **Component-Specific Options**: Different options can be configured for different components
- **Mercury Editor Integration**: Works seamlessly with Mercury Editor when adding components

## Installation

1. Download and enable the Style Options module if not already enabled
2. Place this module in your `modules/custom/` directory
3. Enable the module via Drush or the admin interface:
   ```bash
   drush en style_options_custom_display_selector
   ```

## Configuration

The module uses YML configuration files to define display options. Create a `.style_options.yml` file in your theme or module root directory.

### Basic Configuration Example

```yaml
options:
  component_display_style:
    plugin: display_selector
    label: 'Component Display Style'
    description: 'Choose how this component should be displayed'
    multiple: false
    options:
      default:
        label: 'Default Display'
        class: 'component-default'
      card:
        label: 'Card Display'
        class: 'component-card'
      featured:
        label: 'Featured Display'
        class: 'component-featured highlight'
        attributes:
          'data-display': 'featured'
          'data-priority': 'high'

contexts:
  paragraphs:
    _defaults:
      options:
        component_display_style: true
```

### Configuration Options

- **plugin**: Must be set to `display_selector`
- **label**: Human-readable label shown to users
- **description**: Optional description text
- **multiple**: Set to `true` to allow multiple selections
- **options**: Array of available options, each with:
  - **label**: Human-readable label for the option
  - **class**: CSS class(es) to apply (optional)
  - **attributes**: HTML attributes to apply (optional)

### Context Configuration

Use the `contexts` section to define which options are available for specific components:

- **layout**: Configure options for layout plugins
- **paragraphs**: Configure options for paragraph types
- **_defaults**: Default options for all items in a context
- **_disable**: Disable specific options for a context

## Usage with Mercury Editor

When using Mercury Editor to add components, the display selector will appear as a dropdown field, allowing users to choose from the configured display options. The selected options will automatically apply the associated CSS classes and attributes to the rendered component.

## Output

The plugin applies the selected options to the component's render array:

- **CSS Classes**: Added to the `#attributes['class']` array
- **HTML Attributes**: Added to the `#attributes` array

## Example CSS

```css
/* Default display styles */
.component-default {
  padding: 1rem;
  margin-bottom: 1rem;
}

/* Card display styles */
.component-card {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Featured display styles */
.component-featured {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 2rem;
  border-radius: 12px;
}

.component-featured.highlight {
  border: 3px solid #ffd700;
}
```

## Support

For issues or questions, please refer to the Style Options module documentation or create an issue in the project repository.

## License

This module is licensed under the GPL-2.0-or-later license, the same as Drupal core.