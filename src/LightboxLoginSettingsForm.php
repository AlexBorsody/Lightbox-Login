<?php

/**
 * @file
 * Contains \Drupal\lightbox_login\FancyLoginSettingsForm.
 */

namespace Drupal\lightbox_login;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 *
 */
class FancyLoginSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'admin_lightbox_login_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['lightbox_login.settings'];
  }

  /**
   *
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('lightbox_login.settings');

    $form['display'] = array(
      '#type' => 'details',
      '#title' => t('Display'),
      '#open' => FALSE,
    );
    $form['display']['explanation'] = array(
      '#value' => '<p>' . t('All settings on this page must be valid CSS settings for the item that they will modify. For information on what types of values are valid, check the links included in the descriptions underneath the inputs.') . '</p>',
    );
    $form['display']['screen_fade_color'] = array(
      '#title' => t('Screen Fade Color'),
      '#type' => 'textfield',
      '#maxlength' => 7,
      '#size' => 8,
      '#default_value' => $config->get('screen_fade_color'),
      '#description' => t('This is the color that the screen fades to when the login box is activated. This should generally be black, white, or the same color as the background of your site. CSS property: !url.', array('!url' => '<a href="http://www.devguru.com/technologies/css2/8047">background-color</a>')),
    );
    $form['display']['screen_fade_z_index'] = array(
      '#title' => t('Screen Fade z-index'),
      '#type' => 'textfield',
      '#maxlength' => 4,
      '#size' => 8,
      '#default_value' => $config->get('screen_fade_z_index'),
      '#description' => t('This is the z-index of the faded screen. If you find elements on your layout are appearing over top of the faded out part of your screen, you can increase this number, but you should probably not touch it otherwise. CSS propery !url.', array('!url' => '<a href="http://www.devguru.com/technologies/css2/8139">z-index</a>')),
    );
    $form['display']['login_box_background_color'] = array(
      '#title' => t('Login Box Background Color'),
      '#type' => 'textfield',
      '#maxlength' => 7,
      '#size' => 8,
      '#default_value' => $config->get('login_box_background_color'),
      '#description' => t('This is the background color of the login box. CSS property: !url.', array('!url' => '<a href="http://www.devguru.com/technologies/css2/8047">background-color</a>')),
    );
    $form['display']['login_box_text_color'] = array(
      '#title' => t('Login Box Text Color'),
      '#type' => 'textfield',
      '#maxlength' => 7,
      '#size' => 8,
      '#default_value' => $config->get('login_box_text_color'),
      '#description' => t('This is the color of the text inside the login box. CSS property: !url.', array('!url' => '<a href="http://www.devguru.com/technologies/css2/8077">color</a>')),
    );
    $form['display']['login_box_border_color'] = array(
      '#title' => t('Login Box Border Color'),
      '#type' => 'textfield',
      '#maxlength' => 7,
      '#size' => 8,
      '#default_value' => $config->get('login_box_border_color'),
      '#description' => t('This is the color of the border around the login box. CSS property: !url.', array('!url' => '<a href="http://www.devguru.com/technologies/css2/8057">border-color</a>')),
    );
    $form['display']['login_box_border_width'] = array(
      '#title' => t('Login Box Border Width'),
      '#type' => 'textfield',
      '#maxlength' => 7,
      '#size' => 8,
      '#default_value' => $config->get('login_box_border_width'),
      '#description' => t('This is the width of the border around the login box. CSS property: !url.', array('!url' => '<a href="http://www.devguru.com/technologies/css2/8072">border-width</a>')),
    );
    $form['display']['login_box_border_style'] = array(
      '#title' => t('Login Box Border Style'),
      '#type' => 'textfield',
      '#maxlength' => 7,
      '#size' => 8,
      '#default_value' => $config->get('login_box_border_style'),
      '#description' => t('This is the style (eg: solid, dotted) of the border around the login box. CSS property: !url.', array('!url' => '<a href="http://www.devguru.com/technologies/css2/8067">border-style</a>')),
    );
    $form['display']['lightbox_login_hide_objects'] = array(
      '#title' => t('Hide Objects'),
      '#type' => 'checkbox',
      '#default_value' => $config->get('lightbox_login_hide_objects'),
      '#description' => t('If you are having issues where the fancy login box is being hidden behind videos or other flash objects, check this box to hide the objects while the login box is being shown'),
    );
    $form['display']['lightbox_login_dim_fade_speed'] = array(
      '#title' => t('Background Fade Speed'),
      '#type' => 'textfield',
      '#default_value' => $config->get('lightbox_login_dim_fade_speed'),
      '#maxlength' => 4,
      '#size' => 8,
      '#description' => t('This is the number of milliseconds it will take for the fullscreen background color to fade in/out. The higher the number, the slower the fade process will be. The lower the number, the faster the fade.'),
    );
    $form['display']['lightbox_login_box_fade_speed'] = array(
      '#title' => t('Login Box Fade Speed'),
      '#type' => 'textfield',
      '#default_value' => $config->get('lightbox_login_box_fade_speed'),
      '#maxlength' => 4,
      '#size' => 8,
      '#description' => t('This is the number of milliseconds it will take for the login box to fade in/out. The higher the number, the slower the fade process will be. The lower the number, the faster the fade.'),
    );
    $form['lightbox_login_no_redirect'] = array(
      '#title' => t('Keep User on Same Page'),
      '#type' => 'checkbox',
      '#description' => t('If this box is checked, the user will not be redirected upon login, and will stay on the page from which the login link was clicked. If this box is unchecked, the user will be redirected according to the Drupal system settings'),
      '#default_value' => $config->get('lightbox_login_no_redirect'),
    );
    $form['ssl'] = array(
      '#type' => 'details',
      '#title' => t('SSL (Secure Login)'),
      '#open' => FALSE,
    );
    $form['ssl']['lightbox_login_https'] = array(
      '#title' => t('Enable SSL (HTTPS)'),
      '#type' => 'checkbox',
      '#description' => t('If this box is checked, the form will be posted as encrypted data (HTTPS/SSL). Only use this if you have already set up an SSL certificate on your site, and have set up the login page as an encrypted page.'),
      '#default_value' => $config->get('lightbox_login_https'),
    );
    $form['ssl']['lightbox_login_icon_position'] = array(
      '#type' => 'radios',
      '#title' => t('Secure login icon position'),
      '#options' => array(t("Don't show icon"), t('Above the form'), t('Below the form')),
      '#default_value' => $config->get('lightbox_login_icon_position'),
      '#description' => t("If SSL is turned on, turning this option on will display an icon indicating that the login is secure"),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $test_values = array(
      'screen_fade_color' => 'Screen Fade Color',
      'screen_fade_z_index' => 'Screen Fade z-index',
      'login_box_background_color' => 'login_box_background_color',
      'login_box_text_color' => 'login_box_text_color',
      'login_box_border_color' => 'login_box_border_color',
      'login_box_border_width' => 'login_box_border_width',
      'login_box_border_style' => 'Login Box Border Style',
    );
    foreach ($test_values as $machine => $human) {
      if ($form_state->getValue($machine) == '') {
        $form_state->setErrorByName($machine, $this->t('!field must contain a value.', array('!field' => $human)));
      }
    }
    if (!is_numeric(trim($form_state->getValue('lightbox_login_dim_fade_speed')))) {
      $form_state->setErrorByName('lightbox_login_dim_fade_speed', $this->t('Background Fade Speed must contain a numeric value'));
    }
    if (!is_numeric(trim($form_state->getValue('lightbox_login_box_fade_speed')))) {
      $form_state->setErrorByName('lightbox_login_box_fade_speed', t('Login Box Fade Speed must contain a numeric value'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('lightbox_login.settings')
      ->set('screen_fade_color', $form_state->getValue('screen_fade_color'))
      ->set('screen_fade_z_index', $form_state->getValue('screen_fade_z_index'))
      ->set('login_box_background_color', $form_state->getValue('login_box_background_color'))
      ->set('login_box_text_color', $form_state->getValue('login_box_text_color'))
      ->set('login_box_border_color', $form_state->getValue('login_box_border_color'))
      ->set('login_box_border_width', $form_state->getValue('login_box_border_width'))
      ->set('login_box_border_style', $form_state->getValue('login_box_border_style'))
      ->set('lightbox_login_hide_objects', $form_state->getValue('lightbox_login_hide_objects'))
      ->set('lightbox_login_dim_fade_speed', $form_state->getValue('lightbox_login_dim_fade_speed'))
      ->set('lightbox_login_box_fade_speed', $form_state->getValue('lightbox_login_box_fade_speed'))
      ->set('lightbox_login_no_redirect', $form_state->getValue('lightbox_login_no_redirect'))
      ->set('lightbox_login_https', $form_state->getValue('lightbox_login_https'))
      ->set('lightbox_login_icon_position', $form_state->getValue('lightbox_login_icon_position'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
