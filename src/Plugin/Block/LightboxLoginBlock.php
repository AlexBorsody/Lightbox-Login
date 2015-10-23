<?php

/**
 * @file
 * @file
 */

namespace Drupal\lightbox_login\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * 
 *
 * Provides lightbox_login block.
 *
 * @Block(
 *   id = "lightbox_login_login_block",
 *   admin_label = @Translation("Login"),
 *   category = @Translation("Fancy Login Link")
 * )
 */
class lightboxLoginBlock extends BlockBase {
  /**
   * 
   *
   * {@inheritdoc}
   */
  public function build() {
    if ($GLOBALS['user']->isAnonymous() || !empty($GLOBALS['menu_admin'])) {
      $url = Url::fromRoute('user.login');
      return array('link' => array('#markup' => \Drupal::l(t('Login'), $url), '#prefix' => '<div id="lightbox_login_login_link_wrapper">', '#suffix' => '</div>'));
    }
  }

}
