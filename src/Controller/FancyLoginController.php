<?php
/**
 * @file
 * Contains \Drupal\lightbox_login\Controller\lightboxLoginController.
 */

namespace Drupal\lightbox_login\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Component\Serialization\Json;
/**
 *
 */
class lightboxLoginController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function ajax_callback($type) {
    switch ($type) {
      case "password":
        $form = \Drupal::formBuilder()->getForm('Drupal\lightbox_login\Form\lightboxLogin_passForm');
        break;

      case "login":
        $form = \Drupal::formBuilder()->getForm('Drupal\lightbox_login\Form\lightboxLogin_loginForm');
        unset($form['#prefix'], $form['#suffix']);
        break;
    }

    $rendered_form = render($form);
    drupal_process_attached($form);

    $scripts = _drupal_add_js();
    if (!empty($scripts['drupalSettings'])) {
      unset($scripts['drupalSettings']['data']['path']);
      $settings = '<script type="text/javascript">jQuery.extend(drupalSettings, ';
      $settings .= Json::encode($scripts['drupalSettings']['data']);
      $settings .= ');</script>';
    }
    $return = array('content' => $rendered_form . $settings, 'status' => TRUE, 'type' => $type);

    return new JsonResponse($return);
  }

}
