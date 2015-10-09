<?php

/**
 * @file
 * Definition of Drupal\Core\Ajax\lightboxLoginRefreshPageCommand.
 */

namespace Drupal\lightbox_login\Ajax;

use Drupal\Core\Ajax\CommandInterface;

class lightboxLoginRefreshPageCommand implements CommandInterface {
  protected $closePopup;

  public function __construct($closePopup) {
    $this->closePopup = $closePopup;
  }

  /**
   * Implements Drupal\Core\Ajax\CommandInterface:render().
   */
  public function render() {
    return array(
      'command' => 'lightboxLoginRefreshPage',
      'closePopup' => $this->closePopup,
    );
  }

}
