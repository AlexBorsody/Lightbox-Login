<?php

/**
 * @file
 * Definition of Drupal\Core\Ajax\lightboxLoginRedirectCommand.
 */

namespace Drupal\lightbox_login\Ajax;

use Drupal\Core\Ajax\CommandInterface;
/**
 *
 */
class lightboxLoginRedirectCommand implements CommandInterface {
  protected $closePopup;
  protected $destination;

  /**
   *
   */
  public function __construct($closePopup, $destination) {
    $this->closePopup = $closePopup;
    $this->destination = $destination;
  }

  /**
   * Implements Drupal\Core\Ajax\CommandInterface:render().
   */
  public function render() {
    return array(
      'command' => 'lightboxLoginRedirect',
      'closePopup' => $this->closePopup,
      'destination' => $this->destination,
    );
  }

}
