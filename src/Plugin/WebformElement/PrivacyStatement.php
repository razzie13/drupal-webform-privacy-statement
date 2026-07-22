<?php

namespace Drupal\webform_privacy_statement\Plugin\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformElementBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Provides a 'privacy_statement' webform element.
 *
 * @WebformElement(
 *   id = "privacy_statement",
 *   label = @Translation("Privacy statement"),
 *   description = @Translation("Displays the centrally managed privacy statement. Content can be edited at /admin/structure/webform/config under Privacy statement settings."),
 *   category = @Translation("Reusable content"),
 * )
 */
class PrivacyStatement extends WebformElementBase {

  /**
   * {@inheritdoc}
   */
  protected function defineDefaultProperties() {
    $properties = parent::defineDefaultProperties();
    unset($properties['required']);
    unset($properties['required_error']);
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isInput(array $element) {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function isContainer(array $element) {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function getItemDefaultFormat() {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    // Hide the required checkbox since this is a display-only element.
    if (isset($form['validation']['required'])) {
      $form['validation']['required']['#access'] = FALSE;
    }

    $form['element']['privacy_info'] = [
      '#type' => 'item',
      '#title' => $this->t('Privacy Statement Content'),
      '#markup' => $this->t('The privacy statement content is managed centrally. <a href=":url">Edit the privacy statement</a>.', [
        ':url' => '/admin/structure/webform/config',
      ]),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function preview() {
    return ['#markup' => '<em>' . $this->t('Privacy statement content will render here.') . '</em>'];
  }

  /**
   * {@inheritdoc}
   */
  public function formatHtmlItem(array $element, WebformSubmissionInterface $webform_submission, array $options = []) {
    $config = \Drupal::config('webform_privacy_statement.settings');
    $content = $config->get('content');

    if (!empty($content['value'])) {
      return [
        '#type' => 'processed_text',
        '#text' => $content['value'],
        '#format' => $content['format'] ?? 'basic_html',
      ];
    }

    return ['#markup' => ''];
  }

  /**
   * {@inheritdoc}
   */
  public function formatTextItem(array $element, WebformSubmissionInterface $webform_submission, array $options = []) {
    return '';
  }

}
