<?php

/**
 * @file
 * Contains \Drupal\addressfield\Form\SubdivisionDeleteForm.
 */

namespace Drupal\addressfield\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Builds the form to delete a subdivision.
 */
class SubdivisionDeleteForm extends EntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete %label?', array('%label' => $this->entity->label()));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.subdivision.list');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    try {
      $this->entity->delete();
      $form_state->setRedirectUrl($this->getCancelUrl());
      drupal_set_message($this->t('Subdivision %label has been deleted.', array('%label' => $this->entity->label())));
    } catch (\Exception $e) {
      drupal_set_message($this->t('Subdivision %label could not be deleted.', array('%label' => $this->entity->label())), 'error');
      $this->logger('addressfield')->error($e);
    }
  }

}
