<?php

namespace Drupal\route_titles\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'route_titles_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('route_titles.settings')
      ->set('titles', $form_state->getValue('titles'))
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['route_titles.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('route_titles.settings');

    $form['titles'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Titles'),
      '#description' => $this->t('A list of routes, one per line, followed by a pipe and the new title to set.'),
      '#default_value' => $config->get('titles'),
    ];

    return parent::buildForm($form, $form_state);
  }
}
