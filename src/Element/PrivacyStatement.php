<?php

namespace Drupal\webform_privacy_statement\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a render element for the privacy statement.
 *
 * @RenderElement("privacy_statement")
 */
class PrivacyStatement extends RenderElement {

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

    return $element;
  }

}
