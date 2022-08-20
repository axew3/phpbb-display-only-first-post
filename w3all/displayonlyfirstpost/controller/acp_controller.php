<?php
/**
 *
 * Display Only First Post. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022, axew3, http://axew3.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace w3all\displayonlyfirstpost\controller;

/**
 * Display Only First Post ACP controller.
 */
class acp_controller
{
  /** @var \phpbb\config\config */
  protected $config;

  /** @var \phpbb\language\language */
  protected $language;

  /** @var \phpbb\log\log */
  protected $log;

  /** @var \phpbb\request\request */
  protected $request;

  /** @var \phpbb\template\template */
  protected $template;

  /** @var \phpbb\user */
  protected $user;

  /** @var string Custom form action */
  protected $u_action;

  /**
   * Constructor.
   *
   * @param \phpbb\config\config    $config   Config object
   * @param \phpbb\language\language  $language Language object
   * @param \phpbb\log\log      $log    Log object
   * @param \phpbb\request\request  $request  Request object
   * @param \phpbb\template\template  $template Template object
   * @param \phpbb\user       $user   User object
   */
  public function __construct(\phpbb\config\config $config, \phpbb\language\language $language, \phpbb\log\log $log, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
  {
    $this->config = $config;
    $this->language = $language;
    $this->log    = $log;
    $this->request  = $request;
    $this->template = $template;
    $this->user   = $user;
  }

  /**
   * Display the options a user can configure for this extension.
   *
   * @return void
   */
  public function display_options()
  {
    // Add our common language file
    $this->language->add_lang('common', 'w3all/displayonlyfirstpost');

    // Create a form key for preventing CSRF attacks
    add_form_key('w3all_displayonlyfirstpost_acp');

    // Create an array to collect errors that will be output to the user
    $errors = [];

    // Is the form being submitted to us?
    if ($this->request->is_set_post('submit'))
    {
      // Test if the submitted form is valid
      if (!check_form_key('w3all_displayonlyfirstpost_acp'))
      {
        $errors[] = $this->language->lang('FORM_INVALID');
      }

        if ( preg_match('/[^,0-9]/',$this->request->variable('w3all_displayonlyfirstpost_u_groups', '')) ){
          $errors[] = $this->language->lang('FORM_INVALID');
        }

        if ( preg_match('/[^,0-9a{1}l{2}]/i',$this->request->variable('w3all_displayonlyfirstpost_forums_ids', '')) ){
          $errors[] = $this->language->lang('FORM_INVALID');
        }

      // If no errors, process the form data
      if (empty($errors))
      {

        // Set the options the user configured
        $this->config->set('w3all_displayonlyfirstpost_u_groups', $this->request->variable('w3all_displayonlyfirstpost_u_groups', ''));
        $this->config->set('w3all_displayonlyfirstpost_forums_ids', $this->request->variable('w3all_displayonlyfirstpost_forums_ids', ''));
        $this->config->set('w3all_displayonlyfirstpost_rep_mode', $this->request->variable('w3all_displayonlyfirstpost_rep_mode', 0));
        $this->config->set('w3all_displayonlyfirstpost_rep_content', $this->request->variable('w3all_displayonlyfirstpost_rep_content', ''));

        // Add option settings change action to the admin log
        $this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_DISPLAYONLYFIRSTPOST_SETTINGS');

        // Option settings have been updated and logged
        // Confirm this to the user and provide link back to previous page
        trigger_error($this->language->lang('ACP_DISPLAYONLYFIRSTPOST_SETTING_SAVED') . adm_back_link($this->u_action));
      }
    }

    $s_errors = !empty($errors);

    // Set output variables for display in the template
    $this->template->assign_vars([
      'S_ERROR' => $s_errors,
      'ERROR_MSG' => $s_errors ? implode('<br />', $errors) : '',

      'U_ACTION' => $this->u_action,

      'W3ALL_DISPLAYONLYFIRSTPOST_U_GROUPS' => $this->config['w3all_displayonlyfirstpost_u_groups'],
      'W3ALL_DISPLAYONLYFIRSTPOST_FORUMS_IDS' => $this->config['w3all_displayonlyfirstpost_forums_ids'],
      'W3ALL_DISPLAYONLYFIRSTPOST_REP_MODE' => $this->config['w3all_displayonlyfirstpost_rep_mode'],
      'W3ALL_DISPLAYONLYFIRSTPOST_REP_CONTENT' => $this->config['w3all_displayonlyfirstpost_rep_content'],
    ]);
  }

  /**
   * Set custom form action.
   *
   * @param string  $u_action Custom form action
   * @return void
   */
  public function set_page_url($u_action)
  {
    $this->u_action = $u_action;
  }
}
