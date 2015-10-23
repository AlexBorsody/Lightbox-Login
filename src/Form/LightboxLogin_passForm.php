<?php

/**
 * @file
 * Contains \Drupal\lightbox_login\Form\lightboxLogin_passForm.
 */

namespace Drupal\lightbox_login\Form;

use Drupal\user\Form\UserPasswordForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\lightbox_login\Ajax\lightboxLoginClosePopupCommand;
/**
 *
 */
class lightboxLogin_passForm extends UserPasswordForm {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'lightbox_login_user_pass';
  }

  /**
   *
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  }

  /**
   * Ajax callback function for lightbox_login_user_pass submit button.
   */
  public function user_pass_ajax_callback(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $message_data = drupal_get_messages(NULL, FALSE);

    // Check to see if there were any errors with the form submission.
    if (!count($message_data['error'])) {
      $response->addCommand(new lightboxLoginClosePopupCommand());
    }

    $messages = array('#theme' => 'status_messages');
    $messages = drupal_render($messages);

    $response->addCommand(new AppendCommand('#lightbox_login_user_pass_block_wrapper', $messages));

    return $response;
  }

}
