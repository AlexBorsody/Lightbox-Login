<?php

/**
 * @file
 * Contains \Drupal\lightbox_login\Form\lightboxLogin_loginForm.
 */

namespace Drupal\lightbox_login\Form;

use Drupal\user\Form\UserLoginForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\lightbox_login\Ajax\lightboxLoginRefreshPageCommand;
use Drupal\lightbox_login\Ajax\lightboxLoginRedirectCommand;

class lightboxLogin_loginForm extends UserLoginForm {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'lightbox_login_user_login_block';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  }

  /**
   * Ajax callback function for lightbox_login_user_login_block submit button
   */
  public function user_login_block_ajax_callback(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $message_data = drupal_get_messages(NULL, FALSE);

    // Check to see if there were any errors with the form submission
    if (!count($message_data['error'])) {
      $config = \Drupal::config('lightbox_login.settings');
      if ($config->get('lightbox_login_no_redirect')) {
        drupal_set_message(t('You have been successfully logged in. Please wait the page is refreshed.'));
        $response->addCommand(new lightboxLoginRefreshPageCommand(TRUE));
      }
      else {
        drupal_set_message(t('You have been successfully logged in. Please wait while you are redirected.'));
        $dest = $form_state->getRedirect();
        $response->addCommand(new lightboxLoginRedirectCommand(TRUE, $dest));
      }
    }

    $messages = array('#theme' => 'status_messages');
    $messages = drupal_render($messages);

    $response->addCommand(new AppendCommand('#lightbox_login_user_login_block_wrapper', $messages));

    return $response;
  }

}
