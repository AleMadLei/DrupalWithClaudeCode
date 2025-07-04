<?php

declare(strict_types=1);

namespace Drupal\style_options_custom_display_selector\Plugin\StyleOption;

use Drupal\Core\Form\FormStateInterface;
use Drupal\style_options\Plugin\StyleOptionPluginBase;

/**
 * Define the custom display selector style option plugin.
 *
 * This plugin allows users to select from predefined display options
 * that are configured in YML files and can vary per component.
 *
 * @StyleOption(
 *   id = "display_selector",
 *   label = @Translation("Display Selector")
 * )
 */
class DisplaySelector extends StyleOptionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(
    array $form,
    FormStateInterface $form_state): array {

    $plugin_id = $this->getPluginId();
    $options = $this->getDisplayOptions();

    $form[$plugin_id] = [
      '#type' => 'select',
      '#title' => $this->getLabel(),
      '#default_value' => $this->getValue($plugin_id) ?? $this->getDefaultValue(),
      '#options' => $options,
      '#wrapper_attributes' => [
        'class' => [$this->getConfiguration()[$plugin_id] ?? ''],
      ],
      '#description' => $this->getConfiguration('description'),
      '#empty_option' => $this->t('- None -'),
    ];

    // Add support for multiple selections if configured.
    if ($this->hasConfiguration('multiple') && $this->getConfiguration('multiple')) {
      $form[$plugin_id]['#multiple'] = TRUE;
      unset($form[$plugin_id]['#empty_option']);
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $build) {
    $plugin_id = $this->getPluginId();
    $value = $this->getValue($plugin_id);
    $classes = [];
    $attributes = [];

    if (!empty($value)) {
      $option_definition = $this->getConfiguration('options') ?? [];
      
      // Handle multiple selections.
      if (is_array($value)) {
        foreach ($value as $selected_value) {
          if (isset($option_definition[$selected_value])) {
            $option = $option_definition[$selected_value];
            if (isset($option['class'])) {
              $classes[] = $option['class'];
            }
            if (isset($option['attributes'])) {
              $attributes = array_merge_recursive($attributes, $option['attributes']);
            }
          }
        }
      }
      else {
        // Handle single selection.
        if (isset($option_definition[$value])) {
          $option = $option_definition[$value];
          if (isset($option['class'])) {
            $classes[] = $option['class'];
          }
          if (isset($option['attributes'])) {
            $attributes = array_merge_recursive($attributes, $option['attributes']);
          }
        }
      }
    }

    // Apply CSS classes.
    if (!empty($classes)) {
      foreach ($classes as $class) {
        $build['#attributes']['class'][] = $class;
      }
    }

    // Apply additional attributes.
    if (!empty($attributes)) {
      foreach ($attributes as $attribute => $attribute_value) {
        if (is_array($attribute_value)) {
          $build['#attributes'][$attribute] = array_merge(
            $build['#attributes'][$attribute] ?? [],
            $attribute_value
          );
        }
        else {
          $build['#attributes'][$attribute] = $attribute_value;
        }
      }
    }

    return $build;
  }

  /**
   * Get display options from configuration.
   *
   * This method retrieves the display options from the YML configuration,
   * which can be component-specific or use defaults.
   *
   * @return array
   *   An associative array of display options with keys as machine names
   *   and values as human-readable labels.
   */
  protected function getDisplayOptions(): array {
    $options = [];
    $option_definition = $this->getConfiguration('options') ?? [];

    foreach ($option_definition as $key => $option) {
      if (is_array($option) && isset($option['label'])) {
        $options[$key] = $option['label'];
      }
      elseif (is_string($option)) {
        // Support simple string labels for backward compatibility.
        $options[$key] = $option;
      }
    }

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'options' => [],
      'multiple' => FALSE,
      'description' => '',
    ] + parent::defaultConfiguration();
  }

}