<?php

namespace Drupal\webform_privacy_statement\Element;

use Drupal\Core\Render\Element\RenderElementBase;

/**
 * Provides a form element for the privacy statement.
 *
 * @FormElement("privacy_statement")
 */
class PrivacyStatement extends RenderElementBase {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return [
      '#pre_render' => [
        [static::class, 'preRenderContent'],
      ],
    ];
  }

  /**
   * Pre-render callback: renders the privacy statement from config.
   */
  public static function preRenderContent($element) {
    $config = \Drupal::config('webform_privacy_statement.settings');
    $content = $config->get('content');

    if (!empty($content['value'])) {
      $element['content'] = [
        '#type' => 'processed_text',
        '#text' => $content['value'],
        '#format' => $content['format'] ?? 'basic_html',
      ];
    }

    // Set #name for form-item wrapper classes.
    if (!isset($element['#name']) && isset($element['#webform_key'])) {
      $element['#name'] = $element['#webform_key'];
    }

    return $element;
  }

}
