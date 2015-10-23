<?php

/**
 * @file
 * Definition of Drupal\Core\Ajax\lightboxLoginClosePopupCommand.
 */

namespace Drupal\lightbox_login\Ajax;

use Drupal\Core\Ajax\CommandInterface;
/**
 *
 */
class lightboxLoginClosePopupCommand implements CommandInterface {

  /**
   * Implements Drupal\Core\Ajax\CommandInterface:render().
   */
  public function render() {
    return array(
      'command' => 'lightboxLoginClosePopup',
    );
  }

}
